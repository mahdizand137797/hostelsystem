<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>ثبت نام و ورود با php و mysql</title>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>ورود</h2>
  </div>

  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>نام کاربری</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>رمز</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">ورود</button>
  	</div>
  	<p>
      <p>	اگر ثبت نام نکردید ?</p>
  	 <a href="register.php" class="button is-warning">ثبت نام کاربر جدید</a>
  	</p>
  </form>
</body>
</html>
