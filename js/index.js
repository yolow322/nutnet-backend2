/**
 * Sends inputs values from user form to the database without redirect
 */
function sendForm() {
    $('.create-user').submit(function () {
        let inputValues = $('.create-user').serialize();
        $.ajax({
            url: 'src/create_new_user.php',
            method: 'POST',
            dataType: 'json',
            data: inputValues,
            success: function (data) {
                if (data.status === 'success') {
                    $('#form-submission-status').html("<p class='alert alert-success' role='alert'>" + data.message + "</p>").fadeIn('slow');
                    setTimeout("$('#form-submission-status').fadeOut('slow');", 4000);
                } else {
                    $('#form-submission-status').empty();
                    $.each(data, function (key, value) {
                        $('#form-submission-status').append("<p class='alert alert-danger' role='alert'>" + value.message + "</p>").fadeIn('slow');
                        setTimeout("$('#form-submission-status').fadeOut('slow');", 4000);
                    });
                }
            }
        });
        return false;
    });
}

/**
 * Sends users info from the database to the Google Sheet by pressing button
 */
function sendUsersToGoogleSheet() {
    $('#send-to-google-sheet').click(function () {
        $.ajax({
            url: 'src/insert_users_to_google_sheet.php',
            method: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    $('#google-sheet-send-status').html("<p class='alert alert-success' role='alert'>" + data.message + "</p>").fadeIn('slow');
                    setTimeout("$('#google-sheet-send-status').fadeOut('slow');",4000);
                } else {
                    $('#google-sheet-send-status').html("<p class='alert alert-danger' role='alert'>" + data.message + "</p>").fadeIn('slow');
                    setTimeout("$('#google-sheet-send-status').fadeOut('slow');",4000);

                }
            }
        });
    });
}

$(document).ready(function () {
    sendForm();
    sendUsersToGoogleSheet();
});
