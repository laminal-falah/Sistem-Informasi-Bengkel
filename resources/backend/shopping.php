<?php
if (hasPermit($static['data-penjualan']['permissions'][0])) {
    echo tombol_keranjang($static['data-shopping']['box-shop'], $enc['data-shopping']['remote'], $enc['data-shopping']['sha1'][3]);
}
?>
<div class="" id="list_shopping" data-remote="<?= base64_encode($enc['data-shopping']['remote']); ?>" data-target="<?= base64_encode($enc['data-shopping']['sha1'][0]); ?>">
    <div id="items"></div>
    <div class="text-center" id="box-load" style="display: none;" data-target="<?= base64_encode($enc['data-shopping']['sha1'][4]); ?>">
        <button id="loadmore" name="loadmore" type="button" class="btn btn-warning" title="Klik tombol load more untuk menampilkan data selanjutnya">Muat Lebih</button>
    </div>
    <div class="text-center" id="msg-empty" style="display: none;">
        <h3 id="msg-text">Data Kosong !</h3>
    </div>
</div>
<script src="<?= BASE_URL ?>assets/js/page/shopping.js"></script>