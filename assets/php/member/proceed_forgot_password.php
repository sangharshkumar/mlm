<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

if (!isset($_POST['user_id'])) {
    echo "Something is missing";
    exit();
}
$user_id = clean_text($_POST['user_id']);

if (is_empty($user_id)) {
    echo "User Id is empty";
    exit();
}


$query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_id = '$user_id' || user_name ='$user_id' ");
if (!mysqli_num_rows($query)) {
    echo "Invalid userid or username";
    exit();
}

$userdata = mysqli_fetch_array($query);
$useremail = $userdata['user_contact_email'];
$user_id = $userdata['user_id'];



if (empty($useremail)) {
    echo "You contact email is empty";
    exit();
}

$token = new_token();
$token_purpose = 'forgot-password';
$token_status = '0';
$token_inserted_date = $current_date;
$token_valid_date = strtotime("+15 minutes", ($token_inserted_date));
$token_valid_date = defaultdate($token_valid_date);

$query = mysqli_query($conn, "SELECT * FROM $tokens_tbl WHERE token_creator = '$user_id' AND token_purpose = '$token_purpose' ");
if (mysqli_num_rows($query)) {
    $data = mysqli_fetch_array($query);
    $status =  $data['token_status'];
    if ($status == 0) {
        $token = $data['token'];
    }
    mysqli_query($conn, "DELETE FROM $tokens_tbl WHERE token_creator = '$user_id' AND token_purpose = '$token_purpose' ");
}
$query = mysqli_query($conn, "INSERT INTO $tokens_tbl (`token`, `token_creator`, `token_inserted_date`, `token_valid_date`, `token_purpose`, `token_status`)
                VALUES ('$token','$user_id','$token_inserted_date','$token_valid_date','$token_purpose','$token_status') ");

if (!$query) {
    echo "Something went wrong";
    exit();
}
$last_id = mysqli_insert_id($conn);

include("send_email.php");
$mail = send_forgot_password_email($user_id,$useremail,$token);
if(!$mail) {
    mysqli_query($conn, "DELETE FROM $tokens_tbl WHERE token_id = '$last_id' ");
    echo "Email sending failed";
    exit();
}
echo "Email sending successfull";
exit();
