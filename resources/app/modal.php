<?php
if (@$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[0]))) {
    if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[0]))) {
        ?>
            <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[0] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-user" data-target="<?= base64_encode($enc['data-user']['sha1'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">NIP</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nip" name="nip" class="form-control" placeholder="NIP" data-target="<?= base64_encode($enc['data-user']['check'][2]) ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Lengkap</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Lengkap">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Level</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="level" name="level">
                                            <option selected disabled value="">Pilih Level</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_rules");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_rule'] ?>"><?= ucwords(str_replace("_", "\r", $row['name_rule'])) ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Status</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="status" name="status">
                                            <option selected disabled value="">Pilih Status</option>
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Username</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" data-target="<?= base64_encode($enc['data-user']['check'][0]) ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Password</label>
                                    <div class="col-xs-9">
                                        <input type="password" id="password1" name="password" class="form-control" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Konfirmasi Password</label>
                                    <div class="col-xs-9">
                                        <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="Konfirmasi Password">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[0] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-user" data-target="<?= base64_encode($enc['data-user']['sha1'][4]) ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">NIP</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nip" name="nip" class="form-control" placeholder="NIP" data-target="<?= base64_encode($enc['data-user']['check'][3]) ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Lengkap</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Lengkap">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Level</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="level" name="level">
                                            <option selected disabled value="">Pilih Level</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_rules");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_rule'] ?>"><?= ucwords(str_replace("_", "\r", $row['name_rule'])) ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Status</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="status" name="status">
                                            <option selected disabled value="">Pilih Status</option>
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Username</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" data-target="<?= base64_encode($enc['data-user']['check'][1]) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Detail Data <?= $submenu[0] ?></h3>
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
            <div class="modal fade" id="downloadModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Export Data <?= $submenu[0] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="download-user" data-remote="<?= base64_encode($enc['export'][0]) ?>" data-target="<?= base64_encode($enc['export'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <h4 class="pull-right">Jumlah Data : 0 Data.</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Awal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="awal" name="awal" class="form-control" placeholder="1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Akhir</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="akhir" name="akhir" class="form-control" placeholder="100">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Filter</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="filter" name="filter">
                                            <option selected value="">Filter</option>
                                            <option value="1">Harian</option>
                                            <option value="2">Bulanan</option>
                                            <option value="3">Rentang Tanggal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Tanggal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="range" name="range" class="form-control" placeholder="Rentang tanggal" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="download" name="download" class="btn btn-primary">
                                    <span class="fa fa-download"></span> &nbsp;Export
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    } elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[1]))) {
        ?>
            <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[1] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-alat" data-target="<?= base64_encode($enc['data-alat']['sha1'][2]) ?>" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Alat</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Alat">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Stok</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="stok" name="stok" class="form-control auto" placeholder="Stok">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Satuan</label>
                                    <div class="col-xs-9">
                                        <select name="satuan" id="satuan" class="form-control">
                                            <option selected disabled value="">Pilih Satuan</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_unit");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_unit'] ?>"><?= $row['name_unit'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Harga Beli</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="harga_beli" name="harga_beli" class="form-control auto" placeholder="Harga Beli">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Lokasi Alat</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Lokasi Alat">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Kondisi</label>
                                    <div class="col-xs-9">
                                        <select name="kondisi" id="kondisi" class="form-control">
                                            <option selected disabled value="">Pilih Kondisi</option>
                                            <option value="1">Baik</option>
                                            <option value="0">Buruk</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Deskripsi</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control description" id="description" name="description" rows="2" cols="32" resize="none" style="resize: none;" placeholder="Deskripsi"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Gambar Alat</label>
                                    <div class="col-xs-9">
                                        <div class="input-group" id="fupload">
                                            <input type="text" id="img" name="img" class="form-control" placeholder="Pilih Gambar" readonly>
                                            <span class="input-group-btn">
                                                <a id="choose" class="btn btn-success" data-input="img" data-preview="holder">
                                                    <i class="fa fa-picture-o">&nbsp;Pilih Gambar</i>
                                                </a>
                                                <a id="reset" class="btn btn-danger" data-input="img" data-preview="holder">
                                                    <i class="fa fa-refresh">&nbsp;Reset</i>
                                                </a>
                                            </span>
                                            <input type="file" id="gambar" name="gambar" style="display: none;" accept="image/*">
                                        </div>
                                        <br>
                                        <img id="preview" class="img-responsive" src="" alt="Gambar Alat" height="250" width="250" style="display: none;">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[1] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-alat" data-target="<?= base64_encode($enc['data-alat']['sha1'][4]) ?>" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Alat</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Alat">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Stok</label>
                                    <div class="col-xs-4">
                                        <label id="status_stok" class="control-label text-danger">Jumlah stok saat ini : 0 data.</label>
                                        <label class="col-xs-1 control-label text-danger pull-right"><i class="fa fa-plus"></i></label>
                                    </div>
                                    <div class="col-xs-5">
                                        <input type="text" id="stok" name="stok" class="form-control auto" placeholder="Stok">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Satuan</label>
                                    <div class="col-xs-9">
                                        <select name="satuan" id="satuan" class="form-control">
                                            <option selected disabled value="">Pilih Satuan</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_unit");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_unit'] ?>"><?= $row['name_unit'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Harga Beli</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="harga_beli" name="harga_beli" class="form-control auto" placeholder="Harga Beli">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Lokasi Alat</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Lokasi Alat">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Kondisi</label>
                                    <div class="col-xs-9">
                                        <select name="kondisi" id="kondisi" class="form-control">
                                            <option selected disabled value="">Pilih Kondisi</option>
                                            <option value="1">Baik</option>
                                            <option value="0">Buruk</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Deskripsi</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control description" id="description" name="description" rows="2" cols="32" resize="none" style="resize: none;" placeholder="Deskripsi"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Gambar Alat</label>
                                    <div class="col-xs-9">
                                        <div class="input-group" id="fupload">
                                            <input type="text" id="img-edit" name="img" class="form-control" placeholder="Pilih Gambar" readonly>
                                            <span class="input-group-btn">
                                                <a id="choose-edit" class="btn btn-success" data-input="img" data-preview="holder">
                                                    <i class="fa fa-picture-o">&nbsp;Pilih Gambar</i>
                                                </a>
                                            </span>
                                            <input type="file" id="gambar-edit" name="gambar" style="display: none;" accept="image/*">
                                        </div>
                                        <br>
                                        <img id="preview-edit" class="img-responsive" src="" alt="Gambar Alat" height="250" width="250" style="display: none;">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Detail Data <?= $submenu[1] ?></h3>
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
            <div class="modal fade" id="downloadModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Export Data <?= $submenu[1] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="download-alat" data-remote="<?= base64_encode($enc['export'][0]) ?>" data-target="<?= base64_encode($enc['export'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <h4 class="pull-right">Jumlah Data : 0 Data.</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Awal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="awal" name="awal" class="form-control" placeholder="1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Akhir</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="akhir" name="akhir" class="form-control" placeholder="100">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Filter</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="filter" name="filter">
                                            <option selected value="">Filter</option>
                                            <option value="1">Harian</option>
                                            <option value="2">Bulanan</option>
                                            <option value="3">Rentang Tanggal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Tanggal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="range" name="range" class="form-control" placeholder="Rentang tanggal" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="download" name="download" class="btn btn-primary">
                                    <span class="fa fa-download"></span> &nbsp;Export
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="penggunaanModal">
                <div class="modal-dialog animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Penggunaan Data <?= $submenu[1] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="penggunaan-alat" data-target="<?= base64_encode($enc['data-alat']['sha1'][8]) ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody id="penggunaan-table"></tbody>
                                </table>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">Jumlah yang bagus</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="good" name="good" class="form-control auto" placeholder="Jumlah yang bagus" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">Jumlah yang rusak</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="broken" name="broken" class="form-control auto" placeholder="Jumlah yang rusak" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">Jumlah yang hilang</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="lost" name="lost" class="form-control auto" placeholder="Jumlah yang hilang" required>
                                    </div>
                                </div>
                                <label id="error_msg" style="display: none;" class="text-red"></label>
                            </div>
                            <input type="hidden" id="stok_penggunaan" name="stok_penggunaan" value="0">
                            <div class="modal-footer">
                                <button type="submit" id="ubahPenggunaan" name="ubahPenggunaan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    } elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[2]))) {
        ?>
            <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[2] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-sparepart" data-target="<?= base64_encode($enc['data-sparepart']['sha1'][2]) ?>" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Jenis Sparepart</label>
                                    <div class="col-xs-9">
                                        <select name="sparepart" id="sparepart" class="form-control">
                                            <option selected disabled value="">Pilih Sparepart</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_categories WHERE name_category LIKE '%Sparepart%'");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['code_category'] ?>"><?= $row['name_category'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Sparepart</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Sparepart">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Stok</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="stok" name="stok" class="form-control auto" placeholder="Stok">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Satuan</label>
                                    <div class="col-xs-9">
                                        <select name="satuan" id="satuan" class="form-control">
                                            <option selected disabled value="">Pilih Satuan</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_unit");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_unit'] ?>"><?= $row['name_unit'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Harga Beli</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="harga_beli" name="harga_beli" class="form-control auto" placeholder="Harga Beli">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Harga Jual</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="harga_jual" name="harga_jual" class="form-control auto" placeholder="Harga jual">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Lokasi Sparepart</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Lokasi Sparepart">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Kondisi</label>
                                    <div class="col-xs-9">
                                        <select name="kondisi" id="kondisi" class="form-control">
                                            <option selected disabled value="">Pilih Kondisi</option>
                                            <option value="1">Baik</option>
                                            <option value="0">Buruk</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Deskripsi</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control description" id="description" name="description" rows="2" cols="32" resize="none" style="resize: none;" placeholder="Deskripsi"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Gambar Sparepart</label>
                                    <div class="col-xs-9">
                                        <div class="input-group" id="fupload">
                                            <input type="text" id="img" name="img" class="form-control" placeholder="Pilih Gambar" readonly>
                                            <span class="input-group-btn">
                                                <a id="choose" class="btn btn-success" data-input="img" data-preview="holder">
                                                    <i class="fa fa-picture-o">&nbsp;Pilih Gambar</i>
                                                </a>
                                                <a id="reset" class="btn btn-danger" data-input="img" data-preview="holder">
                                                    <i class="fa fa-refresh">&nbsp;Reset</i>
                                                </a>
                                            </span>
                                            <input type="file" id="gambar" name="gambar" style="display: none;" accept="image/*">
                                        </div>
                                        <br>
                                        <img id="preview" class="img-responsive" src="" alt="Gambar Alat" height="250" width="250" style="display: none;">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[2] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-sparepart" data-target="<?= base64_encode($enc['data-sparepart']['sha1'][4]) ?>" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Alat</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Alat">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Stok</label>
                                    <div class="col-xs-4">
                                        <label id="status_stok" class="control-label text-danger">Jumlah stok saat ini : 0 data.</label>
                                        <label class="col-xs-1 control-label text-danger pull-right"><i class="fa fa-plus"></i></label>
                                    </div>
                                    <div class="col-xs-5">
                                        <input type="text" id="stok" name="stok" class="form-control auto" placeholder="Stok">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Satuan</label>
                                    <div class="col-xs-9">
                                        <select name="satuan" id="satuan" class="form-control">
                                            <option selected disabled value="">Pilih Satuan</option>
                                            <?php
                                            $sql = mysqli_query($link, "SELECT * FROM tb_unit");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <option value="<?= $row['id_unit'] ?>"><?= $row['name_unit'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Harga Beli</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="harga_beli_edit" name="harga_beli_edit" class="form-control auto" placeholder="Harga Beli">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Harga Jual</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="harga_jual_edit" name="harga_jual_edit" class="form-control auto" placeholder="Harga jual">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Lokasi Alat</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Lokasi Alat">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Kondisi</label>
                                    <div class="col-xs-9">
                                        <select name="kondisi" id="kondisi" class="form-control">
                                            <option selected disabled value="">Pilih Kondisi</option>
                                            <option value="1">Baik</option>
                                            <option value="0">Buruk</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Deskripsi</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control description" id="description" name="description" rows="2" cols="32" resize="none" style="resize: none;" placeholder="Deskripsi"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Gambar Alat</label>
                                    <div class="col-xs-9">
                                        <div class="input-group" id="fupload">
                                            <input type="text" id="img-edit" name="img" class="form-control" placeholder="Pilih Gambar" readonly>
                                            <span class="input-group-btn">
                                                <a id="choose-edit" class="btn btn-success" data-input="img" data-preview="holder">
                                                    <i class="fa fa-picture-o">&nbsp;Pilih Gambar</i>
                                                </a>
                                            </span>
                                            <input type="file" id="gambar-edit" name="gambar" style="display: none;" accept="image/*">
                                        </div>
                                        <br>
                                        <img id="preview-edit" class="img-responsive" src="" alt="Gambar Alat" height="250" width="250" style="display: none;">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Detail Data <?= $submenu[2] ?></h3>
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
            <div class="modal fade" id="downloadModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Export Data <?= $submenu[2] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="download-sparepart" data-remote="<?= base64_encode($enc['export'][0]) ?>" data-target="<?= base64_encode($enc['export'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <h4 class="pull-right">Jumlah Data : 0 Data.</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Awal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="awal" name="awal" class="form-control" placeholder="1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Akhir</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="akhir" name="akhir" class="form-control" placeholder="100">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Filter</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="filter" name="filter">
                                            <option selected value="">Filter</option>
                                            <option value="1">Harian</option>
                                            <option value="2">Bulanan</option>
                                            <option value="3">Rentang Tanggal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Tanggal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="range" name="range" class="form-control" placeholder="Rentang tanggal" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="download" name="download" class="btn btn-primary">
                                    <span class="fa fa-download"></span> &nbsp;Export
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="penggunaanModal">
                <div class="modal-dialog animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Penggunaan Data <?= $submenu[2] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="penggunaan-sparepart" data-target="<?= base64_encode($enc['data-sparepart']['sha1'][8]) ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody id="penggunaan-table"></tbody>
                                </table>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">Jumlah yang bagus</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="good" name="good" class="form-control auto" placeholder="Jumlah yang bagus" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">Jumlah yang rusak</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="broken" name="broken" class="form-control auto" placeholder="Jumlah yang rusak" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-4 control-label">Jumlah yang hilang</label>
                                    <div class="col-xs-8">
                                        <input type="text" id="lost" name="lost" class="form-control auto" placeholder="Jumlah yang hilang" required>
                                    </div>
                                </div>
                                <label id="error_msg" style="display: none;" class="text-red"></label>
                            </div>
                            <input type="hidden" id="stok_penggunaan" name="stok_penggunaan" value="0">
                            <div class="modal-footer">
                                <button type="submit" id="ubahPenggunaan" name="ubahPenggunaan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    } elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[10]))) {
        ?>
            <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-xs animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[10] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-satuan" data-target="<?= base64_encode($enc['data-satuan']['sha1'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Satuan</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Satuan">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-xs animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[2] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-satuan" data-target="<?= base64_encode($enc['data-satuan']['sha1'][4]) ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Satuan</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Satuan">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    } 
} elseif (@$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[1]))) {
    if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[3]))) {
        ?>
            <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[3] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-peminjaman" data-target="<?= base64_encode($enc['data-peminjaman']['sha1'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Peminjaman</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Peminjaman">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Tanggal Tempo</label>
                                    <div class="col-xs-9">
                                        <input type='text' id="durasi" name="durasi" class="form-control date" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h4 class="col-xs-12 text-center">List Peralatan & Sparepart <small class="text-red"><i>Pilih item yang akan dipinjam dengan checklist</i></small></h4>
                                </div>
                                <table id="table_peralatan" name="table_peralatan" class="table table-bordered table-striped table-hover table_peralatan" data-target="<?= base64_encode($enc['data-peminjaman']['sha1'][1]) ?>">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Peralatan</th>
                                            <th>Jenis</th>
                                            <th>Stok</th>
                                            <th>Pinjam</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_peralatan"></tbody>
                                </table>
                                <div class="text-center" id="box-load" style="display: block;" data-target="<?= base64_encode($enc['data-peminjaman']['sha1'][7]) ?>">
                                    <button id="loadmore" name="loadmore" type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Klik tombol load more untuk menampilkan data selanjutnya">Load more</button>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[3] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-peminjaman" data-target="<?= base64_encode($enc['data-peminjaman']['sha1'][4]) ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Peminjaman</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Peminjaman">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Tanggal Tempo</label>
                                    <div class="col-xs-9">
                                        <input type='text' id="durasi_edit" name="durasi_edit" class="form-control date" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h4 class="col-xs-12 text-center">List Peralatan & Sparepart <small class="text-red"><i>Pilih item yang akan ditambah dengan checklist</i></small></h4>
                                </div>
                                <table id="table_peralatan" name="table_peralatan" class="table table-bordered table-striped table-hover table_peralatan">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Peralatan</th>
                                            <th>Jenis</th>
                                            <th style="width: 10% !important;">Stok</th>
                                            <th style="width: 10% !important;">Dipinjam</th>
                                            <th>Tambah</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_peralatan_edit"></tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Detail Data <?= $submenu[3] ?></h3>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-striped table-hover">
                                <tbody id="detail-peminjam"></tbody>
                            </table>
                            <table class="table table-bordered table-striped table-hover table_detail_peralatan">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Peralatan</th>
                                        <th>Nama Peralatan</th>
                                        <th>Jenis Peralatan</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="detail-peralatan"></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="downloadModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Export Data <?= $submenu[3] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="download-peminjaman" data-remote="<?= base64_encode($enc['export'][0]) ?>" data-target="<?= base64_encode($enc['export'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <h4 class="pull-right">Jumlah Data : 0 Data.</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Awal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="awal" name="awal" class="form-control" placeholder="1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Akhir</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="akhir" name="akhir" class="form-control" placeholder="100">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Filter</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="filter" name="filter">
                                            <option selected value="">Filter</option>
                                            <option value="1">Harian</option>
                                            <option value="2">Bulanan</option>
                                            <option value="3">Rentang Tanggal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Tanggal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="range" name="range" class="form-control" placeholder="Rentang tanggal" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="download" name="download" class="btn btn-primary">
                                    <span class="fa fa-download"></span> &nbsp;Export
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    } elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[4]))) {
        ?>
            <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn" style="width: 100% !important; margin: 0px auto !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[4] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-pengembalian" data-target="<?= base64_encode($enc['data-pengembalian']['sha1'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Kode Peminjaman</label>
                                    <div class="col-xs-9">
                                        <select name="kode" id="kode" class="form-control select2" data-target="<?= base64_encode($enc['data-pengembalian']['sha1'][8]) ?>" data-pinjam="<?= base64_encode($enc['data-pengembalian']['sha1'][7]) ?>" required>
                                            <option selected disabled value="">Pilih Kode Peminjaman</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="box-nama" style="display: none;">
                                    <label class="col-xs-3 control-label">Nama Pengembali</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Pengembali">
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody id="detail-peminjam"></tbody>
                                </table>
                                <table id="table_peralatan" class="table table-bordered table-striped table-hover table_list_pengembalian" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Peralatan</th>
                                            <th>Nama Peralatan</th>
                                            <th>Jenis Peralatan</th>
                                            <th>Jumlah</th>
                                            <th>Rusak</th>
                                            <th>Jumlah</th>
                                            <th>Hilang</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail-peralatan"></tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-danger" id="reset_pengembalian">
                                    <span class="fa fa-refresh"></span> &nbsp;Reset
                                </button>
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn" style="width: 100% !important; margin: 0px auto !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[4] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-pengembalian" data-target="<?= base64_encode($enc['data-pengembalian']['sha1'][4]) ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group" id="box-nama_edit" style="display: none;">
                                    <label class="col-xs-3 control-label">Nama Pengembali</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama_edit" name="nama" class="form-control" placeholder="Nama Pengembali">
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody id="detail-peminjam_edit"></tbody>
                                </table>
                                <table id="table_peralatan" class="table table-bordered table-striped table-hover table_list_pengembalian">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Peralatan</th>
                                            <th>Nama Peralatan</th>
                                            <th>Jenis Peralatan</th>
                                            <th>Jumlah</th>
                                            <th>Rusak</th>
                                            <th>Jumlah</th>
                                            <th>Hilang</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail-peralatan_edit"></tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <!--button type="reset" class="btn btn-danger" id="reset_pengembalian_edit">
                                    <span class="fa fa-refresh"></span> &nbsp;Reset
                                </button-->
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog modal-lg animated zoomIn" style="width: 100% !important; margin: 0px auto !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Detail Data <?= $submenu[4] ?></h3>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-striped table-hover">
                                <tbody id="detail-pengembalian"></tbody>
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
            <div class="modal fade" id="gantiModal">
                <div class="modal-dialog modal-lg animated zoomIn" style="width: 80% !important; margin: 0px auto !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Pergantian Data <?= $submenu[4] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="ganti-pengembalian" data-target="<?= base64_encode($enc['data-pengembalian']['sha1'][10]) ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody id="detail-peminjam_ganti"></tbody>
                                </table>
                                <table id="table_peralatan" class="table table-bordered table-striped table-hover table_list_penggantian">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Peralatan</th>
                                            <th>Nama Peralatan</th>
                                            <th>Jenis Peralatan</th>
                                            <th>Jumlah Dipinjam</th>
                                            <th>Jumlah Rusak</th>
                                            <th>Jumlah Hilang</th>
                                            <th>Checklist</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail-peralatan_ganti"></tbody>
                                </table>
                                <div class="form-group">
                                    <label class="control-label col-xs-10"></label>
                                    <div class="col-xs-2">
                                        <input type="checkbox" name="agree" id="agree" value="0">&nbsp;<label class="control-label text-red">Sudah diganti semua</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="downloadModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Export Data <?= $submenu[4] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="download-pengembalian" data-remote="<?= base64_encode($enc['export'][0]) ?>" data-target="<?= base64_encode($enc['export'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <h4 class="pull-right">Jumlah Data : 0 Data.</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Awal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="awal" name="awal" class="form-control" placeholder="1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Akhir</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="akhir" name="akhir" class="form-control" placeholder="100">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Filter</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="filter" name="filter">
                                            <option selected value="">Filter</option>
                                            <option value="1">Harian</option>
                                            <option value="2">Bulanan</option>
                                            <option value="3">Rentang Tanggal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Tanggal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="range" name="range" class="form-control" placeholder="Rentang tanggal" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="download" name="download" class="btn btn-primary">
                                    <span class="fa fa-download"></span> &nbsp;Export
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    } elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[5]))) {
        ?>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[5] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-penjualan" data-target="<?= base64_encode($enc['data-penjualan']['sha1'][4]) ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Pembeli</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Pembeli">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Status Pembayaran</label>
                                    <div class="col-xs-9">
                                        <select name="status" id="status" class="form-control">
                                            <option selected disabled value="-">Pilih Status Pembayaran</option>
                                            <option value="0">Belum bayar</option>
                                            <option value="1">Sudah bayar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Detail Data <?= $submenu[5] ?></h3>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-striped table-hover">
                                <tbody id="detail-pembeli"></tbody>
                            </table>
                            <table id="table_jual" name="table_jual" class="table table-bordered table-striped table-hover table_jual">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="list_penjualan"></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="downloadModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Export Data <?= $submenu[5] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="download-penjualan" data-remote="<?= base64_encode($enc['export'][0]) ?>" data-target="<?= base64_encode($enc['export'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <h4 class="pull-right">Jumlah Data : 0 Data.</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Awal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="awal" name="awal" class="form-control" placeholder="1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Akhir</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="akhir" name="akhir" class="form-control" placeholder="100">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Filter</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="filter" name="filter">
                                            <option selected value="">Filter</option>
                                            <option value="1">Harian</option>
                                            <option value="2">Bulanan</option>
                                            <option value="3">Rentang Tanggal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Tanggal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="range" name="range" class="form-control" placeholder="Rentang tanggal" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="download" name="download" class="btn btn-primary">
                                    <span class="fa fa-download"></span> &nbsp;Export
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    } elseif ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[6]))) {
        ?>
            <div class="modal fade" id="addModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[6] ?></h3>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#lama" id="lamonyo">Yang sudah ada</a></li>
                            <li><a data-toggle="tab" href="#baru" id="barunyo">Tambah Baru</a></li>
                        </ul>
                        <div class="tab-content">
                            <!-- Yang lama -->
                            <div id="lama" class="tab-pane fade in active">
                                <form class="form-horizontal" method="POST" role="form" id="add-lama" data-target="<?= base64_encode($enc['data-pembelian']['sha1'][2]) ?>">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Nama Item</label>
                                            <div class="col-xs-9">
                                                <select name="item" id="item" class="form-control select2" data-target="<?= base64_encode($enc['data-pembelian']['sha1'][8]) ?>">
                                                    <option selected disabled value="">Pilih Kode Peminjaman</option>
                                                </select>
                                            </div>
                                        </div>
                                        <table id="table_list_item" class="table table-bordered table-striped table-hover table_list_item" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Item</th>
                                                    <th>Jenis Item</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga Beli</th>
                                                    <th>Harga Jual</th>
                                                </tr>
                                            </thead>
                                            <tbody id="list_item"></tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="simpanLama" name="simpanLama" class="btn btn-primary">
                                            <span class="fa fa-save"></span> &nbsp;Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- Yang baru -->
                            <div id="baru" class="tab-pane fade" data-target="<?= base64_encode($enc['data-pembelian']['sha1'][7]) ?>">
                                <form class="form-horizontal" method="POST" role="form" id="add-baru" data-target="<?= base64_encode($enc['data-pembelian']['sha1'][2]) ?>">
                                    <div class="modal-body">
                                        <h4>Data ke 1</h4>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Kategori</label>
                                            <div class="col-xs-9">
                                                <select name="kategori[]" id="kategori" class="form-control select2"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Nama Item</label>
                                            <div class="col-xs-9">
                                                <input type="text" id="nama" name="nama[]" class="form-control" placeholder="Nama Item">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Stok</label>
                                            <div class="col-xs-9">
                                                <input type="text" id="stok" name="stok[]" class="form-control auto" placeholder="Stok">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Satuan</label>
                                            <div class="col-xs-9">
                                                <select name="satuan[]" id="satuan" class="form-control"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Harga Beli</label>
                                            <div class="col-xs-9">
                                                <input type="text" id="harga_beli" name="harga_beli[]" class="form-control auto" placeholder="Harga Beli">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-3 control-label">Harga Jual</label>
                                            <div class="col-xs-9">
                                                <input type="text" id="harga_jual" name="harga_jual[]" class="form-control auto" placeholder="Harga jual">
                                            </div>
                                        </div>
                                        <div id="insert-form"></div>
                                        <div class="form-group">
                                            <div class="col-xs-9">
                                                <a id="tambah" name="tambah" class="btn btn-default">
                                                    <i class="fa fa-plus"></i>
                                                    <span>Tambah Data</span>
                                                </a>
                                            </div>
                                        </div>
                                        <input type="hidden" id="jumlah-form" value="1">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="simpanBaru" name="simpanBaru" class="btn btn-primary">
                                            <span class="fa fa-save"></span> &nbsp;Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Detail Data <?= $submenu[6] ?></h3>
                        </div>
                        <div class="modal-body">
                            <h4 id="kodenya"></h4>
                            <h5 id="tglnya"></h5>
                            <table id="table_list_item" class="table table-bordered table-striped table-hover table_list_item">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Item</th>
                                        <th>Jenis Item</th>
                                        <th>Jumlah</th>
                                        <th>Harga Beli</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="list_item"></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="downloadModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Export Data <?= $submenu[6] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="download-pembelian" data-remote="<?= base64_encode($enc['export'][0]) ?>" data-target="<?= base64_encode($enc['export'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <h4 class="pull-right">Jumlah Data : 0 Data.</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Awal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="awal" name="awal" class="form-control" placeholder="1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Akhir</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="akhir" name="akhir" class="form-control" placeholder="100">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Filter</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="filter" name="filter">
                                            <option selected value="">Filter</option>
                                            <option value="1">Harian</option>
                                            <option value="2">Bulanan</option>
                                            <option value="3">Rentang Tanggal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Tanggal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="range" name="range" class="form-control" placeholder="Rentang tanggal" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="download" name="download" class="btn btn-primary">
                                    <span class="fa fa-download"></span> &nbsp;Export
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    }
} elseif (@$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[5]))) {
    if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[8]))) {
        ?>
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah ke keranjang</h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="add-cart" data-target="<?= base64_encode($enc['data-shopping']['sha1'][2]) ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody id="detail-table"></tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Masukkan ke keranjang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    }
} elseif (@$_REQUEST['menu'] == strtolower(str_replace(' ', '-', $menu[2]))) {
    if ($_REQUEST['submenu'] == strtolower(str_replace(' ', '-', $submenu[7]))) {
        ?>
            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Tambah Data <?= $submenu[7] ?></h3>
                        </div>
                        <form class="form-horizontal" method="POST" role="form" id="add-pengadaan" data-target="<?= base64_encode($enc['data-pengadaan']['sha1'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Nama Item</label>
                                    <div class="col-xs-9">
                                        <select name="item" id="item" class="form-control select2" data-target="<?= base64_encode($enc['data-pengadaan']['sha1'][7]) ?>"></select>
                                    </div>
                                </div>
                                <table id="table_list_item" class="table table-bordered table-striped table-hover table_list_item" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Item</th>
                                            <th>Jenis Item</th>
                                            <th>Jumlah</th>
                                            <th>Harga Beli</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_item"></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" style="text-align: right !important;">Total</th>
                                            <th id="totalnyo" style="text-align: center !important;">Rp. 0</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div id="codeItemnyo"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="simpanLama" name="simpanLama" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Edit Data <?= $submenu[7] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="edit-pengadaan" data-target="<?= base64_encode($enc['data-pengadaan']['sha1'][4]) ?>">
                            <input type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Level</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="status" name="status">
                                            <option selected disabled value="">Pilih Status Pengadaan</option>
                                            <option value="0">Sedang diproses</option>
                                            <option value="1">Sudah diterima</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="ubah" name="ubah" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Ubah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Detail Data <?= $submenu[7] ?></h3>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-striped table-hover">
                                <tbody id="detail-pengadaan"></tbody>
                            </table>
                            <table id="table_list_item" class="table table-bordered table-striped table-hover table_list_item">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Item</th>
                                        <th>Jenis Item</th>
                                        <th>Jumlah</th>
                                        <th>Harga Beli</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="list_item_detail"></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="downloadModal">
                <div class="modal-dialog modal-lg animated zoomIn">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Export Data <?= $submenu[7] ?></h3>
                        </div>
                        <form class="form-horizontal" method="post" role="form" id="download-pengadaan" data-remote="<?= base64_encode($enc['export'][0]) ?>" data-target="<?= base64_encode($enc['export'][2]) ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <h4 class="pull-right">Jumlah Data : 0 Data.</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Awal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="awal" name="awal" class="form-control" placeholder="1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Jumlah Akhir</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="akhir" name="akhir" class="form-control" placeholder="100">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Filter</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="filter" name="filter">
                                            <option selected value="">Filter</option>
                                            <option value="1">Harian</option>
                                            <option value="2">Bulanan</option>
                                            <option value="3">Rentang Tanggal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">Rentang Tanggal</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="range" name="range" class="form-control" placeholder="Rentang tanggal" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="download" name="download" class="btn btn-primary">
                                    <span class="fa fa-download"></span> &nbsp;Export
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    }
}
