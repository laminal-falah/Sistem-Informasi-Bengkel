$(function() {

    moment.locale("id");
    var remote = $('#table_user').attr('data-remote');
    var target = $('#table_user').attr('data-target');
    var addNip = $('#add-user').find('#nip').attr('data-target');
    var editNip = $('#edit-user').find('#nip').attr('data-target');
    var addUser = $('#add-user').find('#username').attr('data-target');
    var editUser = $('#edit-user').find('#username').attr('data-target');
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
    }

    $.validator.addMethod("hurufbae", function(value, element) {
        return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
    });
    $.validator.addMethod("usernamenyo", function(value, element) {
        return this.optional(element) || /^[a-z0-9_]*$/.test(value);
    });

    // Hide modal & reset form
    $('[data-dismiss=modal]').on('click', function (e) {
        var $t = $(this), target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];
        $(target).find('.form-group').attr('class','form-group');
        $(target).find('label.has-error').remove();
        $(target)
            .find("input,textarea,select").val('').end()
            .find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
        closeModal();
    });

    // Animation modal bootstrap + library Animate.css
    function closeModal() {
        var timeoutHandler = null;
        $('#addModal,#editModal,#detailModal,#downloadModal').on('hide.bs.modal', function (e) {
            var anim = $('.modal-dialog').removeClass('zoomIn').addClass('zoomOut');
            if (timeoutHandler) clearTimeout(timeoutHandler);
            timeoutHandler = setTimeout(function() {
                $('.modal-dialog').removeClass('zoomOut').addClass('zoomIn');
            }, 250); // some delay for complete Animation
        });
    }

    // Validation User Start // 
    $('#add-user').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
            nip: {
                required: true,
                rangelength: [18,18],
                digits: true,
                remote: {
                    url: http + 'fetch?f='+remote+'&d='+addNip,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        nip: function() {
                            return $('#add-user').find("#nip" ).val();
                        }
                    }
                }
            },
            nama: {
                required: true,
                rangelength: [3, 35],
                hurufbae: true,
            },
            level: {
                required: true,
            },
            status: {
                required: true,
            },
            username: {
                required: true,
                rangelength: [8,20],
                usernamenyo: true,
                remote: {
                    url: http + 'fetch?f='+remote+'&d='+addUser,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        username: function() {
                            return $('#add-user').find("#username" ).val();
                        }
                    }
                }
            },
            password: {
                required: true,
                rangelength: [8,25],
            },
            password_confirm: {
                required: true,
                rangelength: [8,25],
                equalTo: '#password1',
            }
        },
        messages: {
            nip: {
                required: "NIP harus diisi !",
                rangelength: "NIP harus 18 digit angka !",
                digits: "Tidak boleh mengandung simbol lain selain angka !",
                remote: "NIP telah digunakan !"
            },
            nama: {
                required: "Nama harus diisi !",
                rangelength: "Minimal 3 huruf dan Maksimal 25 huruf !",
                hurufbae: "Tidak boleh mengandung simbol lain selain huruf !",
            },
            level: {
                required: "Silahkan pilih level akun !",
            },
            status: {
                required: "Silahan pilih status akun !",
            },
            username: {
                required: "Username harus diisi !",
                rangelength: "Minimal 8 karakter dan maksimal 25 karakter !",
                usernamenyo: "Gunakan huruf kecil atau angka atau <i>Underscore</i> _",
                remote: "Username telah digunakan !"
            },
            password: {
                required: "Password harus diisi",
                rangelength: "Minimal password 8 karakter dan maksimal 25 karakter",
            },
            password_confirm: {
                required: "Konfirmasi password harus diisi",
                rangelength: "Minimal password 8 karakter dan maksimal 25 karakter",
                equalTo: "Konfirmasi password harus sama dengan field password",
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
            var uuid = $('#add-user').attr('data-target');
            var user = new FormData($('#add-user')[0]);
            $.ajax({
                url: http + 'fetch?f='+remote+'&d='+uuid,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: user,
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    if (res.length == 0) {
                        hideLoading();
                        alertDanger('Invalid request');
                    } else {
                        if (res.user.code == 1) {
                            ajaxSuccess('#add-user');
                            dataTable.ajax.reload();
                            hideLoading();
                            alertSuccess(res.user.message);
                        } else {
                            hideLoading();
                            alertWarning(res.user.message);
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

    $('#edit-user').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
            nip: {
                required: true,
                rangelength: [18,18],
                digits: true,
                remote: {
                    url: http + 'fetch?f='+remote+'&d='+editNip,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: function() { 
                            return $('#edit-user').find('input[type=hidden]').val();
                        },
                        nip: function() {
                            return $('#edit-user').find("#nip").val();
                        }
                    }
                }
            },
            nama: {
                required: true,
                rangelength: [3, 35],
                hurufbae: true,
            },
            level: {
                required: true,
            },
            status: {
                required: true,
            },
            username: {
                required: false,
                rangelength: [8,20],
                usernamenyo: true,
                remote: {
                    url: http + 'fetch?f='+remote+'&d='+editUser,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: function() { 
                            return $('#edit-user').find('input[type=hidden]').val();
                        },
                        username: function() {
                            return $('#edit-user').find("#username" ).val();
                        }
                    }
                }
            },
        },
        messages: {
            nip: {
                required: "NIP harus diisi !",
                rangelength: "NIP harus 18 digit angka !",
                digits: "Tidak boleh mengandung simbol lain selain angka !",
                remote: "NIP telah digunakan !"
            },
            nama: {
                required: "Nama harus diisi !",
                rangelength: "Minimal 3 huruf dan Maksimal 25 huruf !",
                hurufbae: "Tidak boleh mengandung simbol lain selain huruf !",
            },
            level: {
                required: "Silahkan pilih level akun !",
            },
            status: {
                required: "Silahan pilih status akun !",
            },
            username: {
                required: "Username harus diisi !",
                rangelength: "Minimal 8 karakter dan maksimal 25 karakter !",
                usernamenyo: "Gunakan huruf kecil atau angka atau <i>Underscore</i> _",
                remote: "Username telah digunakan !"
            },
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
            var uuid = $('#edit-user').attr('data-target');
            var user = new FormData($('#edit-user')[0]);
            var uid = $('#edit-user').find('input[type=hidden]').val();
            $.ajax({
                url: http + 'fetch?f='+remote+'&d='+uuid+'&id='+uid,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 3000,
                data: user,
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    if (res.length == 0) {
                        hideLoading();
                        alertDanger('Invalid request');
                    } else {
                        if (res.user.code == 1) {
                            ajaxSuccess('#edit-user');
                            dataTable.ajax.reload();
                            hideLoading();
                            alertSuccess(res.user.message);
                        } else {
                            hideLoading();
                            alertWarning(res.user.message);
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

    $('#download-user').validate({
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
            var page = $('#download-user').attr('data-remote');
            var uuid = $('#download-user').attr('data-target');
            var pdf = new FormData($('#download-user')[0]);
            var uid = "user";
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
                            ajaxSuccess('#download-user');
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
    })
    // Validation User End //

    var dataTable = $("#table_user").DataTable({
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
                $("#table_user_processing").addClass("text-center").html('<i class="fa fa-spinner fa-pulse fa-fw text-blue"></i>&nbsp;<span>Memuat Data...</span>');
            },
            error: function () {
                $(".table_user-error").html("");
                $("#table_user").append('<tbody class="table_user-error"><tr><td colspan="7" class="text-center">Tidak ada data</td></tr></tbody>');
                $("#table_user_processing").css('display', 'none');
            }
        },
        "pageLength": 10,
        "order": [
            [0,"desc"]
        ],
        columnDefs: [
            {
                orderable: true,
                targets: [0,1,2,3,4,5]
            },
            {
                orderable: false,
                targets: [6]
            },
            {
                searchable: true,
                targets: [1,2,3]
            },
            {
                searchable: false,
                targets: [0,4,5,6]
            }
        ],
        "lengthMenu": [ 
            [5, 10, 25, 50, 100, -1], 
            [5, 10, 25, 50, 100, "Semua"]
        ]
    });

    $("#table_user_filter").addClass("pull-right");
    $("#table_user_paginate").addClass("pull-right");
    
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

    $("#create_user").on('click', function (e) {
        e.preventDefault();
        $('#addModal').modal({
            'show': true,
            'backdrop': 'static'
        });
    });

    $("#table_user").on('click', '#edit', function (e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        $a = $('#edit-user').find('input[type=hidden],input[type=text], select, textarea');

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
                    if (res.user.code == 1) {
                        hideLoading();
                        $('#editModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        for (let i = 0; i < $a.length; i++) {
                            $a.eq(i).val(res.user.data[i]);
                        }
                    } else {
                        hideLoading();
                        alertWarning(res.user.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#table_user").on('click', '#detail', function (e) {
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
                    if (res.user.code == 1) {
                        hideLoading();
                        $('#detailModal').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let stts = res.user.data.status == 1 ? '<label class="label label-success">Aktif</label>' : '<label class="label label-danger">Tidak Aktif</label>';
                        let tr_str = '';
                        tr_str += "<tr><td style=\"width: 25% !important;\">NIP</td><td>" + res.user.data.nip + "</td></tr>" +
                            "<tr><td>Nama</td><td>" + res.user.data.name + "</td></tr>" +
                            "<tr><td>Username</td><td>" + res.user.data.username + "</td></tr>" +
                            "<tr><td>Level</td><td>" + capitalizeFirstLetter(res.user.data.name_rule).replace('_'," ") + "</td></tr>" +
                            "<tr><td>Status</td><td>" + stts + "</td></tr>" +
                            "<tr><td>Tanggal Buat Akun</td><td>" + moment(res.user.data.created_at).format("dddd, DD-MMMM-YYYY HH:mm:ss") + "</td></tr>";

                        $('#detail-table').append(tr_str);
                    } else {
                        hideLoading();
                        alertWarning(res.user.message);
                    }
                }
            },
            error: function (jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#table_user").on('click', '#hapus', function (e) {
        e.preventDefault();
        var nm = $(this).attr('title-content');
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        Swal.fire({
            title: 'Apa Anda Yakin?',
            html: 'Menghapus data user <b>' + nm + '</b> ?',
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
                    beforeSend: function () {
                        showLoading();
                    },
                    success: function (res) {
                        if (res.length == 0) {
                            hideLoading();
                            alertDanger('Invalid request');
                        } else {
                            if (res.user.code == 1) {
                                hideLoading();
                                dataTable.ajax.reload();
                                alertSuccess(res.user.message);
                            } else {
                                hideLoading();
                                alertWarning(res.user.message);
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

    $("#table_user").on('click', '#reset', function (e) {
        e.preventDefault();
        var nm = $(this).attr('title-content');
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');

        Swal.fire({
            title: 'Apa Anda Yakin?',
            html: 'Mereset password User <b>' + nm + '</b> ?',
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
                    beforeSend: function () {
                        showLoading();
                    },
                    success: function (res) {
                        if (res.length == 0) {
                            hideLoading();
                            alertDanger('Invalid request');
                        } else {
                            if (res.user.code == 1) {
                                hideLoading();
                                dataTable.ajax.reload();
                                alertSuccess(res.user.message)
                            } else {
                                hideLoading();
                                alertWarning(res.user.message);
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

    $("#download_user").on('click', function (e) {
        e.preventDefault();
        var rule = $(this).attr('data-remote');
        var uuid = $(this).attr('data-target');
        $.ajax({
            url: http + 'fetch?f='+rule+'&d='+uuid+'&tipe=user',
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
                        $('#download-user h4.pull-right').html('Jumlah data sebanyak : ' + res.download.count + ' user.');
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