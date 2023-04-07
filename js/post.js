$(document).ready(function () {
    $('#like-form').submit(function (event) {
        event.preventDefault()
        var formData = $(this).serialize()
        $.ajax({
            url: 'php/like_handler.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                if($('#action').val() == "like") {
                    console.log(response);
                    $("#like-btn").html("Unlike");
                    $('input[name="action"').val("unlike");
                } else {
                    console.log(response);
                    $("#like-btn").html("Like");
                    $('#action').val("like");
                }
                $("#like-count").html("Likes: " + response);
                //TODO: Change format of the btn, so that USER cannot LIKE again
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        })

    })

})