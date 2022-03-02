<?php
session_start();
if (!isset($_SESSION['u_username'])) {
	header('Location: login.php');
}
?>
<div class="row justify-content-center">
	<?php include_once("slider.php"); ?>
</div>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid justify-content-center">
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse justify-content-center" id="navbarTogglerDemo01">
				<a class="navbar-brand" href="index.php">مهمان پذیر</a>
				<ul class="navbar-nav mx-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="index.php">صفحه اصلی</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="khadamat.php">خدمات</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="contact_us.php">تماس با ما</a>
					</li>
					<li class="nav-item">
						<a class="nav-link " href="about.php">درباره ما</a>
					</li>

					<div class="ms-auto">

						<a class="nav-link text-light" href="logout.php">خروج </a>

					</div>
			</div>
		</div>
	</nav>
</nav>

<?php
//اضافه کردن فایل کانفیک به این صفحه
//این فایل شامل اطلاعات لازم برای اتصال به پایگاه داده است
require_once('config.php');

//تنظیم اکشن 
$action = (isset($_POST['action'])) ? $_POST['action'] : '';

//بر اساس اکشن تنظیم شده، تابع مربوطه فراخوانی می شود
switch ($action) {
	case "reserve":
		insert_reserve();
		break;
	default:
		display_form_reserve('', '', '', '', '', '', '', '', '', '', '');
		break;
}

//وظیفه این تابع، نمایش فرم رزرو است 	
function display_form_reserve($r_code_meli, $r_name, $r_fname, $r_tel, $r_code_posti, $r_date_vorod, $r_date_khoroj, $r_meghdar_eghamat, $r_tedad_otagh, $r_tedad_hamrah, $r_adres)
{
?>
	<!DOCTYPE html>
	<html lang="fa" dir="rtl">

	<head>
		<title>سایت مدیریت مهمان پذیر</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
		<link href="css/bootstrap.rtl.min.css" rel="stylesheet">
		<script src="js/jquery-3.6.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>

	<body>
			<div class="form-group " style="padding:50px;">
				<div class="container mt-2 mx-auto">
					<div class="row">
						<div class="card">
							<div class="form-group">
								<h1><?php if (isset($_SESSION['u_username'])) {
										echo "<br> سلام " . $_SESSION['u_username'] . " " . "عزیز خوش آمدید";
									} ?></h1><br><br>
								<h2>رزرو اتاق مهمان پذیر</h2>
								<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
									<input type="hidden" name="action" value="reserve" />
									<div class="form-group">
										<dl>
											<dd>
												<label>نام :</label>
												<input type="text" class="form-control" name="r_name" size="25" maxlength="25" required pattern="\D{1,25}" title="فقط کاراکترهای غیرعددی" value="<?php echo $r_name ?>" />
												<span class="error"><?php if (isset($GLOBALS['r_name_err'])) echo $GLOBALS['r_name_err']; ?></span>
											</dd>
											<dd>
												<label>نام خانوادگی :</label>
												<input type="text" class="form-control" name="r_fname" size="25" maxlength="25" required pattern="\D{1,25}" title="فقط کاراکترهای غیرعددی" value="<?php echo $r_fname ?>" />
												<span class="error"><?php if (isset($GLOBALS['r_fname_err'])) echo $GLOBALS['r_fname_err']; ?></span>
											</dd>
											<dd>
												<label>کد ملی :</label>
												<input type="text" class="form-control" name="r_code_meli" size="25" maxlength="10" required pattern="\d{10}" title="فقط شامل 10 عدد" autofocus value="<?php echo $r_code_meli ?>" />
												<span class="error"><?php if (isset($GLOBALS['r_code_meli_err'])) echo $GLOBALS['r_code_meli_err']; ?></span>
											</dd>
											<dd>
												<label>تلفن :</label>
												<input type="text" class="form-control" name="r_tel" size="25" maxlength="25" required pattern="([0-9]{3,4}-)?([0-9]{7,11})?" title="فقط شامل کاراکترهای عددی و خط تیره" value="<?php echo $r_tel ?>" />
												<span class="error"><?php if (isset($GLOBALS['r_tel_err'])) echo $GLOBALS['r_tel_err']; ?></span>
											</dd>
											<dd>
												<label>کدپستی :</label>
												<input type="text" class="form-control" name="r_code_posti" size="25" maxlength="10" required pattern="\d{10}" title="فقط شامل 10 عدد" value="<?php echo $r_code_posti ?>" />
												<span class="error"><?php if (isset($GLOBALS['r_code_posti_err'])) echo $GLOBALS['r_code_posti_err']; ?></span>
											</dd>
											<dd>
												<label>تاریخ ورود :</label>
												<input type="text" class="form-control" name="r_date_vorod" size="25" maxlength="25" required pattern="([0-9]{2,4}[/])([0-9]{2}[/])([0-9]{2})" title="فرمت تاریخ صحیح نیست - 1400/08/21" value="<?php echo $r_date_vorod ?>" />
												<span class="error"><?php if (isset($GLOBALS['r_date_vorod_err'])) echo $GLOBALS['r_date_vorod_err']; ?></span>
											</dd>
											<dd>
												<label>تاریخ خروج :</label>
												<input type="text" class="form-control" name="r_date_khoroj" size="25" maxlength="25" required pattern="([0-9]{2,4}[/])([0-9]{2}[/])([0-9]{2})" title="فرمت تاریخ صحیح نیست - 1400/08/21" value="<?php echo $r_date_khoroj ?>" />
												<span class="error"><?php if (isset($GLOBALS['r_date_khoroj_err'])) echo $GLOBALS['r_date_khoroj_err']; ?></span>
											</dd>
											<dd>
												<label>مدت اقامت :</label>
												<input type="text" class="form-control" name="r_meghdar_eghamat" size="25" maxlength="25" required value="<?php echo $r_meghdar_eghamat ?>" />
												<span class="error"><?php if (isset($GLOBALS['r_meghdar_eghamat_err'])) echo $GLOBALS['r_meghdar_eghamat_err']; ?></span>
											</dd>
											<dd>
												<label>تعداد اتاق :</label>
												<input type="text" class="form-control" name="r_tedad_otagh" size="25" maxlength="25" required value="<?php echo $r_tedad_otagh ?>" />
												<span class="error"><?php if (isset($GLOBALS['r_tedad_otagh_err'])) echo $GLOBALS['r_tedad_otagh_err']; ?></span>
											</dd>
											<dd>
												<label>تعداد همراهان :</label>
												<input type="text" class="form-control" name="r_tedad_hamrah" size="25" maxlength="25" required value="<?php echo $r_tedad_hamrah ?>" />
												<span class="error"><?php if (isset($GLOBALS['r_tedad_hamrah_err'])) echo $GLOBALS['r_tedad_hamrah_err']; ?></span>
											</dd>
											<dd>
												<label>آدرس :</label>
												<textarea type="text" class="form-control" name="r_adres" rows="2" cols="35" maxlength="100" required><?php echo $r_adres ?></textarea>
												<span class="error"><?php if (isset($GLOBALS['r_adres_err'])) echo $GLOBALS['r_adres_err']; ?></span>
											</dd>
											<dd class="button">
												<input type="submit" class="btn btn-primary" value="ثبت اطلاعات" />
												<input type="reset" class="btn btn-secondary" value="تصحيح" />
											</dd>
										</dl>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php
}

