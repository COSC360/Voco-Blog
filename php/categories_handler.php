<?php

function get_categories($conn) {
    $sql = "SELECT * FROM Category";
    $stmt = $conn->query($sql);
    return $stmt;
}

?>
