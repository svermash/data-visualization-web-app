<?php
if (isset($_POST["submit"])) {
    $file = $_FILES["file"]["tmp_name"];
    $handle = fopen($file, "r");

    $conn = new mysqli("localhost", "root", "", "database_name");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    if (isset($_POST['input_name'])) {
        $input_name = $_POST['input_name']; 
        $tableName = "name_" . strtolower(str_replace(' ', '_', $input_name));
    } else {
        echo "Input not received.";
    }

    $createTableSQL = "CREATE TABLE $tableName (
        rollNumber VARCHAR(255),
        subjects VARCHAR(255),
        internal INT(255),
        practical INT(255),
        theory INT(255),
        semester VARCHAR(255),
        CGPA FLOAT(5, 2),  
        student_name VARCHAR(255),
        grade VARCHAR(255)
    )";

    if ($conn->query($createTableSQL) === TRUE) {
        $success = true;

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $col1 = $data[0];
            $col2 = $data[1];
            $col3 = $data[2];
            $col4 = $data[3];
            $col5 = $data[4];
            $col6 = $data[5];
            $col7 = $data[6];
            $col8 = $data[7];
            $col9 = $data[8];

            $insertSQL = "INSERT INTO $tableName (rollNumber, subjects, internal, practical, theory, semester, CGPA, student_name, grade) 
            VALUES ('$col1', '$col2', '$col3', '$col4', '$col5', '$col6', '$col7', '$col8', '$col9')";

            if ($conn->query($insertSQL) !== TRUE) {
                $success = false;
                echo "Error: " . $insertSQL . "<br>" . $conn->error;
            }
        }
    } else {
        $success = false;
        echo "Error creating the table: " . $conn->error;
    }

    fclose($handle);
    $conn->close();

    if ($success) {
        echo '<script>
            if (confirm("Data uploaded successfully!")) {
                window.history.back();
                window.location.reload();

            };

        </script>';
    }
}
?>
