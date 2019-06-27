<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <a href="<?= BASE_URL . 'dashboard/' . strtolower(str_replace(' ', '-', $menu[5])) . '/' . strtolower(str_replace(' ', '-', $submenu[8])) . '/'; ?>">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <h4 class="box-title">Keranjang</h4>
            </div>
            <div class="box-body">
                <!-- Form Password -->
                <form class="form-horizontal" method="post" role="form" id="form-checkout" data-target="<?= base64_encode($enc['data-cart']['sha1'][2]) ?>">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nama pembeli</label>
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
                    <table id="table_cart" name="table_cart" class="table table-bordered table-striped table-hover table_cart" data-remote="<?= base64_encode($enc['data-cart']['remote']) ?>" data-target="<?= base64_encode($enc['data-cart']['sha1'][0]) ?>">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="all" id="all"></th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="list_cart"></tbody>
                    </table>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="pull-right">
                                <button type="submit" id="simpan" name="simpan" class="btn btn-primary">
                                    <span class="fa fa-save"></span> &nbsp;Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Form Password -->
            </div>
        </div>
    </div>
</div>
<script src="<?= BASE_URL ?>assets/js/page/cart.js"></script>