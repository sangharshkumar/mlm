<?php
if (!isset($_POST['action'])) {
   header("location:$error_page");
   exit();
}

$action = $_POST['action'];
include("../../db.php");

if (is_empty($action)) {
   exit();
}
switch ($action) {
    
   case 'login':
      include("member/proceed_login.php");
      break;


   case 'edit_profile':
      include("profile/edit_profile.php");
      break;

   case 'add_ticket':
      include("support/add_ticket.php");
   break;

   case 'add_reply_to_ticket':
      include("support/add_reply_to_ticket.php");
   break;

   case 'close_ticket':
      include("support/close_ticket.php");
   break;

   case 'change_password':
      include("profile/change_password.php");
      break;

   case 'validate_registration_form':
      include("member/validate_form.php");
      break;

   case 'generate_pin':
      include("pin/generate_pin.php");
      break;

   
   case 'registartion':
      include("member/proceed_registartion.php");
      break;
      
   
   case 'change_profile':
      include("profile/change_profile.php");
      break;

   case 'withdraw_money':
      include("balance/withdraw_money.php");
      break;


   case 'forgot_password':
      include("member/proceed_forgot_password.php");
      break;


   case 'reset_password':
      include("member/proceed_reset_password.php");
      break;

   case 'send_registration_otp':
      include("member/proceed_send_otp.php");
      break;

   case 'payment_img':
      include("profile/upload_payment_img.php");
      break;
      
   case 'update_payment_infomation':
      include("profile/update_payment_infomation.php");
      break;
      
   default:
     break;
}
?>