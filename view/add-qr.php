<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<?php
include '../commons/phpqrcode/phpqrcode/qrlib.php';
$text = "codedamn123";//employee name and ID , save it in database
QRcode::png($text, 'img/qrcodes/image2.png');
?>

<img src="img/qrcodes/image2.png" alt="" height="300px" width="300px">
</body>

</html>