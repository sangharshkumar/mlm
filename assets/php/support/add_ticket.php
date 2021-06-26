<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}


if (!isset($_POST['subject'], $_POST['message'], $_POST['files'])) {
    echo "Something is missing";
    exit();
}

$message = clean_text($_POST['message']);
$subject = clean_text($_POST['subject']);
$files = clean_text($_POST['files']);

if (is_empty($message)) {
   echo "Message is required";
   exit();
}
if (is_empty($subject)) {
   echo "Subject is required";
   exit();
}


$ticket_id = random_number(10);
$query = mysqli_query($conn,"INSERT INTO $tickets_tbl (`ticket_id`,`ticket_creator`,`ticket_subject`,`ticket_create_date`,`status`,`ticket_closed_by`, `ticket_close_date` )
                        VALUES ('$ticket_id','$loggedin_user_id','$subject','$current_date','pending','','')  ");
if ($query) {
    mysqli_query($conn, "INSERT INTO $ticket_messages_tbl (`ticket_id`, `ticket_creator`, `ticket_message`, `ticket_date`, `ticket_files`) 
                    VALUES ('$ticket_id','$loggedin_user_id','$message','$current_date','$files') ");
    echo "Ticket submitted successfully";
}else{
    echo "Something went wrong";
}