//وظیفه این تابع، درج اطلاعات ارسال شده از فرم در پایگاه داده است
function insert_reserve()
{
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//متغییرهایی برای ذخیره پیغام های خطا
		global $conn;
		global $r_code_meli_err;
		global $r_name_err;
		global $r_fname_err;
		global $r_tel_err;
		global $r_code_posti_err;
		global $r_date_vorod_err;
		global $r_date_khoroj_err;
		global $r_meghdar_eghamat_err;
		global $r_tedad_otagh_err;
		global $r_tedad_hamrah_err;
		global $r_adres_err;
		$r_code_meli_err = $r_name_err = $r_fname_err = $r_tel_err = $r_code_posti_err = $r_date_vorod_err = $r_date_khoroj_err = $r_meghdar_eghamat_err = $r_tedad_otagh_err = $r_tedad_hamrah_err = $r_adres_err = '';

		//تنظیم مقادیر ارسال شده از سمت کاربر
		$r_code_meli = test_input($_POST['r_code_meli']);
		$r_name = test_input($_POST['r_name']);
		$r_fname = test_input($_POST['r_fname']);
		$r_tel = test_input($_POST['r_tel']);
		$r_code_posti = test_input($_POST['r_code_posti']);
		$r_date_vorod = test_input($_POST['r_date_vorod']);
		$r_date_khoroj = test_input($_POST['r_date_khoroj']);
		$r_meghdar_eghamat = test_input($_POST['r_meghdar_eghamat']);
		$r_tedad_otagh = test_input($_POST['r_tedad_otagh']);
		$r_tedad_hamrah = test_input($_POST['r_tedad_hamrah']);
		$r_adres = test_input($_POST['r_adres']);

		//اعتبار سنجی اطلاعات ارسال شده
		if (empty($r_code_meli)) {
			$r_code_meli_err = "الزامی است";
		} else if (!preg_match("/^\d{10}$/", $r_code_meli)) {
			$r_code_meli_err = "فقط شامل 10 کاراکتر عددی";
		}
		//---------
		if (empty($r_name)) {
			$r_name_err = "الزامی است";
		} else   if (preg_match('/^[^\x{600}-\x{6FF}]+$/u', str_replace("\\\\", "", $r_name))) {
			$r_name_err = "فقط شامل کاراکترهای غیر عددی";
		}
		//---------
		if (empty($r_fname)) {
			$r_fname_err = "الزامی است";
		} else   if (preg_match('/^[^\x{600}-\x{6FF}]+$/u', str_replace("\\\\", "", $r_fname))) {
			$r_fname_err = "فقط شامل کاراکترهای غیر عددی";
		}
		//---------
		if (empty($r_tel)) {
			$r_tel_err = "الزامی است";
		} else if (!preg_match("/^([0-9]{3,4}-)?([0-9]{7,11})?$/", $r_tel)) {
			$r_tel_err = "فقط شامل کاراکترهای عددی و خط تیره";
		}
		//---------
		if (empty($r_code_posti)) {
			$r_code_posti_err = "الزامی است";
		} else if (!preg_match("/^\d{10}$/", $r_code_posti)) {
			$r_code_posti_err = "فقط شامل 10 کاراکتر عددی";
		}
		//---------
		if (empty($r_date_vorod)) {
			$r_date_vorod_err = "الزامی است";
		} else if (!preg_match("/^([0-9]{2,4}\/)([0-9]{2}\/)([0-9]{2})?$/", $r_date_vorod)) {
			$r_date_vorod_err = "فرمت تاریخ صحیح نیست - 93/05/09";
		}
		//---------
		if (empty($r_date_khoroj)) {
			$r_date_khoroj_err = "الزامی است";
		} else if (!preg_match("/^([0-9]{2,4}\/)([0-9]{2}\/)([0-9]{2})?$/", $r_date_khoroj)) {
			$r_date_khoroj_err = "فرمت تاریخ صحیح نیست - 93/05/09";
		}
		//---------
		if (empty($r_meghdar_eghamat)) {
			$r_meghdar_eghamat_err = "الزامی است";
		}
		//---------
		if (empty($r_tedad_otagh)) {
			$r_tedad_otagh_err = "الزامی است";
		}
		//---------
		if (empty($r_tedad_hamrah)) {
			$r_tedad_hamrah_err = "الزامی است";
		}
		//---------
		if (empty($r_adres)) {
			$r_adres_err = "الزامی است";
		}

		//اگر هر کدام از متغیرهای خطا مقداردهی شده باشد، فرم رزرو با پیغام های مناسب نمایش داده می شود و اجرای تابع متوقف می شود 
		if ($r_code_meli_err != '' || $r_name_err != '' || $r_fname_err != '' || $r_tel_err != '' ||  $r_code_posti_err != '' ||  $r_date_vorod_err != '' || $r_date_khoroj_err != '' || $r_meghdar_eghamat_err != '' || $r_tedad_otagh_err != '' || $r_tedad_hamrah_err != '' || $r_adres_err != '') {
			display_form_reserve($r_code_meli, $r_name, $r_fname, $r_tel, $r_code_posti, $r_date_vorod, $r_date_khoroj, $r_meghdar_eghamat, $r_tedad_otagh, $r_tedad_hamrah, $r_adres);
			return;
		}


		//مقادیر ارسال شده از سمت کاربر، نباید خالی باشد
		if (empty($r_code_meli) || empty($r_name) || empty($r_fname) || empty($r_tel) || empty($r_code_posti) || empty($r_date_vorod) || empty($r_date_khoroj) || empty($r_meghdar_eghamat) || empty($r_tedad_otagh) || empty($r_tedad_hamrah) || empty($r_adres)) {
			$error = "لطفاً همه فیلدها را پر کنید.";
			display_form_reserve(
				$r_code_meli,
				$r_name,
				$r_fname,
				$r_tel,
				$r_code_posti,
				$r_date_vorod,
				$r_date_khoroj,
				$r_meghdar_eghamat,
				$r_tedad_otagh,
				$r_tedad_hamrah,
				$r_adres
			);
			return;
		}

		$conn->set_charset('utf8');
		$u_username = (isset($_SESSION['u_username'])) ? $_SESSION['u_username'] : NULL;

		//درج اطلاعات فرم در پایگاه داده
		if ($stmt = $conn->prepare("INSERT INTO reserve (
										r_uid,
										r_code_meli,
										r_name,
										r_fname,
										r_tel,
										r_code_posti,
										r_date_vorod,
										r_date_khoroj,
										r_meghdar_eghamat,
										r_tedad_otagh,
										r_tedad_hamrah,
										r_adres)  
										VALUES((select u_id from users where u_username=?),?,?,?,?,?,?,?,?,?,?,?)")) {
			$stmt->bind_param(
				"ssssssssssss",
				$u_username,
				$r_code_meli,
				$r_name,
				$r_fname,
				$r_tel,
				$r_code_posti,
				$r_date_vorod,
				$r_date_khoroj,
				$r_meghdar_eghamat,
				$r_tedad_otagh,
				$r_tedad_hamrah,
				$r_adres
			);
			$stmt->execute();
			echo "<div  class='card alert alert-success text-center' role='alert'>عملیات رزرو با موفقیت انجام شد.</div>";
		} else {
			$error = "عدم اجرای دستور Prepare <br /> شماره خطا = $conn->errno <br /> متن خطا = $conn->error";
			display_form_reserve($r_code_meli, $r_name, $r_fname, $r_tel, $r_code_posti, $r_date_vorod, $r_date_khoroj, $r_meghdar_eghamat, $r_tedad_otagh, $r_tedad_hamrah, $r_adres);
			return;
		}

		//بستن ارتباط با پایگاه داده
		$stmt->close();
		$conn->close();
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