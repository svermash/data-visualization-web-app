<?php

$conn = mysqli_connect("localhost", "root", "", "database_name");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$query = "SELECT semester, SUM(CGPA) AS cumulative_cgpa FROM name_new GROUP BY semester ORDER BY semester";
$result = mysqli_query($conn, $query);
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}


mysqli_close($conn);
echo json_encode($data);
?>
