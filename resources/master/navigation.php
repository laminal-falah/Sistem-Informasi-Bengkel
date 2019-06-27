        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">    
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                    <img src="<?= BASE_URL . 'assets/img/logosma.png'; ?>" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info" id="account">
                        <p><?= $_SESSION['name']; ?></p>
                        <a id="password" name="password" href="<?= BASE_URL.'dashboard/'.strtolower(str_replace(' ','-',$menu[3])).'/@'.strtolower($_SESSION['username']).'/' ?>">
                            <i class="fa fa-lock text-blue"></i>
                        </a>
                        <a id="logout" name="logout" href="<?= BASE_URL.'logout/'; ?>">
                            <i class="fa fa-sign-out text-red"></i>
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree" id="navigation">
                    <li class="header">MAIN NAVIGATION</li>
                    <!-- Optionally, you can add icons to the links -->
                    <li class="<?= FIRST_PART == 'dashboard' && SECOND_PART == '' && THIRD_PART == '' ? 'active' : '' ?>">
                        <a href="<?= BASE_URL . 'dashboard/' ?>" class="menu">
                            <i class="fa fa-dashboard text-olive"></i> 
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <!-- Nav Manajemen Data -->
                    <?php if (hasPermit('menu_data')) { ?>
                        <li class="treeview <?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[0])) ? 'active' : '' ?>">
                            <a href="javascript:void()">
                                <i class="fa fa-database text-purple"></i> 
                                <span><?= $menu[0] ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if (hasPermit('submenu_data_user')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[0])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[0])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[0])). '/' .strtolower(str_replace(' ', '-', $submenu[0])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-red"></i>
                                            <span><?= $submenu[0] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (hasPermit('submenu_data_alat')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[0])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[1])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[0])). '/' .strtolower(str_replace(' ', '-', $submenu[1])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-yellow"></i>
                                            <span><?= $submenu[1] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (hasPermit('submenu_data_sparepart')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[0])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[2])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[0])). '/' .strtolower(str_replace(' ', '-', $submenu[2])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-green"></i>
                                            <span><?= $submenu[2] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (hasPermit('submenu_data_user')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[0])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[10])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[0])). '/' .strtolower(str_replace(' ', '-', $submenu[10])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-blue"></i>
                                            <span><?= $submenu[10] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- Nav Transaksi -->
                    <?php if (hasPermit('menu_transaksi')) { ?>
                        <li class="treeview <?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[1])) ? 'active' : '' ?>">
                            <a href="javascript:void()">
                                <i class="fa fa-shopping-basket text-maroon"></i> 
                                <span><?= $menu[1] ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if (hasPermit('submenu_transaksi_peminjaman')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[1])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[3])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[1])). '/' .strtolower(str_replace(' ', '-', $submenu[3])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-red"></i>
                                            <span><?= $submenu[3] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (hasPermit('submenu_transaksi_pengembalian')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[1])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[4])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[1])). '/' .strtolower(str_replace(' ', '-', $submenu[4])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-yellow"></i>
                                            <span><?= $submenu[4] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (hasPermit('submenu_transaksi_penjualan')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[1])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[5])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[1])). '/' .strtolower(str_replace(' ', '-', $submenu[5])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-green"></i>
                                            <span><?= $submenu[5] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (hasPermit('submenu_transaksi_pembelian')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[1])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[6])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[1])). '/' .strtolower(str_replace(' ', '-', $submenu[6])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-blue"></i>
                                            <span><?= $submenu[6] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- Nav Laporan -->
                    <?php if (hasPermit('menu_laporan')) { ?>
                        <li class="treeview <?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[2])) ? 'active' : '' ?>">
                            <a href="javascript:void()">
                                <i class="fa fa-file-pdf-o text-red"></i> 
                                <span><?= $menu[2] ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if (hasPermit('submenu_laporan_peminjaman')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[2])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[3])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[2])). '/' .strtolower(str_replace(' ', '-', $submenu[3])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-red"></i>
                                            <span><?= $submenu[3] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (hasPermit('submenu_laporan_pengembalian')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[2])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[4])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[2])). '/' .strtolower(str_replace(' ', '-', $submenu[4])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-yellow"></i>
                                            <span><?= $submenu[4] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (hasPermit('submenu_laporan_penjualan')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[2])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[5])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[2])). '/' .strtolower(str_replace(' ', '-', $submenu[5])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-green"></i>
                                            <span><?= $submenu[5] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (hasPermit('submenu_laporan_pembelian')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[2])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[6])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[2])). '/' .strtolower(str_replace(' ', '-', $submenu[6])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-blue"></i>
                                            <span><?= $submenu[6] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (hasPermit('submenu_laporan_pengadaan')) { ?>
                                    <li class="<?= @$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[2])) && @$_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[7])) ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . 'dashboard/' .strtolower(str_replace(' ', '-', $menu[2])). '/' .strtolower(str_replace(' ', '-', $submenu[7])). '/' ?>" class="menu">
                                            <i class="fa fa-circle-o text-aqua"></i>
                                            <span><?= $submenu[7] ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>