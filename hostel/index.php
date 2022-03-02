<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <title>سایت مدیریت مهمان پذیر</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />

</head>

<body>

<div class="container-fluid col-12 col-lg-10 px-0">
    <?php include_once("menu.php"); ?>

    <div class="row justify-content-center">
            <?php include_once("slider.php"); ?>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 " style="padding:50px;">
            <?php include_once "home_text.php"?>
        </div>
    </div>
</div>


    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>



<!--            --><?php //include($page_content); ?>



</body>

</html>