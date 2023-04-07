<?php
include('db_info.php');


function connect(){
    try {
        $connString = "mysql:host=".DBHOST.";dbname=".DBNAME;
        $pdo = new PDO($connString, DBUSER, DBPASS);
    } catch (PDOException $e){
        die($e->getMessage());
    }

    return $pdo;
}

function close_connection($conn){
    $conn = null;
}


?>


