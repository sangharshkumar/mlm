<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

if (!isset($_POST['message'], $_POST['ticket_id'])) {
    echo "Something is missing";
    exit();
}


$message = clean_text($_POST['message']);
$files = clean_text($_POST['files']);
$ticket_id = clean_text($_POST['ticket_id']);

if (is_empty($message)) {
    echo "Message is required";
    exit();
}

if (is_empty($ticket_id)) {
    echo "Message is required";
    exit();
}

if (!is_ticket($ticket_id)) {
    echo "Something went wrong";
    exit();
}


$ticket_status = ticket_status($ticket_id);
if ($ticket_status == "closed") {
  echo "This ticket was closed";
  exit();
}

$query = mysqli_query($conn, "INSERT INTO $ticket_messages_tbl (`ticket_id`, `ticket_creator`, `ticket_message`, `ticket_date`, `ticket_files`) 
                    VALUES ('$ticket_id','$loggedin_user_id','$message','$current_date','$files') ");

if (!$query) {
    echo "Something went wrong";
} else {
    $id = mysqli_insert_id($conn);
    $name = ticket_message_name($id);
    $message =  ticket_replied_message($id);
    $date = ticket_message_date($id);
?>
    <div class="col-12 single-note-item all-category px-4 py-1">
        <div class="card card-body">
            <span class="side-stick"></span>
            <h5 class="note-title text-truncate w-75 mb-0"><?php echo $name; ?> </h5>
            <p class="note-date font-12 text-muted"><?php echo $date; ?></p>
            <div class="note-content">
                <p class="note-inner-content text-muted"><?php echo $message; ?></p>
            </div>
            <div class="py-1">
                <?php echo ticket_message_files($id); ?>
            </div>
        </div>
    </div>
<?php
}
