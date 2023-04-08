//check passwords

function isBlank(inputField)
{
    return inputField.value == "";

}

function makeRed(inputDiv){
    inputDiv.style.borderColor="#AA0000";
}

function makeClean(inputDiv){
    inputDiv.style.borderColor="#FFFFFF";
}

function checkMatchingPassword(e) {

    var password = document.getElementById("password");
    var password_check = document.getElementById("verifyPassword");

    if(password.value === password_check.value) {
        mainForm.submit();
    } else {
        makeRed(password);
        makeRed(password_check);
        alert("Passwords do not match");
        e.preventDefault();
    }

}

window.onload = function()
{
    var mainForm = document.getElementById("updateuser-form");
    var requiredInputs = document.querySelectorAll(".required");

    mainForm.onsubmit = function(e)
    {
        var err = false;
        for (var i=0; i < requiredInputs.length; i++)
        {
            if( isBlank(requiredInputs[i]))
            {
                err |= true;
                makeRed(requiredInputs[i]);
            }
            else
            {
                makeClean(requiredInputs[i]);
            }
        }
        checkPasswordMatch(e);
    }
}
