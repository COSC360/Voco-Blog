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
        $sql = "SELECT * FROM Users WHERE role_id=2";
    } elseif ($tablename == "user") {
        $sql = "SELECT * FROM Users";
    } elseif ($tablename == "blog") {
        $sql = "SELECT * FROM Blogs";
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
                //Result set weirdness makes have to do this check
                if(is_int($key)) {
                $row .= "<td>".$value."</td>";
                }
            }
            $tbody .= $row."</tr>";
        }
        $table .= $tbody."</tbody></table>";
        echo $table;
    } else {
        echo "Empty Table";
    }
?>