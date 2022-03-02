<?php 
if (!isset($_SESSION['u_username_paziresh'])) {
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
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="all" />
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <link href="../css/bootstrap.rtl.min.css" rel="stylesheet">
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

</head>

<body>
	<div class="container">
		<header class="row">
			<div class="card">
				<?php
				require_once("config.php");
				//تنظیم اکشن 
				$action = '';
				if (isset($_POST['action']) || isset($_GET['action'])) {
					//اگر کاربر روی لینک حذف یا ویرایش، کلیک کند، بصورت اتوماتیک، آی دی ردیف مورد نظر و همچنین اکشن نیز ارسال خواهد شد
					$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
				}

				//بر اساس اکشن تنظیم شده، تابع مربوطه فراخوانی می شود
				switch ($action) {
					case "update":
						$update_by_r_id = (isset($_POST['update_by_r_id'])) ? $_POST['update_by_r_id'] : '';
						update_by_id($update_by_r_id);
						break;
					case "display_form_update":
						$update_by_r_id = (isset($_GET['update_by_r_id'])) ? $_GET['update_by_r_id'] : '';
						display_form_update($update_by_r_id);
						break;
					case "delete":
						$delete_by_r_id = (isset($_GET['delete_by_r_id'])) ? $_GET['delete_by_r_id'] : '';
						delete_by_id($delete_by_r_id);
						break;
					case "search":
					default:
						fill_table_reserve();
						break;
				}

				//وظیفه این تابع، نمایش فرم لاگین است
				function fill_table_reserve()
				{
					//متغییرهایی که در جستجو استفاده می شود و مقادیری که کاربر وارد کرده در آن ذخیره می شود
					$search_r_code_meli = $search_r_fname = '';

					//اگر کاربر فیلدهای جستجو را تنظیم کند و روی دکمه جستجو کلیک کنید، مقادیر مورد نظر علاوه بر اینکه در متغییرهای جستجو قرار میگیرد
					//دو سشن هم نام با متغییرهای جستجو نیز ایجاد و مقداردهی می شود، از این سشن ها برای حفظ مقادیر، زمانی که بین صفحات حرکت می کنیم، استفاده می شود
					if (isset($_POST['search_r_code_meli']) || isset($_POST['search_r_fname'])) {
						$search_r_code_meli = $_SESSION['search_r_code_meli'] = $_POST['search_r_code_meli'];
						$search_r_fname = $_SESSION['search_r_fname'] = $_POST['search_r_fname'];
					} else if (isset($_SESSION['search_r_code_meli']) || isset($_SESSION['search_r_fname'])) {
						$search_r_code_meli = $_SESSION['search_r_code_meli'];
						$search_r_fname = $_SESSION['search_r_fname'];
					}


					//نمایش فرم جستجو
					display_search_form_reserve($search_r_code_meli, $search_r_fname);

					//ایجاد ارتباط به پایگاه داده
					$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
					$conn->set_charset('utf8');
					//اطمینان از صحت ارتباط
					if ($conn->connect_error) {
						$error = "متاسفانه نمي توان به پايگاه داده متصل شد.";
						fill_table_reserve();
						return;
					}

					//اگر فیلد جستجو توسط کاربر تنظیم نشود، می خواهیم که تمام ردیف ها نمایش داده شود، بنابراین آنرا با یک مقدار قراردادی 
					//تنظیم می کنیم، و با یک تغییر کوچک در کوئری تمام ردیف ها را نمایش می دهیم.
					$search_r_code_meli = (!isset($search_r_code_meli) || $search_r_code_meli == "") ?  "nothing" : $search_r_code_meli;
					$search_r_fname = (!isset($search_r_fname) || $search_r_fname == "") ?  "nothing" : $search_r_fname;

					//تنظیم کوئری و اطمینان از صحت کار
					if ($stmt = $conn->prepare("SELECT 	r_id,
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
										r_adres
									FROM reserve
									where (r_code_meli like concat('%',?,'%') or (?='nothing' and r_code_meli like '%'))
									   and (r_fname like concat('%',?,'%') or (?='nothing' and r_fname like '%' ))
									order by r_id desc")) {
						//بایند کردن پارامترها
						$stmt->bind_param("ssss", $search_r_code_meli, $search_r_code_meli, $search_r_fname, $search_r_fname);

						//اجرای کوئری
						$stmt->execute();

						//بایند کردن فیلدهای کوئری به متغیرهای هم نام
						$stmt->bind_result(
							$r_id,
							$r_uid,
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
						//ذخیره کردن نتیجه
						$stmt->store_result();

						//می خواهیم اطلاعات را در یک جدول نمایش دهیم، بنابراین ابتدا باید ساختار اولیه جدول را چاپ کنیم

						echo "<div class='form-controls'>";
						echo "<div class='table-responsive'>";
						echo "<div class='aligmen-center'>";
						echo "<table class='table table-bordered border-primary table-hover table-striped'>";
						echo "<center><caption>تعداد کل : $stmt->num_rows</caption></center>";
						echo "<thead class='thead-dark'>";
						echo "<tr>";
						echo "<th>کد ملی </th>";
						echo "<th>نام </th>";
						echo "<th>نام خانوادگی</th>";
						echo "<th>تلفن </th>";
						echo "<th>کدپستی</th>";
						echo "<th>تاریخ ورود</th>";
						echo "<th>تاریخ خروج</th>";
						echo "<th>مدت اقامت</th>";
						echo "<th>تعداد اتاق</th>";
						echo "<th>تعداد همراهان</th>";
						echo "<th>آدرس</th>";
						echo "<th></th>";
						echo "</tr>";
						echo "</thead>";
						//هر بار که متد فچ اجرا می شود یک ردیف از جدول در متغییرهایی که قبلاً  ست کردیم ریخته می شود
						while ($stmt->fetch()) {
							echo "<tr>";
							echo "<td>$r_code_meli</td>";
							echo "<td>$r_name</td>";
							echo "<td>$r_fname</td>";
							echo "<td>$r_tel</td>";
							echo "<td>$r_code_posti</td>";
							echo "<td>$r_date_vorod</td>";
							echo "<td>$r_date_khoroj</td>";
							echo "<td>$r_meghdar_eghamat</td>";
							echo "<td>$r_tedad_otagh</td>";
							echo "<td>$r_tedad_hamrah</td>";
							echo "<td>$r_adres</td>";
							echo "<td><a href='all_reserve.php?update_by_r_id=$r_id&action=display_form_update' class='btn btn-warning'>ویرایش</a></td>";
							echo "</tr>";
						}

						if ($stmt->num_rows == 0) {
							echo "<tr><td colspan='13' style='text-align:center;'><div  class='alert alert-danger text-center' role='alert'>موجود نیست ...!</td></div></tr></table></div></div></div>";
						}
						echo "</table>";
					} else {
						echo "عدم اجرای دستور Prepare <br /> شماره خطا = $conn->errno <br /> متن خطا = $conn->error";
						return;
					}
					//بستن ارتباط با پایگاه داده
					$stmt->close();
					$conn->close();
				}
				function display_search_form_reserve($search_r_code_meli, $search_r_fname)
				{
				?>
					<!-- htmlspecialchars میتواند از حمله هکر هایی که میخواهند از طریق تزریق کد های html ,javascript اختلال ایجاد کنند جلوگیری میکند -->
						<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
							<input type="hidden" name="action" value="search" />
							<div class="form" id="search">
								<br>
								<h2>جستجو</h2>
								<div style="float:right"><label>کد ملی :</label><input type="text" class="form-control" name="search_r_code_meli" size="25" maxlength="25" value="<?php echo $search_r_code_meli ?>" /></div>
								<div style="float:right"><label>نام خانوادگی :</label><input type="text" class="form-control" name="search_r_fname" size="25" maxlength="25" value="<?php echo $search_r_fname ?>" /></div>
								<div style="clear:both" class="button"><input type="submit" class="btn btn-primary" value="جستجو" /></div> <br>
							</div>
						</form>
					
					<?php
				}

				//وظیفه این تابع حذف، ردیف مورد نظر با توجه به آی دی است	
				function delete_by_id($delete_by_r_id)
				{
					if (isset($delete_by_r_id) && !empty($delete_by_r_id)) {
						//ایجاد ارتباط به پایگاه داده
						$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
						$conn->set_charset('utf8');
						//اطمینان از صحت ارتباط
						if ($conn->connect_error) {
							$error = "متاسفانه نمي توان به پايگاه داده متصل شد.";
							fill_table_reserve();
							return;
						}

						//تنظیم کوئری و اطمینان از صحت کار
						if ($stmt = $conn->prepare("delete FROM reserve
										where r_id=?")) {
							//بایند کردن پارامترها
							$stmt->bind_param("i", $delete_by_r_id);

							//اجرای کوئری
							$stmt->execute();

							echo "<div class='success'>عملیات حذف با موفقیت انجام شد</div>";
						} else {
							echo "عدم اجرای دستور Prepare <br /> شماره خطا = $conn->errno <br /> متن خطا = $conn->error";
							return;
						}
						//بستن ارتباط با پایگاه داده
						$stmt->close();
						$conn->close();

						fill_table_reserve();
					}
				}


				//وظیفه این تابع، نمایش فرم رزرو است 	
				function display_form_update($update_by_r_id)
				{
					if (isset($update_by_r_id)) {
						fill_table_reserve();

						//ایجاد ارتباط به پایگاه داده
						$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
						$conn->set_charset('utf8');
						//اطمینان از صحت ارتباط
						if ($conn->connect_error) {
							$error = "متاسفانه نمي توان به پايگاه داده متصل شد.";
							fill_table_reserve();
							return;
						}

						//تنظیم کوئری و اطمینان از صحت کار
						if ($stmt = $conn->prepare("SELECT 	r_id,
											u_username,
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
											r_adres
										FROM reserve left outer join
											users on (r_uid=u_id)
										where r_id=?")) {
							//بایند کردن پارامترها
							$stmt->bind_param("i", $update_by_r_id);

							//اجرای کوئری
							$stmt->execute();

							//بایند کردن فیلدهای کوئری به متغیرهای هم نام
							$stmt->bind_result(
								$r_id,
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
							$stmt->fetch();
						} else {
							echo "عدم اجرای دستور Prepare <br /> شماره خطا = $conn->errno <br /> متن خطا = $conn->error";
							return;
						}
						//بستن ارتباط با پایگاه داده
						$stmt->close();
						$conn->close();

					
					?>
						<div class="card">
							<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
								<input type="hidden" name="action" value="update" />
								<input type="hidden" name="update_by_r_id" value="<?php echo $update_by_r_id ?>" />
								<div class="form" id="login">
									<h2>ویرایش اطلاعات کاربر</h2>
									<div style="float:right;">
										<div><label>کد ملی :</label><input type="text" class="form-control" name="r_code_meli" size="25" maxlength="25" value="<?php echo $r_code_meli ?>" required /></div>
										<div><label>نام :</label><input type="text" class="form-control" name="r_name" size="25" maxlength="25" value="<?php echo $r_name ?>" required /></div>
										<div><label>نام خانوادگی :</label><input type="text" class="form-control" name="r_fname" size="25" maxlength="25" value="<?php echo $r_fname ?>" required /></div>
										<div><label>تلفن :</label><input type="text" class="form-control" name="r_tel" size="25" maxlength="25" value="<?php echo $r_tel ?>" required /></div>
										<div><label>کدپستی :</label><input type="text" class="form-control" name="r_code_posti" size="25" maxlength="25" value="<?php echo $r_code_posti ?>" required /></div>
									</div>
									<div style="float:right;">
										<div><label>تاریخ ورود :</label><input type="text" class="form-control" name="r_date_vorod" size="25" maxlength="25" value="<?php echo $r_date_vorod ?>" required /></div>
										<div><label>تاریخ خروج :</label><input type="text" class="form-control" name="r_date_khoroj" size="25" maxlength="25" value="<?php echo $r_date_khoroj ?>" required /></div>
										<div><label>مدت اقامت :</label><input type="text" class="form-control" name="r_meghdar_eghamat" size="25" maxlength="25" value="<?php echo $r_meghdar_eghamat ?>" required /></div>
										<div><label>تعداد اتاق :</label><input type="text" class="form-control" name="r_tedad_otagh" size="25" maxlength="25" value="<?php echo $r_tedad_otagh ?>" required /></div>
										<div><label>تعداد همراهان :</label><input type="text" class="form-control" name="r_tedad_hamrah" size="25" maxlength="25" value="<?php echo $r_tedad_hamrah ?>" required /></div>
									</div>
									<div style="clear:both"><label>آدرس :</label><textarea type="text" class="form-control" name="r_adres" rows="2" cols="100" required><?php echo $r_adres ?></textarea></div>
									<div class="button"><input type="submit" class="btn btn-primary" value="ویرایش" /></div>
									<div class="error"><?php if (isset($GLOBALS['error'])) echo $GLOBALS['error']; ?></div>
								</div>
							</form>
						</div>
				<?php
					}
				}

				//وظیفه این تابع حذف، ردیف مورد نظر با توجه به آی دی است	
				function update_by_id($update_by_r_id)
				{
					if (isset($update_by_r_id) && !empty($update_by_r_id)) {
						//متغییری برای ذخیره پیغام های خطا
						global $error;
						$error = '';

						//تنظیم مقادیر ارسال شده از سمت کاربر
						$r_code_meli = $_POST['r_code_meli'];
						$r_name = $_POST['r_name'];
						$r_fname = $_POST['r_fname'];
						$r_tel = $_POST['r_tel'];
						$r_code_posti = $_POST['r_code_posti'];
						$r_date_vorod = $_POST['r_date_vorod'];
						$r_date_khoroj = $_POST['r_date_khoroj'];
						$r_meghdar_eghamat = $_POST['r_meghdar_eghamat'];
						$r_tedad_otagh = $_POST['r_tedad_otagh'];
						$r_tedad_hamrah = $_POST['r_tedad_hamrah'];
						$r_adres = $_POST['r_adres'];

						//مقادیر ارسال شده از سمت کاربر، نباید خالی باشد
						if (empty($r_code_meli) || empty($r_name) || empty($r_fname) || empty($r_tel) || empty($r_code_posti) || empty($r_date_vorod) || empty($r_date_khoroj) || empty($r_meghdar_eghamat) || empty($r_tedad_otagh) || empty($r_tedad_hamrah) || empty($r_adres)) {
							$error = "لطفاً همه فیلدها را پر کنید.";
							display_form_update($update_by_r_id);
							return;
						}


						//ایجاد ارتباط به پایگاه داده
						$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
						$conn->set_charset('utf8');
						//اطمینان از صحت ارتباط
						if ($conn->connect_error) {
							$error = "متاسفانه نمي توان به پايگاه داده متصل شد.";
							fill_table_reserve();
							return;
						}

						//تنظیم کوئری و اطمینان از صحت کار
						if ($stmt = $conn->prepare("update reserve set 
												r_code_meli=?,
												r_name=?,
												r_fname=?,
												r_tel=?,
												r_code_posti=?,
												r_date_vorod=?,
												r_date_khoroj=?,
												r_meghdar_eghamat=?,
												r_tedad_otagh=?,
												r_tedad_hamrah=?,
												r_adres=? 
											where r_id=?")) {
							$stmt->bind_param(
								"sssssssssssi",
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
								$r_adres,
								$update_by_r_id
							);
							$stmt->execute();
							echo "  <div class='card'> <div class='alert alert-success text-center'>عملیات ویرایش با موفقیت انجام شد.</div> </div>";
						} else {
							echo "عدم اجرای دستور Prepare <br /> شماره خطا = $conn->errno <br /> متن خطا = $conn->error";
							return;
						}
						//بستن ارتباط با پایگاه داده
						$stmt->close();
						$conn->close();

						fill_table_reserve();
					}
				}
				?>
			</div>
</body>

</html>