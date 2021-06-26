<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

if (!is_loggedin()) {
    echo "You must login to update the information";
    exit();
}

$user_id = $loggedin_user_id;

if (!isset($_POST['account_number'],$_POST['user_upi'],$_POST['current_password'])) {
    echo "Something went wrong";
    exit();
}



$account_number = clean_text($_POST['account_number']);
$user_upi = clean_text($_POST['user_upi']);
$user_account_img = user_account_image($user_id);
$current_password = clean_text($_POST['current_password']);


if (is_empty($current_password)) {
    echo "Current Password is empty";
    exit();
}

$data = user_data($loggedin_user_id);
$db_password = $data['user_password'];
$pass_decode = password_verify($current_password, $db_password);
if (!$pass_decode) {
    echo "Invalid password";
    exit();
}

if ( (is_empty($account_number)) && (is_empty($user_upi)) && ($user_account_img == $base_url.'/assets/images/users/') ) {
    echo "Please provide at least an information";
    exit();
}

$query = mysqli_query($conn,"UPDATE $users_tbl SET user_account_number = '$account_number', user_upi = '$user_upi' WHERE user_id = '$user_id' ");
if ($query) {
    echo "Information updated successfully";
    exit();
}

echo "45Something went wrong";