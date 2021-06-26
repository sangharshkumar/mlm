<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

if (!is_admin_loggedin()) {
    echo "Login First";
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


$query = mysqli_query($conn, "UPDATE $tickets_tbl SET status = 'closed',ticket_closed_by='$admin_id', ticket_close_date = '$current_date' WHERE ticket_id = '$ticket_id' ");
if ($query) {
    echo "Ticket closed successfully";
} else {
    echo "Something went wrong";
}
