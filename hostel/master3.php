<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<link href="css/bootstrap.rtl.min.css" rel="stylesheet">
	<script src="js/jquery-3.6.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container-fluid col-12 col-lg-10 px-0">
		<?php include_once("menu.php"); ?>
		<div class="row justify-content-center">
			<?php include_once("slider.php"); ?>
		</div>
		<div id="right">
			<?php include($page_content); ?>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>

</html>