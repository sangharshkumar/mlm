<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

if (!isset($_POST['first_name'],$_POST['last_name'],$_POST['user_email'],$_POST['phone'],$_POST['address'],$_POST['pincode'],$_POST['password'])) {
    echo "Something is missing";
    exit();
}

$user_contact_email = clean_text($_POST['user_email']);
$phone = clean_text($_POST['phone']);
$address = clean_text($_POST['address']);
$pincode = clean_text($_POST['pincode']);
$password = clean_text($_POST['password']);
$first_name = clean_text($_POST['first_name']);
$last_name = clean_text($_POST['last_name']);


if (is_empty($user_contact_email))  {
    echo "User email is required";
    exit();
}
if (is_empty($phone))  {
    echo "Phone is required";
    exit();
}
if (is_empty($address))  {
    echo "Address is required";
    exit();
}
if (is_empty($pincode))  {
    echo "Pincode is required";
    exit();
}

if (is_empty($first_name))  {
    echo "First name is required";
    exit();
}
if (is_empty($last_name))  {
    echo "Last name is required";
    exit();
}
if (is_empty($password))  {
    echo "Password is required";
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
if (!preg_match("/^[0-9']*$/", $pincode)) {
    echo "Pin code is invalid. Only numbers are allowed";
    exit();
}
if (!preg_match("/^[0-9']*$/", $phone)) {
    echo "Phone is invalid. Only numbers  are allowed";
    exit();
}

if (!filter_var($user_contact_email, FILTER_VALIDATE_EMAIL)) {
    echo  "Email format is invalid";
    exit();
}

if ( (strlen($phone) < 11) ||  (strlen($phone) > 13) ) {
   echo "Invalid mobile number";
   exit();
}

$data = user_data($loggedin_user_id);
$db_password = $data['user_password'];
$pass_decode = password_verify($password,$db_password);
if (!$pass_decode) {
   echo "Invalid password";
   exit();
}

$query = mysqli_query($conn,"UPDATE $users_tbl SET `first_name` = '$first_name', `last_name`= '$last_name', `user_phone` = '$phone', `user_address` = '$address' , `user_pincode` = '$pincode' , `user_contact_email` = '$user_contact_email' WHERE user_id = '$loggedin_user_id' ");
if ($query) {
   echo "Successfully updated";
   exit();
}

echo "Something Went Wrong";
?>