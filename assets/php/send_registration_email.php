<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once 'member/vendor/autoload.php';
require_once 'member/vendor/mailer/credential.php';
require_once 'member/vendor/mailer/class.phpmailer.php';
require_once 'member/vendor/mailer/class.smtp.php';

$subject = "Registration Successfull";
$name = user_fullname($user_id);
$user_name = user_name($user_id);
$body_heading = $subject;
$body_content = "<p style='margin:20px 0;'>Hi $name,</p>
                        <p style='margin:20px 0;'>You have successfully created your account.</p>
                        <p>User Id: <b> $user_id</b></p>
                        <p>User Name: <b> $user_name</b></p>
                        <p>Thanks for becoming a member of $web_name </p>
                        <p style='margin:20px 0;'>Thanks,<br>
                        $regards</p> ";
    $body = "<div style='font-size: 15px;padding: 40px 10px;width:100%; height:100%; background-color:#EEEDF2;'>
            <div style='width:100%; max-width:40%; min-width: 320px; background: #fff; height: max-content; padding: 20px 20px 50px 20px;margin:auto;'>
                <div style='text-align:center;width:100%; padding:20px 0; display: block; border-bottom:1px solid #ccc;'>
                    <img style='display: block;margin:auto;padding:20px 0;width:60px;' src='$base_url/assets/images/web/images-logo-text.png' alt=''>
                    <strong style='padding:20px 0;font-size:20px;'>$body_heading</strong>
                </div>
                <div>
                    $body_content       
                </div>
            </div>
        </div>";
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $sender_email;
    $mail->Password = 'SUN790SUN';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 25;
    $mail->setFrom('puamitha6@gmail.com', 'Mitha Pua');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

if (!$mail->send()) {
} else {
}
