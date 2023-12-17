<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';

// Create a connection to the MySQL server
$conn = new mysqli($dbHost, $dbUser, $dbPass);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the list of databases
$queryDatabases = "SHOW DATABASES";
$resultDatabases = $conn->query($queryDatabases);

$databases = array();

if ($resultDatabases->num_rows > 0) {
    while ($row = $resultDatabases->fetch_assoc()) {
        $databases[] = $row['Database'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database and Table Selection</title>
</head>
<body>

<!-- Database dropdown -->
<label for="databases">Select Database:</label>
<select id="databases">
    <?php foreach ($databases as $database) : ?>
        <option value="<?php echo $database; ?>"><?php echo $database; ?></option>
    <?php endforeach; ?>
</select>

<!-- Table dropdown -->
<label for="tables">Select Table:</label>
<select id="tables"></select>

<script>
// JavaScript to handle dynamic table dropdown based on selected database

document.getElementById('databases').addEventListener('change', function() {
    var selectedDatabase = this.value;

    // Fetch the list of tables for the selected database
    fetch('get_tables.php?database=' + selectedDatabase)
        .then(response => response.json())
        .then(data => {
            var tablesDropdown = document.getElementById('tables');
            tablesDropdown.innerHTML = '';

            // Populate the tables dropdown
            data.forEach(function(table) {
                var option = document.createElement('option');
                option.value = table;
                option.text = table;
                tablesDropdown.add(option);
            });
        });
});
</script>

</body>
</html>
