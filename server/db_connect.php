<?php
$host = 'localhost';
$db = 'hospitaltriage';
$user = 'postgres';
$pass = 'ningjun556556'; //change this password to your own database password 

try {
    $conn = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
