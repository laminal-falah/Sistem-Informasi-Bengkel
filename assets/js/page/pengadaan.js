$(function () {

    moment.locale("id");
    var remote = $('#table_pengadaan').attr('data-remote');
    var target = $('#table_pengadaan').attr('data-target');
    var laporan = $('#table_pengadaan').attr('data-laporan');
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
        $('#table_list_item').css('display','none');
        $('tbody#list_item').empty();
        $('div#codeItemnyo').empty();
    }

    // Validation pengadaan Start //
    $('#download-pengadaan').validate({
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
            var page = $('#download-pengadaan').attr('data-remote');
            var uuid = $('#download-pengadaan').attr('data-target');
            var pdf = new FormData($('#download-pengadaan')[0]);
            var uid = "pengadaan";
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
                            ajaxSuccess('#download-pengadaan');
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
    // Validation pengadaan End //

    var dataTable = $("#table_pengadaan").DataTable({
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
                $("#table_pengadaan_processing").addClass("text-center").html('<i class="fa fa-spinner fa-pulse fa-fw text-blue"></i>&nbsp;<span>Memuat Data...</span>');
            },
            error: function () {
                $(".table_pengadaan-error").html("");
                $("#table_pengadaan").append('<tbody class="table_pengadaan-error"><tr><td colspan="6" class="text-center">Tidak ada data</td></tr></tbody>');
                $("#table_pengadaan_processing").css('display', 'none');
            }
        },
        "pageLength": 10,
        "order": [
            [0, "desc"]
        ],
        columnDefs: [
            {
                orderable: true,
                targets: [0, 1, 2, 3]
            },
            {
                orderable: false,
                targets: [4]
            },
            {
                searchable: true,
                targets: [1]
            },
            {
                searchable: false,
                targets: [0, 2, 3, 4]
            }
        ],
        "lengthMenu": [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Semua"]
        ]
    });

    $("#table_pengadaan_filter").addClass("pull-right");
    $("#table_pengadaan_paginate").addClass("pull-right");

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
        dropdownParent: $('#add-pengadaan'),
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
        var codeItem = $('div#codeItemnyo');
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
                    if (res.pengadaan.code == 1) {
                        $('#table_list_item').css('display', 'block');
                        let name = res.pengadaan.data.name;
                        let tipe = res.pengadaan.data.tipe;
                        let jmlh = res.pengadaan.data.sum;
                        let beli = res.pengadaan.data.buy;
                        let sub = res.pengadaan.data.sub;
                        let item = res.pengadaan.data.code;
                        let tr_data = '';
                        tr_data += "<tr>" +
                                    "<td>" + no + ".</td>" +
                                    "<td>" + name + "</td>" +
                                    "<td>" + tipe + "</td>" +
                                    "<td>" + formatAngka(jmlh) + "</td>" +
                                    "<td>Rp. " + formatAngka(beli) + "</td>" +
                                    "<td>Rp. " + formatAngka(sub) + "</td>" +
                                   "</tr>";
                        body.append(tr_data);
                        codeItem.append(item);
                        let c = 0;
                        for (let i = 0; i < $('#list_item tr td:last-child').length; i++) {
                            let a = $('#list_item tr td:last-child')[i].textContent.split(' ');
                            let b = a[1].replace(/[.]/g,'');
                            c += parseInt(b);
                        }
                        $('#totalnyo').html('Rp. ' + formatAngka(c));
                        hideLoading();
                    } else {
                        hideLoading();
                        alertWarning(res.pengadaan.message);
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

    function validateLama() {
        var valid = true;
        if ($('#list_item').children().length <= 0) {
            valid = false;
        } else {
            valid = true;
        }
        return valid;
    }

    $(document).on('submit', '#add-pengadaan', function (e) {
        e.preventDefault();
        var uuid = $('#add-pengadaan').attr('data-target');
        var pengadaan = new FormData($('#add-pengadaan')[0]);

        if (!validateLama()) { alertDanger('check kembali'); return false }

        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + uuid,
            type: 'POST',
            async: true,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            timeout: 3000,
            data: pengadaan,
            beforeSend: function () {
                showLoading();
            },
            success: function (res) {
                if (res.length == 0) {
                    hideLoading();
                    alertDanger('Invalid request');
                } else {
                    if (res.pengadaan.code == 1) {
                        $('#table_list_item').css('display','none');
                        $('#list_item').empty();
                        ajaxSuccess('#add-pengadaan');
                        dataTable.ajax.reload();
                        hideLoading();
                        alertSuccess(res.pengadaan.message);
                    } else {
                        hideLoading();
                        alertWarning(res.pengadaan.message);
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

    $(document).on('submit', '#edit-pengadaan', function(e) {
        e.preventDefault();
        var uuid = $('#edit-pengadaan').attr('data-target');
        var pengadaan = new FormData($('#edit-pengadaan')[0]);
        var uid = $('#edit-pengadaan').find('input[type=hidden]').val();

        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + uuid + '&id='+uid,
            type: 'POST',
            async: true,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            timeout: 3000,
            data: pengadaan,
            beforeSend: function () {
                showLoading();
            },
            success: function (res) {
                if (res.length == 0) {
                    hideLoading();
                    alertDanger('Invalid request');
                } else {
                    if (res.pengadaan.code == 1) {
                        ajaxSuccess('#edit-pengadaan');
                        dataTable.ajax.reload();
                        hideLoading();
                        alertSuccess(res.pengadaan.message);
                    } else {
                        hideLoading();
                        alertWarning(res.pengadaan.message);
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

    $("#create_pengadaan").on('click', function (e) {
        e.preventDefault();
        var trgt = $(this).attr('data-target');
        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + trgt,
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
                    if (res.pengadaan.code == 1) {
                        hideLoading();
                        $('#addModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                    } else {
                        hideLoading();
                        alertWarning(res.pengadaan.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#table_pengadaan").on('click', '#edit', function (e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        $a = $('#edit-pengadaan').find('input[type=hidden],input[type=text], select, textarea');

        $.ajax({
            url: http + 'fetch?f='+remote+'&d='+uuid+'&id='+uid,
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
                    if (res.pengadaan.code == 1) {
                        hideLoading();
                        $('#editModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        $a.eq(0).val(res.pengadaan.data.code);
                        $a.eq(1).val(res.pengadaan.data.stts);
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

    $("#table_pengadaan").on('click', '#detail', function (e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        var pengada = $('#detail-pengadaan');
        var body = $('tbody#list_item_detail');

        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + uuid + '&id=' + uid,
            type: 'GET',
            async: true,
            dataType: 'json',
            beforeSend: function () {
                pengada.empty();
                body.empty();
                showLoading();
            },
            success: function (res) {
                if (res.length == 0) {
                    hideLoading();
                    alertDanger('Invalid request');
                } else {
                    if (res.pengadaan.code == 1) {
                        hideLoading();
                        $('#detailModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let tr_pengada = ''
                        let code = res.pengadaan.data.detail.code;
                        let stts = res.pengadaan.data.detail.status;
                        tr_pengada += "<tr><td>Kode Pengadaan</td><td>" + code + "</td></tr>" + 
                                      "<tr><td>Status</td><td>" + stts + "</td></tr>";
                        pengada.append(tr_pengada);

                        let d = res.pengadaan.data.list;
                        let item = 0;
                        let tr_str = '';
                        let no = 1;
                        for (let i = 0; i < d.length; i++) {
                            tr_str += "<tr>"+
                                        "<td>" + no + ".</td>" +
                                        "<td>" + d[i].name + "</td>" +
                                        "<td>" + d[i].jenis + "</td>" +
                                        "<td>" + formatAngka(d[i].jmlh) + " " + d[i].unit + "</td>" +
                                        "<td>Rp. " + d[i].price + "</td>" +
                                        "<td>Rp. " + d[i].sub + "</td>" +
                                      "</tr>";
                            no++;
                            item+=parseInt(d[i].sub.replace(/[.]/g,''));
                        }
                        tr_str += "<tr><td colspan=\"5\" style=\"text-align: right !important;\">Total</td><td>Rp. " + formatAngka(item) + "</td>/tr>";
                        body.append(tr_str);
                    } else {
                        hideLoading();
                        alertWarning(res.pengadaan.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#table_pengadaan").on('click', '#hapus', function (e) {
        e.preventDefault();
        var nm = $(this).attr('title-content');
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        Swal.fire({
            title: 'Apa Anda Yakin?',
            html: 'Menghapus data pengadaan <b>' + nm + '</b> ?',
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
                            if (res.pengadaan.code == 1) {
                                hideLoading();
                                dataTable.ajax.reload();
                                alertSuccess(res.pengadaan.message);
                            } else {
                                hideLoading();
                                alertWarning(res.pengadaan.message);
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

    $("#download_pengadaan").on('click', function (e) {
        e.preventDefault();
        var rule = $(this).attr('data-remote');
        var uuid = $(this).attr('data-target');
        $.ajax({
            url: http + 'fetch?f=' + rule + '&d=' + uuid + '&tipe=pengadaan',
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
                        $('#download-pengadaan h4.pull-right').html('Jumlah data sebanyak : ' + res.download.count + ' pengadaan.');
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

    $("#table_pengadaan").on('click', '#download', function (e) {
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
                    if (res.pengadaan.code == 1) {
                        hideLoading();
                        alertSuccess(res.pengadaan.message);
                        let win = window.open();
                        win.location = res.pengadaan.url;
                        win.opener = null;
                        win.blur();
                        window.focus();
                    } else {
                        hideLoading();
                        alertWarning(res.pengadaan.message);
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