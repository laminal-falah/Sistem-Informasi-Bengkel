$(function() {
    var remote = $('#table_cart').attr('data-remote');
    var target = $('#table_cart').attr('data-target');
    var tableCart = $('#list_cart');

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
        while (reg.test(angka)) angka = angka.replace(reg, '$1.$2');
        return angka;
    }

    $('.auto').autoNumeric('init', {
        aSep: '.',
        aDec: ',',
        vMin: '0',
        vMax: '9999999999'
    });

    // Hide modal & reset form
    $('[data-dismiss=modal]').on('click', function(e) {
        var $t = $(this),
            target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];
        $(target).find('.form-group').attr('class', 'form-group');
        $(target).find('label.has-error').remove();
        $(target)
            .find("input,textarea,select").val('').end()
            .find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
        $(target).find('#preview').attr({
            src: '',
            style: 'display: none'
        });
        closeModal();
    });

    // Animation modal bootstrap + library Animate.css
    function closeModal() {
        var timeoutHandler = null;
        $('#addModal,#editModal,#detailModal,#downloadModal').on('hide.bs.modal', function() {
            var anim = $('.modal-dialog').removeClass('zoomIn').addClass('zoomOut');
            if (timeoutHandler) clearTimeout(timeoutHandler);
            timeoutHandler = setTimeout(function() {
                $('.modal-dialog').removeClass('zoomOut').addClass('zoomIn');
            }, 750); // some delay for complete Animation
        });
        $('#detail-table').empty();
    }

    setInterval(cart(), 1000);
    tableCart.empty();
    function cart() {
        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + target,
            async: true,
            dataType: 'json',
            type: 'POST',
            beforeSend: function() {
                tableCart.empty();
            },
            success: function(response) {
                loadDatanyo(response);
            },
            error: function(jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    }

    function loadDatanyo(res) {
        if (res.length == 0) {
            hideLoading();
            alertDanger('Invalid request');
        } else {
            let tr_str = '';
            if (res.cart.code == 1) {
                if (res.cart.data.length > 0) {
                    let items = 0;
                    let total = 0;
                    for (let i = 0; i < res.cart.data.length; i++) {
                        let code = res.cart.data[i].code;
                        let max = res.cart.data[i].stock;
                        let price = res.cart.data[i].price;
                        let amount = res.cart.data[i].amount;
                        let tgt = res.cart.data[i].target;
                        let jmlh = "<input type=\"number\" id=\"jumlah\" name=\"jumlah[" + code + "]\" value=\"" + amount + "\" min=\"1\" max=\"" + max + "\" data-target=\"" + tgt + "\" required>";
                        let checkbox = "<input type=\"checkbox\" name=\"pilih[" + code + "]\" class=\"pilih\" value=\"" + code + "\">"
                        let sub = parseInt(amount) * parseInt(price);
                        tr_str += "<tr>" +
                            "<td>" + checkbox + "</td>" +
                            "<td>" + res.cart.data[i].name + "</td>" +
                            "<td>Rp. " + formatAngka(price) + "</td>" +
                            "<td>" + jmlh + "</td>" +
                            "<td>Rp. " + formatAngka(sub) + "</td>" +
                            "<td>" + res.cart.data[i].action + "</td>" +
                            "</tr>";
                        items += parseInt(amount);
                        total += sub;
                    }
                    tr_str += "<tr>" +
                        "<td colspan=\"3\" style=\"text-align: right !important;\">Jumlah Item</td>" +
                        "<td style=\"text-align: center !important;\" id=\"jumlah_item\">" + formatAngka(items) + "</td>" +
                        "<td id=\"jumlah_total\">Total Rp. " + formatAngka(total) + "</td>" +
                        "</tr>";
                } else {
                    tr_str += "<tr><td colspan=\"6\">Tidak ada data</td></tr>";
                }
            } else {
                hideLoading();
                tr_str += "<tr><td colspan=\"6\">Tidak ada data</td></tr>";
                alertWarning(res.cart.data);
            }
            tableCart.append(tr_str);
        }
    }

    $('#form-checkout').validate({
        errorClass: 'has-error animated tada',
        validClass: 'has-success',
        rules: {
            nama: {
                required: true,
                rangelength: [3, 35],
            },
            status: {
                required: true,
            }
        },
        messages: {
            nama: {
                required: "Nama Peminjam harus diisi !",
                rangelength: "Minimal 3 huruf dan Maksimal 35 huruf !",
            },
            status: {
                required: "Pilih status pembayaran !",
            }
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
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
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(errorClass).removeClass(validClass);
            $(element).next("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass(validClass).removeClass(errorClass);
            $(element).next("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
        },
        submitHandler: function(form) {
            var uuid = $('#form-checkout').attr('data-target');
            var sp = new FormData($(form)[0]);
            if (!validate()) return false;
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
                beforeSend: function() {
                    showLoading();
                },
                success: function(res) {
                    if (res.length == 0) {
                        hideLoading();
                        alertDanger('Invalid request');
                    } else {
                        if (res.cart.code == 1) {
                            hideLoading();
                            tableCart.empty();
                            $(form)[0].reset();
                            $(form).find('.form-group').removeClass('has-success');
                            window.setTimeout(function() {
                                window.location.href = res.cart.url;
                            }, 2500);
                            alertSuccess(res.cart.message);
                        } else {
                            hideLoading();
                            alertWarning(res.cart.message);
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

    $(document).on('change', '#all', function(e) {
        e.preventDefault();
        var checkbox = $('#list_cart tr td .pilih');
        if ($(this)[0].checked == true) {
            for (let i = 0; i < checkbox.length; i++) {
                checkbox[i].checked = true;
            }
        } else {
            for (let i = 0; i < checkbox.length; i++) {
                checkbox[i].checked = false;
            }
        }
    });

    $(document).on('change', '#list_cart tr td .pilih', function(e) {
        e.preventDefault();
        var a = $('#list_cart tr td .pilih');
        for (let i = 0; i < a.length; i++) {
            if (a[i].checked == false) {
                $('#all')[0].checked = false;
            }
        }
    });

    $(document).on('keyup change', '#list_cart tr td input[type=number]', function(e) {
        e.preventDefault();
        var hrg = $('#list_cart tr td:nth-child(3)');
        var sub = $('#list_cart tr td:nth-last-child(2)');
        var jlh = $('#list_cart tr td:nth-child(4) input#jumlah');

        let subtotal = 0;
        let total = 0;

        for (let i = 0; i < jlh.length; i++) {
            var a = hrg[i].textContent;
            var b = a.split(' ');
            var c = b[1].replace(/[.]/g, '');
            sub[i].innerText = 'Rp. ' + formatAngka(parseInt(jlh[i].value) * parseInt(c));
            subtotal += parseInt(jlh[i].value);
            updateJmlh(jlh[i]);
        }
        $('#jumlah_item')[0].innerText = formatAngka(subtotal);

        for (let i = 0; i < sub.length - 1; i++) {
            var a = sub[i].textContent;
            var b = a.split(' ');
            let c = b[1].replace(/[.]/g, '');
            total += parseInt(c);
        }
        $('#jumlah_total')[0].innerText = 'Total Rp. ' + formatAngka(total);
    });

    function updateJmlh(ubah) {
        var a = ubah.name;
        var b = a.split('[');
        var c = b[1].split(']');
        var code = c[0];
        var jmlh = ubah.value;
        var trgt = ubah.attributes[6].value;
        var timer = 0;
        clearTimeout(timer);
        timer = setTimeout(function() {
            $.ajax({
                url: http + 'fetch?f=' + remote + '&d=' + trgt + '&id=' + code,
                async: true,
                dataType: 'json',
                type: 'POST',
                data: {
                    "jumlah": jmlh
                },
                success: function(res) {}
            });
        }, timer);
    }

    function validate() {
        var valid = true;
        if ($('.pilih:checked').length <= 0) {
            alertWarning("Checklist item yang ingin dibeli !");
            valid = false;
        } else {
            valid = true;
        }
        return valid;
    }

    jQuery.noConflict();


    $("#table_cart").on('click', '#detail', function(e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        var body = $('#detail-table').empty();

        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + uuid + '&id=' + uid,
            type: 'GET',
            async: true,
            dataType: 'json',
            beforeSend: function() {
                showLoading();
            },
            success: function(res) {
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
                        tr_str += "<tr><td colspan=\"2\"><img class=\"img-responsive\" style=\"max-height: 250px;\" width=\"100%\" src=\"" + http + 'assets/img/alat/' + res.alat.data[0] + "\"></td></tr>" +
                            "<tr><td style=\"width: 25% !important;\">Kode Alat</td><td>" + res.alat.data[1] + "</td></tr>" +
                            "<tr><td>Nama Alat</td><td>" + res.alat.data[2] + "</td></tr>" +
                            "<tr><td>Tipe</td><td>" + res.alat.data[3] + "</td></tr>" +
                            "<tr><td>Jumlah Bagus</td><td>" + res.alat.data[4] + " " + res.alat.data[8] + "</td></tr>" +
                            "<tr><td>Jumlah Rusak</td><td>" + res.alat.data[5] + " " + res.alat.data[8] + "</td></tr>" +
                            "<tr><td>Jumlah Hilang</td><td>" + res.alat.data[6] + " " + res.alat.data[8] + "</td></tr>" +
                            "<tr><td>Jumlah Stok</td><td>" + res.alat.data[7] + " " + res.alat.data[8] + "</td></tr>" +
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
            error: function(jqXHR, status, error) {
                hideLoading();
                alertDanger(status);
            }
        });
    });

    $("#table_cart").on('click', '#hapus', function(e) {
        e.preventDefault();
        var nm = $(this).attr('title-content');
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        Swal.fire({
            title: 'Apa Anda Yakin?',
            html: 'Menghapus item <b>' + nm + '</b> dari keranjang?',
            type: 'warning',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function(isConfirm) {
            if (isConfirm.value) {
                $.ajax({
                    url: http + 'fetch?f=' + remote + '&d=' + uuid + '&id=' + uid,
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    processData: false,
                    contentType: false,
                    timeout: 3000,
                    beforeSend: function() {
                        showLoading();
                    },
                    success: function(res) {
                        if (res.length == 0) {
                            hideLoading();
                            alertDanger('Invalid request');
                        } else {
                            if (res.cart.code == 1) {
                                hideLoading();
                                cart();
                                alertSuccess(res.cart.message);
                            } else {
                                hideLoading();
                                alertWarning(res.cart.message);
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
    });

});