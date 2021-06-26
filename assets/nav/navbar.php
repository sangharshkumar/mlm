<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>
            <a class="navbar-brand" href="<?php echo $base_url; ?>">
                <b class="logo-icon">
                    <img src="<?php echo $base_url; ?>/assets/images/web/images-logo-icon.png" alt="homepage" class="dark-logo">
                    <img src="<?php echo $base_url; ?>/assets/images/web/images-logo-light-icon.png" alt="homepage" class="light-logo">
                </b>
                <span class="logo-text">
                    <img src="<?php echo $base_url; ?>/assets/images/web/images-logo-text.png" alt="homepage" class="dark-logo">
                    <img src="<?php echo $base_url; ?>/assets/images/web/images-logo-light-text.png" class="light-logo" alt="homepage">
                </span>
            </a>
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti-more"></i>
            </a>
        </div>
        <div class="navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
            </ul>
            <ul class="navbar-nav header-profile-dropdown">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="ltr.html" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo user_image($loggedin_user_id); ?>" alt="user" class="rounded-circle" width="31">
                    </a>
                    <div style="max-width: 300px;" class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <span class="with-arrow"><span class="bg-success"></span></span>
                        <div class="d-flex no-block align-items-center p-15 bg-success text-white mb-2">
                            <div class="">
                                <img src="<? echo user_image($loggedin_user_id); ?>" alt="user" class="rounded-circle" width="60">
                            </div>
                            <div class="ml-2">
                                <h4 style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:now-wrap;" class="mb-0">
                                    <? echo user_name($loggedin_user_id); ?>
                                </h4>
                                <p style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:now-wrap;" class=" mb-0">
                                    <? echo user_email($loggedin_user_id); ?>
                                </p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="<?php echo $base_url; ?>/profile/"><i class=" icon-user  mr-1 ml-1"></i>My Profile</a>
                        <a class="dropdown-item" href="<?php echo $base_url; ?>/balance/wallet"><i class="ti-wallet mr-1 ml-1"></i>Wallet</a>
                        <a class="dropdown-item" href="<?php echo $base_url; ?>/income-history/"><i class="icon-book-open mr-1 ml-1"></i>Income History</a>
                        <a class="dropdown-item" href="<?php echo $base_url; ?>/refer-link/"><i class="icon-link mr-1 ml-1"></i>Referral Link</a>
                        <a class="dropdown-item" href="<?php echo $base_url; ?>/member/logout.php"><i class="fa fa-power-off mr-1 ml-1"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'dashboard')) {
                                            echo 'active';
                                        } ?> ">
                    <a href="<?php echo $base_url; ?>/dashboard/" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i class="cs-icon icon-grid"></i>
                        <span class="hide-menu">Dashboard </span>
                    </a>
                </li>
                <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'tree')) {
                                            echo 'active';
                                        } ?> ">
                    <a href="<?php echo $base_url; ?>/tree/" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i class="cs-icon mdi mdi-file-tree"></i>
                        <span class="hide-menu">Tree </span>
                    </a>
                </li>
                <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'total-team')) {
                                            echo 'active';
                                        } ?> ">
                    <a href="<?php echo $base_url; ?>/total-team/" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i data-feather="users" class="feather-icon"></i>
                        <span class="hide-menu">Total Team </span>
                    </a>
                </li>
                <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'plan')) {
                                            echo 'active';
                                        } ?> ">
                    <a href="<?php echo $base_url; ?>/plan/" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i class="cs-icon icon-info "></i>
                        <span class="hide-menu">Plan</span>
                    </a>
                </li>
                <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'pin')) {
                                            echo 'active';
                                        } ?> ">
                    <a href="<?php echo $base_url; ?>/pin/" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i class="cs-icon ti-key"></i>
                        <span class="hide-menu">Pin</span>
                    </a>
                </li>
                <li class="sidebar-item has-nav-item">
                    <a class="<?php if ((isset($page_tab)) && ($page_tab == 'balance')) {
                                    echo 'light-active active';
                                } ?> sidebar-link has-arrow waves-effect waves-dark sidebar-link" href=" javascript:void(0)" aria-expanded="false"><i style="-webkit-text-stroke: .4px white;" class="cs-icon mdi mdi-currency-usd"></i><span class="hide-menu">Balance </span></a>
                    <ul aria-expanded="false" class="collapse first-level <?php if ((isset($page_tab)) && ($page_tab == 'balance')) {
                                                                                echo 'in';
                                                                            } ?>  ">
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'wallet')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/balance/" class="sidebar-link"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Wallet </span>
                            </a>
                        </li>
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'add-money')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/balance/add-money.php" class="sidebar-link"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Add Money </span>
                            </a>
                        </li>
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'withdraw')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/balance/withdraw.php" class="sidebar-link"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Withdraw</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-nav-item">
                    <a class="<?php if ((isset($page_tab)) && ($page_tab == 'income-history')) {
                                    echo 'light-active active';
                                } ?> sidebar-link has-arrow waves-effect waves-dark sidebar-link" href=" javascript:void(0)" aria-expanded="false"><i style="-webkit-text-stroke: .4px white;" class="cs-icon icon-book-open"></i><span class="hide-menu">Income History </span></a>
                    <ul aria-expanded="false" class="collapse first-level <?php if ((isset($page_tab)) && ($page_tab == 'income-history')) {
                                                                                echo 'in';
                                                                            } ?>  ">
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'level-income')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/income-history/level-income.php" class="sidebar-link"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Level Income </span>
                            </a>
                        </li>
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'referral-income')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/income-history/referral-income.php" class="sidebar-link"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Referral Income </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'my-referral')) {
                                            echo 'active';
                                        } ?> ">
                    <a href="<?php echo $base_url; ?>/my-referral/" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i class="cs-icon icon-user-follow"></i>
                        <span class="hide-menu">My Referral </span>
                    </a>
                </li>
                <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'refer-link')) {
                                            echo 'active';
                                        } ?>">
                    <a href="<?php echo $base_url; ?>/refer-link/" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i data-feather="link" class="feather-icon"></i>
                        <span class="hide-menu">Refer Link </span>
                    </a>
                </li>
                <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'profile')) {
                                            echo 'active';
                                        } ?>">
                    <a href="<?php echo $base_url; ?>/profile/" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i data-feather="user" class="feather-icon"></i>
                        <span class="hide-menu">Profile </span>
                    </a>
                </li>
                <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'change-password')) {
                                            echo 'active';
                                        } ?>">
                    <a href="<?php echo $base_url; ?>/change-password/" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i data-feather="lock" class="feather-icon"></i>
                        <span class="hide-menu">Change Password</span>
                    </a>
                </li>
                <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'support')) {
                                            echo 'active';
                                        } ?>">
                    <a href="<?php echo $base_url; ?>/support/" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i class="cs-icon icon-speech"></i>
                        <span class="hide-menu">Support</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?php echo $base_url; ?>/member/logout.php" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i data-feather="log-out" class="feather-icon"></i>
                        <span class="hide-menu">Log Out</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>