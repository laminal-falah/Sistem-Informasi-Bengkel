<?php include_once '../master/header.php'; ?>
<!-- Full Width Column -->
<div class="content-wrapper">
    <div class="container">
        <!-- Main content -->
        <section class="content">
            <div class="box box-solid">
                <div id="carousel-example-generic" class="carousel slide hidden-xs" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="<?= BASE_URL . 'assets/img/slider/gb4.jpg' ?>" alt="First slide">
                            <div class="carousel-caption"></div>
                        </div>
                        <div class="item">
                            <img src="<?= BASE_URL . 'assets/img/slider/gb1.jpg' ?>" alt="Second slide">
                            <div class="carousel-caption"></div>
                        </div>
                        <div class="item">
                            <img src="<?= BASE_URL . 'assets/img/slider/2.jpg' ?>" alt="Third slide">
                            <div class="carousel-caption"></div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                        <span class="fa fa-angle-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                        <span class="fa fa-angle-right"></span>
                    </a>
                </div>
            </div>
            <div class="callout callout-info">
                <h4 class="text-center">Selamat Datang Di Aplikasi Pengolahan Data Alat dan Sparepart SMK Teknologi BISTEK Palembang</h4>
            </div>
            <div class="box box-info">
                <div class="box-body">
                    <div class="col-md-12 col-xs-12">
                        <div class="pull-right">
                            <form method="POST" id="form-cari" class="form-inline" data-remote="<?= base64_encode($enc['data-shopping']['remote'])?>" data-target="<?= base64_encode($enc['data-shopping']['sha1'][3])?>">
                                <div class="input-group">
                                    <input type="text" id="cari" name="cari" class="form-control" placeholder="Cari" title="Masukkan nama sparepart yang ingin dibeli" required>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Items -->
            <div id="list_shopping" data-remote="<?= base64_encode($enc['data-shopping']['remote']); ?>" data-target="<?= base64_encode($enc['data-shopping']['sha1'][0]); ?>">
                <div id="items"></div>
                <div class="text-center" id="box-load" style="display: none;" data-target="<?= base64_encode($enc['data-shopping']['sha1'][4]); ?>">
                    <button id="loadmore" name="loadmore" type="button" class="btn btn-warning" title="Klik tombol load more untuk menampilkan data selanjutnya">Muat Lebih</button>
                </div>
                <div class="text-center" id="msg-empty" style="display: none;">
                    <h3 id="msg-text">Data Kosong !</h3>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>
<script src="<?=BASE_URL?>assets/js/page/home.js"></script>
<div class="modal fade" id="detailModal">
    <div class="modal-dialog animated zoomIn">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title text-center">Detail Data Peralatan</h3>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover">
                    <tbody id="detail-table"></tbody>
                </table>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<?php include_once '../master/footer.php'; ?>