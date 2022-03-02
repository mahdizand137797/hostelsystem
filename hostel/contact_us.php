<?php include 'sendemail.php'; ?>

</div>
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

	<!--alert messages start-->
	<?php echo $alert; ?>
	<!--alert messages end-->

	<div class="container mt-2">
		<div class="row align-items-center">
			<div class="form-group " style="padding:50px;">
				<div class="row d-flex justify-content-center">
					<br>
					<?php include_once("menu.php"); ?>
					<?php include_once("slider.php"); ?>
				<div class="card ">
						<form class="contact" action="" method="post">
							<dl>
								<dd><label>نام و نام خانوادگی:</label><input class="form-control text-right" type="text" name="name" placeholder="نام شما" required /></dd>
								<dd><label>ايميل :</label><input class="form-control text-right" type="email" name="email" required /></dd>
								<dd><label>موضوع :</label><input class="form-control text-right" type="text" name="subject" placeholder="موضوع ایمیل" required /></dd>
								<dd><label>پيام :</label><textarea class="form-control text-right" type="text" name="message" rows="5" placeholder="پیام خود را بنویسید" required></textarea><br></dd>
								<dd class="button"><input class="form-control text-center submit btn-outline-success btn-block" type="submit" name="submit" value="ارسال"></dd>
							</dl>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


	<script type="text/javascript">
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>
	<script src="js/jquery-3.6.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>