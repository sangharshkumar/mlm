<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

if (!isset($_POST['user_id'], $_POST['password'], $_POST['keeploggedin'])) {
    echo "Something is missing";
    exit();
}
$user_id = clean_text($_POST['user_id']);
$password = clean_text($_POST['password']);
$keeploggedin = $_POST['keeploggedin'];
if (is_empty($user_id)) {
    echo "Username or userid is required";
    exit();
}
if (is_empty($password)) {
    echo "Password is required";
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM $users_tbl WHERE user_name = '$user_id' || user_id = '$user_id' ");
$row = mysqli_fetch_array($query);
if (!mysqli_num_rows($query)) {
    echo "Username and password is invalid";
    exit();
}

$db_password = $row['user_password'];
$pass_decode = password_verify($password,$db_password);
if (!$pass_decode) {
    echo "Username and password is invalid";
   exit();
}

$login_status = $row['status'];
$db_user_id = $row['user_id'];

if ($login_status === 'active') {
    $session_id = new_session_id();
    $valid_till_date = '';

    if ($keeploggedin == 1) {
        $valid_till_date = (strtotime("+30 days", ($current_date)));
        $time = time() + (86400 * 30);
    }else if($keeploggedin == 0){
        $valid_till_date = (strtotime("+30 minutes", ($current_date)));
        $time =  time() + (1800);
    }
    setcookie('session_id', $session_id,$time, '/');
    $query = mysqli_query($conn, "INSERT INTO $login_session_tbl (`user_id`, `session_id`, `loggedin_at`, `valid_till`) 
                VALUES ('$db_user_id','$session_id','$current_date','$valid_till_date') ");

    if ($query) {
        echo "Login successfull";
        exit();
    }
    echo "Something went wrong";
    exit();
}

if ($login_status == 'block') {
    echo "You are blocked";
    exit();
}

echo "Something went wrong";