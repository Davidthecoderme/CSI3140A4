<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $code = $_POST['uniqueCode'];

    // Retrieve the patient's data
    $stmt = $conn->prepare("SELECT arrival_time FROM patients WHERE name = :name AND uniquecode = :code");
    $stmt->execute(['name' => $name, 'code' => $code]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($patient !== false) {
        // Calculate wait time based on current time and arrival time
        $arrivalTime = new DateTime($patient['arrival_time']);
        
        $currentTime = new DateTime();

        // Calculate elapsed time
        $elapsedTime = $currentTime->getTimestamp() - $arrivalTime->getTimestamp();
        $elapsedMinutes = floor($elapsedTime / 60 / 5 );

        echo "Your wait time is probably" . $elapsedMinutes . " minutes.";
    } else {
        echo "Patient not found. Please check your details.";
    }
}
?>
