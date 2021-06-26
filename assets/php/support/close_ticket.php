<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   exit();
}

if (!is_loggedin()) {
   echo "Login to close the ticket";
   exit();
}


if (!isset($_POST['ticket_id'])) {
   echo "Something is missing";
   exit();
}

$ticket_id = $_POST['ticket_id'];
if (!is_ticket($ticket_id)) {
   echo "Something went wrong";
   exit();
}

$ticket_creator = ticket_creator($ticket_id);

if ($ticket_creator !== $loggedin_user_id) {
   echo "You have not permission to close the ticket";
   exit();
}

$query = mysqli_query($conn,"UPDATE $tickets_tbl SET status = 'closed',ticket_closed_by='$loggedin_user_id' WHERE ticket_id = '$ticket_id' ");
if ($query) {
   echo "Ticket closed successfully";
}else{
    echo "Something went wrong";
}


?>