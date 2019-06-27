$(function () {

    moment.locale("id");
    var remote = $('#table_pengembalian').attr('data-remote');
    var target = $('#table_pengembalian').attr('data-target');
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
        return this.optional(element) || (parseInt(value.replace('.', '')) < parseInt($(params).val().replace('.', ''))) ? false : true;
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
        $('#detail-table').empty();
        $('#detail-peminjam').empty();
        $('#detail-peralatan').empty();
        $('#box-nama').css('display', 'none');
        $('#table_peralatan').css('display','none');
    }

    // Validation Alat Start // 
    $('#add-pengembalian').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
            nama: {
                required: true,
                rangelength: [3, 50],
            },
            kode: {
                required: true,
            },
            tepat: {
                required: true,
            }
        },
        messages: {
            nama: {
                required: "Nama Pengembali harus diisi !",
                rangelength: "Minimal 3 huruf dan Maksimal 50 huruf !",
            },
            kode: {
                required: "Pilih kode atau nama peminjaman !"
            },
            tepat: {
                required: "Pilih ketepatan waktu !"
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(errorClass).removeClass(validClass);
            var elem = $(element);

            if (elem.hasClass('s-select2')) {
                var isMulti = (!!elem.attr('multiple')) ? 's' : '';
                elem.siblings('.sl').find('.select2-choice' + isMulti + '').addClass(errorClass);
            } else {
                elem.addClass(errorClass);
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(validClass).removeClass(errorClass);
            var elem = $(element);

            if (elem.hasClass('sl')) {
                elem.siblings('.sl').find('.select2-choice').removeClass(errorClass);
            } else {
                elem.removeClass(errorClass);
            }
        },
        submitHandler: function (form) {
            var uuid = $('#add-pengembalian').attr('data-target');
            var sp = new FormData($(form)[0]);
            $.ajax({
                url: http + 'fetch?f=' + remote + '&d=' + uuid,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: sp,
                beforeSend: function () {
                    showLoading();
                },
                success: function (res) {
                    if (res.length == 0) {
                        hideLoading();
                        alertDanger('Invalid request');
                    } else {
                        if (res.pengembalian.code == 1) {
                            ajaxSuccess('#add-pengembalian');
                            dataTable.ajax.reload();
                            hideLoading();
                            alertSuccess(res.pengembalian.message);
                        } else {
                            hideLoading();
                            alertWarning(res.pengembalian.message);
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

    $('select').on('change', function () {
        //$(this).valid();
    });

    $('#edit-pengembalian').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
            nama: {
                required: true,
                rangelength: [3, 50],
            },
        },
        messages: {
            nama: {
                required: "Nama Peminjam harus diisi !",
                rangelength: "Minimal 3 huruf dan Maksimal 50 huruf !",
            },
        },
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(errorClass).removeClass(validClass);
            $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(validClass).removeClass(errorClass);
            $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
        },
        submitHandler: function(form) {
            var uuid = $('#edit-pengembalian').attr('data-target');
            var sp = new FormData($('#edit-pengembalian')[0]);
            var uid = $('#edit-pengembalian').find('input[type=hidden]').val();
            $.ajax({
                url: http + 'fetch?f='+remote+'&d='+uuid+'&id='+uid,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: sp,
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    if (res.length == 0) {
                        hideLoading();
                        alertDanger('Invalid request');
                    } else {
                        if (res.pengembalian.code == 1) {
                            ajaxSuccess('#edit-pengembalian');
                            dataTable.ajax.reload();
                            hideLoading();
                            alertSuccess(res.pengembalian.message);
                        } else {
                            hideLoading();
                            alertWarning(res.pengembalian.message);
                        }
                    }
                },
                error: function(jqXHR, status, error) {
                    hideLoading();
                    alertDanger(status);
                }
            });
            return false;
        }
    });

    $('#ganti-pengembalian').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
            agree: {
                required: true,
            },
        },
        messages: {
            agree: {
                required: "Checklist persetujuan !",
            },
        },
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(validClass).removeClass(errorClass);
        },
        submitHandler: function(form) {
            var uuid = $('#ganti-pengembalian').attr('data-target');
            var sp = new FormData($('#ganti-pengembalian')[0]);
            var uid = $('#ganti-pengembalian').find('input[type=hidden]').val();

            if (!validate()) return false;

            $.ajax({
                url: http + 'fetch?f='+remote+'&d='+uuid+'&id='+uid,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: sp,
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    if (res.length == 0) {
                        hideLoading();
                        alertDanger('Invalid request');
                    } else {
                        if (res.pengembalian.code == 1) {
                            ajaxSuccess('#ganti-pengembalian');
                            dataTable.ajax.reload();
                            hideLoading();
                            alertSuccess(res.pengembalian.message);
                        } else {
                            hideLoading();
                            alertWarning(res.pengembalian.message);
                        }
                    }
                },
                error: function(jqXHR, status, error) {
                    hideLoading();
                    alertDanger(status);
                }
            });
            return false;
        }
    });

    $('#download-pengembalian').validate({
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
            var page = $('#download-pengembalian').attr('data-remote');
            var uuid = $('#download-pengembalian').attr('data-target');
            var pdf = new FormData($('#download-pengembalian')[0]);
            var uid = "pengembalian";
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
                            ajaxSuccess('#download-pengembalian');
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

    $(document).on('submit', '#penggunaan-pengembalian', function (e) {
        e.preventDefault();
        var a = $('#stok_penggunaan').val();
        $b = $(this).find('.auto');

        var uuid = $(this).attr('data-target');
        var alat = new FormData($(this)[0]);
        var uid = $(this).find('input[type=hidden]').val();

        var total = 0;
        for (let i = 0; i < $b.length; i++) {
            total += parseInt($b.eq(i).val().replace('.', ''));
        }
        if (total > a) {
            for (let i = 0; i < $b.length; i++) {
                $b.eq(i).closest('.form-group').addClass("has-error animated tada").removeClass("has-success");
            }
            $('#error_msg').css('display', 'block').html("Jumlah semua melebihi jumlah stok !");
        } else {
            for (let i = 0; i < $b.length; i++) {
                $b.eq(i).closest('.form-group').addClass("has-success").removeClass("has-error animated tada");
            }
            $('#error_msg').css('display', 'none');

            $.ajax({
                url: http + 'fetch?f=' + remote + '&d=' + uuid + '&id=' + uid,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: alat,
                beforeSend: function () {
                    showLoading();
                },
                success: function (res) {
                    if (res.length == 0) {
                        hideLoading();
                        alertDanger('Invalid request');
                    } else {
                        if (res.pengembalian.code == 1) {
                            ajaxSuccess('#penggunaan-pengembalian');
                            dataTable.ajax.reload();
                            hideLoading();
                            alertSuccess(res.pengembalian.message);
                        } else {
                            hideLoading();
                            alertWarning(res.pengembalian.message);
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
    // Validation Alat End //

    var dataTable = $("#table_pengembalian").DataTable({
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
                $("#table_pengembalian_processing").addClass("text-center").html('<i class="fa fa-spinner fa-pulse fa-fw text-blue"></i>&nbsp;<span>Memuat Data...</span>');
            },
            error: function () {
                $(".table_pengembalian-error").html("");
                $("#table_pengembalian").append('<tbody class="table_pengembalian-error"><tr><td colspan="6" class="text-center">Tidak ada data</td></tr></tbody>');
                $("#table_pengembalian_processing").css('display', 'none');
            }
        },
        "pageLength": 10,
        "order": [
            [0, "desc"]
        ],
        columnDefs: [
            {
                orderable: true,
                targets: [0, 1, 2, 3, 4, 5]
            },
            {
                orderable: false,
                targets: [6]
            },
            {
                searchable: true,
                targets: [1, 2, 3]
            },
            {
                searchable: false,
                targets: [0, 4, 5, 6]
            }
        ],
        "lengthMenu": [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Semua"]
        ]
    });

    $("#table_pengembalian_filter").addClass("pull-right");
    $("#table_pengembalian_paginate").addClass("pull-right");

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

    var targetKode = $('#kode').attr('data-target');

    $('#kode').select2({
        minimumInputLength: 3,
        allowClear: true,
        placeholder: 'Cari Kode Peminjaman atau Nama Peminjam',
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
        loadDataNyo(data);
    });

    function loadDataNyo(datanyo) {
        var targetform = $('#kode').attr('data-pinjam');
        var peminjam = $('#detail-peminjam').empty();
        var peralatan = $('#detail-peralatan').empty();

        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + targetform + '&code=' + datanyo,
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
                    if (res.pengembalian.code == 1) {
                        $('#table_peralatan').css('display', 'block');
                        let today = moment(new Date());
                        let exp = moment(res.pengembalian.data.peminjam.exp);
                        let hari = today.diff(exp,'days');
                        let denda = hari * 5000 == 0 ? 5000 : hari * 5000;
                        var msg = "";
                        if (today > exp) {
                            msg = "<em class=\"text-center text-red\">Dikenakan biaya penalti keterlambatan <i>Rp. 5.000</i> per hari ! Total yang harus dibayarkan Rp <b>" + formatAngka(denda) + "</b></em>";
                        } else {
                            msg = "<em class=\"text-center text-success\">Tidak dikenakan biaya penalti !</em>";
                        }
                        let tr_peminjam = '';
                        tr_peminjam += "<tr><td style=\"width: 25% !important;\">Kode Peminjaman</td><td>" + res.pengembalian.data.peminjam.code + "</td></tr>" +
                            "<tr><td>Nama Peminjam</td><td id=\"namo\">" + res.pengembalian.data.peminjam.name + "</td></tr>" +
                            "<tr><td>Beda orang yang mengembalikan</td><td><input type=\"checkbox\" id=\"sama\" name=\"sama\">&nbsp;<b class=\"text-success\">Ya</b></td></tr>" +
                            "<tr><td>Tanggal Peminjaman</td><td>" + moment(res.pengembalian.data.peminjam.create).format("dddd, DD-MMMM-YYYY HH:mm") + "</td></tr>" +
                            "<tr><td>Tanggal Tempo</td><td>" + exp.format("dddd, DD-MMMM-YYYY HH:mm") + "</td></tr>" +
                            "<tr><td>Tanggal Hari ini</td><td>" + today.format("dddd, DD-MMMM-YYYY HH:mm") + "</td></tr>"+
                            "<tr>" + 
                                "<td colspan=\"2\">" + msg + "</td" +
                            "</tr>";
                        peminjam.append(tr_peminjam);

                        let tr_peralatan = '';
                        let jmlh = res.pengembalian.data.peralatan;
                        let no = 1;
                        for (let i = 0; i < jmlh.length; i++) {
                            let name = res.pengembalian.data.peralatan[i].name;
                            let code = res.pengembalian.data.peralatan[i].code;
                            let max = res.pengembalian.data.peralatan[i].amount;
                            tr_peralatan += "<tr>" +
                                "<td>" + no + ".</td>" +
                                "<td title=\"" + code + "\">" + res.pengembalian.data.peralatan[i].code + "</td>" +
                                "<td title=\"" + name + "\">" + res.pengembalian.data.peralatan[i].name + "</td>" +
                                "<td>" + res.pengembalian.data.peralatan[i].category + "</td>" +
                                "<td>" + res.pengembalian.data.peralatan[i].amount + "</td>" +
                                "<td>" +
                                "<input type=\"radio\" id=\"rusak_ya\" class=\"rusak\" name=\"rusak[" + code + "]\" value=\"1\">&nbsp;<b class=\"text-red\">Sengaja</b>&nbsp;&nbsp;" +
                                "<input type=\"radio\" id=\"rusak_tidak\" class=\"rusak\" name=\"rusak[" + code + "]\" value=\"2\">&nbsp;<b class=\"text-red\">Tidak Sengaja</b>&nbsp;&nbsp;" +
                                "</td>" +
                                "<td>" +
                                "<input type=\"number\" id=\"jumlah_rusak\" name=\"jumlah_rusak[" + code + "]\" class=\"form-control\" value=\"0\" min=\"1\" max=\"" + max + "\" disabled required>" +
                                "</td>" +
                                "<td>" +
                                "<input type=\"radio\" id=\"hilang_ya\" class=\"hilang\" name=\"hilang[" + code + "]\" value=\"1\">&nbsp;<b class=\"text-red\">Sengaja</b>&nbsp;&nbsp;" +
                                "<input type=\"radio\" id=\"hilang_tidak\" class=\"hilang\" name=\"hilang[" + code + "]\" value=\"2\">&nbsp;<b class=\"text-red\">Tidak Sengaja</b>&nbsp;&nbsp;" +
                                "</td>" +
                                "<td>" +
                                "<input type=\"number\" id=\"jumlah_hilang\" name=\"jumlah_hilang[" + code + "]\" class=\"form-control\" value=\"0\" min=\"1\" max=\"" + max + "\" disabled required>" +
                                "</td>" +
                                "</tr>";
                            no++;
                        }
                        peralatan.append(tr_peralatan);
                        $('#nama').val(res.pengembalian.data.peminjam.name);
                        hideLoading();
                    } else {
                        hideLoading();
                        alertWarning(res.pengembalian.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    }

    $('#kode').on('select2:unselect', function (e) {
        $('#box-nama').css('display', 'none');
        $('#detail-peminjam').empty();
        $('#table_peralatan').css('display','none');
    });

    $(document).on('change','#sama', function(e) {
        if((this).checked) {
            $('#box-nama').css('display', 'block');
            $('#nama').val("");
        } else {
            $('#box-nama').css('display', 'none');
            $('#nama').val($('#namo').text());
        }
    });

    $(document).on('change','#sama_edit', function(e) {
        if((this).checked) {
            $('#box-nama_edit').css('display', 'block');
            $('#nama_edit').val("");
        } else {
            $('#box-nama_edit').css('display', 'none');
            $('#nama_edit').val($('#namo_edit').text());
        }
    });

    $('#reset_pengembalian').on('click', function(e) {
        e.preventDefault();
        var radionyo = $('#detail-peralatan tr td input[type=radio]');
        var jmlhnyo = $('#detail-peralatan tr td input[type=number]');
        for (let i = 0; i < radionyo.length; i++) {
            radionyo[i].checked = false;
        }
        for (let i = 0; i < jmlhnyo.length; i++) {
            jmlhnyo[i].disabled = true;
            jmlhnyo[i].value = 0;
        }
    });

    $('#reset_pengembalian_edit').on('click', function(e) {
        e.preventDefault();
        var radionyo = $('#detail-peralatan_edit tr td input[type=radio]');
        var jmlhnyo = $('#detail-peralatan_edit tr td input[type=number]');
        for (let i = 0; i < radionyo.length; i++) {
            radionyo[i].checked = false;
        }
        for (let i = 0; i < jmlhnyo.length; i++) {
            jmlhnyo[i].disabled = true;
            jmlhnyo[i].value = 0;
        }
    });

    $(document).on('change','#detail-peralatan tr td input[type=radio].rusak', function(e) {
        e.preventDefault();
        var ya = $('#detail-peralatan tr td input[type=radio]#rusak_ya');
        var tdk = $('#detail-peralatan tr td input[type=radio]#rusak_tidak');
        var jmlh = $('#detail-peralatan tr td input#jumlah_rusak');
        for (let i = 0; i < jmlh.length; i++) {
            jmlh[i].disabled = !ya[i].checked && !tdk[i].checked;
            ya[i].checked || tdk[i].checked ? jmlh[i].value = 1 : jmlh[i].value = 0;
            //if (!pjmn[i].checked) jmlh[i].min;
        }
    });

    $(document).on('change','#detail-peralatan tr td input[type=radio].hilang', function(e) {
        e.preventDefault();
        var ya = $('#detail-peralatan tr td input[type=radio]#hilang_ya');
        var tdk = $('#detail-peralatan tr td input[type=radio]#hilang_tidak');
        var jmlh = $('#detail-peralatan tr td input#jumlah_hilang');
        for (let i = 0; i < jmlh.length; i++) {
            jmlh[i].disabled = !ya[i].checked && !tdk[i].checked;
            ya[i].checked || tdk[i].checked ? jmlh[i].value = 1 : jmlh[i].value = 0;
            //if (!pjmn[i].checked) jmlh[i].min;
        }
    });

    $(document).on('change','#detail-peralatan_edit tr td input[type=radio].rusak_edit', function(e) {
        e.preventDefault();
        var ya = $('#detail-peralatan_edit tr td input[type=radio]#rusak_ya');
        var tdk = $('#detail-peralatan_edit tr td input[type=radio]#rusak_tidak');
        var jmlh = $('#detail-peralatan_edit tr td input#jumlah_rusak');
        for (let i = 0; i < jmlh.length; i++) {
            jmlh[i].disabled = !ya[i].checked && !tdk[i].checked;
            //ya[i].checked || tdk[i].checked ? jmlh[i].value = 1 : jmlh[i].value = 0;
        }
    });

    $(document).on('change','#detail-peralatan_edit tr td input[type=radio].hilang_edit', function(e) {
        e.preventDefault();
        var ya = $('#detail-peralatan_edit tr td input[type=radio]#hilang_ya');
        var tdk = $('#detail-peralatan_edit tr td input[type=radio]#hilang_tidak');
        var jmlh = $('#detail-peralatan_edit tr td input#jumlah_hilang');
        for (let i = 0; i < jmlh.length; i++) {
            jmlh[i].disabled = !ya[i].checked && !tdk[i].checked;
            //ya[i].checked || tdk[i].checked ? jmlh[i].value = 1 : jmlh[i].value = 0;
        }
    });

    $(document).on('keyup change','#detail-peralatan tr td input[type=number]', function(e) {
        e.preventDefault();
        var max = $('#detail-peralatan tr td:nth-child(5)');
        var rusak = $('#detail-peralatan tr td input[type=number]#jumlah_rusak');
        var hilang = $('#detail-peralatan tr td input[type=number]#jumlah_hilang');
        var item = $('#detail-peralatan tr td:nth-child(3)');
        var btn = false;
        var total;
        for (let i = 0; i < max.length; i++) {
            total = parseInt(rusak[i].value) + parseInt(hilang[i].value);
            if (total > parseInt(max[i].textContent)) {
                alertWarning("Jumlah rusak atau hilang pada " + item[i].textContent + " melebihi batas jumlah peminjaman");
                btn = true;
            }
        }
        if (btn) {
            $('#simpan')[0].disabled = true;
        } else {
            $('#simpan')[0].disabled = false;
        }
    });

    $(document).on('keyup change','#detail-peralatan_edit tr td input[type=number]', function(e) {
        e.preventDefault();
        var max = $('#detail-peralatan_edit tr td:nth-child(5)');
        var rusak = $('#detail-peralatan_edit tr td input[type=number]#jumlah_rusak');
        var hilang = $('#detail-peralatan_edit tr td input[type=number]#jumlah_hilang');
        var item = $('#detail-peralatan_edit tr td:nth-child(3)');
        var btn = false;
        var total;
        for (let i = 0; i < max.length; i++) {
            total = parseInt(rusak[i].value) + parseInt(hilang[i].value);
            if (total > parseInt(max[i].textContent)) {
                alertWarning("Jumlah rusak atau hilang pada " + item[i].textContent + " melebihi batas jumlah peminjaman");
                btn = true;
            }
        }
        if (btn) {
            $('#ubah')[0].disabled = true;
        } else {
            $('#ubah')[0].disabled = false;
        }
    });

    jQuery.noConflict();

    function validate() {
        var a = $('input.ganti');
        var valid = true;
        if ($('.ganti:checked').length != a.length) {
            alertWarning("Checklist semua item!");
            valid = false;
        } else {
            valid = true;
        }
        return valid;
    }

    $("#create_pengembalian").on('click', function (e) {
        e.preventDefault();
        var target = $(this).attr('data-target');
        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + target,
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
                    if (res.pengembalian.code == 1) {
                        hideLoading();
                        $('#addModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                    } else {
                        hideLoading();
                        alertWarning(res.pengembalian.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#table_pengembalian").on('click', '#edit', function (e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        var pengembali = $('#detail-peminjam_edit').empty();
        var peralatan = $('#detail-peralatan_edit').empty();

        $a = $('#edit-pengembalian').find('input[type=hidden],input[type=text], select, textarea');

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
                    if (res.pengembalian.code == 1) {
                        $('#editModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let tr_pengembali = '';
                        tr_pengembali += "<tr><td style=\"width: 25% !important;\">Kode pengembalian</td><td>" + res.pengembalian.data.peminjam.code_return + "</td></tr>" +
                                         "<tr><td>Kode peminjaman</td><td>" + res.pengembalian.data.peminjam.code_loan + "</td></tr>" +
                                         "<tr><td>Nama Peminjam</td><td id=\"namo_edit\">" + res.pengembalian.data.peminjam.name + "</td></tr>" +
                                         "<tr><td>Beda orang yang mengembalikan</td><td><input type=\"checkbox\" id=\"sama_edit\" name=\"sama_edit\">&nbsp;<b class=\"text-success\">Ya</b></td></tr>" +
                                         "<tr><td>Ketepatan pengembalian</td><td>" + res.pengembalian.data.peminjam.pin + "</td></tr>" +
                                         "<tr><td>Lama peminjaman</td><td>" + res.pengembalian.data.peminjam.period + "</td></tr>" +
                                         "<tr><td>Penggantian rusak atau hilang</td><td>" + res.pengembalian.data.peminjam.change + "</td></tr>" +
                                         "<tr><td>Info keterlambatan</td><td>" + res.pengembalian.data.peminjam.info + "</td></tr>" +
                                         "<tr><td>Tanggal Dikembalikan</td><td>" + res.pengembalian.data.peminjam.create + "</td></tr>";
                        pengembali.append(tr_pengembali);

                        let tr_peralatan = '';
                        let jmlh = res.pengembalian.data.peralatan;
                        let no = 1;
                        for (let i = 0; i < jmlh.length; i++) {
                            let name = res.pengembalian.data.peralatan[i].name_item;
                            let code = res.pengembalian.data.peralatan[i].code_item;
                            let unit = res.pengembalian.data.peralatan[i].unit;
                            let jenisRusak = res.pengembalian.data.peralatan[i].broken_status;
                            let jenisHilang = res.pengembalian.data.peralatan[i].lost_status;
                            let jmlhRusak = res.pengembalian.data.peralatan[i].broken_amount;// == 0 ? 1 : res.pengembalian.data.peralatan[i].broken_amount;
                            let jmlhHilang = res.pengembalian.data.peralatan[i].lost_amount;// == 0 ? 1 : res.pengembalian.data.peralatan[i].lost_amount;
                            let rusakYa = jenisRusak == 1 ? "checked" : "";
                            let rusakTdk = jenisRusak == 2 ? "checked" : "";
                            let hilangYa = jenisHilang == 1 ? "checked" : "";
                            let hilangTdk = jenisHilang == 2 ? "checked" : "";
                            let dkbolehRsk = jenisRusak == 0 ? "disabled=\"disabled\"" : "";
                            let dkbolehHlg = jenisHilang == 0 ? "disabled=\"disabled\"" : "";
                            let max = res.pengembalian.data.peralatan[i].amount;
                            tr_peralatan += "<tr>" +
                                "<td>" + no + ".</td>" +
                                "<td title=\"" + code + "\">" + code + "</td>" +
                                "<td title=\"" + name + "\">" + name + "</td>" +
                                "<td>" + res.pengembalian.data.peralatan[i].category + "</td>" +
                                "<td>" + max + " " + unit + "</td>" +
                                "<td>" +
                                "<input type=\"radio\" id=\"rusak_ya\" class=\"rusak_edit\" name=\"rusak[" + code + "]\" value=\"1\" "+rusakYa+">&nbsp;<b class=\"text-red\">Sengaja</b>&nbsp;&nbsp;" +
                                "<input type=\"radio\" id=\"rusak_tidak\" class=\"rusak_edit\" name=\"rusak[" + code + "]\" value=\"2\" "+rusakTdk+">&nbsp;<b class=\"text-red\">Tidak Sengaja</b>&nbsp;&nbsp;" +
                                "</td>" +
                                "<td>" +
                                "<input type=\"number\" id=\"jumlah_rusak\" name=\"jumlah_rusak[" + code + "]\" class=\"form-control\" value=\""+jmlhRusak+"\" min=\"1\" max=\"" + max + "\" "+dkbolehRsk+" required>" +
                                "</td>" +
                                "<td>" +
                                "<input type=\"radio\" id=\"hilang_ya\" class=\"hilang_edit\" name=\"hilang[" + code + "]\" value=\"1\" "+hilangYa+">&nbsp;<b class=\"text-red\">Sengaja</b>&nbsp;&nbsp;" +
                                "<input type=\"radio\" id=\"hilang_tidak\" class=\"hilang_edit\" name=\"hilang[" + code + "]\" value=\"2\" "+hilangTdk+">&nbsp;<b class=\"text-red\">Tidak Sengaja</b>&nbsp;&nbsp;" +
                                "</td>" +
                                "<td>" +
                                "<input type=\"number\" id=\"jumlah_hilang\" name=\"jumlah_hilang[" + code + "]\" class=\"form-control\" value=\""+jmlhHilang+"\" min=\"1\" max=\"" + max + "\" "+dkbolehHlg+" required>" +
                                "</td>" +
                                "</tr>";
                            no++;
                        }
                        peralatan.append(tr_peralatan);

                        $a.eq(0).val(res.pengembalian.data.peminjam.code_return);
                        $('#nama_edit').val(res.pengembalian.data.peminjam.name);
                        hideLoading();
                    } else {
                        hideLoading();
                        alertWarning(res.pengembalian.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#table_pengembalian").on('click', '#detail', function (e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        var pengembali = $('#detail-pengembalian').empty();
        var peralatan = $('#detail-peralatan-return');//.empty();
        peralatan.empty();

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
                    if (res.pengembalian.code == 1) {
                        hideLoading();
                        $('#detailModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let tr_pengembali = '';
                        tr_pengembali += "<tr><td style=\"width: 25% !important;\">Kode pengembalian</td><td>" + res.pengembalian.data.peminjam.code_return + "</td></tr>" +
                                         "<tr><td>Kode peminjaman</td><td>" + res.pengembalian.data.peminjam.code_loan + "</td></tr>" +
                                         "<tr><td>Nama Pengembali</td><td>" + res.pengembalian.data.peminjam.name + "</td></tr>" +
                                         "<tr><td>Ketepatan pengembalian</td><td>" + res.pengembalian.data.peminjam.pin + "</td></tr>" +
                                         "<tr><td>Lama peminjaman</td><td>" + res.pengembalian.data.peminjam.period + "</td></tr>" +
                                         "<tr><td>Penggantian rusak atau hilang</td><td>" + res.pengembalian.data.peminjam.change + "</td></tr>" +
                                         "<tr><td>Info keterlambatan</td><td>" + res.pengembalian.data.peminjam.info + "</td></tr>" +
                                         "<tr><td>Tanggal Pinjam</td><td>" + res.pengembalian.data.peminjam.pinjam + "</td></tr>" +
                                         "<tr><td>Tanggal Tempo</td><td>" + res.pengembalian.data.peminjam.due + "</td></tr>" +
                                         "<tr><td>Tanggal Dikembalikan</td><td>" + res.pengembalian.data.peminjam.create + "</td></tr>";
                        pengembali.append(tr_pengembali);

                        let tr_peralatan = '';
                        let jmlh = res.pengembalian.data.peralatan;
                        let no = 1;
                        let unit = null;
                        let total = 0;
                        let rusak = 0;
                        let hilang = 0;
                        for (let i = 0; i < jmlh.length; i++) {
                            unit = res.pengembalian.data.peralatan[i].unit;
                            tr_peralatan += "<tr>" +
                                                "<td>" + no + ".</td>" +
                                                "<td>" + res.pengembalian.data.peralatan[i].code_item + "</td>" +
                                                "<td>" + res.pengembalian.data.peralatan[i].name_item + "</td>" +
                                                "<td>" + res.pengembalian.data.peralatan[i].category + "</td>" +
                                                "<td>" + res.pengembalian.data.peralatan[i].amount + " " + unit + "</td>" +
                                                "<td>" + res.pengembalian.data.peralatan[i].broken_status + "</td>" +
                                                "<td style=\"text-align: center\">" + res.pengembalian.data.peralatan[i].broken_amount + " " + unit + "</td>" +
                                                "<td>" + res.pengembalian.data.peralatan[i].lost_status + "</td>" +
                                                "<td>" + res.pengembalian.data.peralatan[i].lost_amount + " " + unit + "</td>" +
                                            "</tr>";
                            total += parseInt(res.pengembalian.data.peralatan[i].amount);
                            rusak += parseInt(res.pengembalian.data.peralatan[i].broken_amount);
                            hilang += parseInt(res.pengembalian.data.peralatan[i].lost_amount);
                            no++;
                        }
                        tr_peralatan += "<tr>" +
                                            "<td colspan=\"4\" style=\"text-align: right !important; font-weight: 600;\">Jumlah</td>" + 
                                            "<td style=\"text-align: center; font-weight: 600;\">" + formatAngka(total) + " " + unit + "</td>" +
                                            "<td style=\"text-align: right !important; font-weight: 600;\">Jumlah</td>" +
                                            "<td style=\"text-align: center; font-weight: 600;\">" + formatAngka(rusak) + " " + unit + "</td>" +
                                            "<td style=\"text-align: right !important; font-weight: 600;\">Jumlah</td>" +
                                            "<td style=\"text-align: center; font-weight: 600;\">" + formatAngka(hilang) + " " + unit + "</td>" +
                                        "</tr>";
                        peralatan.append(tr_peralatan);
                    } else {
                        hideLoading();
                        alertWarning(res.pegembalian.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $('#table_pengembalian').on('click', '#ganti', function (e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        var pengembali = $('#detail-peminjam_ganti').empty();
        var peralatan = $('#detail-peralatan_ganti').empty();

        $a = $('#ganti-pengembalian').find('input[type=hidden],input[type=text], select, textarea');

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
                    if (res.pengembalian.code == 1) {
                        $('#gantiModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let tr_pengembali = '';
                        tr_pengembali += "<tr><td style=\"width: 25% !important;\">Kode pengembalian</td><td>" + res.pengembalian.data.peminjam.code_return + "</td></tr>" +
                                         "<tr><td>Kode peminjaman</td><td>" + res.pengembalian.data.peminjam.code_loan + "</td></tr>" +
                                         "<tr><td>Nama Peminjam</td><td id=\"namo_edit\">" + res.pengembalian.data.peminjam.name + "</td></tr>" +
                                         "<tr><td>Ketepatan pengembalian</td><td>" + res.pengembalian.data.peminjam.pin + "</td></tr>" +
                                         "<tr><td>Lama peminjaman</td><td>" + res.pengembalian.data.peminjam.period + "</td></tr>" +
                                         "<tr><td>Penggantian rusak atau hilang</td><td>" + res.pengembalian.data.peminjam.change + "</td></tr>" +
                                         "<tr><td>Info keterlambatan</td><td>" + res.pengembalian.data.peminjam.info + "</td></tr>" +
                                         "<tr><td>Tanggal Dikembalikan</td><td>" + res.pengembalian.data.peminjam.create + "</td></tr>";
                        pengembali.append(tr_pengembali);

                        let tr_peralatan = '';
                        let jmlh = res.pengembalian.data.peralatan;
                        let no = 1;
                        let total = 0, rusak = 0, hilang = 0, semua = 0;
                        for (let i = 0; i < jmlh.length; i++) {
                            let name = res.pengembalian.data.peralatan[i].name_item;
                            let code = res.pengembalian.data.peralatan[i].code_item;
                            let unit = res.pengembalian.data.peralatan[i].unit;
                            let jmlhRusak = res.pengembalian.data.peralatan[i].broken_amount;
                            let jmlhHilang = res.pengembalian.data.peralatan[i].lost_amount;
                            let max = res.pengembalian.data.peralatan[i].amount;
                            tr_peralatan += "<tr>" +
                                "<td>" + no + ".</td>" +
                                "<td title=\"" + code + "\">" + code + "</td>" +
                                "<td title=\"" + name + "\">" + name + "</td>" +
                                "<td>" + res.pengembalian.data.peralatan[i].category + "</td>" +
                                "<td>" + max + " " + unit + "</td>" +
                                "<td>" + jmlhRusak + " " + unit + "</td>" +
                                "<td>" + jmlhHilang + " " + unit + "</td>" +
                                "<td><input type=\"checkbox\" class=\"ganti\" name=\"ganti[" + code + "]\"></td>" + 
                                "</tr>";
                            total+=parseInt(max);
                            rusak+=parseInt(jmlhRusak);
                            hilang+=parseInt(jmlhHilang);
                            let c = parseInt(jmlhRusak) + parseInt(jmlhHilang);
                            semua+=c;
                            no++;
                        }
                        tr_peralatan += "<tr>" + 
                                            "<td colspan=\"4\" style=\"text-align: right !important;\">Total</td>" +
                                            "<td>" + formatAngka(total) + "</td>" +
                                            "<td>" + formatAngka(rusak) + "</td>" +
                                            "<td>" + formatAngka(hilang) + "</td>" +
                                            "<td>" + formatAngka(semua) + "</td>" +
                                        "</tr>";
                        peralatan.append(tr_peralatan);

                        $a.eq(0).val(res.pengembalian.data.peminjam.code_return);
                        hideLoading();
                    } else {
                        hideLoading();
                        alertWarning(res.pengembalian.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#table_pengembalian").on('click', '#hapus', function (e) {
        e.preventDefault();
        var nm = $(this).attr('title-content');
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        var addMsg = "Tindakan penghapusan data pengembalian mengakibatkan hilangnya stok peralatan !";

        Swal.fire({
            title: 'Apa Anda Yakin?',
            html: 'Menghapus data pengembalian <b>' + nm + '</b> ? <br><b class="text-red">' + addMsg.toUpperCase() + '</b>',
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
                            if (res.pengembalian.code == 1) {
                                hideLoading();
                                dataTable.ajax.reload();
                                alertSuccess(res.pengembalian.message);
                            } else {
                                hideLoading();
                                alertWarning(res.pengembalian.message);
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

    $("#download_pengembalian").on('click', function (e) {
        e.preventDefault();
        var rule = $(this).attr('data-remote');
        var uuid = $(this).attr('data-target');
        $.ajax({
            url: http + 'fetch?f=' + rule + '&d=' + uuid + '&tipe=pengembalian',
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
                        $('#download-pengembalian h4.pull-right').html('Jumlah data sebanyak : ' + res.download.count + ' pengembalian.');
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