<?php
session_start();

if(!isset($_SESSION['u_username_paziresh']))
{
	header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
	<title>سایت مدیریت مهمان پذیر</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <link href="../css/bootstrap.rtl.min.css" rel="stylesheet">
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</head>
<body>
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="padding:70px;">
		<div class="form-group">
			<div class="panel panel-primary">
				<div class="panel-body">
	<?php include_once("menu.php"); ?>
	<div id="main">
		<div><?php include($page_content);?></div>
	</div>
	<div style="clear:both;"></div>
	</div>
</div>		
</div>		
</div>		
</body>
</html>