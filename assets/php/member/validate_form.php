<?php


if (!isset($_POST['condition'])) {
   exit();
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

$condition = clean_text($_POST['condition']);
if (is_empty($condition)) {
  exit();
}

switch ($condition) {

    case 'referral_id':
        $referral_id = clean_text($_POST['referral_id']);
        if (!is_user_id($referral_id)) {
           echo "Invalid referral id";
        }else{
            $referral_username = user_name($referral_id);
            echo $referral_username;
        }
        
    break;

    case 'placement_id':
        $placement_id = clean_text($_POST['placement_id']);
        if (!is_user_id($placement_id)) {
           echo "Invalid placement id";
        }else{
            $placement_name = user_name($placement_id);
            $data = user_tree_data($placement_id);
            $left_id = $data['left_id'];
            $right_id = $data['right_id'];

            $output = new stdClass();
            $output->placement_name = $placement_name;
            $output->left_id = $left_id;
            $output->right_id = $right_id;
            echo json_encode($output);
        }
       break;

    case 'referral_code':
        $referral_code = clean_text($_POST['referral_code']);
        if (is_referral_code($referral_code)) {
            echo "Referral code matched";
        }else{
            echo "Invalid referral code";
        }

        break;

    case 'user_name_verify':
        $user_name = clean_text($_POST['user_name']);
        if (is_empty($user_name)) {
          echo "User name is empty";
          exit();
        }
        $query = mysqli_query($conn,"SELECT * FROM $users_tbl WHERE user_name ='$user_name' ");
        if (mysqli_num_rows($query)) {
          echo "username is already in use";
        }else{
            echo "username is available";
        }
    break;


    case 'validate_otp':
        if(!isset($_POST['email'],$_POST['otp'])){
            echo "Invalid otp";
            exit();
        }
        $email = clean_text($_POST['email']);
        $otp = clean_text($_POST['otp']);
        $query = mysqli_query($conn,"SELECT * FROM $otp_tbl WHERE otp = '$otp' AND otp_email ='$email' AND otp_status = '0' ");
        if (mysqli_num_rows($query)) {
           echo "Otp valid";
           exit();
        }
        echo "Invalid otp";
    break;
    
    default:
        # code...
        break;
}


?>