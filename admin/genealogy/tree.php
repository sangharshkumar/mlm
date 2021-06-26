<?php
include("../../db.php");
include("../assets/php/functions.php");
$active_tab = 'tree';


if (!is_admin_loggedin()) {
    header("location:$base_url/admin/login.php");
    exit();
}


if (isset($_GET['user'])) {
    if (is_user_id($_GET['user'])) {
        $admin_id = $_GET['user'];
    }
}

$page_tab = 'genealogy';
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $web_name; ?></title>
    <script src="<?php echo $base_url; ?>/assets/js/OrgChart.js"></script>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/sweetalert.css">
    <script id="insert"></script>
</head>

<body>

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


        <div class="tree-page-wrapper row col-12">

            <div class="page-breadcrumb" style="width: 100%;">
                <div class="row">
                    <div class="col-12 align-self-center">
                        <h4 class="page-title">Tree</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Genealogy</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Tree</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" id="tree" style="margin-top: 10px;position: relative;">

            </div>

        </div>
        <script type="text/javascript">
            var chart;
            window.onload = function() {
                chart = new OrgChart(document.getElementById("tree"), {
                    template: "ula",
                    mouseScrool: OrgChart.action.none,
                    nodeMouseClick: OrgChart.action.none,
                    collapse: {
                        level: 1,
                        allChildren: true
                    },
                    toolbar: {
                        zoom: true,
                        fit: true,
                        fullScreen: true
                    },

                    scaleInitial: .8,
                    zoom: false,
                    nodeBinding: {
                        img_0: "img",
                        field_0: "name",
                        field_1: "title"
                    },
                    nodes: <?php echo show_admin_tree($admin_id); ?>
                });

                chart.on('searchclick', function(sender, nodeId) {
                    var node = $('g.node[node-id=' + nodeId + ']');
                    aa(node);
                });

                function aa(node) {
                    setTimeout(function() {
                        node.find('rect').attr('fill', 'red !important');
                    }, 1000);
                }

            }
        </script>
        <?php
        include("../../assets/nav/footer.php");
        ?>
        <script>
            $(document).on('click', 'g.node', function() {
                var element = this;
                var nodeId = $(element).attr('node-id');
                var data = chart.get(nodeId);
                //
                var name = data["name"];
                var title = data["title"];
                var email = data["email"];
                var img = data["img"];
                var level = data['level'];
                var left_count = data['left_count'];
                var right_count = data['right_count'];
                var referred_by = data['referred_by'];
                var direct_left_referral = data['direct_left_referral'];
                var direct_right_referral = data['direct_right_referral'];

                var p_id = data['pid'];
                var p_t = data['p_t'];
                if (p_t == 0) {
                    p_t = 'l';
                } else {
                    p_t = 'r';
                }


                $('#profiledata').modal('show');
                $('#profiledata .modal-body').html('<div class="profile-container">\
                            <img src="' + img + '" alt="">\
                            <div>\
                                <p class="h2">' + name + '</p>\
                                <a class="link" href="' + base_url + '/admin/genealogy/tree/' + title + '" ><h6 style="font-size:13px">' + title + '</h6></a>\
                            </div>\
                        </div>\
                       <div class="d-flex justify-content-center"> <p class="m-0" >Level : ' + level + '</p>\</div>\
                        <div class="d-flex justify-content-center"> <h5>Referred by : </h5><p class="h5 ml-1" >' + referred_by + '</p>\</div>\
                        <table class="table table-bordered">\
                            <tbody>\
                                <tr>\
                                    <th>&nbsp;</th>\
                                    <th>LEFT</th>\
                                    <th>RIGHT</th>\
                                </tr>\
                                <tr>\
                                    <td>Direct Referral</td>\
                                    <td><span class="lbv">' + direct_left_referral + '</span></td>\
                                    <td><span class="rbv">' + direct_right_referral + '</span></td>\
                                </tr>\
                                <tr>\
                                    <td>Free Member</td>\
                                    <td><span class="lfree">' + left_count + '</span></td>\
                                    <td><span class="rfree">' + right_count + '</span></td>\
                                </tr>\
                                <tr>\
                                    <td>Paid Member</td>\
                                    <td><span class="lpaid">0</span></td>\
                                    <td><span class="rpaid">0</span></td>\
                                </tr>\
                            </tbody>\
                        </table>');

            });
        </script>




        <!-- Modal -->
        <div class="modal fade" id="profiledata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>