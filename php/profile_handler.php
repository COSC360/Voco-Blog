<?php
include("db_connection.php");
include("validateRequests.php");
include("comment_handler.php");
include("like_handler.php");

$conn = connect();

if(validateGetRequest($_GET,$_SERVER)){
    $tablename = $_GET["tablename"];
} else {
    die();
};
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $user_id = $_SESSION['active_user_id'];
}else{
    die();
}

if($tablename == "likedposts") {
    $result = get_liked_posts($conn,$user_id);
    // Set up for unlike actions
    $id = "user_id";
    $action = "like_handler.php?action=delete&id=".$user_id;
} elseif ($tablename == "usercomments") {
    $result = get_user_comments($conn,$user_id);
    $id = "user_id";
    $action = "comment_handler.php?action=delete";

//    $sql = "SELECT * FROM Users";
//    // Set up for delete action
//    $id = "user_id";
//    $action = "comment_handler.php?action=get";
} else {
    echo("Error: Invalid request parameter");
    die();
}

if($result->rowCount() > 0) {

    $result = $result->fetchAll();
    $table = "<table>";

    //Create table header
    // TODO: Probs should check if table is empty first

    $first_entry = $result[0];
    $keys = array_keys($first_entry);
    $thead = "<thead><tr>";

    foreach($keys as $key => $value) {
        //Result set weirdness makes have to do this check
        if(!is_int($value)) {
            $thead .="<th>".$value."</th>";
        }
    }
    $table .= $thead."</tr></thead>";

    //Create table body
    $tbody = "<tbody>";

    foreach($result as $entry) {
        $row = "<tr>";
        foreach($entry as $key=>$value) {
            // Result set weirdness makes have to do this check
            if(is_int($key)) {
                $row .= "<td>".$value."</td>";
            }
        }
        $delete = "<td><form method=\"GET\" action=\"php/".$action."\"><input type=\"hidden\" name=".$id."\" value=\"".$entry[0]."\"><button type=\"submit\">Delete</button></form></td>";
        $tbody .= $row.$delete."</tr>";
    }
    $table .= $tbody."</tbody></table>";
    echo $table;
} else {
    echo "Error: Empty Table";
}