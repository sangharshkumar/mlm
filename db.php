<?php

date_default_timezone_set("Asia/Kolkata");

// Connection to database
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "mlm";
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Database Tables
$users_tbl = 'users';
$tickets_tbl = 'tickets';
$ticket_messages_tbl = 'ticket_messages';
$pin_history_tbl = 'pin_transfer_history';
$pins_tbl = 'pins';
$tree_tbl = 'tree';
$payment_tbl = 'payment_session';
$balance_tbl = 'balance';
$transaction_tbl = 'transaction_history';
$pair_count_tbl = 'pair_count';
$tokens_tbl = 'tokens';
$otp_tbl = 'otps';
$login_session_tbl = 'login_session';
$withdraw_request_tbl = 'withdraw_request';
$blocked_users_tbl = 'blocked_users';
$deposit_tbl = 'deposit_summary';
$wallet_logs_tbl = 'wallet_logs';
$paypal_tbl = 'paypal_payments';
$level_income_tbl = 'level_income';
$referral_income_tbl = 'referral_income';
// Defined Urls


$base_url = 'http://localhost/mlm'; // Change url
$current_date = strtotime(date("d-m-Y H:i:s"));
$lastweek = strtotime("-6 days");
$error_page = "$base_url/404.php";
$block_page = "$base_url/block.php";
$web_name = 'Jamsrworld';
$c_symbol = '$';
$admin_id  = "1006090";
$moment_time = date("d F, Y", ($lastweek)) .' - '. date("d F, Y", ($current_date));
$his = " 23:59:59";
// Include function file
include("assets/php/functions.php");
?>