<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

if (!isset($_POST['email'])) {
   echo "Something is missing";
   exit();
}

$email = clean_text($_POST['email']);

if (is_empty($email)) {
   echo "Email is empty";
   exit();
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email format is invalid";
    exit();
}

$query = mysqli_query($conn,"SELECT * FROM $otp_tbl WHERE otp_email = '$email' AND otp_status = '0' ");
if (mysqli_num_rows($query)) {
    $data = mysqli_fetch_array($query);
    $otp = $data['otp'];
    mysqli_query($conn,"DELETE FROM $otp_tbl WHERE otp_email = '$email' AND otp_status = '0' ");
}else{
    $otp = new_otp($email);
}


$otp_inserted_date = $current_date;
$otp_valid_date = strtotime("+15 minutes", ($otp_inserted_date));

$query = mysqli_query($conn, "INSERT INTO $otp_tbl (`otp`, `otp_email`, `otp_inserted_date`, `otp_valid_date`, `otp_status`)
                 VALUES ('$otp','$email','$otp_inserted_date','$otp_valid_date','0') ");

if (!$query) {
    echo "Something went wrong";
    exit();
}

$last_id = mysqli_insert_id($conn);

include("send_email.php");
$action = send_otp($email,$otp);
if (!$action) {
    mysqli_query($conn, "DELETE FROM $otp_tbl WHERE otp_id = '$last_id' ");
    echo "Otp sending failed";
    exit();
}
echo "Otp sending successfull";
exit();

?>