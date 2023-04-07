$(document).ready(function () {
    $('#like-form').submit(function (event) {
        console.log("submitting");
        event.preventDefault()
        var formData = $(this).serialize()
        $.ajax({
            url: 'php/like_handler.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#like_count').append(response)
                //TODO: Change format of the btn, so that USER cannot LIKE again
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        })
    })
})