<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

if (!isset($_POST['referral_id'], $_POST['placement_id'], $_POST['referral_code'], $_POST['first_name'], $_POST['last_name'], $_POST['user_name'], $_POST['mobile_number'], $_POST['email'], $_POST['otp'], $_POST['password'], $_POST['confirm_password'], $_POST['placement_type'])) {
    echo "Something is missing";
    exit();
}

$referral_id = clean_text($_POST['referral_id']);
$placement_id = clean_text($_POST['placement_id']);
$referral_code = clean_text($_POST['referral_code']);
$first_name = clean_text($_POST['first_name']);
$last_name = clean_text($_POST['last_name']);
$email = clean_text($_POST['email']);
$user_name = clean_text($_POST['user_name']);
$mobile_number = clean_text($_POST['mobile_number']);
$otp = clean_text($_POST['otp']);
$password = clean_text($_POST['password']);
$confirm_password = clean_text($_POST['confirm_password']);
$placement_type = clean_text($_POST['placement_type']);

if (is_empty($referral_id)) {
    echo "Referral id is empty";
    exit();
}

if (is_empty($placement_id)) {
    echo "Placement id is empty";
    exit();
}
if (is_empty($referral_code)) {
    echo "Referral code is empty";
    exit();
}
if (is_empty($first_name)) {
    echo "First name is empty";
    exit();
}
if (is_empty($last_name)) {
    echo "Last name is empty";
    exit();
}
if (is_empty($email)) {
    echo "Email is empty";
    exit();
}
if (is_empty($user_name)) {
    echo "User name is empty";
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
if (is_empty($placement_type)) {
    echo "Placement type is empty";
    exit();
}

if (is_empty($mobile_number)) {
    echo "Mobile number is empty";
    exit();
}

if (is_empty($otp)) {
    echo "Otp is empty";
    exit();
}
if (!preg_match("/^[0-9']*$/", $mobile_number)) {
    echo "Mobile number is invalid. Only numbers  are allowed";
    exit();
}
if (!preg_match("/^[0-9']*$/", $otp)) {
    echo "Otp is invalid. Only numbers are allowed";
    exit();
}

if (!preg_match("/^[a-zA-Z']*$/", $first_name)) {
    echo "First name is invalid. Only letters are allowed";
    exit();
}

if (!preg_match("/^[a-zA-Z']*$/", $last_name)) {
    echo "Last name is invalid. Only letters are allowed";
    exit();
}

if (!preg_match("/^[0-9']*$/", $referral_id)) {
    echo "Last name is invalid. Only numbers are allowed";
    exit();
}
if (!preg_match("/^[0-9']*$/", $placement_id)) {
    echo "Placement id is invalid. Only numbers are allowed";
    exit();
}
if (!preg_match("/^[A-za-z0-9']*$/", $user_name)) {
    echo "User name is invalid. Only alphanumerics are allowed";
    exit();
}

if (($placement_type !== "Left") && ($placement_type !== "Right")) {
    echo "Placement type is invalid";
    exit();
}

if ($placement_type == "Left") {
    $placement_type = 'left';
} else
if ($placement_type == "Right") {
    $placement_type = 'right';
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email format is invalid";
    exit();
}

if ($password !== $confirm_password) {
    echo "Passwords are not matching";
    exit();
}

if ((strlen($mobile_number) < 11) ||  (strlen($mobile_number) > 13)) {
    echo "Invalid mobile number";
    exit();
}

if (strlen($otp) !== 5) {
    echo "Otp length is invalid";
    exit();
}


if (!is_valid_otp($otp, $email)) {
    echo "Otp is invalid";
    exit();
}

// data validation

$query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id = '$referral_id'");
if (!mysqli_num_rows($query)) {
    echo "Referral id is invalid";
    exit();
}


$query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id = '$placement_id'");
if (!mysqli_num_rows($query)) {
    echo "Placement id is invalid";
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM $pins_tbl WHERE pin = '$referral_code' and status = 'inactive' ");
if (!mysqli_num_rows($query)) {
    echo "Referral code is invalid";
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_name = '$user_name' ");
if (mysqli_num_rows($query)) {
    echo "Username is already in use";
    exit();
}

$data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM $users_tbl ORDER BY id DESC LIMIT 1"));
$user_id = $data['user_id'] + 1;
$query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id = '$user_id' ");
if (mysqli_num_rows($query)) {
    echo "Something went wrong";
    exit();
}

check_placement_type($placement_id, $placement_type);
if (!user_is_in_my_team($referral_id, $placement_id)) {
    echo "Invalid combination of referral and placement id";
    exit();
}


$password = password_hash($password, PASSWORD_BCRYPT);
$query = mysqli_query($conn, "INSERT INTO $users_tbl (`user_id`, `user_name`, `user_password`, `first_name`, `last_name`, `user_phone`, `user_address`, `user_pincode`, `user_contact_email`, `user_image`,`account_image`,`user_registration_date`, `user_account_number`, `user_upi`, `referal_code`, `status`)
    VALUES ('$user_id','$user_name','$password','$first_name','$last_name','$mobile_number','','','$email','avatar.jpg','','$current_date','','','$referral_code','active') ");
if (!$query) {
    echo "Something went wrong";
    exit();
}
$last_id = mysqli_insert_id($conn);

$left_count = 0;
$right_count = 0;
$left_id = 0;
$right_id = 0;
$pair_count = 0;

$tree_query = mysqli_query($conn, "INSERT INTO $tree_tbl ( `user_id`, `referral_id`, `placement_id`, `placement_type`, `left_count`, `right_count`, `left_id`, `right_id`, `pair_count`)
                 VALUES ('$user_id','$referral_id','$placement_id','$placement_type','$left_count','$right_count','$left_id','$right_id', '$pair_count')");
if (!$tree_query) {
    mysqli_query($conn, "DELETE FROM $users_tbl WHERE id = '$last_id' ");
    echo "Something went wrong";
    exit();
}

add_balance_row($user_id);
update_otp($otp, $email);
update_referral_code_and_balance($user_id, $referral_id, $referral_code);
update_placement_data($placement_id, $placement_type, $user_id);
binary_count($placement_id, $placement_type);
include("send_email.php");
send_registration_successfull_email($email, $user_id);
echo "Registartion successfull";
setcookie('registered_user_id', $user_id, time() + (1800), '/');
