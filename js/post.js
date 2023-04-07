window.onload = function() {

    var form = document.getElementById("like-form");

    $
    like_btn.addEventListener("onclick",function() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if(this.readyState == 4 && this.status == 200) {
                document.getElementById("like_count").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET",pagename+"?tablename="+tablename,true);
        xhttp.send();
    })
}
