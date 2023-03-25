
function userTableRequest(tablename) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200) {
            document.getElementById("table").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","php/adminmanager.php"+"?tablename="+tablename,true);
    xhttp.send();



}