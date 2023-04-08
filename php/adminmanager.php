<?php
    include("db_connection.php");
    include("validateRequests.php");


    $pdo = connect();

    if(validateGetRequest($_GET,$_SERVER)){
        $tablename = $_GET["tablename"];
    } else {
        die();
    };

    if($tablename == "admin") {
        $sql = "SELECT user_id,role_id,username,first_name,last_name,email FROM Users WHERE role_id=2";
        // Set up for delete actions
        $id = "user_id";
        $action = "delete_user.php";
    } elseif ($tablename == "user") {
        $sql = "SELECT user_id,role_id,username,first_name,last_name,email FROM Users";
        // Set up for delete actions
        $id = "user_id";
        $action = "delete_user.php";
    } elseif ($tablename == "blog") {
        $sql = "SELECT blog_id,user_id,blog_title,blog_createdAt,blog_modifiedAt,blog_contents,like_count FROM Blogs";
        // Set up for delete actions
        $id = "blog_id";
        $action = "delete_blog.php";

    } else {
        echo("Error: Invalid request parameter");
        die();

    }

    $result = $pdo->query($sql);

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
            $delete = "<td><form method=\"GET\" action=\"php/".$action."\"><input type=\"hidden\" name=\"".$id."\" value=\"".$entry[0]."\"><button type=\"submit\">Delete</button></form></td>";
            $tbody .= $row.$delete;

            //Add 'admin button' for user page
            if($tablename=="user" ) {
                //Check if current user is a USER, then add 'add admin'
                if($entry['role_id'] == 1) {
                $addadmin = "<td><form method='POST' action='php/addadmin.php'><input type='hidden' name='".$id."' value='".$entry[0]."'><button type='submit'>Add Admin</button></form></td>";
                $tbody .= $addadmin;
                }
            }
            //Add 'admin button' remove admin for admin page
            if($tablename=="admin" ) {
                $removedadmin = "<td><form method='POST' action='php/removeadmin.php'><input type='hidden' name='".$id."' value='".$entry[0]."'><button type='submit'>Remove Admin</button></form></td>";
                $tbody .= $removedadmin;

            }

            $tbody.="</tr>";
        }
        $table .= $tbody."</tbody></table>";
        echo $table;
    } else {
        echo "Error: Empty Table";
    }
?>