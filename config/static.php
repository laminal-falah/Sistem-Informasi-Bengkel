<?php

return $static = array(
    'data-user' => array(
        'permissions' => array(
            'create_user',
            'search_user'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_user',
                'name' => 'create_user',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data User',
                'data-target' => base64_encode($enc['data-user']['sha1'][1])
            ),
            'box-download' => array(
                'id' => 'download_user',
                'name' => 'download_user',
                'class' => 'btn btn-default btn-sm',
                'title' => 'Export ke *.pdf',
                'data-remote' => base64_encode($enc['export'][0]),
                'data-target' => base64_encode($enc['export'][1])
            )
        ),
        'table' => array(
            'id' => 'table_user',
            'name' => 'table_user',
            'class' => 'table table-bordered table-striped table-hover table_user',
            'data-remote' => base64_encode($enc['data-user']['remote']),
            'data-target' => base64_encode($enc['data-user']['sha1'][0]),
            'field' => array('No.','NIP','Nama','Nama Pengguna','Level','Status','Aksi')
        ),
    ),
    'data-alat' => array(
        'permissions' => array(
            'create_tool',
            'search_alat'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_alat',
                'name' => 'create_alat',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Alat',
                'data-target' => base64_encode($enc['data-alat']['sha1'][1])
            ),
            'box-download' => array(
                'id' => 'download_alat',
                'name' => 'download_alat',
                'class' => 'btn btn-default btn-sm',
                'title' => 'Export ke *.pdf',
                'data-remote' => base64_encode($enc['export'][0]),
                'data-target' => base64_encode($enc['export'][1])
            )
        ),
        'table' => array(
            'id' => 'table_alat',
            'name' => 'table_alat',
            'class' => 'table table-bordered table-striped table-hover table_alat',
            'data-remote' => base64_encode($enc['data-alat']['remote']),
            'data-target' => base64_encode($enc['data-alat']['sha1'][0]),
            'field' => array('No.','Kode Alat','Nama Alat','Stok','Kondisi','Aksi')
        )
    ),
    'data-sparepart' => array(
        'permissions' => array(
            'create_sparepart',
            'search_sparepart'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_sparepart',
                'name' => 'create_sparepart',
                'class' => 'btn btn-primary',
                'title' => 'Tambah Data Sparepart',
                'data-target' => base64_encode($enc['data-sparepart']['sha1'][1])
            ),
            'box-download' => array(
                'id' => 'download_sparepart',
                'name' => 'download_sparepart',
                'class' => 'btn btn-default btn-sm',
                'title' => 'Export ke *.pdf',
                'data-remote' => base64_encode($enc['export'][0]),
                'data-target' => base64_encode($enc['export'][1])
            )
        ),
        'table' => array(
            'id' => 'table_sparepart',
            'name' => 'table_sparepart',
            'class' => 'table table-bordered table-striped table-hover table_sparepart',
            'data-remote' => base64_encode($enc['data-sparepart']['remote']),
            'data-target' => base64_encode($enc['data-sparepart']['sha1'][0]),
            'field' => array('No.','Kode Sparepart','Nama Sparepart','Stok','Kondisi','Aksi')
        )
    ),
    'data-satuan' => array(
        'permissions' => array(
            'create_user',
            'search_user'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_satuan',
                'name' => 'create_satuan',
                'class' => 'btn btn-primary',
                'title' => 'Tambah Data Satuan',
                'data-target' => base64_encode($enc['data-satuan']['sha1'][1])
            ),
        ),
        'table' => array(
            'id' => 'table_satuan',
            'name' => 'table_satuan',
            'class' => 'table table-bordered table-striped table-hover table_satuan',
            'data-remote' => base64_encode($enc['data-satuan']['remote']),
            'data-target' => base64_encode($enc['data-satuan']['sha1'][0]),
            'field' => array('No.','Nama Satuan','Aksi')
        )
    ),
    'data-peminjaman' => array(
        'permissions' => array(
            'create_loaning',
            'search_alat'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_peminjaman',
                'name' => 'create_peminjaman',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Peminjaman',
                'data-target' => base64_encode($enc['data-peminjaman']['sha1'][1])
            ),
            'box-download' => array(
                'id' => 'download_peminjaman',
                'name' => 'download_peminjaman',
                'class' => 'btn btn-default btn-sm',
                'title' => 'Export ke *.pdf',
                'data-remote' => base64_encode($enc['export'][0]),
                'data-target' => base64_encode($enc['export'][1])
            )
        ),
        'table' => array(
            'id' => 'table_peminjaman',
            'name' => 'table_peminjaman',
            'class' => 'table table-bordered table-striped table-hover table_peminjaman',
            'data-remote' => base64_encode($enc['data-peminjaman']['remote']),
            'data-target' => base64_encode($enc['data-peminjaman']['sha1'][0]),
            'data-laporan' => base64_encode($enc['data-peminjaman']['laporan']),
            'field' => array('No.','Kode Peminjaman','Nama Peminjam','Tanggal Pinjam','Jatuh Tempo','Status','Aksi')
        )
    ),
    'data-pengembalian' => array(
        'permissions' => array(
            'create_returning',
            'search_alat'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_pengembalian',
                'name' => 'create_pengembalian',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Pengembalian',
                'data-target' => base64_encode($enc['data-pengembalian']['sha1'][1])
            ),
            'box-download' => array(
                'id' => 'download_pengembalian',
                'name' => 'download_pengembalian',
                'class' => 'btn btn-default btn-sm',
                'title' => 'Export ke *.pdf',
                'data-remote' => base64_encode($enc['export'][0]),
                'data-target' => base64_encode($enc['export'][1])
            )
        ),
        'table' => array(
            'id' => 'table_pengembalian',
            'name' => 'table_pengembalian',
            'class' => 'table table-bordered table-striped table-hover table_pengembalian',
            'data-remote' => base64_encode($enc['data-pengembalian']['remote']),
            'data-target' => base64_encode($enc['data-pengembalian']['sha1'][0]),
            'data-laporan' => base64_encode($enc['data-pengembalian']['laporan']),
            'field' => array('No.','Kode Pengembalian','Kode Peminjaman','Nama Pengembalian','Tanggal Kembali','Ketepatan','Aksi')
        )
    ),
    'data-penjualan' => array(
        'permissions' => array(
            'create_selling',
            'search_alat'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_penjualan',
                'name' => 'create_penjualan',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Penjualan',
                'data-target' => base64_encode($enc['data-penjualan']['sha1'][1])
            ),
            'box-download' => array(
                'id' => 'download_penjualan',
                'name' => 'download_penjualan',
                'class' => 'btn btn-default btn-sm',
                'title' => 'Export ke *.pdf',
                'data-remote' => base64_encode($enc['export'][0]),
                'data-target' => base64_encode($enc['export'][1])
            )
        ),
        'table' => array(
            'id' => 'table_penjualan',
            'name' => 'table_penjualan',
            'class' => 'table table-bordered table-striped table-hover table_penjualan',
            'data-remote' => base64_encode($enc['data-penjualan']['remote']),
            'data-target' => base64_encode($enc['data-penjualan']['sha1'][0]),
            'data-laporan' => base64_encode($enc['data-penjualan']['laporan']),
            'field' => array('No.','Kode Penjualan','Nama Pembeli','Total','Status','Aksi')
        )
    ),
    'data-pembelian' => array(
        'permissions' => array(
            'create_buying',
            'search_alat'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_pembelian',
                'name' => 'create_pembelian',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Pembelian',
                'data-target' => base64_encode($enc['data-pembelian']['sha1'][1])
            ),
            'box-download' => array(
                'id' => 'download_pembelian',
                'name' => 'download_pembelian',
                'class' => 'btn btn-default btn-sm',
                'title' => 'Export ke *.pdf',
                'data-remote' => base64_encode($enc['export'][0]),
                'data-target' => base64_encode($enc['export'][1])
            )
        ),
        'table' => array(
            'id' => 'table_pembelian',
            'name' => 'table_pembelian',
            'class' => 'table table-bordered table-striped table-hover table_pembelian',
            'data-remote' => base64_encode($enc['data-pembelian']['remote']),
            'data-target' => base64_encode($enc['data-pembelian']['sha1'][0]),
            'data-laporan' => base64_encode($enc['data-pembelian']['laporan']),
            'field' => array('No.','Kode Pembelian','Total','Aksi')
        )
    ),
    'data-shopping' => array(
        'box-shop' => array(
            'id' => 'cart',
            'name' => 'cart',
            'class' => 'btn btn-primary btn-sm',
            'title' => 'Keranjang (0)',
            'data-target' => base64_encode($enc['data-cart']['sha1'][0])
        )
    ),
    'data-pengadaan' => array(
        'permissions' => array(
            'create_pengadaan',
            'search_pengadaan'
        ),
        'box-create' => array(
            'box-add' => array(
                'id' => 'create_pengadaan',
                'name' => 'create_pengadaan',
                'class' => 'btn btn-primary btn-sm',
                'title' => 'Tambah Data Pengadaan',
                'data-target' => base64_encode($enc['data-pengadaan']['sha1'][1])
            ),
            'box-download' => array(
                'id' => 'download_pengadaan',
                'name' => 'download_pengadaan',
                'class' => 'btn btn-default btn-sm',
                'title' => 'Export ke *.pdf',
                'data-remote' => base64_encode($enc['export'][0]),
                'data-target' => base64_encode($enc['export'][1])
            )
        ),
        'table' => array(
            'id' => 'table_pengadaan',
            'name' => 'table_pengadaan',
            'class' => 'table table-bordered table-striped table-hover table_pengadaan',
            'data-remote' => base64_encode($enc['data-pengadaan']['remote']),
            'data-target' => base64_encode($enc['data-pengadaan']['sha1'][0]),
            'data-laporan' => base64_encode($enc['data-pengadaan']['laporan']),
            'field' => array('No.','Kode Pengadaan','Status','Total','Aksi')
        )
    ), 
);