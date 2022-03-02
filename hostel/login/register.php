<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>ثبت نام کاربر جدید</h2>
  </div>
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>نام کاربری</label>
  	  <input class="input" type="text" name="username" value="<?php echo @$username; ?>">
  	</div>
  	<div class="input-group">
  	  <label>ایمیل</label>
  	  <input class="input" type="email" name="email" value="<?php echo @$email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>رمز</label>
  	  <input class="input" type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>تکرار رمز</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">ثبت نام</button>
  	</div>
  	<p>
      <p>	قبلا ثبت نام کردید ? </p>
  	<a href="login.php" class="button is-warning">وارد شوید</a>
  	</p>
  </form>
</body>
</html>
