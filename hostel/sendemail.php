<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';

$mail = new PHPMailer(true);

$alert = '';

if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject=$_POST['subject'];
  $message = $_POST['message'];

  try{
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mahdizand19988@gmail.com'; // Gmail address which you want to use as SMTP server
    $mail->Password = 'Mahdi1377'; // Gmail address Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = '587';

    $mail->setFrom('mahdizand19988@gmail.com'); // Gmail address which you used as SMTP server
    $mail->addAddress('mahdizand19988@gmail.com'); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)

    $mail->isHTML(true);
    $mail->Subject = 'پیام دریافت شد';
    $mail->Body = "<h3>نام ونام خانوادگی : $name <br>ایمیل: $email <br>موضوع : $subject<br>پیام : $message</h3>";

    $mail->send();
    $alert = '<div  class="alert alert-success text-center" role="alert">
                 <span>پیام شما برای مدیریت سایت ارسال شد. باتشکر</span>
                </div>';
  } catch (Exception $e){
    $alert = '<div class="alert-error text-center">
                <span>'.$e->getMessage().'</span>
              </div>';
  }
}
?>
