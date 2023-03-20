<?php
require('db_info.php');

function open_connection(){
    $conn = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME)
    or die("Connect failed: %s\n". $conn -> error);
    return $conn;
}
function close_connection($conn){
    $conn -> close();
}

