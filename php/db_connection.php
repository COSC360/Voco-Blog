<?php
include('db_info.php');


function open_connection(){
    try {
        $connString = "mysql:host=".DBHOST.";dbname=".DBNAME;
        $pdo = new PDO($connString, DBUSER, DBPASS);
    } catch (PDOException $e){
        die($e->getMessage());
    }

    return $pdo;
}

function close_connection($conn){
    $conn -> close();
}

?>


