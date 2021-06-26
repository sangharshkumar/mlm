<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   exit();
}

if (!isset($_POST['amount'])) {
   echo "Something is missing";
   exit();
}

$user_id = $loggedin_user_id;

if(is_user_blocked($user_id)){
   echo "You id has blocked please contact customer support";
   exit();
}

$amount = $_POST['amount'];
$wallet = wallet($user_id);
if ($amount > $wallet) {
    echo "Insufficient amount to withdraw";
    exit();
}

$user_income = income($user_id);
$query = mysqli_query($conn,"UPDATE $balance_tbl SET wallet = wallet - $amount WHERE user_id = '$user_id' ");
if (!$query) {
   echo "Something went wrong";
   exit();
}
$user_wallet = wallet($user_id);
if ($user_income > $user_wallet) {
  mysqli_query($conn,"UPDATE $balance_tbl SET income = '$user_wallet' WHERE user_id = '$user_id' ");
}
//
$transaction_charge = '0.00';
if ($amount < 100) {
   $transaction_charge = '10.00';
}

$charge = (5 / 100) * $amount;
$net_amount = $amount - $transaction_charge - $charge;

$amount = to_decimal($amount);
$net_amount = to_decimal($net_amount);

$total_charge = $transaction_charge + $charge;
$total_charge = to_decimal($total_charge);
if ($net_amount < 0 ){
   echo "Amount is very less";
   exit();
}
mysqli_query($conn,"INSERT INTO $withdraw_request_tbl (`user_id`, `amount`, `charge`, `other_charge`, `payable`, `payment_method`, `requested_date`, `status`, `payment_date`) 
         VALUES ('$user_id','$amount','$charge','$transaction_charge','$net_amount','','$current_date','pending','') ");

mysqli_query($conn,"UPDATE $balance_tbl SET pending = pending + '$amount' WHERE user_id = '$user_id' ");
echo "Withdraw successfull";
exit();
?>