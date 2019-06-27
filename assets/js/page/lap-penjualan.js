$(function() {

    var remote = $('#table_penjualan').attr('data-remote');
    var target = $('#table_penjualan').attr('data-laporan');

    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        animation: false,
        customClass: {
            popup: 'animated tada'
        },
    });

    function alertSuccess(msg) {
        Toast.fire({
            type: 'success',
            title: msg
        });
    }

    function alertWarning(msg) {
        Toast.fire({
            type: 'warning',
            title: msg
        });
    }

    function alertDanger(msg) {
        Toast.fire({
            type: 'error',
            title: msg
        });
    }

    var dataTable = $("#table_penjualan").DataTable({
        "language": {
            "sEmptyTable":   "Tidak ada data yang tersedia pada tabel ini",
            "sProcessing":   "Sedang memproses...",
            "sLengthMenu":   "Tampilkan _MENU_ entri",
            "sZeroRecords":  "Tidak ditemukan data yang sesuai",
            "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
            "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
            "sInfoPostFix":  "",
            "sSearch":       "Cari:",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "Pertama",
                "sPrevious": "Sebelumnya",
                "sNext":     "Selanjutnya",
                "sLast":     "Terakhir"
            }
        },
        //"scrollY": true,
        "fixedHeader": true,
        "fixedColumns": true,
        //"autoWidth": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: http + 'fetch?f='+remote+'&d='+target,
            type: "POST",
            beforeSend: function () {
                $("#table_penjualan_processing").addClass("text-center").html('<i class="fa fa-spinner fa-pulse fa-fw text-blue"></i>&nbsp;<span>Memuat Data...</span>');
            },
            error: function () {
                $(".table_penjualan-error").html("");
                $("#table_penjualan").append('<tbody class="table_penjualan-error"><tr><td colspan="6" class="text-center">Tidak ada data</td></tr></tbody>');
                $("#table_penjualan_processing").css('display', 'none');
            }
        },
        "pageLength": 10,
        "order": [
            [0,"desc"]
        ],
        columnDefs: [
            {
                orderable: true,
                targets: [0,1,2,3,4]
            },
            {
                orderable: false,
                targets: [5]
            },
            {
                searchable: true,
                targets: [1,2]
            },
            {
                searchable: false,
                targets: [0,3,4,5]
            }
        ],
        "lengthMenu": [ 
            [5, 10, 25, 50, 100, -1], 
            [5, 10, 25, 50, 100, "Semua"]
        ]
    });

    $("#table_penjualan_filter").addClass("pull-right");
    $("#table_penjualan_paginate").addClass("pull-right");
    
    dataTable.on("draw.dt", function () {
        var info = dataTable.page.info();
        dataTable.column(0, {
            search: "applied",
            order: "applied",
            page: "applied"
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + info.start + ".";
        });
    });

    jQuery.noConflict();

    $("#table_penjualan").on('click', '#download', function (e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');

        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + uuid + '&id=' + uid,
            type: 'GET',
            async: true,
            dataType: 'json',
            beforeSend: function () {
                showLoading();
            },
            success: function (res) {
                if (res.length == 0) {
                    hideLoading();
                    alertDanger('Invalid request');
                } else {
                    if (res.penjualan.code == 1) {
                        hideLoading();
                        alertSuccess(res.penjualan.message);
                        let win = window.open();
                        win.location = res.penjualan.url;
                        win.opener = null;
                        win.blur();
                        window.focus();
                    } else {
                        hideLoading();
                        alertWarning(res.penjualan.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });
});