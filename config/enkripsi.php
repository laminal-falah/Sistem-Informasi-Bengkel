<?php
return $enc = array(
    'home' => array(
        'remote' => 'cari-home',
        'sha1' => array(
            'search_home',
            'detail_home',
        )
    ),
    'export' => array(
        sha1('download'), 
        sha1('pdf'),
        sha1('download_laporan'),
    ),
    'data-user' => array(
        'remote' => sha1('table-user'),
        'download' => sha1('download_user'),
        'check' => array(
            sha1('check_user'),
            sha1('check_user_edit'),
            sha1('check_nip'),
            sha1('check_nip_edit')
        ),
        'sha1' => array(
            sha1('read_user'),
            sha1('create_user'),
            sha1('store_user'),
            sha1('edit_user'),
            sha1('update_user'),
            sha1('show_user'),
            sha1('destroy_user'),
            sha1('reset_password')
        )
    ),
    'data-alat' => array(
        'remote' => sha1('table-alat'),
        'download' => sha1('download_alat'),
        'sha1' => array(
            sha1('read_alat'),
            sha1('create_alat'),
            sha1('store_alat'),
            sha1('edit_alat'),
            sha1('update_alat'),
            sha1('show_alat'),
            sha1('destroy_alat'),
            sha1('penggunaan_alat'),
            sha1('save_penggunaan')
        )
    ),
    'data-sparepart' => array(
        'remote' => sha1('table-sparepart'),
        'download' => sha1('download_sparepart'),
        'sha1' => array(
            sha1('read_sparepart'),
            sha1('create_sparepart'),
            sha1('store_sparepart'),
            sha1('edit_sparepart'),
            sha1('update_sparepart'),
            sha1('show_sparepart'),
            sha1('destroy_sparepart'),
            sha1('penggunaan_sparepart'),
            sha1('save_penggunaan')
        )
    ),
    'data-satuan' => array(
        'remote' => sha1('table-satuan'),
        'sha1' => array(
            sha1('read_satuan'),
            sha1('create_satuan'),
            sha1('store_satuan'),
            sha1('edit_satuan'),
            sha1('update_satuan'),
            sha1('show_satuan'),
            sha1('destroy_satuan'),
        )
    ),
    'data-peminjaman' => array(
        'remote' => sha1('table-peminjaman'),
        'download' => sha1('download_peminjaman'),
        'laporan' => sha1('lapoaran_penjualan'),
        'unduh' => sha1('unduh_peminjaman_1'),
        'sha1' => array(
            sha1('read_peminjaman'),
            sha1('create_peminjaman'),
            sha1('store_peminjaman'),
            sha1('edit_peminjaman'),
            sha1('update_peminjaman'),
            sha1('show_peminjaman'),
            sha1('destroy_peminjaman'),
            sha1('load_peminjaman'),
        )
    ),
    'data-pengembalian' => array(
        'remote' => sha1('table-pengembalian'),
        'download' => sha1('download_pengembalian'),
        'laporan' => sha1('lapoaran_penjualan'),
        'unduh' => sha1('unduh_pengembalian_1'),
        'sha1' => array(
            sha1('read_pengembalian'),
            sha1('create_pengembalian'),
            sha1('store_pengembalian'),
            sha1('edit_pengembalian'),
            sha1('update_pengembalian'),
            sha1('show_pengembalian'),
            sha1('destroy_pengembalian'),
            sha1('load_balekke'),
            sha1('load_kodenyo'),
            sha1('ganti_kembalinyo'),
            sha1('form_ganti')
        )
    ),
    'data-penjualan' => array(
        'remote' => sha1('table-penjualan'),
        'download' => sha1('download_penjualan'),
        'laporan' => sha1('lapoaran_penjualan'),
        'unduh' => sha1('unduh_penjualan_1'),
        'sha1' => array(
            sha1('read_penjualan'),
            sha1('create_penjualan'),
            sha1('store_penjualan'),
            sha1('edit_penjualan'),
            sha1('update_penjualan'),
            sha1('show_penjualan'),
            sha1('destroy_penjualan'),
        )
    ),
    'data-shopping' => array(
        'remote' => sha1('table-shopping'),
        'sha1' => array(
            sha1('read_shopping'),
            sha1('detail_shopping'),
            sha1('add_cart'),
            sha1('search_shopping'),
            sha1('more_shopping'),
        )
    ),
    'data-cart' => array(
        'remote' => sha1('table-cart'),
        'sha1' => array(
            sha1('read_cart'),
            sha1('change_amount'),
            sha1('checkout'),
            sha1('detail_cart'),
            sha1('destroy_cart')
        )
    ),
    'data-pembelian' => array(
        'remote' => sha1('table-pembelian'),
        'download' => sha1('download_pembelian'),
        'laporan' => sha1('laporan_pembelian'),
        'unduh' => sha1('unduh_pembelian_1'),
        'sha1' => array(
            sha1('read_pembelian'),
            sha1('create_pembelian'),
            sha1('store_pembelian'),
            sha1('edit_pembelian'),
            sha1('update_pembelian'),
            sha1('show_pembelian'),
            sha1('destroy_pembelian'),
            sha1('load_selected'),
            sha1('load_items'),
        )
    ),
    'data-password' => array(
        'remote' => sha1('form_password'),
        'sha1' => array(
            sha1('ubah_password'),
            sha1('check_password')
        )
    ),
    'data-pengadaan' => array(
        'remote' => sha1('table-pengadaan'),
        'download' => sha1('download_pengadaan'),
        'laporan' => sha1('laporan_pengadaan'),
        'unduh' => sha1('unduh_pengadaan_1'),
        'sha1' => array(
            sha1('read_pengadaan'),
            sha1('create_pengadaan'),
            sha1('store_pengadaan'),
            sha1('edit_pengadaan'),
            sha1('update_pengadaan'),
            sha1('show_pengadaan'),
            sha1('destroy_pengadaan'),
            sha1('load_pengadaan')
        )
    ),
    'data-notifikasi' => array(
        'remote' => sha1('list-notifikasi'),
        'sha1' => array(
            sha1('read_notifikasi'),
            sha1('detail_notifikasi')
        )
    )
);