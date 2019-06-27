<?php 
  session_set_cookie_params(0,'/sisinfobengkel'); 
  session_start();
  include_once '../path.php';
  include_once (ABSPATH . '../config/config.php');
  include_once (ABSPATH . '../config/database.php');
  include_once (ABSPATH . '../config/functions.php');
  include_once (ABSPATH . '../config/enkripsi.php');
  include_once (ABSPATH . '../config/static.php');
  
  $url = BASE_URL;
  if (FIRST_PART == "login") {
    if (isset($_SESSION['is_logged']) && isset($_COOKIE['sisteminformasibengkel'])) {
      echo "<script>window.location.href= '".$url."dashboard/';</script>";
      exit();
    }
  } elseif (FIRST_PART == "dashboard") {
    if (!isset($_SESSION['is_logged']) && !isset($_COOKIE['sisteminformasibengkel'])) {
      echo "<script>window.location.href= '".$url."login/';</script>";
      exit();
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= APPNAME ?> | <?= ucwords(FIRST_PART) ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/font-awesome/css/font-awesome.css">
    <!--link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/Ionicons/css/ionicons.css"-->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/AdminLTE.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/animatecss/animate.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/sweetalert2/dist/sweetalert2.css"/>
    <?php if (FIRST_PART == "dashboard") { ?>
      <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css">
      <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/DataTables/dataTables.css">
      <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/DataTables/DataTables-1.10.18/css/dataTables.bootstrap.css">
      <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/DataTables/Scroller-2.0.0/css/scroller.bootstrap.css">
      <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/DataTables/Responsive-2.2.2/css/responsive.bootstrap.css">
      <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/select2/dist/css/select2.css">
      <link rel="stylesheet" href="<?= BASE_URL ?>assets/plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
    <?php } ?>
    <?= FIRST_PART == "home" || FIRST_PART == "dashboard" ? '<link rel="stylesheet" href="'.BASE_URL.'assets/css/skins/skin-red.css">' : '' ?>
    <link rel="icon" href="<?= BASE_URL ?>favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?= BASE_URL ?>favicon.ico" type="image/x-icon"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <meta name="url" content="<?= BASE_URL; ?>">
    <script src="<?= BASE_URL ?>assets/plugins/jquery/dist/jquery.js"></script>
    <script src="<?= BASE_URL ?>assets/plugins/bootstrap/dist/js/bootstrap.js"></script>
    <script src="<?= BASE_URL ?>assets/plugins/sweetalert2/dist/sweetalert2.js"></script>
    <script src="<?= BASE_URL ?>assets/plugins/moment/min/moment-with-locales.js"></script>
    <?php if (FIRST_PART == "dashboard") { 
        if (SECOND_PART == "" && THIRD_PART == "") { ?>
            <script src="<?= BASE_URL ?>assets/js/page/dashboard.js"></script>
        <?php } ?>
        <script src="<?= BASE_URL ?>assets/js/notification.js"></script>
        <script src="<?= BASE_URL ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="<?= BASE_URL ?>assets/plugins/DataTables/dataTables.js"></script>
        <script src="<?= BASE_URL ?>assets/plugins/DataTables/DataTables-1.10.18/js/dataTables.bootstrap.js"></script>
        <script src="<?= BASE_URL ?>assets/plugins/DataTables/Scroller-2.0.0/js/scroller.bootstrap.js"></script>
        <script src="<?= BASE_URL ?>assets/plugins/DataTables/Responsive-2.2.2/js/dataTables.responsive.js"></script>
        <script src="<?= BASE_URL ?>assets/plugins/autoNumeric/autoNumeric.js"></script>
        <script src="<?= BASE_URL ?>assets/plugins/tinymce/jquery.tinymce.min.js"></script>
        <script src="<?= BASE_URL ?>assets/plugins/tinymce/tinymce.min.js"></script>
        <script src="<?= BASE_URL ?>assets/plugins/autoNumeric/autoNumeric.js"></script>
        <script src="<?= BASE_URL ?>assets/plugins/select2/dist/js/select2.js"></script>
        <script src="<?= BASE_URL ?>assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <?php } ?>
    <script src="<?= BASE_URL ?>assets/js/main.js"></script>
    <script src="<?= BASE_URL ?>assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
  </head>
  
  <body class="hold-transition <?= (FIRST_PART == "home") ? 'skin-red layout-top-nav' : ((FIRST_PART == "dashboard") ? 'skin-red sidebar-mini' : 'login-page') ?>">
    <noscript>Situs ini membutuhkan Javascript. Silahkan Aktifkan Javascript untuk melanjutkan. <a href="http://www.enable-javascript.com/id/" target="_blank" class="notjs">Klik disini</a></noscript>
    <div>
      <!--[if lte IE 6]> <div id='badBrowser'>Browser ini tidak mendukung. Silakan gunakan browser seperti <a href="https://www.mozilla.org/id/firefox/fx/" rel="nofollow">Firefox</a>, <a href="https://www.google.com/intl/id/chrome/browser/" rel="nofollow">Chrome</a> atau <a https="http://www.apple.com/safari/" rel="nofollow">Safari</a></div> <![endif]-->
    </div>
    <?= FIRST_PART == "home" || FIRST_PART == "dashboard" ? '<div class="wrapper">' : '' ?>

      <?php if (FIRST_PART == "home") { ?>
        <header class="main-header">
          <nav class="navbar navbar-static-top">
            <div class="container">
              <div class="navbar-header">
                <a href="<?= BASE_URL . 'home/' ?>" class="navbar-brand"><b>SMK</b>BISTEK</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                  <i class="fa fa-bars"></i>
                </button>
              </div>
              <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                  <li class="<?= FIRST_PART == 'home' ? 'active' : '' ?>">
                    <a href="<?= BASE_URL . 'home/' ?>">
                      Home <span class="sr-only">(current)</span>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <?php if (isset($_SESSION['is_logged'])) { ?>
                    <li class="dropdown user user-menu">
                      <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= BASE_URL . '/assets/img/logosma.png'; ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= $_SESSION['name']; ?></span>
                      </a>
                      <ul class="dropdown-menu">
                        <li class="user-body">
                          <a href="<?= BASE_URL.'dashboard' ?>">
                            <i class="fa fa-dashboard text-yellow"></i>
                            <span>Dashboard</span>
                          </a>
                        </li>
                        <li class="user-body">
                          <a href="<?= BASE_URL.'logout' ?>">
                            <i class="fa fa-sign-out text-red"></i>
                            <span>Logout</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                  <?php } else { ?>
                    <li>
                      <a href="<?= BASE_URL . 'login/' ?>">
                        <i class="fa fa-sign-in"></i>
                        <span>Login</span>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </nav>
        </header>
      <?php } elseif (FIRST_PART == "dashboard") { ?>
        <header class="main-header">
          <a href="<?= BASE_URL . 'dashboard/' ?>" class="logo">
            <span class="logo-mini"><b>S</b>MK</span>
            <span class="logo-lg"><b>SMK</b>BISTEK</span>
          </a>
          <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
              <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu" data-remote="<?= base64_encode($enc['data-notifikasi']['remote']) ?>" data-target="<?= base64_encode($enc['data-notifikasi']['sha1'][0]) ?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    <span class="label label-info">0</span>
                  </a>
                  <ul class="dropdown-menu">
                    <li class="header">You haven't notifications</li>
                    <li>
                      <!-- inner menu: contains the actual data -->
                      <ul class="menu"></ul>
                    </li>
                  </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                  <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?= BASE_URL . 'assets/img/logosma.png'; ?>" class="user-image" alt="User Image">
                    <span class="hidden-xs"><?= $_SESSION['name']; ?></span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- Menu Body -->
                    <li class="user-body">
                      <a href="<?= BASE_URL . 'home/' ?>" target="_blank">
                        <i class="fa fa-home text-yellow"></i>
                        <span>Beranda</span>
                      </a>
                    </li>
                    <li class="user-body">
                      <a href="<?= BASE_URL.'dashboard/'.strtolower(str_replace(' ','-',$menu[3])).'/@'.strtolower($_SESSION['username']).'/' ?>">
                        <i class="fa fa-lock text-blue"></i>
                        <span>Password</span>
                      </a>
                    </li>
                    <li class="user-body">
                      <a href="<?= BASE_URL.'logout' ?>">
                        <i class="fa fa-sign-out text-red"></i>
                        <span>Logout</span>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
        </header>
      <?php } ?>
      
      <?php if (FIRST_PART == "dashboard") include_once '../master/navigation.php'; ?>
