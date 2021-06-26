<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>
            <a class="navbar-brand" href="<?php echo $base_url; ?>/admin">
                    <img style="height: 64px;width: 80%;margin: auto;" src="<?php echo $base_url; ?>/assets/images/web/admin-logo.jpg" alt="homepage" class="img-fluid dark-logo">
                    <img style="height: 64px;width: 80%;margin: auto;" src="<?php echo $base_url; ?>/assets/images/web/admin-logo.jpg" class="img-fluid light-logo" alt="homepage">
            </a>
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti-more"></i>
            </a>
        </div>
        <div class="bg-primary navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
            </ul>
            <ul class="navbar-nav header-profile-dropdown">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="ltr.html" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo user_image($admin_id); ?>" alt="user" class="rounded-circle" width="31">
                    </a>
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
                    <a href="<?php echo $base_url; ?>/admin/dashboard/" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i class="cs-icon icon-grid"></i>
                        <span class="hide-menu">Dashboard </span>
                    </a>
                </li>


                <li class="sidebar-item has-nav-item <?php if ((isset($page_tab)) && ($page_tab == 'genealogy')) {
                                                            echo 'selected';
                                                        } ?> ">
                    <a class="<?php if ((isset($page_tab)) && ($page_tab == 'genealogy')) {
                                    echo 'light-active active';
                                } ?> sidebar-link has-arrow waves-effect waves-dark sidebar-link" href=" javascript:void(0)" aria-expanded="false"><i style="" class="cs-icon  icon-people "></i><span class="hide-menu">Genealogy </span></a>
                    <ul aria-expanded="false" class="collapse first-level <?php if ((isset($page_tab)) && ($page_tab == 'genealogy')) {
                                                                                echo 'in';
                                                                            } ?>  ">
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'tree')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/admin/genealogy/tree.php" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Tree </span>
                            </a>
                        </li>
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'total-team')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/admin/genealogy/total-team.php" class="sidebar-link" aria-expanded="false"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Total Team </span>
                            </a>
                        </li>
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'block-users')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/admin/genealogy/block.php" class="sidebar-link" aria-expanded="false"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Block</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="sidebar-item has-nav-item <?php if ((isset($page_tab)) && ($page_tab == 'wallet')) {
                                                            echo ' selected';
                                                        } ?> ">
                    <a class="<?php if ((isset($page_tab)) && ($page_tab == 'wallet')) {
                                    echo 'light-active active';
                                } ?> sidebar-link has-arrow waves-effect waves-dark sidebar-link" href=" javascript:void(0)" aria-expanded="false"><i style="" class="cs-icon  ti-wallet"></i><span class="hide-menu">Wallet</span></a>
                    <ul aria-expanded="false" class="collapse first-level <?php if ((isset($page_tab)) && ($page_tab == 'wallet')) {
                                                                                echo 'in';
                                                                            } ?>  ">
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'payout')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/admin/wallet/payout.php" class="sidebar-link"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Payout</span>
                            </a>
                        </li>
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'transfered-fund')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/admin/wallet/transfered-fund.php" class="sidebar-link"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Transfered Fund</span>
                            </a>
                        </li>
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'income-history')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/admin/wallet/wallet-history.php" class="sidebar-link"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Wallet History</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item has-nav-item <?php if ((isset($page_tab)) && ($page_tab == 'report')) {
                                                            echo 'selected';
                                                        } ?> ">
                    <a class="<?php if ((isset($page_tab)) && ($page_tab == 'report')) {
                                    echo 'light-active active';
                                } ?> sidebar-link has-arrow waves-effect waves-dark sidebar-link" href=" javascript:void(0)" aria-expanded="false"><i style="" class="cs-icon  icon-chart "></i><span class="hide-menu">Report</span></a>
                    <ul aria-expanded="false" class="collapse first-level <?php if ((isset($page_tab)) && ($page_tab == 'report')) {
                                                                                echo 'in';
                                                                            } ?>  ">
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'income')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/admin/report/income.php" class="sidebar-link"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Income</span>
                            </a>
                        </li>
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'e-pin')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/admin/report/e-pin.php" class="sidebar-link"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">E-Pin</span>
                            </a>
                        </li>
                        <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'joining')) {
                                                    echo 'active';
                                                } ?> ">
                            <a href="<?php echo $base_url; ?>/admin/report/joining.php" class="sidebar-link"><i style="font-size: 10px !important;" class="fas fa-circle"></i>
                                <span class="hide-menu">Joining</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item <?php if ((isset($active_tab)) && ($active_tab == 'support')) {
                                            echo 'active';
                                        } ?>">
                    <a href="<?php echo $base_url; ?>/admin/support/" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i class="cs-icon icon-speech"></i>
                        <span class="hide-menu">Support</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?php echo $base_url; ?>/admin/logout.php" class="sidebar-link waves-effect waves-dark" aria-expanded="false"><i data-feather="log-out" class="feather-icon"></i>
                        <span class="hide-menu">Log Out</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>