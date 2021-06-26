<?php
include("../db.php");
$active_tab = 'support';
if (!is_loggedin()) {
    header("location:$base_url");
    exit();
}

$user_id = $loggedin_user_id;
$loggedin_user_name = user_name($user_id);
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
                        <h4 class="page-title">Add a ticket</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo $base_url;?>/support/">Support</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add a ticket</li>
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Add a ticket</h4>
                                <form id="add_ticket" class="needs-validation" novalidate="">
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom01">Username</label>
                                            <input readonly type="text" class="form-control" placeholder="First name" value="<?php echo $loggedin_user_name; ?>" required="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="validationCustom02">User Id</label>
                                            <input readonly type="text" class="form-control" placeholder="Last name" value="<?php echo $loggedin_user_id; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustom01">Subject</label>
                                            <input name="subject" type="text" class="form-control" id="validationCustom01" placeholder="Subject" required="">
                                            <div class="invalid-feedback">
                                                Please provide a valid subject
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustom01">Message</label>
                                            <textarea rows="13" name="message" type="text" class="form-control" id="validationCustom01" placeholder="Message" required=""></textarea>
                                            <div class="invalid-feedback">
                                                Please provide a valid message
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="validationCustom01">Add attachements (Optional)</label>
                                            <div id="drag-drop-area"></div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
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
        var uppy = Uppy.Core({
            restrictions: {
                maxFileSize: 1000000,
                maxNumberOfFiles: 3,
                allowedFileTypes: ['image/*']
            }
        }).use(Uppy.Dashboard, {
            inline: true,
            target: '#drag-drop-area',
            height: 400,
            width: 800

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