<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
	<title>سایت مدیریت مهمان پذیر</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<link href="css/bootstrap.rtl.min.css" rel="stylesheet">

</head>

<body>
	<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="padding:70px;">
		<div class="form-group">
			<div class="panel panel-primary">
				<div class="panel-body">
					<?php include_once("menu.php"); ?>
					<div id="main">
					<div class="row justify-content-center">
						<?php include_once("slider.php"); ?>
					</div>
						<div id="right">
							<?php include($page_content); ?>
						</div>
						<div style="clear:both;"></div>
					</div>
				</div>
			</div>
		</div>


        <script src="js/jquery-3.6.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>


</body>

</html>