<?php
include("../db.php");
if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}
$active_tab = 'support';
$ticket_id = $_GET['ticket'];
$user_id = $loggedin_user_id;
if (!is_my_ticket($ticket_id, $user_id)) {
    echo "Permission denied";
    exit();
}

$ticket_status = ticket_status($ticket_id);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $web_name; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/sweetalert.css">
</head>

<body page="support">
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper">
        <?php
        include("../assets/nav/navbar.php");
        ?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 align-self-center">
                        <h4 class="page-title">Support</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo $base_url; ?>/support/">Support</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Ticket</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <a href="<?php echo $base_url; ?>/support" class="btn btn-primary btn-lg">All tickets</a>
                    </div>
                </div>
            </div>
            <div class="container-fluid">

                <div class="col-12 card d-flex flex-row align-items-center py-3 px-4 justify-content-between">
                    <?php
                    $ticket_closed_by = ticket_closed_by($ticket_id);
                    $ticket_status_color = 'success';
                    if ($ticket_status == 'closed') {
                        $ticket_status_color =  'danger';
                    } else {
                        $ticket_status_color =  'success';
                    }
                    ?>
                    <div> <span style="font-size:14px;" class="label label-<?php echo $ticket_status_color; ?> py-2 px-3"><?php echo $ticket_status; ?></span><span style="background:transparent"><?php if ($ticket_status == "closed") {
                                                                                                                                                                                                        echo "<b class='ml-3'>by $ticket_closed_by</b> ";
                                                                                                                                                                                                    } ?></span>
                    </div>

                    <?php if ($ticket_status !== 'closed') {
                    ?>
                        <button id="close_ticket_btn" class="btn btn-danger">Close Ticket</button>
                    <?php
                    } else {
                        echo '<button style="opacity:0"></button>';
                    }
                    ?>


                </div>
                <?php if ($ticket_status !== 'closed') {
                ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Add your reply</h4>
                                    <form id="add_reply_to_ticket" class="needs-validation" ticket-id="<?php echo $ticket_id; ?>" novalidate="">
                                        <div class="form-row">
                                            <div class="col-md-12 mb-3">
                                                <label>Message</label>
                                                <textarea name="message" rows="13" type="text" class="form-control" placeholder="Message" required=""></textarea>
                                                <div class="invalid-feedback">
                                                    Please provide a valid message
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="validationCustom01">Add attachements</label>
                                                <div id="drag-drop-area"></div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                <div id="tickets_container" class="row">
                    <?php
                    $ticket_id = $_GET['ticket'];
                    echo show_tickets_messages($ticket_id);
                    ?>
                </div>


            </div>
        </div>
    </div>
    <?php
    include("../assets/nav/footer.php");
    ?>
    <link href="<?php echo $base_url; ?>/assets/css/uppy.css" rel="stylesheet">
    <script src="<?php echo $base_url; ?>/assets/js/uppy.js"></script>
    <script>
        var ticket_id = '<?php echo $ticket_id; ?>';
        var uppy = Uppy.Core({
            restrictions: {
                maxFileSize: 1000000,
                maxNumberOfFiles: 3,
                allowedFileTypes: ['image/*']
            }
        }).use(Uppy.Dashboard, {
            inline: true,
            target: '#drag-drop-area',
            height: 300,

        });
        var uploadfiles = '';
        const XHRUpload = Uppy.XHRUpload;
        uppy.use(XHRUpload, {
            formData: true,
            endpoint: base_url + '/support/upload',
            fieldName: 'my_file',
            metaFields: null,
            getResponseData(responseText, response) {
                uploadfiles += responseText + ',';
                return {
                    url: responseText
                }
            }
        })
    </script>
</body>

</html>