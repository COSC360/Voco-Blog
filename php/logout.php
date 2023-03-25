<?php

    session_start();

    echo "<p>".$_SESSION["loggedIn"]."</p>";
    echo "<p>".$_SESSION["username"]."</p>";


    unset($_SESSION["username"]);
    $_SESSION["loggedIn"] = false;


    header("Location: ../index.php")
?>
