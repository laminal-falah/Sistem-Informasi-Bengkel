        <?php if (FIRST_PART == "home") { ?>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="container">
                    <div class="pull-right hidden-xs">
                        <b>Version</b> 1.1.1
                    </div>
                    <strong>Copyright &copy; <label id="year-copy"></label> <a href="https://www.smk-bistek-indosains.sch.id/" target="_blank">SMK BISTEK</a>.</strong> All rights reserved.
                </div>
                <!-- /.container -->
            </footer>
        <?php } else if (FIRST_PART == "dashboard") { include_once '../app/modal.php'; ?>
            <script>
                $(function() {
                    var str = $('span.hidden-xs').html();
                    var res = str.substr(0, 15);
                    $('span.hidden-xs').html(res);
                    var name_account = $('#account').find('p').html();
                    var nm = name_account.substr(0,15);
                    $('#account').find('p').html(nm);
                });
            </script>
            <!-- Main Footer -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.1.1
                </div>
                <strong>Copyright &copy; <label id="year-copy"></label> <a href="https://www.smk-bistek-indosains.sch.id/" target="_blank">SMK BISTEK</a>.</strong> All rights reserved.
            </footer>
        <?php } ?>
    <?= FIRST_PART == "home" || FIRST_PART == "dashboard" ? '</div>' : '' ?>
    <div id="loading" aria-hidden="true" role="dialog"></div>

    <script src="<?= BASE_URL ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="<?= BASE_URL ?>assets/plugins/fastclick/lib/fastclick.js"></script>
    <?= FIRST_PART == "home" || FIRST_PART == "dashboard" ? '<script src="'.BASE_URL.'assets/js/adminlte.js"></script>' : '' ?>
    <?= FIRST_PART == "login" ? '<script src="'.BASE_URL.'assets/js/page/login.js"></script>' : '' ?>
    <?php if (FIRST_PART == "home") { ?> 
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();
                $('#cari[data-toggle="tooltip"]').on('shown.bs.tooltip', function () {
                    $('.tooltip').addClass('animated wobble');
                    trigger: 'manual';
                }).tooltip('show');
                var str = $('span.hidden-xs').html();
                var res = str.substr(0, 15);
                $('span.hidden-xs').html(res);
            });
        </script>
    <?php } ?>
    <?php if (FIRST_PART == "dashboard") { ?>
        <script>
            tinymce.init({
            selector: '.description',
            theme: 'modern',
            width: '100%',
            height: 100,
            toolbar: false,
            menubar: false,
            statusbar: false,
            /* plugins: [
              'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
              'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
              'save table contextmenu directionality emoticons template paste textcolor'
            ], */
            content_css: '<?= BASE_URL ?>assets/plugins/tinymce/skins/lightgray/content.min.css',
            //toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
            });
            function ajaxLoad() {
                var ed = tinyMCE.get('description');

                // Do you ajax call here, window.setTimeout fakes ajax call
                ed.setProgressState(1); // Show progress
                window.setTimeout(function() {
                    ed.setProgressState(0); // Hide progress
                    ed.setContent('HTML content that got passed from server.');
                }, 3000);
            }
            function ajaxSave() {
                var ed = tinyMCE.get('description');

                // Do you ajax call here, window.setTimeout fakes ajax call
                ed.setProgressState(1); // Show progress
                window.setTimeout(function() {
                    ed.setProgressState(0); // Hide progress
                    alert(ed.getContent());
                }, 3000);
            }
        </script>
    <?php } ?>
    <div class="modal fade" id="detailNotif">
        <div class="modal-dialog modal-lg animated zoomIn" style="width: 100% !important; margin: 0px auto !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title text-center">Detail Data <?= $submenu[4] ?></h3>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-hover">
                        <tbody id="detail-notifikasi"></tbody>
                    </table>
                    <table class="table table-bordered table-striped table-hover table_detail_peralatan">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Peralatan</th>
                                <th>Nama Peralatan</th>
                                <th>Jenis Peralatan</th>
                                <th>Jumlah Pinjam</th>
                                <th>Rusak</th>
                                <th>Jumlah</th>
                                <th>Hilang</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody id="detail-peralatan-return"></tbody>
                    </table>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
  </body>
</html>