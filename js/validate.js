window.onload = function()
{
  console.log("ready");
    var form = document.getElementById("newuser-form");

    form.onsubmit = function (e) {

      console.log("checking password match");
      checkMatchingPassword(e);
    }

}
