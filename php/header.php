<?php
include("user_handler.php");
include('php/db_connection.php');
$conn = connect();
session_start();
$username = null;
$loggedIn = null;
$isAdmin = null;

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $user_id = $_SESSION['active_user_id'];
}

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
    $loggedIn = true;
    $isAdmin = $_SESSION["isAdmin"];
}

$user = get_user($conn, $user_id);

?>

<header>
    <nav class="navbar">
        <div class="headbox">
            <a href="index.php">Home</a>
        </div>
        <div class="headbox">
            <form action="search.php" method="GET" id="search">
                <label>
                    <input id="search_query" name="search" type="text" placeholder="Search..">
                </label>
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <div class="headbox">
            <img src="./img/voco_logo_black.png" alt="VOCO Logo img" class="logo">
        </div>

        <?php
        if ($loggedIn && $isAdmin) {
            echo "<div class=\"headbox\"><a href=\"admin.php\">Admin</a><a href='profile.php'>".$username. "</a><a href='php/logout.php'>Log out</a></div>";
        }elseif ($loggedIn){
            echo "<div class=\"headbox\"><a href='profile.php'><img src=\"data:image/".$user["profile_picture_type"].";base64,".base64_encode($user["profile_picture"])."\" style=\"border:solid thin black;border-radius:50%\" height=\"30em\" width=\"30em\">".$username."</a><a href='php/logout.php'>Logout</a></div>";
        } else {
            echo "<div class=\"headbox\"><a href=\"login.php\">Login</a><a href=\"register.php\">Register</a></div>";
        }

        close_connection($conn);

        ?>

    </nav>

</header>