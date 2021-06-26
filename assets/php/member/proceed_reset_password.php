<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

if (!isset($_POST['password'],$_POST['confirm_password'],$_POST['token'])) {
    echo "Something is missing";
    exit();
}

$password = clean_text($_POST['password']);
$confirm_password = clean_text($_POST['confirm_password']);
$token = $_POST['token'];

if (!is_member_token_valid($token)) {
   echo "Something went wrong";
   exit();
}

if (is_empty($password)) {
    echo "Password is empty";
    exit();
}
if (is_empty($confirm_password)) {
    echo "Confirm password is empty";
    exit();
}

if ($password !== $confirm_password) {
    echo "Passwords are not matching";
    exit();
}

$query = mysqli_query($conn,"SELECT * FROM $tokens_tbl WHERE token = '$token'");
$data = mysqli_fetch_array($query);
$user_id = $data['token_creator'];

$password = password_hash($password, PASSWORD_BCRYPT);
$query = mysqli_query($conn,"UPDATE $users_tbl SET user_password = '$password' WHERE user_id = '$user_id' ");
if (!$query) {
    echo "Something went wrong";
    exit();
}
update_token($token);
logout_all_user($user_id);

include("send_email.php");
$receiver_email = user_email($user_id);
send_reset_password_successfull_email($user_id,$receiver_email);
echo "Password reset successfull";
exit();
