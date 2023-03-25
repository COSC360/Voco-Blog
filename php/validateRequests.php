<?php
    function validatePostRequest($POST,$SERVER) {
        if (!$SERVER['REQUEST_METHOD'] == "POST"){
            echo "Error: Invalid request method to php server";
            return 0;
        } else {

            foreach($POST as $param) {
                if (!isset($param)) {
                    echo "Error: Parameter".$param." is not set";
                    return 0;
                }
            }
    }
    return 1;
}


function validateGetRequest($POST,$SERVER) {
    if (!$SERVER['REQUEST_METHOD'] == "GET"){
        echo "Error: Invalid request method to php server";
        return 0;
    } else {

        foreach($POST as $param) {
            if (!isset($param)) {
                echo "Error: Parameter".$param." is not set";
                return 0;
            }
        }
}
return 1;
}
?>