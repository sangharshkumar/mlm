<?php

require "PHPMailer/PHPMailerAutoload.php";
$sender_email = '';
$regards = 'Jamsr World';

function send_registration_successfull_email($email, $user_id)
{
    global $regards;
    global $web_name;
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


    send_email($email, $subject, $body_heading, $body_content);
}

function send_forgot_password_email($user_id, $receiver_email, $token)
{
    global $base_url;
    global $regards;
    $name = user_fullname($user_id);
    $subject = 'Reset Your Account Password';
    $body_heading = 'Reset Your Account Password';
    $link_url = "$base_url/member/reset-password.php?token=$token";
    $link_text = "Reset Your Password";
    $body_content = "<p style='margin:20px 0;'>Hi $name,</p>
                        <p style='margin:20px 0;'>We heard that you lost your password. Sorry about that !</p>
                        <p style='margin:20px 0;'>To set up a new password, click \"Reset Your Password\" below, or <a style='color:#1dbf73;text-decoration:none;' href='$base_url/member/reset-password.php?token=$token'>Click Here</a></p>
                        <p style='margin:20px 0;'>The link will expire in 15 minutes.</p>
                        <p style='margin:20px 0;'>Thanks,<br>
                       $regards</p>
                        <div style='width:100%;padding:40px 0;text-align: center;'>
                        <a href=\"$link_url\" style='color: #ffffff; background-color: #1dbf73; display: inline-block; font-family: Helvetica Neue; font-size: 16px; line-height: 30px; text-align: center; font-weight: bold; text-decoration: none; padding: 5px 20px; border-radius: 3px; text-transform: none; cursor: pointer;'>$link_text</a>
                    </div>  ";
    $action = send_email($receiver_email, $subject, $body_heading, $body_content);
    if ($action) {
        return true;
    } else {
        return false;
    }
}


function send_reset_password_successfull_email($user_id, $receiver_email)
{
    global $regards;
    $name = user_fullname($user_id);
    $subject = "Password reset successfully";
    $body_heading = 'Your password has reset successfully';
    $body_content = "<p style='margin:20px 0;'>Hi $name,</p>
                        <p style='margin:20px 0;'>Your password has successfully reset.</p>
                        <p style='margin:20px 0;'>Thanks,<br>
                        $regards</p> ";
    send_email($receiver_email, $subject, $body_heading, $body_content);
}

function send_change_password_successfull_email($user_id)
{
    global $regards;
    $receiver_email = user_email($user_id);
    $name = user_fullname($user_id);
    $subject = "Password changed successfully";
    $body_heading = 'Your password has changed successfully';
    $body_content = "<p style='margin:20px 0;'>Hi $name,</p>
                        <p style='margin:20px 0;'>Your password has successfully changed.</p>
                        <p style='margin:20px 0;'>Thanks,<br>
                        $regards</p> ";
    send_email($receiver_email, $subject, $body_heading, $body_content);
}

function send_otp($receiver_email, $otp)
{
    global $regards;
    $subject = 'Otp validatation';
    $body_heading = "You're almost there! Just validate otp";
    $body_content = "<p style='margin:20px 0;'>Hi,</p>
                        <p style='margin:20px 0;'>Your otp is:- $otp </p>
                        <p style='margin:20px 0;'>The otp will expire in 15 minutes. </p>
                        <p style='margin:20px 0;'>Thanks,<br>
                        $regards</p> ";
    $action = send_email($receiver_email, $subject, $body_heading, $body_content);
    if ($action) {
        return true;
    } else {
        return false;
    }
}

function send_email($receiver_email, $subject, $body_heading, $body_content)
{
    global $sender_email;
    global $base_url;
    global $regards;
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

    $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Host = '';
        $mail->Port = 465;  
        $mail->Username = $sender_email;
        $mail->Password = '';   
        $mail->IsHTML(true);
        $mail->From= $sender_email;
        $mail->FromName=$regards;
        $mail->Sender=$sender_email;
        $mail->AddReplyTo($sender_email, $regards);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($receiver_email);
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
}
