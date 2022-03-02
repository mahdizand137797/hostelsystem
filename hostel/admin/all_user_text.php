<?php

//اگر سیشن مقدار دهی نشده باشد به صفحه لاگین منقل می شوید

if (!isset($_SESSION['u_username_admin'])) {
	header('Location: login.php');
}

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
	<title>سایت مدیریت مهمان پذیر</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="all" />
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	<link href="../css/bootstrap.rtl.min.css" rel="stylesheet">
	<script src="../js/jquery-3.6.0.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
		<header class="row">
			<div class="card">
				<?php

				//اضافه کردن فایل کانفیک به این صفحه این فایل شامل اطلاعات لازم برای اتصال به پایگاه داده است
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
						$update_by_u_id = (isset($_POST['update_by_u_id'])) ? $_POST['update_by_u_id'] : '';
						update_by_id($update_by_u_id);
						break;
					case "display_form_update":
						$update_by_u_id = (isset($_GET['update_by_u_id'])) ? $_GET['update_by_u_id'] : '';
						display_form_update($update_by_u_id);
						break;
					case "delete":
						$delete_by_u_id = (isset($_GET['delete_by_u_id'])) ? $_GET['delete_by_u_id'] : '';
						delete_by_id($delete_by_u_id);
						break;
					case "search":
					default:
						fill_table_users();
						break;
				}

				//وظیفه این تابع، نمایش فرم لاگین است
				function fill_table_users()
				{
					$search_u_username = $search_u_usertype = '';

					if (isset($_POST['search_u_username']) || isset($_POST['search_u_usertype'])) {
						$search_u_username = $_SESSION['search_u_username'] = $_POST['search_u_username'];
						$search_u_usertype = $_SESSION['search_u_usertype'] = $_POST['search_u_usertype'];
					} else if (isset($_SESSION['search_u_username']) || isset($_SESSION['search_u_usertype'])) {
						$search_u_username = $_SESSION['search_u_username'];
						$search_u_usertype = $_SESSION['search_u_usertype'];
					}

					//نمایش فرم جستجو
					display_search_form_user($search_u_username, $search_u_usertype);

					//ایجاد ارتباط به پایگاه داده
					$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
					$conn->set_charset('utf8');



					//اطمینان از صحت ارتباط
					if ($conn->connect_error) {
						$error = "متاسفانه نمي توان به پايگاه داده متصل شد.";
						fill_table_users();
						return;
					}
					//اگر فیلد جستجو توسط کاربر تنظیم نشود، می خواهیم که تمام ردیف ها نمایش داده شود، بنابراین آنرا با یک مقدار قراردادی 
					//تنظیم می کنیم، و با یک تغییر کوچک در کوئری تمام ردیف ها را نمایش می دهیم.
					$search_u_username = (!isset($search_u_username) || $search_u_username == "") ?  "nothing" : $search_u_username;
					$search_u_usertype = (!isset($search_u_usertype) || $search_u_usertype == "") ?  "nothing" : $search_u_usertype;

					//تنظیم کوئری و اطمینان از صحت کار
					if ($stmt = $conn->prepare("SELECT 	u_id,
										u_username,
										u_email,
										u_password,
										u_usertype,
										u_activation
									FROM users
									where (u_username like concat('%',?,'%') or (?='nothing' and u_username like '%'))
									   and (u_usertype like concat('%',?,'%') or (?='nothing' and u_usertype like '%' ))")) {
						//بایند کردن پارامترها
						$stmt->bind_param("ssss", $search_u_username, $search_u_username, $search_u_usertype, $search_u_usertype);

						//اجرای کوئری
						$stmt->execute();

						//بایند کردن فیلدهای کوئری به متغیرهای هم نام
						$stmt->bind_result(
							$u_id,
							$u_username,
							$u_email,
							$u_password,
							$u_usertype,
							$u_activation
						);
						//ذخیره کردن نتیجه
						$stmt->store_result();

						//می خواهیم اطلاعات را در یک جدول نمایش دهیم، بنابراین ابتدا باید ساختار اولیه جدول را چاپ کنیم
						echo "<div class='container table-responsive-sm aligmen-center'>";
						echo "<table class='table table-bordered table-responsive-sm'>";
						echo "<caption>تعداد کل کاربر ثبت نام شده: $stmt->num_rows</caption>";
						echo "<thead class='thead-dark'>";
						echo "<tr>";
						echo "<th>نام کاربری</th>";
						echo "<th>ایمیل</th>";
						echo "<th>کلمه عبور</th>";
						echo "<th>نوع کاربر</th>";
						echo "<th>فعال</th>";
						echo "<th></th>";
						echo "<th></th>";
						echo "</tr>";
						echo "</thead>";
						//هر بار که متد فچ اجرا می شود یک ردیف از جدول در متغییرهایی که قبلاً  ست کردیم ریخته می شود
						while ($stmt->fetch()) {
							echo "<tr>";
							echo "<td>$u_username</td>";
							echo "<td>$u_email</td>";
							echo "<td>$u_password</td>";
							echo "<td>$u_usertype</td>";
							echo "<td>$u_activation</td>";
							echo "<td><a class='btn btn-outline-warning' href='all_user.php?delete_by_u_id=$u_id&action=delete' onclick='return confirm(\"آیا اطلاعات حذف شود؟\");'>حذف</a></td>";
							echo "<td><a class='btn btn-outline-info' href='all_user.php?update_by_u_id=$u_id&action=display_form_update'>ویرایش</a></td>";
							echo "</tr>";
						}

						if ($stmt->num_rows == 0) {
							echo "<tr><td  class='alert alert-denger text-center'>موجود نیست ...!</td></tr></table></div>";
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
				function display_search_form_user($search_u_username, $search_u_usertype)
				{
				?>
					<div class="card">
						<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
							<div class="form-group">
								<input type="hidden" name="action" value="search" />
								<div class="form" id="search">
									<br>
									<h2>جستجو</h2><br>
									<div style="float:right"><label>نام کاربری :</label><input type="text" class="form-control" name="search_u_username" size="25" maxlength="25" autofocus value="<?php echo $search_u_username ?>" /></div>
									<div style="float:right"><label>نوع کاربر :</label>
										<select name="search_u_usertype" class="form-control">
											<option value="" class="form-control">انتخاب کنید ... </option>
											<option value="register" class="form-control" <?php if ($search_u_usertype == 'register') echo 'selected' ?>>register</option>
											<option value="admin" class="form-control" <?php if ($search_u_usertype == 'admin') echo 'selected' ?>>admin</option>
										</select><br>
									</div>
									<div style="clear:both" class="button"><input type="submit" class="btn btn-primary" value="جستجو" /></div>
						</form>
					</div>
					<br>
					<?php
				}

				//وظیفه این تابع حذف، ردیف مورد نظر با توجه به آی دی است	
				function delete_by_id($delete_by_u_id)
				{
					if (isset($delete_by_u_id) && !empty($delete_by_u_id)) {
						//ایجاد ارتباط به پایگاه داده
						$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

						//اطمینان از صحت ارتباط
						if ($conn->connect_error) {
							$error = "متاسفانه نمي توان به پايگاه داده متصل شد.";
							fill_table_users();
							return;
						}

						//تنظیم کوئری و اطمینان از صحت کار
						if ($stmt = $conn->prepare("delete FROM users
										where u_id=? and u_id<>1")) {
							//بایند کردن پارامترها
							$stmt->bind_param("i", $delete_by_u_id);

							//اجرای کوئری
							$stmt->execute();

							if ($delete_by_u_id != 1)
								echo "<div  class='alert alert-success text-center'>عملیات حذف با موفقیت انجام شد</div>";
							else echo "<div  class='alert alert-danger text-center'>این ردیف قابل حذف نیست ...!</div>";
						} else {
							echo "عدم اجرای دستور Prepare <br /> شماره خطا = $conn->errno <br /> متن خطا = $conn->error";
							return;
						}
						//بستن ارتباط با پایگاه داده
						$stmt->close();
						$conn->close();

						fill_table_users();
					}
				}


				//وظیفه این تابع، نمایش فرم رزرو است 	
				function display_form_update($update_by_u_id)
				{
					if (isset($update_by_u_id)) {
						fill_table_users();

						//ایجاد ارتباط به پایگاه داده
						$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
						$conn->set_charset('utf8');
						//اطمینان از صحت ارتباط
						if ($conn->connect_error) {
							$error = "متاسفانه نمي توان به پايگاه داده متصل شد.";
							fill_table_users();
							return;
						}

						//تنظیم کوئری و اطمینان از صحت کار
						if ($stmt = $conn->prepare("SELECT 	u_id,
											u_username,
											u_email,
											u_password,
											u_usertype,
											u_activation
										FROM users				
										where u_id=?")) {
							//بایند کردن پارامترها
							$stmt->bind_param("i", $update_by_u_id);

							//اجرای کوئری
							$stmt->execute();

							//بایند کردن فیلدهای کوئری به متغیرهای هم نام
							$stmt->bind_result(
								$u_id,
								$u_username,
								$u_email,
								$u_password,
								$u_usertype,
								$u_activation
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
							<div class="form-group">
								<h2>ویرایش اطلاعات کاربر</h2>
								<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
									<input type="hidden" name="action" value="update" />
									<input type="hidden" name="update_by_u_id" value="<?php echo $update_by_u_id ?>" />
									<dl style="float:right;">
										<dd>
											<label>نام کاربری :</label>
											<input type="text" name="u_username" size="25" maxlength="25" class="form-control" value="<?php echo $u_username ?>" required pattern=".{3,25}" title="حداقل شامل 3 کاراکتر" />
										</dd>

										<dd>
											<label>نوع کاربر :</label>
											<select name="u_usertype">
												<option value="register" class="form-check-input" <?php if ($u_usertype == 'register') echo 'selected' ?>>register</option>
												<option value="admin" class="form-check-input" <?php if ($u_usertype == 'admin') echo 'selected' ?>>admin</option>
											</select>
										</dd>
										<dd>
											<label>وضعیت حساب کاربری :</label>
											<input type="radio" class="form-check-input" name="u_activation" value="1" <?php if ($u_activation == '1') echo 'checked' ?> /> فعال
											<input type="radio" class="form-check-input" name="u_activation" value="0" <?php if ($u_activation == '0') echo 'checked' ?> /> غیرفعال
										</dd>

										<dd>
											<label>ایمیل :</label>
											<input type="email" name="u_email" size="25" maxlength="25" class="form-control" value="<?php echo $u_email ?>" required />
										</dd>
										<dd>
											<label>کلمه عبور :</label>
											<input type="text" name="u_password" size="25" maxlength="25" class="form-control" value="<?php echo $u_password ?>" required pattern=".{3,25}" title="حداقل شامل 3 کاراکتر" />
										</dd>

									</dl>
									<div style="clear:both"><input type="submit" class="btn btn-outline-primary" value="ویرایش" /></div>
									<div class="error"><?php if (isset($GLOBALS['error'])) echo $GLOBALS['error']; ?></div>
								</form>
							</div>
						</div>
				<?php
					}
				}

				//وظیفه این تابع، ویرایش ردیف انتخاب شده در جدول است	
				function update_by_id($update_by_u_id)
				{
					if (isset($update_by_u_id) && !empty($update_by_u_id)) {
						//متغییری برای ذخیره پیغام های خطا
						global $error;
						$error = '';

						//تنظیم مقادیر ارسال شده از سمت کاربر
						$u_username = $_POST['u_username'];
						$u_email = $_POST['u_email'];
						$u_password = $_POST['u_password'];
						$u_usertype = $_POST['u_usertype'];
						$u_activation = $_POST['u_activation'];

						//مقادیر ارسال شده از سمت کاربر، نباید خالی باشد
						if (empty($u_username) || empty($u_email) || empty($u_password) || empty($u_usertype)) {
							$error = "لطفاً همه فیلدها را پر کنید.";
							display_form_update($update_by_u_id);
							return;
						}


						//ایجاد ارتباط به پایگاه داده
						$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
						$conn->set_charset('utf8');
						//اطمینان از صحت ارتباط
						if ($conn->connect_error) {
							$error = "متاسفانه نمي توان به پايگاه داده متصل شد.";
							fill_table_users();
							return;
						}

						//تنظیم کوئری و اطمینان از صحت کار
						if ($stmt = $conn->prepare("update users set 
												u_username=?,
												u_email=?,
												u_password=?,
												u_usertype=?,
												u_activation=?
											where u_id=? and u_id<>1")) {
							$stmt->bind_param(
								"ssssii",
								$u_username,
								$u_email,
								$u_password,
								$u_usertype,
								$u_activation,
								$update_by_u_id
							);
							$stmt->execute();
							if ($update_by_u_id != 1)
								echo "<div  class='alert alert-success text-center'>عملیات ویرایش با موفقیت انجام شد.</div>";
							else echo "<div  class='alert alert-danger text-center'>این ردیف قابل ویرایش نیست ...!</div>";
						} else {
							echo "عدم اجرای دستور Prepare <br /> شماره خطا = $conn->errno <br /> متن خطا = $conn->error";
							return;
						}
						//بستن ارتباط با پایگاه داده
						$stmt->close();
						$conn->close();
						fill_table_users();
					}
				}
				?>
			</div>
	</div>
</body>

</html>