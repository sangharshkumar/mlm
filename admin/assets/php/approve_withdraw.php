<?php

if(!isset($_POST['withdraw_id'],$_POST['payment_method'])){
    echo "Something went wrong";
    exit();
}

if (!is_admin_loggedin()) {
    echo "Login First";
    exit();
}


$withdraw_id = $_POST['withdraw_id'];
if (!is_withdraw_id($withdraw_id)) {
    echo "Something went wrong";
    exit();
}

$payment_method = $_POST['payment_method'];
if (is_empty($payment_method)) {
   echo "Select a payment method";
   exit();
}

if ($payment_method !== "qr" && $payment_method !== "paytm" && $payment_method !== "upi") {
    echo "Payment method is invalid";
    exit();
}


$status = get_withdraw_status($withdraw_id);
if ($status !== "pending") {
    echo "Something went wrong";
    exit();
}



$query = mysqli_query($conn,"SELECT * FROM $withdraw_request_tbl WHERE withdraw_id = '$withdraw_id' ");
$data = mysqli_fetch_array($query);
$user_id = $data['user_id'];
$amount = $data['amount'];
$charge = $data['charge'];
$other_charge = $data['other_charge'];
$net_amount = $data['payable'];
$requested_date = $data['requested_date'];
$total_charge = $charge + $other_charge;

$user_data = user_data($user_id);
if ($payment_method == "qr") {
    if (!is_empty($user_data['account_image'])) {
        $payment_method = $payment_method . '||' . $user_data['account_image'];
        $withdraw_description = '<a href="'.user_account_image($user_id).'" >QR Code</a>';
    }
  else{
      echo "Payment image is empty";
      exit();
  }
}
else if ($payment_method == "paytm") {
    if (!is_empty($user_data['user_account_number'])) {
        $payment_method = $payment_method . '||' . $user_data['user_account_number'];
        $withdraw_description = $user_data['user_account_number'];
    }else{
        echo "Payment number is empty";
        exit();
    }
}

if ($payment_method == "upi") {
    if (!is_empty($user_data['user_upi'])) {
        $payment_method = $payment_method . '||' . $user_data['user_upi'];
        $withdraw_description = $user_data['user_upi'];
    }else{
        echo "Upi is invalid";
        exit();
    }
}

$payable_amount = withdraw_payable_amount($withdraw_id);
$query = mysqli_query($conn, "UPDATE $withdraw_request_tbl SET status = 'success',payment_method = '$payment_method', payment_date = '$current_date' WHERE withdraw_id = '$withdraw_id' ");
mysqli_query($conn, "INSERT INTO $transaction_tbl (`user_id`, `amount`, `transaction_charge`, `net_amount`, `description`,`category`, `date`, `status`)
                         VALUES ('$user_id','$amount','$total_charge','$net_amount','$withdraw_description','withdraw','$current_date','debit') ");
mysqli_query($conn, "UPDATE $balance_tbl SET pending = pending - '$amount', total_withdrawl = total_withdrawl + '$amount',  last_withdrawl = '$amount' WHERE user_id = '$user_id' ");
echo "Withdraw approved";
exit();
?>