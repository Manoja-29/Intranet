let currentUserId = sessionStorage.getItem('currentloggedin');

function showLoading() {
    $('#loading').show();
}

function hideLoading() {
    $('#loading').hide();
}

function showError(message) {
    $('#error-message').text(message);
    $('#error-message').show();
}

function hideError() {
    $('#error-message').text('');
    $('#error-message').hide();
}


function getUsers() {
    if (!currentUserId) {
        showError('Invalid building code. Please enter a valid building code.');
        return;
    }
    $.ajax({
        url: '../model/attendance_model_api.php',
        method: 'GET',
        cache: false,
        data: {
            action: 'get_users',
            user_id: currentUserId,
        },
        dataType: 'json',
        beforeSend: function() {
            showLoading();
        },
        success: function(response) {
            hideLoading();
            if (response.error) {

                showError(response.error);
            } else {
                populateUserLists(response.present, $('#users-present'));
                populateUserLists(response.absent, $('#users-absent'));

            }
        },
        error: function() {
            hideLoading();
            showError('Failed to fetch user data. Please try again.');
        },
    });
}

function populateUserLists(users, listElement) {
    listElement.empty();
    users.forEach(function(user) {
        const listItem = $('<div></div>');
        listItem.text(user.text);

        const checkInOutBtn = $('<button></button>');
        checkInOutBtn.text(user.is_present ? 'Check Out' : 'Check In');
        checkInOutBtn.addClass(user.is_present ? 'btn btn-danger' : 'btn btn-success');
        checkInOutBtn.attr('id', user.is_present ? 'btn-checkout' : 'btn-checkin');

        if(user.check_in  !=='') {
            $("#checked-in").addClass("glyphicon glyphicon-time");
            $("#checked-in").html('Checked in at ' + user.check_in);
            $("#checked-in").addClass("alert alert-success");
        }
        checkInOutBtn.click(function() {
            if((user.check_in && user.check_out) !==''){
                $("#alertDiv").html("Already checked out");
                $("#alertDiv").addClass("alert alert-danger");
                return false;
            }else{
                var result = confirm("Are you sure?");
                if (result) {

                    // Check in or check out
                    $("#alertDiv").html("Successful");
                    $("#alertDiv").addClass("alert alert-primary");
                    checkInOutUser(user.user_id, !user.is_present);

                } else {
                    // If request is cancelled
                    $("#alertDiv").html("Request denied");
                    $("#alertDiv").addClass("alert alert-primary");
                }
            }

        });


        listItem.append(' ', checkInOutBtn);
        listElement.append(listItem);
    });
}

function checkInOutUser(userId, isPresent, time,check_out) {
    $.ajax({
        url: '../model/attendance_model_api.php',
        method: 'POST',
        cache: false,
        data: {
            action: 'check_in_out',
            user_id: userId,
            is_present: isPresent ? 1 : 0,
            check_in: time,
            check_out: check_out
        },
        dataType: 'json',
        beforeSend: function() {
            showLoading();
        },
        success: function(response) {
            hideLoading();
            if (response.error) {
                showError(response.error);
            } else {
                getUsers();
            }
        },
        error: function() {
            hideLoading();
            showError('Failed to update user status. Please try again.');
        },
    });

}

$(document).ready(function() {

    if (currentUserId) {
        getUsers();
    }
});

