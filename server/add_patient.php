    <?php
    include 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $code = $_POST['uniqueCode'];
        $severity = $_POST['severity'];

        // Check if the code is unique
        $stmt = $conn->prepare("SELECT COUNT(*) FROM patients WHERE uniqueCode = :code");
        $stmt->execute(['code' => $code]);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            // Insert the patient data
            $sql = "INSERT INTO patients (name, uniqueCode, severity) VALUES (:name, :code, :severity)";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['name' => $name, 'code' => $code, 'severity' => $severity]);

            echo "Patient added successfully with your unique code: $code";
        } else {
            echo "Failed to add patient: the generated code is not unique. Please try again.";
        }
    }
    ?>
