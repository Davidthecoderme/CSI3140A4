<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $code = $_POST['uniqueCode'];

    // Retrieve the patient's data
    $stmt = $conn->prepare("SELECT id, arrival_time, severity, treated FROM patients WHERE name = :name AND uniquecode = :code");
    $stmt->execute(['name' => $name, 'code' => $code]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($patient !== false) {
        if ($patient['treated']) {
            echo "You have been treated. Please visit us next time if you feel unwell.";
        } else {
            // Calculate total wait time based on arrival time and severity
            $arrivalTime = new DateTime($patient['arrival_time']);
            $currentTime = new DateTime();

            // Ensure both times are in the same time zone
            $arrivalTime->setTimezone(new DateTimeZone('UTC'));
            $currentTime->setTimezone(new DateTimeZone('UTC'));

            // Calculate elapsed time in minutes
            $elapsedTime = $currentTime->getTimestamp() - $arrivalTime->getTimestamp();
            $elapsedMinutes = floor($elapsedTime / 60);

            // Example formula for wait time calculation
            $baseWaitTimeMinutes = 30; // base wait time in minutes
            $severityFactor = 10; // additional wait time per severity level in minutes
            $totalWaitTime = $baseWaitTimeMinutes + ($patient['severity'] * $severityFactor);

            // Calculate remaining wait time
            $remainingWaitTime = max(0, $totalWaitTime - $elapsedMinutes);

            // Get all untreated patients and calculate their wait times and priorities
            $stmt = $conn->prepare("SELECT id, name, arrival_time, severity FROM patients WHERE treated = FALSE");
            $stmt->execute();
            $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $currentPatientPriority = $patient['severity'] + ($elapsedMinutes / 60);
            $patientsAhead = 0;

            $priorityList = [];

            foreach ($patients as $otherPatient) {
                $otherArrivalTime = new DateTime($otherPatient['arrival_time']);
                $otherArrivalTime->setTimezone(new DateTimeZone('UTC'));
                $otherElapsedTime = $currentTime->getTimestamp() - $otherArrivalTime->getTimestamp();
                $otherElapsedMinutes = floor($otherElapsedTime / 60);
                $otherPriority = $otherPatient['severity'] + ($otherElapsedMinutes / 60);

                $priorityList[] = [
                    'id' => $otherPatient['id'],
                    'name' => $otherPatient['name'],
                    'priority' => $otherPriority
                ];

                if ($otherPriority > $currentPatientPriority) {
                    $patientsAhead++;
                }
            }

            // Sort patients by priority in descending order (highest priority first)
            usort($priorityList, function($a, $b) {
                return $b['priority'] <=> $a['priority'];
            });

            // Determine the current patient's position in the sorted list
            $currentPosition = 0;
            foreach ($priorityList as $index => $p) {
                if ($p['id'] == $patient['id']) {
                    $currentPosition = $index;
                    break;
                }
            }

            // Calculate the remaining wait time based on the position
            $adjustedWaitTime = ($currentPosition + 1) * 10; // 10 minutes for the first position, 20 for the second, etc.

            echo "Your wait time is approximately " . $adjustedWaitTime . " minutes. There are " . $patientsAhead . " patients ahead of you in the queue. The next patient to be treated is " . $priorityList[0]['name'] . ".";
        }
    } else {
        echo "Patient not found. Please check your details.";
    }
}
?>
