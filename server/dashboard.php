<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.html");
    exit();
}
include 'db_connect.php';

$stmt = $conn->query("SELECT * FROM patients WHERE treated = FALSE ORDER BY arrival_time DESC");
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <script>
        function treatPatient(patientId) {
            fetch('treated.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `patient_id=${patientId}`
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Show the server response
                // Reload the page to update the list
                window.location.reload();
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <a href="logout.php">Logout</a>
    </header>
    <main>
        <h2>Patient List</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Unique Code</th>
                    <th>Severity</th>
                    <th>Arrival Time</th>
                    <th>Treated</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($patient['name']); ?></td>
                        <td><?php echo htmlspecialchars($patient['uniquecode']); ?></td>
                        <td><?php echo htmlspecialchars($patient['severity']); ?></td>
                        <td><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($patient['arrival_time']))); ?></td>
                        <td><?php echo $patient['treated'] ? 'Yes' : 'No'; ?></td>
                        <td>
                            <button onclick="treatPatient(<?php echo $patient['id']; ?>)">Treat</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
