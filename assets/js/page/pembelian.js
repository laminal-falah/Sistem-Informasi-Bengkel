$(function () {

    moment.locale("id");
    var remote = $('#table_pembelian').attr('data-remote');
    var target = $('#table_pembelian').attr('data-target');
    var start = moment().subtract(29, 'days');
    var end = moment();

    $('.modal-content').css('border-radius', '10px');

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

    function ajaxSuccess(id) {
        $(id)[0].reset();
        $(id).find('.form-group').removeClass('has-success');
        $('[data-dismiss=modal]').click();
        $('#reset').click();
    }

    function formatAngka(angka) {
        if (typeof (angka) != 'string') angka = angka.toString();
        var reg = new RegExp('([0-9]+)([0-9]{3})');
        while (reg.test(angka)) angka = angka.replace(reg, '$1.$2');
        return angka;
    }

    $('.auto').autoNumeric('init', {
        aSep: '.',
        aDec: ',',
        vMin: '0',
        vMax: '9999999999'
    });

    $.validator.addMethod("hurufbae", function (value, element) {
        return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
    });
    $.validator.addMethod("angkonyo", function (value, element) {
        return this.optional(element) || /^[0-9.,]*$/.test(value);
    });
    $.validator.addMethod("untung", function (value, element, params) {
        return this.optional(element) || (parseInt(value.replace(/[.]/g, '')) < parseInt($(params).val().replace(/[.]/g, ''))) ? false : true;
    });

    // Hide modal & reset form
    $('[data-dismiss=modal]').on('click', function (e) {
        var $t = $(this), target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];
        $(target).find('.form-group').attr('class', 'form-group');
        $(target).find('label.has-error').remove();
        $(target)
            .find("input,textarea,select").val('').end()
            .find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
        $(target).find('#preview').attr({ src: '', style: 'display: none' });
        closeModal();
    });

    // Animation modal bootstrap + library Animate.css
    function closeModal() {
        var timeoutHandler = null;
        $('#addModal,#editModal,#detailModal,#downloadModal').on('hide.bs.modal', function () {
            var anim = $('.modal-dialog').removeClass('zoomIn').addClass('zoomOut');
            if (timeoutHandler) clearTimeout(timeoutHandler);
            timeoutHandler = setTimeout(function () {
                $('.modal-dialog').removeClass('zoomOut').addClass('zoomIn');
            }, 750); // some delay for complete Animation
        });
        $('tbody#list_item').empty();
        $('#insert-form').empty();
        $('#jumlah-form').val(1);
    }

    // Validation pembelian Start // 
    $('#download-pembelian').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
            awal: {
                required: true,
                digits: true,
            },
            akhir: {
                required: true,
                digits: true,
            },
            filter: {
                required: false
            },
            range: {
                required: false
            }
        },
        messages: {
            awal: {
                required: "Field harus diisi ! Minimal 1",
                digits: "Field tidak boleh mengandung karakter selain angka !"
            },
            akhir: {
                required: "Field harus diisi ! Maksimal 100",
                digits: "Field tidak boleh mengandung karakter selain angka !"
            }
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("help-block");
            element.parents(".col-xs-9").addClass("has-feedback");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
            if (!element.next("span")[0]) {
                $("<span class='glyphicon glyphicon-remove form-control-feedback'></span>").insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(errorClass).removeClass(validClass);
            $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(validClass).removeClass(errorClass);
            $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
        },
        submitHandler: function (form) {
            var page = $('#download-pembelian').attr('data-remote');
            var uuid = $('#download-pembelian').attr('data-target');
            var pdf = new FormData($('#download-pembelian')[0]);
            var uid = "pembelian";
            $.ajax({
                url: http + 'fetch?f=' + page + '&d=' + uuid + '&id=' + uid,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: pdf,
                beforeSend: function () {
                    showLoading();
                },
                success: function (res) {
                    if (res.length == "") {
                        alertDanger('Invalid request');
                    } else {
                        if (res.download.code == 1) {
                            hideLoading();
                            ajaxSuccess('#download-pembelian');
                            alertSuccess('Tunggu Sebentar ... ');
                            //window.open(res.download.url);
                            let win = window.open();
                            win.location = res.download.url;
                            win.opener = null;
                            win.blur();
                            window.focus();
                        } else {
                            hideLoading();
                            alertWarning(res.download.message);
                        }
                    }
                },
                error: function (jqXHR, status, error) {
                    hideLoading();
                    alertDanger(status);
                }
            });
            return false;
        }
    });
    // Validation pembelian End //

    var dataTable = $("#table_pembelian").DataTable({
        "language": {
            "sEmptyTable": "Tidak ada data yang tersedia pada tabel ini",
            "sProcessing": "Sedang memproses...",
            "sLengthMenu": "Tampilkan _MENU_ entri",
            "sZeroRecords": "Tidak ditemukan data yang sesuai",
            "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
            "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
            "sInfoPostFix": "",
            "sSearch": "Cari:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Pertama",
                "sPrevious": "Sebelumnya",
                "sNext": "Selanjutnya",
                "sLast": "Terakhir"
            }
        },
        //"scrollY": true,
        "fixedHeader": true,
        "fixedColumns": true,
        //"autoWidth": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: http + 'fetch?f=' + remote + '&d=' + target,
            type: "POST",
            beforeSend: function () {
                $("#table_pembelian_processing").addClass("text-center").html('<i class="fa fa-spinner fa-pulse fa-fw text-blue"></i>&nbsp;<span>Memuat Data...</span>');
            },
            error: function () {
                $(".table_pembelian-error").html("");
                $("#table_pembelian").append('<tbody class="table_pembelian-error"><tr><td colspan="6" class="text-center">Tidak ada data</td></tr></tbody>');
                $("#table_pembelian_processing").css('display', 'none');
            }
        },
        "pageLength": 10,
        "order": [
            [0, "desc"]
        ],
        columnDefs: [
            {
                orderable: true,
                targets: [0, 1, 2]
            },
            {
                orderable: false,
                targets: [3]
            },
            {
                searchable: true,
                targets: [1]
            },
            {
                searchable: false,
                targets: [0, 2, 3]
            }
        ],
        "lengthMenu": [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Semua"]
        ]
    });

    $("#table_pembelian_filter").addClass("pull-right");
    $("#table_pembelian_paginate").addClass("pull-right");

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

    var targetKode = $('#item').attr('data-target');

    $('#item').select2({
        minimumInputLength: 3,
        allowClear: true,
        placeholder: 'Cari Kode atau Nama alat & sparepart',
        width: '100%',
        ajax: {
            url: http + 'fetch?f=' + remote + '&d=' + targetKode,
            type: 'GET',
            async: true,
            dataType: 'json',
            delay: 800,
            data: function (params) {
                return {
                    q: params.term
                }
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            },
        }
    }).on('select2:select', function (evt) {
        var data = $(".select2 option:selected").val();
        loadlamo(data);
    });

    function loadlamo(kodenyo) {
        var body = $('tbody#list_item');
        let no = parseInt($('#list_item').children().length) + 1;
        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + targetKode + '&c=' + kodenyo,
            type: 'GET',
            async: true,
            dataType: 'json',
            beforeSend: function () {
                //body.empty();
                showLoading();
            },
            success: function (res) {
                if (res.length == 0) {
                    hideLoading();
                    alertDanger('Invalid request');
                } else {
                    if (res.pembelian.code == 1) {
                        $('#table_list_item').css('display', 'block');
                        let name = res.pembelian.data.name;
                        let tipe = res.pembelian.data.tipe;
                        let jmlh = res.pembelian.data.jmlh;
                        let beli = res.pembelian.data.buy;
                        let jual = res.pembelian.data.sell;
                        let tr_data = '';
                        tr_data += "<tr>" +
                                    "<td>" + no + ".</td>" +
                                    "<td>" + name + "</td>" +
                                    "<td>" + tipe + "</td>" +
                                    "<td>" + jmlh + "</td>" +
                                    "<td>" + beli + "</td>" +
                                    "<td>" + jual + "</td>" +
                                   "</tr>";
                        body.append(tr_data);
                        hideLoading();
                    } else {
                        hideLoading();
                        alertWarning(res.pembelian.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    }

    jQuery.noConflict();

    $(document).on('click', '#lamonyo', function (e) {
        e.preventDefault();
        $('#table_list_item').css('display','none');
        $('#list_item').empty();
    });

    $(document).on('click', '#barunyo', function (e) {
        e.preventDefault();
        $('#insert-form').empty();
        $('#jumlah-form').val(1);
        var trgt = $('#baru').attr('data-target');
        loadbaru(trgt);
    });

    function loadbaru(trgt) {
        var ktg = $('select#kategori');
        var unit = $('select#satuan');
        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + trgt,
            type: 'GET',
            async: true,
            dataType: 'json',
            beforeSend: function () {
                //showLoading();
            },
            success: function (res) {
                if (res.pembelian.length == 0) {
                    hideLoading();
                    alertDanger("Invalid request");
                } else {
                    let kategori = "<option selected disabled value=\"\">Pilih Kategori</option>";
                    let satuan = "<option selected disabled value=\"\">Pilih Satuan</option>";
                    let c = res.pembelian.category;
                    let u = res.pembelian.unit;

                    ktg.empty();
                    unit.empty();

                    for (let i = 0; i < c.length; i++) {
                        let v = c[i].value;
                        let t = c[i].text;
                        kategori += "<option value=\"" + v + "\">" + t + "</option>";
                    }

                    for (let i = 0; i < u.length; i++) {
                        let v = u[i].value;
                        let t = u[i].text;
                        satuan += "<option value=\"" + v + "\">" + t + "</option>";
                    }

                    ktg.append(kategori);
                    unit.append(satuan);

                    hideLoading();
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    }

    $(document).on('change click', '#kategori', function (e) {
        e.preventDefault();
        var sk = $('select#kategori');
        var hj = $('input#harga_jual');
        for (let i = 0; i < sk.length; i++) {
            hj[i].disabled = sk[i].value == "alt";
            if (sk[i].value == "alt") hj[i].value = '';
        }
    });

    $(document).on('click', '#tambah', function (e) {
        e.preventDefault();
        var trgt = $('#baru').attr('data-target');
        var jmlh = $('#jumlah-form').val();
        var next = parseInt(jmlh) + 1;
        $('#jumlah-form').val(next);
        var add = $('#insert-form');
        var html = "<h4>Data ke " + next + "</h4>" +
            "<div class=\"form-group\">" +
            "<label class=\"col-xs-3 control-label\">Kategori</label>" +
            "<div class=\"col-xs-9\">" +
            "<select name=\"kategori[]\" id=\"kategori\" class=\"form-control select2\"></select>" +
            "</div>" +
            "</div>" +
            "<div class=\"form-group\">" +
            "<label class=\"col-xs-3 control-label\">Nama Item</label>" +
            "<div class=\"col-xs-9\">" +
            "<input type=\"text\" id=\"nama\" name=\"nama[]\" class=\"form-control\" placeholder=\"Nama Item\">" +
            "</div>" +
            "</div>" +
            "<div class=\"form-group\">" +
            "<label class=\"col-xs-3 control-label\">Stok</label>" +
            "<div class=\"col-xs-9\">" +
            "<input type=\"text\" id=\"stok\" name=\"stok[]\" class=\"form-control auto\" placeholder=\"Stok\">" +
            "</div>" +
            "</div>" +
            "<div class=\"form-group\">" +
            "<label class=\"col-xs-3 control-label\">Satuan</label>" +
            "<div class=\"col-xs-9\">" +
            "<select name=\"satuan[]\" id=\"satuan\" class=\"form-control\"></select>" +
            "</div>" +
            "</div>" +
            "<div class=\"form-group\">" +
            "<label class=\"col-xs-3 control-label\">Harga Beli</label>" +
            "<div class=\"col-xs-9\">" +
            "<input type=\"text\" id=\"harga_beli\" name=\"harga_beli[]\" class=\"form-control auto\" placeholder=\"Harga Beli\">" +
            "</div>" +
            "</div>" +
            "<div class=\"form-group\">" +
            "<label class=\"col-xs-3 control-label\">Harga Jual</label>" +
            "<div class=\"col-xs-9\">" +
            "<input type=\"text\" id=\"harga_jual\" name=\"harga_jual[]\" class=\"form-control auto\" placeholder=\"Harga jual\">" +
            "</div>" +
            "</div>";
        add.append(html);
        loadbaru(trgt);
    });

    function validate() {
        var valid = true;
        var kategori = $('select#kategori'),
            nama = $('input#nama'),
            stok = $('input#stok'),
            satuan = $('select#satuan'),
            beli = $('input#harga_beli'),
            jual = $('input#harga_jual');

        for (let i = 0; i < kategori.length; i++) {
            valid = !kategori[i].value == "" && (!nama[i].value == "" && nama[i].value.length >= 3) &&
                (!stok[i].value == "" && stok[i].value != "0") && !satuan[i].value == "" && !beli[i].value == "" &&
                kategori[i].value == "alt" && jual[i].value == "" || jual[i].value != "" && jual[i].value.replace(/[.]/g, '') > beli[i].value.replace(/[.]/g, '');
        }

        return valid;
    }

    function validateLama() {
        var valid = true;
        var item = $('select#item');
        var jmlh = $('input#jumlah'), 
            beli = $('input#beli'), 
            jual = $('input#jual');

        valid = !item[0].value == "";

        for (let i = 0; i < jmlh.length; i++) {
            valid = !jmlh[i].value == "" && !beli[i].value == "" && !jual[i].value == ""
        }
        return valid;
    }

    $(document).on('submit', '#add-lama', function (e) {
        e.preventDefault();
        var uuid = $('#add-lama').attr('data-target');
        var pembelian = new FormData($('#add-lama')[0]);

        if (!validateLama()) { alertDanger('check kembali'); return false }

        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + uuid + "&tipe=lama",
            type: 'POST',
            async: true,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            timeout: 3000,
            data: pembelian,
            beforeSend: function () {
                showLoading();
            },
            success: function (res) {
                if (res.length == 0) {
                    hideLoading();
                    alertDanger('Invalid request');
                } else {
                    if (res.pembelian.code == 1) {
                        $('#table_list_item').css('display','none');
                        $('#list_item').empty();
                        ajaxSuccess('#add-lama');
                        dataTable.ajax.reload();
                        hideLoading();
                        alertSuccess(res.pembelian.message);
                    } else {
                        hideLoading();
                        alertWarning(res.pembelian.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
        return false;
    });

    $(document).on('submit', '#add-baru', function (e) {
        e.preventDefault();
        var uuid = $('#add-baru').attr('data-target');
        var pembelian = new FormData($('#add-baru')[0]);

        if (!validate()) { alertDanger('check kembali'); return false }

        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + uuid + "&tipe=baru",
            type: 'POST',
            async: true,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            timeout: 3000,
            data: pembelian,
            beforeSend: function () {
                showLoading();
            },
            success: function (res) {
                if (res.length == 0) {
                    hideLoading();
                    alertDanger('Invalid request');
                } else {
                    if (res.pembelian.code == 1) {
                        $('#insert-form').empty();
                        ajaxSuccess('#add-baru');
                        dataTable.ajax.reload();
                        hideLoading();
                        alertSuccess(res.pembelian.message);
                    } else {
                        hideLoading();
                        alertWarning(res.pembelian.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
        return false;
    });

    $("#create_pembelian").on('click', function (e) {
        e.preventDefault();
        $('#addModal').modal({
            'show': true,
            'backdrop': 'static'
        });
    });

    $("#table_pembelian").on('click', '#detail', function (e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        var body = $('tbody#list_item');

        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + uuid + '&id=' + uid,
            type: 'GET',
            async: true,
            dataType: 'json',
            beforeSend: function () {
                body.empty();
                showLoading();
            },
            success: function (res) {
                if (res.length == 0) {
                    hideLoading();
                    alertDanger('Invalid request');
                } else {
                    if (res.pembelian.code == 1) {
                        hideLoading();
                        $('#detailModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        $('#kodenya').html(res.pembelian.ket.kode);
                        $('#tglnya').html(res.pembelian.ket.tgl);

                        let d = res.pembelian.data;
                        let item = 0;
                        let tr_str = '';
                        let no = 1;
                        for (let i = 0; i < d.length; i++) {
                            tr_str += "<tr>"+
                                        "<td>" + no + ".</td>" +
                                        "<td>" + res.pembelian.data[i].nama + "</td>" +
                                        "<td>" + res.pembelian.data[i].jenis + "</td>" +
                                        "<td>" + res.pembelian.data[i].jmlh + " " + res.pembelian.data[i].satuan + "</td>" +
                                        "<td>Rp. " + formatAngka(res.pembelian.data[i].harga) + "</td>" +
                                        "<td>Rp. " + formatAngka(res.pembelian.data[i].subtotal) + "</td>" +
                                      "</tr>";
                            no++;
                            item+=parseInt(d[i].jmlh);
                        }
                        tr_str += "<tr><td colspan=\"3\" style=\"text-align: right !important;\">Total</td><td>" + formatAngka(item) + "</td><td></td><td>Rp. " + formatAngka(res.pembelian.ket.total) + "</td></tr>";
                        body.append(tr_str);
                    } else {
                        hideLoading();
                        alertWarning(res.pembelian.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#table_pembelian").on('click', '#hapus', function (e) {
        e.preventDefault();
        var nm = $(this).attr('title-content');
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        Swal.fire({
            title: 'Apa Anda Yakin?',
            html: 'Menghapus data pembelian <b>' + nm + '</b> ?',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function (isConfirm) {
            if (isConfirm.value) {
                $.ajax({
                    url: http + 'fetch?f=' + remote + '&d=' + uuid + '&id=' + uid,
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    processData: false,
                    contentType: false,
                    timeout: 3000,
                    beforeSend: function () {
                        showLoading();
                    },
                    success: function (res) {
                        if (res.length == 0) {
                            hideLoading();
                            alertDanger('Invalid request');
                        } else {
                            if (res.pembelian.code == 1) {
                                hideLoading();
                                dataTable.ajax.reload();
                                alertSuccess(res.pembelian.message);
                            } else {
                                hideLoading();
                                alertWarning(res.pembelian.message);
                            }
                        }
                    },
                    error: function (jqXHR, status, error) {
                        hideLoading();
                        alertDanger(status);
                    }
                });
            }
        });
    });

    $("#download_pembelian").on('click', function (e) {
        e.preventDefault();
        var rule = $(this).attr('data-remote');
        var uuid = $(this).attr('data-target');
        $.ajax({
            url: http + 'fetch?f=' + rule + '&d=' + uuid + '&tipe=pembelian',
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
                    if (res.download.code == 1) {
                        hideLoading();
                        $('#downloadModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        $('#download-pembelian h4.pull-right').html('Jumlah data sebanyak : ' + res.download.count + ' pembelian.');
                    } else {
                        hideLoading();
                        alertWarning(res.download.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $('#filter').on('click change', function () {
        $a = $(this);
        if ($a.val() == 3) {
            $('#range').prop('disabled', false).focus();
        } else {
            $('#range').val('').attr('disabled', true).closest('.form-group').removeClass('has-success');
        }
    });

    $('#range').daterangepicker({
        locale: {
            format: "DD/MM/YYYY"
        },
        showDropdowns: true,
        autoApply: true,
        startDate: start,
        endDate: end,
        maxDate: end,
        opens: "center",
        drops: "down",
    }, function (start, end, label) {
        //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
});