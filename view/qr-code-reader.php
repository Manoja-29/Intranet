<!-- Index.html file -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 Admin &amp; Dashboard Template">
    <meta name="author" content="Bootlab">

    <link rel="canonical" href="https://appstack.bootlab.io/dashboard-default.html" />
    <link rel="shortcut icon" href="img/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Choose your prefered color scheme -->
    <link href="css/light.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="style.css">
    <title>QR Code Scanner / Reader
    </title>

    <style type="text/css">
        #my-qr-reader {
            padding: 20px !important;
            border: 1.5px solid #b2b2b2 !important;
            border-radius: 8px;
        }

        #my-qr-reader img[alt="Info icon"] {
            display: none;
        }

        button {
            padding: 10px 20px;
            border: 1px solid #b2b2b2;
            outline: none;
            border-radius: 0.25em;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin-top: 15px;
            margin-bottom: 10px;
            background-color: #008000ad;
            transition: 0.3s background-color;
        }

        button:hover {
            background-color: #008000;
        }

        #html5-qrcode-anchor-scan-type-change {
            text-decoration: none !important;
            color: #1d9bf0;
        }

        video {
            width: 100% !important;
            border: 1px solid #b2b2b2 !important;
            border-radius: 0.25em;
        }

    </style>
</head>

<body>
<div class="container-fluid">
    <?php
    $msg=$_REQUEST['attendance'];
    ?>
    <form method="GET" enctype="multipart/form-data">
        <input id="attendance_id" class="attendance_id" type="hidden" value="<?php echo $msg?>">
    </form>
    <div id="users-present"></div>


    <div id="reader">
    </div>
    <div class="qr-alert"></div>
</div>

<script src="js/app.js"></script>
<script src="js/html5-test.min.js"></script>

<script type="text/javascript">

    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        console.log(`Code matched = ${decodedText}`, decodedResult);

        var IdEncoded = btoa(decodedText);

        var url = 'https://onenine-solutions.lk/intra/view/qr-code-reader.php';
        var userid = '?attendance=' + IdEncoded; // unique timestamp
        var refreshedUrl = url + userid;
        location.replace(refreshedUrl); // navigate to the refreshed URL

    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        console.warn(`Code scan error = ${error}`);
    }
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250},
            rememberLastUsedCamera: false
        });

    //implement the scanner
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);

    function checkExist() {
        var attendance_id = document.getElementById('attendance_id').value;

        $.ajax({
            url: "../controller/qr_attendance_controller.php?status=check_exist",
            method: 'GET',
            cache: false,
            data: {
                attendance_id: attendance_id
            },
            dataType: 'text',
            success: function(response) {
                if (response.error) {

                    showError(response.error);
                } else {
                    alert('works fine');

                }
            },
            error: function() {
                showError('Failed to fetch user data. Please try again.');
            },
        });
    }

    var field = 'attendance';
    var url = window.location.href;
    //Check if a string (parameter) is found in URL
    if(url.indexOf('?' + field + '=') != -1){

        var attendance_id = document.getElementById('attendance_id').value;

        $.ajax({
            url: "../controller/qr_attendance_controller.php?status=add_qr_attendance",
            type: "GET",
            dataType: 'text',
            cache: false,
            data: {
                attendance_id: attendance_id
            },
            success: function() {
                alert('successfully checked in');
                // Success message
                $('#qr-alert').html("<div class='alert alert-success'>");
                $('#qr-alert > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                    .append("</button>");
                $('#qr-alert > .alert-success')
                    .append("<strong>Your message has been sent. </strong>");
                $('#qr-alert > .alert-success')
                    .append('</div>');

            },
            error: function (xhr, status, errorThrown) {
                //Here the status code can be retrieved like;
                alert(xhr.status);

                //The message added to Response object in Controller can be retrieved as following.
                alert(xhr.responseText);
            }
            })

    }
    else{
        alert('Please scan the code');
    }

</script>
</body>

</html>