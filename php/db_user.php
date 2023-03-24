<?php
include("db_connection.php");

// opens connection
$pdo = open_connection();

$sql = "SELECT * from Users";

// result
$result = $pdo->query($sql);

while($row = $result->fetch()) {

    echo $row['first_name']." ";
}

// closes connection
$pdo = null;

?>