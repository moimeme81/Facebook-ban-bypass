<?php
$dbh = mysqli_connect("localhost", "DATABASE NAME", "PASSWORD", "USERNAME");

if (!$dbh) {
    die('Could not connect: ' . mysqli_error());
}

// Set the character set to utf8mb4
mysqli_set_charset($dbh, "utf8mb4");

$sql = "SELECT * FROM articles";
$result = mysqli_query($dbh, $sql) or die('SQL Error: ' . mysqli_error($dbh));

$data = array();

while ($row = mysqli_fetch_array($result)) {
    $data[] = $row;
}

echo json_encode($data); // Output the data as JSON
?>
