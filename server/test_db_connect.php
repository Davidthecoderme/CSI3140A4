<?php
include 'db_connect.php';

try {
    $stmt = $conn->query("SELECT * FROM patients LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "Database connection and query successful!<br>";
        echo "Sample Data: " . print_r($row, true);
    } else {
        echo "Database connection successful, but no data found in the patients table.";
    }
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}
?>
