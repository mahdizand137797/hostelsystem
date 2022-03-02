<?php
session_start();

//اضافه کردن فایل کانفیک به این صفحه این فایل شامل اطلاعات لازم برای اتصال به پایگاه داده است
require_once('config.php');


//تنظیم اکشن 
$action = '';
if (isset($_POST['action'])) {
   $action = $_POST['action'];
}

//بر اساس اکشن تنظیم شده، تابع مربوطه فراخوانی می شود
switch ($action) {
   case "login":
      login();
      break;
   default:
      display_form_login();
      break;
}

//وظیفه این تابع، نمایش فرم لاگین است
function display_form_login()
{
   //اگر کاربر، قبلاً لاگین کرده باشد بنابراین سشن زیر تنظیم شده است و نباید فرم لاگین نمایش داده شود
   if (isset($_SESSION['u_username_paziresh'])) {
      header('Location: all_reserve.php');
      return;
   }
?>
   <!DOCTYPE html>
   <html lang="fa" dir="rtl">

   <head>
      <title>سایت مدیریت مهمان پذیر</title>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="../css/bootstrap.rtl.min.css">
      <link rel="stylesheet" href="../css/style.css" type="text/css" media="all" />
      <script src="../js/validate.js"></script>
   </head>

   <body>
      <div class="container py-5 text-dark">
         <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
               <div class="card">
                  <h2 class="text-center pt-3">ورود مسئول پذیرش</h2>
                  <div class="card-body">
                     <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="action" value="login" />
                        <div class="form-group">
                           <label for="username">نام کاربری </label>
                           <input class="form-control" type="text" name="u_username" size="25" maxlength="25" placeholder="نام کاربری را وارد کنید" required autofocus />
                        </div>
                        <div class="form-group">
                           <label for="password">کلمه عبور </label>
                           <input type="password" class="form-control" name="u_password" size="25" maxlength="25" placeholder="رمز عبور خود را وارد کنید." required>
                        </div>
                        <br>
                        <button type="submit" name="login" class="btn btn-outline-primary btn-block">ورود</button><br><br>
                        <div class="error"><?php if (isset($GLOBALS['error'])) echo $GLOBALS['error']; ?></div>

                     </form>
                  </div>

               </div>
            </div>
         </div>
      </div>
      </div>
      </div>
      <script src="../js/validate.js"></script>
   </body>

   </html>
<?php
}

//وظیفه این تابع، این است که براساس نام کاربری و کلمه عبور دریافت شده، اجازه ورود به کاربر بدهد
function login()
{
   global $conn;
   //متغییری برای ذخیره پیغام های خطا
   global $error;
   $error = '';

   //تنظیم مقادیر ارسال شده از سمت کاربر
   $u_username = $_POST['u_username'];
   $u_password = $_POST['u_password'];

   //مقادیر ارسال شده از سمت کاربر، نباید خالی باشد
   if (empty($u_username) || empty($u_password)) {
      $error = "لطفاً همه فیلدها را پر کنید.";
      display_form_login();
      return;
   }

   $conn->set_charset('utf8');

   //تنظیم کوئری و اطمینان از صحت کار
   if ($stmt = $conn->prepare("SELECT u_id FROM users WHERE u_username=? and u_password=? and u_usertype='paziresh'")) {
      //بایند کردن پارامترها
      $stmt->bind_param("ss", $u_username, $u_password);
      //اجرای کوئری
      $stmt->execute();

      //ذخیره کردن نتیجه
      $stmt->store_result();
      //اگر تعداد رکوردها بزرگتر از صفر باشد، کاربر بدرستی اطلاعات را وارد کرده است
      if ($stmt->num_rows > 0) {
         $_SESSION['u_username_paziresh'] = $u_username;
         header('Location: all_reserve.php');
      } else {
         $error = "نام کاربری یا کلمه عبور مسئول پذیرش اشتباه است";
         display_form_login();
         return;
      }
   } else {
      $error = "عدم اجرای دستور Prepare <br /> شماره خطا = $conn->errno <br /> متن خطا = $conn->error";
      display_form_login();
      return;
   }
   //بستن ارتباط با پایگاه داده
   $stmt->close();
   $conn->close();
}
?>