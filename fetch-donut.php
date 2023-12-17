<?php
$db = new mysqli("localhost", "root", "", "database_name");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$semester = $_GET['semester'];
$query = "SELECT CGPA FROM name_new WHERE semester = '$semester'";

$result = $db->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row['CGPA'];
}

$db->close();
echo json_encode($data);
?>
