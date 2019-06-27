$(function() {

    moment.locale("id");
    var remote = $('#table_alat').attr('data-remote');
    var target = $('#table_alat').attr('data-target');
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
        if (typeof(angka) != 'string') angka = angka.toString();
          var reg = new RegExp('([0-9]+)([0-9]{3})');
        while(reg.test(angka)) angka = angka.replace(reg, '$1.$2');
          return angka;
    }

    $('.auto').autoNumeric('init',{
        aSep: '.',
        aDec: ',',
        vMin: '0',
        vMax: '9999999999'
    });

    $.validator.addMethod("hurufbae", function(value, element) {
        return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
    });
    $.validator.addMethod("angkonyo", function(value, element) {
        return this.optional(element) || /^[0-9.,]*$/.test(value);
    });

    // Hide modal & reset form
    $('[data-dismiss=modal]').on('click', function (e) {
        var $t = $(this), target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];
        $(target).find('.form-group').attr('class','form-group');
        $(target).find('label.has-error').remove();
        $(target)
            .find("input,textarea,select").val('').end()
            .find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
        $(target).find('#preview').attr({src: '', style: 'display: none'});
        closeModal();
    });

    // Animation modal bootstrap + library Animate.css
    function closeModal() {
        var timeoutHandler = null;
        $('#addModal,#editModal,#detailModal,#downloadModal').on('hide.bs.modal', function () {
            var anim = $('.modal-dialog').removeClass('zoomIn').addClass('zoomOut');
            if (timeoutHandler) clearTimeout(timeoutHandler);
            timeoutHandler = setTimeout(function() {
                $('.modal-dialog').removeClass('zoomOut').addClass('zoomIn');
            }, 750); // some delay for complete Animation
        });
        $('#detail-table').empty();
    }

    // Validation Alat Start // 
    $('#add-alat').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
            nama: {
                required: true,
                rangelength: [3, 50],
            },
            stok: {
                required: true,
                angkonyo: true,
            },
            satuan: {
                required: true
            },
            harga_beli: {
                required: true,
                angkonyo: true,
            },
            lokasi: {
                required: true,
            },
            kondisi: {
                required: true,
            },
            description: {
                required: false,
            },
            img: {
                required: false,
            }
        },
        messages: {
            nama: {
                required: "Nama Alat harus diisi !",
                rangelength: "Minimal 3 huruf dan Maksimal 50 huruf !",
            },
            stok: {
                required: "Stok harus diisi !",
                angkonyo: "Tidak boleh mengandung simbol lain selain angka !"
            },
            satuan: {
                required: "Pilih satuan unit !"
            },
            harga_beli: {
                required: "Harga beli harus diisi !",
                digits: "Tidak boleh mengandung simbol lain selain angka !"
            },
            lokasi: {
                required: "Lokasi alat harus diisi !"
            },
            kondisi: {
                required: "Kondisi alat harus dipilih !"
            }
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            error.addClass("help-block");
            element.parents(".col-xs-9").addClass("has-feedback");

            if (element.prop( "type" ) === "checkbox") {
                error.insertAfter( element.parent("label"));
            } else {
                error.insertAfter( element);
            }
            if (!element.next( "span" )[ 0 ] ) {
                $( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>").insertAfter(element);
            }
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
            tinyMCE.triggerSave();
            var uuid = $('#add-alat').attr('data-target');
            var alat = new FormData($('#add-alat')[0]);
            $.ajax({
                url: http + 'fetch?f='+remote+'&d='+uuid,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: alat,
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    if (res.length == 0) {
                        hideLoading();
                        alertDanger('Invalid request');
                    } else {
                        if (res.alat.code == 1) {
                            ajaxSuccess('#add-alat');
                            dataTable.ajax.reload();
                            hideLoading();
                            alertSuccess(res.alat.message);
                        } else {
                            hideLoading();
                            alertWarning(res.alat.message);
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

    $('#edit-alat').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
            nama: {
                required: true,
                rangelength: [3, 50],
            },
            stok: {
                required: true,
                angkonyo: true,
            },
            satuan: {
                required: true
            },
            harga_beli: {
                required: true,
                angkonyo: true,
            },
            lokasi: {
                required: true,
            },
            kondisi: {
                required: true,
            },
            description: {
                required: false,
            },
            img: {
                required: false,
            }
        },
        messages: {
            nama: {
                required: "Nama Alat harus diisi !",
                rangelength: "Minimal 3 huruf dan Maksimal 50 huruf !",
            },
            stok: {
                required: "Stok harus diisi !",
                digits: "Tidak boleh mengandung simbol lain selain angka !"
            },
            satuan: {
                required: "Pilih satuan unit !"
            },
            harga_beli: {
                required: "Harga beli harus diisi !",
                digits: "Tidak boleh mengandung simbol lain selain angka !"
            },
            lokasi: {
                required: "Lokasi alat harus diisi !"
            },
            kondisi: {
                required: "Kondisi alat harus dipilih !"
            }
        },
        errorElement: "em",
        /*errorPlacement: function (error, element) {
            error.addClass("help-block");
            element.parents(".col-xs-9").addClass("has-feedback");

            if (element.prop( "type" ) === "checkbox") {
                error.insertAfter( element.parent("label"));
            } else {
                error.insertAfter( element);
            }
            if (!element.next( "span" )[ 0 ]) {
                $( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>").insertAfter(element);
            }
        },*/
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(errorClass).removeClass(validClass);
            $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(validClass).removeClass(errorClass);
            $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
        },
        submitHandler: function(form) {
            var uuid = $('#edit-alat').attr('data-target');
            var alat = new FormData($('#edit-alat')[0]);
            var uid = $('#edit-alat').find('input[type=hidden]').val();
            $.ajax({
                url: http + 'fetch?f='+remote+'&d='+uuid+'&id='+uid,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: alat,
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    if (res.length == 0) {
                        hideLoading();
                        alertDanger('Invalid request');
                    } else {
                        if (res.alat.code == 1) {
                            ajaxSuccess('#edit-alat');
                            dataTable.ajax.reload();
                            hideLoading();
                            alertSuccess(res.alat.message);
                        } else {
                            hideLoading();
                            alertWarning(res.alat.message);
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

    $('#download-alat').validate({
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
        errorPlacement: function ( error, element ) {
            error.addClass("help-block");
            element.parents(".col-xs-9").addClass("has-feedback");

            if (element.prop( "type" ) === "checkbox") {
                error.insertAfter( element.parent("label"));
            } else {
                error.insertAfter( element);
            }
            if (!element.next( "span" )[ 0 ] ) {
                $( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>").insertAfter(element);
            }
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
            var page = $('#download-alat').attr('data-remote');
            var uuid = $('#download-alat').attr('data-target');
            var pdf = new FormData($('#download-alat')[0]);
            var uid = "alat";
            $.ajax({
                url: http + 'fetch?f='+page+'&d='+uuid+'&id='+uid,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: pdf,
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    if (res.length == "") {
                        alertDanger('Invalid request');
                    } else {
                        if (res.download.code == 1) {
                            hideLoading();
                            ajaxSuccess('#download-alat');
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
                error: function(jqXHR, status, error) {
                    hideLoading();
                    alertDanger(status);
                }
            });
            return false;
        }
    });

    $(document).on('submit','#penggunaan-alat', function(e) {
        e.preventDefault();
        var a = $('#stok_penggunaan').val();
        $b = $(this).find('.auto');

        var uuid = $(this).attr('data-target');
        var alat = new FormData($(this)[0]);
        var uid = $(this).find('input[type=hidden]').val();

        var total = 0;
        for (let i = 0; i < $b.length; i++) {
            total += parseInt($b.eq(i).val().replace(/[.]/g,''));
        }
        if (total > a) {
            for (let i = 0; i < $b.length; i++) {
                $b.eq(i).closest('.form-group').addClass("has-error animated tada").removeClass("has-success");
            }
            $('#error_msg').css('display','block').html("Jumlah semua melebihi jumlah stok !");
        } else {
            for (let i = 0; i < $b.length; i++) {
                $b.eq(i).closest('.form-group').addClass("has-success").removeClass("has-error animated tada");
            }
            $('#error_msg').css('display','none');
            
            $.ajax({
                url: http + 'fetch?f='+remote+'&d='+uuid+'&id='+uid,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: alat,
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    if (res.length == 0) {
                        hideLoading();
                        alertDanger('Invalid request');
                    } else {
                        if (res.alat.code == 1) {
                            ajaxSuccess('#penggunaan-alat');
                            dataTable.ajax.reload();
                            hideLoading();
                            alertSuccess(res.alat.message);
                        } else {
                            hideLoading();
                            alertWarning(res.alat.message);
                        }
                    }
                },
                error: function(jqXHR, status, error) {
                    hideLoading();
                    alertDanger(status);
                }
            });
        }
    });
    // Validation Alat End //

    var dataTable = $("#table_alat").DataTable({
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
                $("#table_alat_processing").addClass("text-center").html('<i class="fa fa-spinner fa-pulse fa-fw text-blue"></i>&nbsp;<span>Memuat Data...</span>');
            },
            error: function () {
                $(".table_alat-error").html("");
                $("#table_alat").append('<tbody class="table_alat-error"><tr><td colspan="6" class="text-center">Tidak ada data</td></tr></tbody>');
                $("#table_alat_processing").css('display', 'none');
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

    $("#table_alat_filter").addClass("pull-right");
    $("#table_alat_paginate").addClass("pull-right");
    
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

    $("#create_alat").on('click', function (e) {
        e.preventDefault();
        $('#addModal').modal({
            'show': true,
            'backdrop': 'static'
        });
    });

    // Load Image Preview before upload
    $(document).on('click change','#choose', function(e) {
        e.preventDefault();
        $('#gambar').trigger('click');
        $('#gambar').on('change', function() {
            var imgPath = $(this).val();
            var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            if (ext == "gir" || ext == "png" || ext == "jpg" || ext == "jpeg") {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();
                    reader.onload = function(r) {
                        $('#preview').attr({
                            src: r.target.result,
                            style: "display: block"
                        });
                    }
                    $('button[type=submit]').attr('readonly',false);
                    $('#img').val($(this)[0].files[0].name);
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    console.log('This is browser does not support file reader !');
                }
            } else {
                $('button[type=submit]').attr('readonly',true);
                console.log('please select only image *.gif, *.png, *.jpg, *.jpeg');
            }
        });
        $('#reset').on('click', function(e) {
            e.preventDefault();
            $('#preview').attr({
                src: '',
                style: "display: none"
            });
            $('#img').val('');
            $('#gambar').val('');
        });
        return false;
    });

    $(document).on('click change','#choose-edit', function(e) {
        e.preventDefault();
        $('#gambar-edit').trigger('click');
        $('#gambar-edit').on('change', function() {
            var imgPath = $(this).val();
            var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            if (ext == "gir" || ext == "png" || ext == "jpg" || ext == "jpeg") {
                if (typeof (FileReader) != "undefined") {
                    var reader = new FileReader();
                    reader.onload = function(r) {
                        $('#preview-edit').attr({
                            src: r.target.result,
                            style: "display: block"
                        });
                    }
                    $('button[type=submit]').attr('readonly',false);
                    $('#img-edit').val($(this)[0].files[0].name);
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    console.log('This is browser does not support file reader !');
                }
            } else {
                $('button[type=submit]').attr('readonly',true);
                console.log('please select only image *.gif, *.png, *.jpg, *.jpeg');
            }
        });
        return false;
    });

    $("#table_alat").on('click', '#edit', function (e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        $a = $('#edit-alat').find('input[type=hidden],input[type=text], select, textarea');

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
                    if (res.alat.code == 1) {
                        hideLoading();
                        $('#editModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let stoknyo = 0;
                        for (let i = 0; i < $a.length - 2; i++) {
                            if (i == 2) {
                                $a.eq(i).val(0);
                                stoknyo = res.alat.data[i];
                                continue;
                            }
                            if (i == 4) {
                                $a.eq(i).val(formatAngka(res.alat.data[i]));
                                continue;
                            }
                            $a.eq(i).val(res.alat.data[i]);
                        }
                        $('#status_stok').html("Jumlah stok saat ini : " + stoknyo + " data.");
                        tinymce.get('description').setContent(res.alat.data[7]);
                        $('#img-edit').val(res.alat.data[8]);
                        $('#edit-alat').find('#preview-edit').attr({src:http + 'assets/img/alat/' + res.alat.data[8], style: 'display: block;'});
                    } else {
                        hideLoading();
                        alertWarning(res.alat.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#table_alat").on('click', '#detail', function (e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        var body = $('#detail-table').empty();

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
                    if (res.alat.code == 1) {
                        hideLoading();
                        $('#detailModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let stts = res.alat.data[12] == 1 ? '<label class="label label-success">Bagus</label>' : '<label class="label label-danger">Buruk</label>';
                        let tr_str = '';
                        tr_str += "<tr><td colspan=\"2\"><img class=\"img-responsive\" style=\"max-height: 250px;\" width=\"100%\" src=\""+ http + 'assets/img/alat/' +res.alat.data[0] + "\"></td></tr>" +
                                  "<tr><td style=\"width: 25% !important;\">Kode Alat</td><td>" + res.alat.data[1] + "</td></tr>" +
                                  "<tr><td>Nama Alat</td><td>" + res.alat.data[2] + "</td></tr>" +
                                  "<tr><td>Tipe</td><td>" + res.alat.data[3] + "</td></tr>" +
                                  "<tr><td>Jumlah Bagus</td><td>" + res.alat.data[4] + " " +res.alat.data[8] +"</td></tr>" +
                                  "<tr><td>Jumlah Rusak</td><td>" + res.alat.data[5] + " " +res.alat.data[8] +"</td></tr>" +
                                  "<tr><td>Jumlah Hilang</td><td>" + res.alat.data[6] + " " +res.alat.data[8] +"</td></tr>" +
                                  "<tr><td>Jumlah Stok</td><td>" + res.alat.data[7] + " " +res.alat.data[8] +"</td></tr>" +
                                  "<tr><td>Harga Jual</td><td> Rp. " + formatAngka(res.alat.data[9]) + "</td></tr>" +
                                  "<tr><td>Harga Beli</td><td> Rp. " + formatAngka(res.alat.data[10]) + "</td></tr>" +
                                  "<tr><td>Lokasi</td><td>" + res.alat.data[11] + "</td></tr>" +
                                  "<tr><td>Kondisi</td><td>" + stts + "</td></tr>" +
                                  "<tr><td>Deskripsi</td><td>" + res.alat.data[13] + "</td></tr>" +
                                  "<tr><td>Tanggal Masuk</td><td>" + moment(res.alat.data[14]).format("dddd, DD-MMMM-YYYY HH:mm:ss") + "</td></tr>" + 
                                  "<tr><td>Tanggal Pembaharuan</td><td>" + moment(res.alat.data[15]).format("dddd, DD-MMMM-YYYY HH:mm:ss") + "</td></tr>";

                        $('#detail-table').append(tr_str);
                    } else {
                        hideLoading();
                        alertWarning(res.alat.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#table_alat").on('click', '#hapus', function (e) {
        e.preventDefault();
        var nm = $(this).attr('title-content');
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        Swal.fire({
            title: 'Apa Anda Yakin?',
            html: 'Menghapus data alat <b>' + nm + '</b> ?',
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
                    url: http + 'fetch?f='+remote+'&d='+uuid+'&id='+uid,
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
                            if (res.alat.code == 1) {
                                hideLoading();
                                dataTable.ajax.reload();
                                alertSuccess(res.alat.message);
                            } else {
                                hideLoading();
                                alertWarning(res.alat.message);
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

    $('#table_alat').on('click', '#penggunaan', function(e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        var body = $('#penggunaan-table').empty();
        $a = $('#penggunaan-alat').find('input[type=hidden],input[type=text], select, textarea');
        $b = $('#penggunaan-alat').find('input[name=stok_penggunaan]');

        $.ajax({
            url: http + 'fetch?f='+remote+'&d='+uuid+'&id='+uid,
            type: 'GET',
            async: true,
            dataType: 'json',
            beforeSend: function () {
                showLoading();
            },
            success: function(res) {
                if (res.length == 0) {
                    hideLoading();
                    alertDanger('Invalid request');
                } else {
                    if (res.alat.code == 1) {
                        hideLoading();
                        $('#penggunaanModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let tr_str = '';
                        tr_str += "<tr><td style=\"width: 25% !important;\">Kode Alat</td><td>" + res.alat.data[4] + "</td></tr>" +
                                  "<tr><td>Nama Alat</td><td>" + res.alat.data[5] + "</td></tr>" +
                                  "<tr><td>Jumlah Stok</td><td>" + res.alat.data[6] + " " +res.alat.data[7] +"</td></tr>";
                        $('#penggunaan-table').append(tr_str);
                        $b.eq(0).val(res.alat.data[6]);
                        for (let i = 0; i < $a.length - 1; i++) {
                            $a.eq(i).val(res.alat.data[i]);
                        }
                    } else {
                        hideLoading();
                        alertWarning(res.alat.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#download_alat").on('click', function (e) {
        e.preventDefault();
        var rule = $(this).attr('data-remote');
        var uuid = $(this).attr('data-target');
        $.ajax({
            url: http + 'fetch?f='+rule+'&d='+uuid+'&tipe=alat',
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
                        $('#download-alat h4.pull-right').html('Jumlah data sebanyak : ' + res.download.count + ' alat.');
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

    $('#filter').on('click change', function() {
        $a = $(this);
        if ($a.val() == 3) {
            $('#range').prop('disabled',false).focus();
        } else {
            $('#range').val('').attr('disabled',true).closest('.form-group').removeClass('has-success');
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
      }, function(start, end, label) {
        //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
});