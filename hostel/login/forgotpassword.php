<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="">
	 <link rel="stylesheet" type="text/css" href="style.css">
  <title>بازیابی رمز عبور</title>
 </head>
<body>
  <div class="container">
  	<div class="row">
  		<div class="col-md-4 offset-md-4 form-div login"></div>
	   <form method="post" action="forgotpassword.php">
	   	<h3 class="text-center">recover your password</h3>

	   	<p>
	   		please enter email and recover your pass

	   	</p>
  	<?php if(count($errors) >0): ?>
  		<div class="alert alert-danger">
  			<?php foreach($errors as $errors): ?>
  				<li><?php echo $error; ?></li>
  			<?php endforeach; ?>
  		</div>
  	<?php endif; ?>

  	  	<div class="form-group">
  		<input type="email" name="email"  class="form-control from-control-lg" >
  	</div>
  		
  	<div class="form-group">
  		<button type="submit" name="forgot-password" class="btn btn-primary btn-block btn-lg" >recover your password</button>
  	</div>
  </form>
</div>
</div>
</body>
</html>