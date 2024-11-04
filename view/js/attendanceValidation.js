let currentUserId = sessionStorage.getItem('currentloggedin');
let timerInterval;

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
        showError('Invalid user ID. Please try again.');
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
        beforeSend: function () {
            showLoading();
        },
        success: function (response) {
            hideLoading();
            if (response.error) {
                showError(response.error);
            } else {
                populateUserLists(response.present, $('#users-present'));
                populateUserLists(response.absent, $('#users-absent'));
            }
        },
        error: function () {
            hideLoading();
            showError('Failed to fetch user data. Please try again.');
        },
    });
}

function populateUserLists(users, listElement) {
    listElement.empty();
    users.forEach(function (user) {
        const listItem = $('<div></div>');
        listItem.text(user.text);

        const checkInOutBtn = $('<button></button>');
        checkInOutBtn.text(user.is_present ? 'Check Out' : 'Check In');
        checkInOutBtn.addClass(user.is_present ? 'btn btn-danger' : 'btn btn-success');
        checkInOutBtn.attr('id', user.is_present ? 'btn-checkout' : 'btn-checkin');

        if (user.check_in !== '') {
            $("#checked-in").addClass("glyphicon glyphicon-time");
            $("#checked-in").html('Checked in at ' + user.check_in);
            $("#checked-in").addClass("alert alert-success");
        }
        checkInOutBtn.click(function () {
            if ((user.check_in && user.check_out) !== '') {
                $("#alertDiv").html("Already checked out");
                $("#alertDiv").addClass("alert alert-danger");
                return false;
            } else {
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

function checkInOutUser(userId, isPresent, time, check_out) {
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
        beforeSend: function () {
            showLoading();
        },
        success: function (response) {
            hideLoading();
            if (response.error) {
                showError(response.error);
            } else {
                getUsers();
                if (isPresent) {
                    
                    const now = new Date();
                    const options = { hour: '2-digit', minute: '2-digit', hour12: true };
                    let formattedTime = now.toLocaleTimeString([], options);
                    formattedTime = formattedTime.replace("am", "AM").replace("pm", "PM");
                    $('#currentTime').text(formattedTime);

                    // Save check-in time with user-specific key
                    localStorage.setItem(`checkInTime_${currentUserId}`, formattedTime);
                    localStorage.setItem(`startTime_${currentUserId}`, now.getTime());
                    startTimer();
                } else {
                    stopTimer();
                    // Clear check-in time with user-specific key
                    localStorage.removeItem(`checkInTime_${currentUserId}`);
                    localStorage.removeItem(`startTime_${currentUserId}`);
                }
            }
        },
        error: function () {
            hideLoading();
            showError('Failed to update user status. Please try again.');
        },
    });
}

function startTimer() {
    if (!timerInterval) {
        timerInterval = setInterval(updateTimerDisplay, 1000);
    }
}

function stopTimer() {
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
    resetTimerDisplay();
}

function updateTimerDisplay() {
    // Retrieve user-specific start time
    const startTime = localStorage.getItem(`startTime_${currentUserId}`);
    if (!startTime) {
        console.log("No start time available");
        return;
    }

    const now = new Date();
    const startDate = new Date(parseInt(startTime));

    if (now.getDate() !== startDate.getDate() || now.getMonth() !== startDate.getMonth() || now.getFullYear() !== startDate.getFullYear()) {
        localStorage.removeItem(`startTime_${currentUserId}`);
        $('#currentTime').text('');
        resetTimerDisplay();
        return;
    }

    const elapsedTime = now - new Date(parseInt(startTime));
    const hours = Math.floor(elapsedTime / (1000 * 60 * 60));
    const minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

    $('#hour').text((hours < 10 ? '0' : '') + hours + ' :');
    $('#minute').text((minutes < 10 ? '0' : '') + minutes + ' :');
    $('#second').text((seconds < 10 ? '0' : '') + seconds);
}

function resetTimerDisplay() {
    $('#hour').text('00 :');
    $('#minute').text('00 :');
    $('#second').text('00');
}

$(document).ready(function () {
    if (currentUserId) {
        getUsers();
    }

    // Display saved check-in time with user-specific key
    const savedCheckInTime = localStorage.getItem(`checkInTime_${currentUserId}`);
    if (savedCheckInTime) {
        $('#currentTime').text(savedCheckInTime);
    }

    // Restart timer if there's a saved start time with user-specific key
    const savedStartTime = localStorage.getItem(`startTime_${currentUserId}`);
    if (savedStartTime) {
        startTimer();
    }
});
