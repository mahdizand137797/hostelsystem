<?php

//اضافه کردن فایل کانفیک به این صفحه این فایل شامل اطلاعات لازم برای اتصال به پایگاه داده است
require_once('config.php');

//تنظیم اکشن 
$action = (isset($_POST['action'])) ? $_POST['action'] : '';

//بر اساس اکشن تنظیم شده، تابع مربوطه فراخوانی می شود
switch ($action) {
	case "insert_user":
		insert_user();
		break;
	default:
		display_form_register('', '');
		break;
}

//وظیفه این تابع، نمایش فرم رزرو است 	
function display_form_register($u_username, $u_email)
{
?>
	<!DOCTYPE html>
	<html lang="fa" dir="rtl">
	<head>
		<title>ثبت نام - سایت مدیریت مهمان پذیر</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
		<link href="css/bootstrap.rtl.min.css" rel="stylesheet">
		<script src="js/jquery-3.6.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
	</head>

	<body>
		<div class="container row d-flex justify-content-center align-items-center" style="height: 100vh">
		<div class="col-12 col-lg-12 col-xl-11 col-sm-10">
			<div class="card ">
				<h3 class=" text-center pt-3">ثبت نام مشتریان</h3>
				<div class="panel-body" id="register">
					<div class="form-group">
						<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="myform" novalidate>
							<input type="hidden" name="action" value="insert_user" />
							<div class="form-group">
								<dl>
									<dd>
										<label>نام کاربری :</label>
										<input class="form-control" type="text" name="u_username" id="u_username" size="25" maxlength="25" autofocus pattern=".{3,25}" title="حداقل شامل 3 کاراکتر" autofocus value="<?php echo $u_username ?>" />

										<span class="error"><?php if (isset($GLOBALS['u_username_err'])) echo $GLOBALS['u_username_err']; ?></span>
									</dd>
									<div class="form-group">
										<dd>
											<label>ایمیل :</label>
											<input class="form-control" id="exampleInputEmail1" type="email" name="u_email" size="25" maxlength="25" value="<?php echo $u_email ?>" />

											<span class="error"><?php if (isset($GLOBALS['u_email_err'])) echo $GLOBALS['u_email_err']; ?></span>
										</dd>
										<div class="form-group">
											<dd>
												<label>کلمه عبور :</label>
												<input class="form-control" id="u_password" type="password" name="u_password" size="25" maxlength="25" pattern=".{3,25}" title="حداقل شامل 3 کاراکتر" />

												<span class="error"><?php if (isset($GLOBALS['u_password_err'])) echo $GLOBALS['u_password_err']; ?></span>
											</dd>
											<div class="form-group">
												<dd>
													<label>تکرار کلمه عبور :</label>
													<input class="form-control" id="u_password_repeat" type="password" name="u_password_repeat" size="25" maxlength="25" pattern=".{3,25}" title="حداقل شامل 3 کاراکتر" />

													<span class="error"><?php if (isset($GLOBALS['u_password_repeat_err'])) echo $GLOBALS['u_password_repeat_err']; ?></span>
												</dd>
												<div class="form-group">
													<dd class="button" class="btn  btn-block">
														<input class="btn btn-primary" type="submit" value="ثبت اطلاعات" />
														<input class="btn btn-secondary" type="reset" value="تصحيح" />
													</dd>
								</dl>
						</form>
					</div>
				</div>
			</div>
		</div>
		</div>
		</div>
		<script src="js/validate.js"></script>
	</body>

	</html>
<?php
}

//وظیفه این تابع، درج اطلاعات ارسال شده از فرم در پایگاه داده است
function insert_user()
{
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//متغییرهایی برای ذخیره پیغام های خطا
		global $u_username_err;
		global $u_email_err;
		global $u_password_err;
		global $u_password_repeat_err;
		global $conn;
		$u_username_err = $u_email_err = $u_password_err = $u_password_repeat_err = '';

		//تنظیم مقادیر ارسال شده از سمت کاربر
		$u_username = test_input($_POST['u_username']);
		$u_email = test_input($_POST['u_email']);
		$u_password = test_input($_POST['u_password']);
		$u_password_repeat = test_input($_POST['u_password_repeat']);

		//اعتبار سنجی اطلاعات ارسال شده
		if (empty($u_username)) {
			$u_username_err = "*نام کاربری را وارد کنید";
		} else if (!preg_match("/^.{3,25}$/", $u_username)) {
			$u_username_err = "باید حداقل شامل 3 کاراکتر باشد";
		}
		//---------
		if (empty($u_email)) {
			$u_email_err = "وارد کردن ایمیل الزامی است";
		} else if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $u_email)) {
			$u_email_err = "فرمت ایمیل صحیح نیست";
		}
		//---------
		if (empty($u_password)) {
			$u_password_err = "کلمه عبور را وارد کنید";
		} else if (!preg_match("/^.{3,25}$/", $u_password)) {
			$u_password_err = "کلمه عبور باید حداقل شامل 3 کاراکتر باشد";
		}
		//---------
		if (empty($u_password_repeat)) {
			$u_password_repeat_err = "الزامی است";
		} else if ($u_password != $u_password_repeat) {
			$u_password_repeat_err = "تکرار کلمه عبور صحیح نیست";
		}


		//اگر هر کدام از متغیرهای خطا مقداردهی شده باشد، فرم رزرو با پیغام های مناسب نمایش داده می شود و اجرای تابع متوقف می شود 
		if ($u_username_err != '' || $u_email_err != '' || $u_password_err != '' || $u_password_repeat_err != '') {
			display_form_register($u_username, $u_email);
			return;
		}

		$conn->set_charset('utf8');

		//بررسی تکراری نبودن نام کاربری 
		if ($stmt = $conn->prepare("SELECT * FROM users WHERE u_username=? LIMIT 1")) {
			//بايند کردن پارامترها
			$u_username = $_POST['u_username'];
			$stmt->bind_param("s", $u_username);

			//اجراي کوئري
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows > 0) {
				echo "<div class='alert alert-danger text-center' role='alert'>نام کاربری تکراری است لطفا نام کاربری دیگری را وارد کنید.</div>";
				display_form_register($u_username, $u_email);
				return;
			} else {
				//تنظیم کوئری و اطمینان از صحت کار
				if ($stmt = $conn->prepare("INSERT INTO users (
						u_username,
						u_email,
						u_password)  
						VALUES(?,?,?)")) {
					$stmt->bind_param(
						"sss",
						$u_username,
						$u_email,
						$u_password
					);
					$stmt->execute();
					echo "<div  class='alert alert-success text-center' role='alert'>عملیات ثبت نام با موفقیت انجام شد.</div>";
				} else {
					$error = "عدم اجرای دستور Prepare <br /> شماره خطا = $conn->errno <br /> متن خطا = $conn->error";
					display_form_register($u_username, $u_email);
					return;
				}
			}
		}
	}
}
//وظیفه این تابع استاندارد کردن مقدار فیلدهای ارسالی است
function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>