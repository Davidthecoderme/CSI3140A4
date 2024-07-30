<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patientId = $_POST['patient_id'];

    $stmt = $conn->prepare("UPDATE patients SET treated = TRUE WHERE id = :id");
    $stmt->execute(['id' => $patientId]);

    echo "Patient treated successfully.";
}
?>
