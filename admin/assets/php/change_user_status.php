<?php
if (!isset($_POST['condition'],$_POST['user_id'])) {
    exit();
}

if (!is_admin_loggedin()) {
    echo "Login First";
    exit();
}


$condition = $_POST['condition'];
$user_id = $_POST['user_id'];


switch ($condition) {
    case 'block':
       mysqli_query($conn, "UPDATE $users_tbl SET status = 'block' WHERE user_id = '$user_id' ");
       $query = mysqli_query($conn,"SELECT * FROM $blocked_users_tbl WHERE user_id = '$user_id' ");
       if(!mysqli_num_rows($query)){
            mysqli_query($conn, "INSERT INTO $blocked_users_tbl (`user_id`,`blocked_date`) VALUES ('$user_id','$current_date') ");
       }
        break;

    case 'unblock':
       mysqli_query($conn, "UPDATE $users_tbl SET status = 'active' WHERE user_id = '$user_id' ");
       mysqli_query($conn,"DELETE FROM $blocked_users_tbl WHERE user_id = '$user_id' ");
        break;
    
    default:
        break;
}