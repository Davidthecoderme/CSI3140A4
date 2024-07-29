<?php
include 'db_connect.php';

$sql = "SELECT *, EXTRACT(EPOCH FROM (CURRENT_TIMESTAMP - arrival_time)) AS wait_time FROM patients WHERE treated = FALSE ORDER BY severity DESC, arrival_time ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($patients);
?>
