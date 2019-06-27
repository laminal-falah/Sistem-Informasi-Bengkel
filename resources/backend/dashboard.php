<?php include_once '../master/header.php'; ?>

        <div class="content-wrapper">

            <section class="content-header">
                <h1>
                    <?php
                        if (FIRST_PART == "dashboard" && SECOND_PART == "" && THIRD_PART == "") {
                            echo ucwords(str_replace('-', ' ', FIRST_PART));
                        }
                        elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[0]))) {
                            if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[0]))) {
                                echo $menu[0] ." ".$submenu[0];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[1]))) {
                                echo $menu[0] ." ".$submenu[1];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[2]))) {
                                echo $menu[0] ." ".$submenu[2];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[10]))) {
                                echo $menu[0] ." ".$submenu[10];
                            }
                            else {
                                echo "Error";
                            }
                        }
                        elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[1]))) {
                            if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[3]))) {
                                echo $menu[1] ." ".$submenu[3];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[4]))) {
                                echo $menu[1] ." ".$submenu[4];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[5]))) {
                                echo $menu[1] ." ".$submenu[5];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[6]))) {
                                echo $menu[1] ." ".$submenu[6];
                            }
                            else {
                                echo "Error";
                            }
                        }
                        elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[2]))) {
                            if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[3]))) {
                                echo $menu[2] ." ".$submenu[3];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[4]))) {
                                echo $menu[2] ." ".$submenu[4];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[5]))) {
                                echo $menu[2] ." ".$submenu[5];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[6]))) {
                                echo $menu[2] ." ".$submenu[6];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[7]))) {
                                echo $menu[2] ." ".$submenu[7];
                            }
                            else {
                                echo "Error";
                            }
                        }
                        elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[3]))) {
                            if ($_REQUEST['submenu'] == "@".strtolower(str_replace([' ', '_'],'-',$_SESSION['username']))) {
                                echo $menu[3];
                            }
                            else {
                                echo "Error";
                            }
                        }
                        elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[5]))) {
                            if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[8]))) {
                                echo $menu[5] ." ".$submenu[8];
                            }
                            elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[9]))) {
                                echo $menu[5] ." ".$submenu[9];
                            }
                            else {
                                echo "Error";
                            }
                        }
                        else {
                            echo "Error";
                        }
                    ?>
                    <small><b><?= tanggal(date('N-Y-n-d',strtotime('now'))) ?> <span id="clock"></span></b></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?= BASE_URL . 'dashboard/'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <?php
                        if (FIRST_PART == "dashboard" && SECOND_PART == "" && THIRD_PART == "") {
                            ?><li class="active">Here</li><?php
                        } 
                        else if ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[0])) || $_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[1])) ||
                                 $_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[2])) || $_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[4])) ||
                                 $_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[5]))) {
                            if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[0])) || $_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[1])) || 
                                $_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[2])) || $_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[3])) ||
                                $_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[4])) || $_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[5])) ||
                                $_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[6])) || $_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[7])) ||
                                $_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[8])) || $_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[9])) ||
                                $_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[10])) ) {
                                ?>  
                                    <li><a href="javascript:void()"><?= ucwords(str_replace('-', ' ', $_REQUEST['menu'])) ?></a></li>
                                    <li><a href="javascript:void()"><?= ucwords(str_replace('-', ' ', $_REQUEST['submenu'])) ?></a></li>
                                    <li class="active">Here</li>
                                <?php
                            }
                            else {
                                ?><li><a href="javascript:void()">Error</a></li><?php
                            }
                        }
                        else if ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[3]))) {
                            ?>
                                <li><a href="javascript:void()"><?= ucwords(str_replace('-', ' ', $_REQUEST['menu'])) ?></a></li>
                                <li class="active">Here</li>
                            <?php
                        } 
                        else {
                            ?><li><a href="javascript:void()">Error</a></li><?php
                        }
                    ?>
                </ol>
            </section>
    
            <!-- Main content -->
            <section class="content container-fluid" id="content-js">
                <?php
                    // Dashboard //
                    if (FIRST_PART == "dashboard" && SECOND_PART == "" && THIRD_PART == "") { ?>
                        <div class="callout callout-info">
                            <h4 class="text-center">Selamat Datang Di Aplikasi Pengolahan Data Alat dan Sparepart SMK Teknologi BISTEK Palembang</h4>
                        </div>
                        <div class="row" id="data-box"></div>
                <?php }
                    // Manajemen Data //
                    elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[0])) && hasPermit('menu_data')) {
                        if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[0]))) {
                            if (hasPermit('submenu_data_user')) {
                                if (hasPermit($static['data-user']['permissions'][0])) { 
                                    echo tombol_tambah(1,$static['data-user']['box-create']);
                                }
                                echo table($static['data-user']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/user.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[1]))) {
                            if (hasPermit('submenu_data_alat')) {
                                if (hasPermit($static['data-alat']['permissions'][0])) { 
                                    echo tombol_tambah(1,$static['data-alat']['box-create']);
                                }
                                echo table($static['data-alat']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/alat.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[2]))) {
                            if (hasPermit('submenu_data_sparepart')) {
                                if (hasPermit($static['data-sparepart']['permissions'][0])) { 
                                    echo tombol_tambah(1,$static['data-sparepart']['box-create']);
                                }
                                echo table($static['data-sparepart']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/sparepart.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[10]))) {
                            if (hasPermit('submenu_data_user')) {
                                if (hasPermit($static['data-satuan']['permissions'][0])) { 
                                    echo tombol_tambah(0,$static['data-satuan']['box-create']);
                                }
                                echo table($static['data-satuan']['table']);
                                echo "<style> #boxnyo { width: 50% !important; } </style>";
                                echo '<script src="'.BASE_URL.'assets/js/page/satuan.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        else {
                            include_once '../master/error/404.php';
                        }
                    }
                    // Transaksi //
                    elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[1])) && hasPermit('menu_transaksi')) {
                        if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[3]))) {
                            if (hasPermit('submenu_transaksi_peminjaman')) {
                                if (hasPermit($static['data-peminjaman']['permissions'][0])) { 
                                    echo tombol_tambah(1,$static['data-peminjaman']['box-create']);
                                }
                                echo table($static['data-peminjaman']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/peminjaman.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[4]))) {
                            if (hasPermit('submenu_transaksi_pengembalian')) {
                                if (hasPermit($static['data-pengembalian']['permissions'][0])) { 
                                    echo tombol_tambah(1,$static['data-pengembalian']['box-create']);
                                }
                                echo table($static['data-pengembalian']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/pengembalian.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[5]))) {
                            if (hasPermit('submenu_transaksi_penjualan')) {
                                if (hasPermit($static['data-penjualan']['permissions'][0])) { 
                                    echo tombol_tambah(1,$static['data-penjualan']['box-create']);
                                }
                                echo table($static['data-penjualan']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/penjualan.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[6]))) {
                            if (hasPermit('submenu_transaksi_pembelian')) {
                                if (hasPermit($static['data-pembelian']['permissions'][0])) { 
                                    echo tombol_tambah(1,$static['data-pembelian']['box-create']);
                                }
                                echo table($static['data-pembelian']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/pembelian.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        else {
                            include_once '../master/error/404.php';
                        }
                    }
                    // Laporan //
                    elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[2])) && hasPermit('menu_laporan')) {
                        if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[3]))) {
                            if (hasPermit('submenu_laporan_peminjaman')) {
                                echo table($static['data-peminjaman']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/lap-peminjaman.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[4]))) {
                            if (hasPermit('submenu_laporan_pengembalian')) {
                                echo table($static['data-pengembalian']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/lap-pengembalian.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[5]))) {
                            if (hasPermit('submenu_laporan_penjualan')) {
                                echo table($static['data-penjualan']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/lap-penjualan.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[6]))) {
                            if (hasPermit('submenu_laporan_pembelian')) {
                                echo table($static['data-pembelian']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/lap-pembelian.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[7]))) {
                            if (hasPermit('submenu_laporan_pengadaan')) {
                                if (hasPermit($static['data-pengadaan']['permissions'][0])) { 
                                    echo tombol_tambah(1,$static['data-pengadaan']['box-create']);
                                }
                                echo table($static['data-pengadaan']['table']);
                                echo '<script src="'.BASE_URL.'assets/js/page/pengadaan.js"></script>';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        }
                        else {
                            echo "404";
                        }
                    }
                    // Password //
                    elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[3]))) {
                        if ($_REQUEST['submenu'] == "@".strtolower(str_replace([' ', '_'],'-',$_SESSION['username']))) {
                            include_once 'change_password.php';
                        }
                        else {
                            echo "404";
                        }
                    }
                    // shopping //
                    elseif ($_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[5])) && hasPermit('menu_shopping')) {
                        if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[8]))) {
                            if (hasPermit('sub_menu_shopping')) {
                                include_once 'shopping.php';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        } elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[9]))) {
                            if (hasPermit('sub_menu_cart')) {
                                include_once 'cart.php';
                            } else {
                                include_once '../master/error/403.php';
                            }
                        } else {
                            include_once '../master/error/404.php';
                        }
                    }
                    // Error Handling //
                    else {
                        include_once '../master/error/404.php';
                    }
                ?>
            </section>
            <!-- /.content -->
        </div>

<?php include_once '../master/footer.php'; ?>