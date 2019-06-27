$(function() {
    var tagnyo = $('.notifications-menu');
    var remote = tagnyo.attr('data-remote');
    var target = tagnyo.attr('data-target');

    var a = $('ul.nav').children()[0].children;
    var no = a[0].children[1];
    var header = a[1].children[0];
    var item = $('ul.menu');

    function formatAngka(angka) {
        if (typeof (angka) != 'string') angka = angka.toString();
        var reg = new RegExp('([0-9]+)([0-9]{3})');
        while (reg.test(angka)) angka = angka.replace(reg, '$1.$2');
        return angka;
    }

    setInterval(function () {
        $.ajax({
            url: http + 'fetch?f=' + remote + '&d=' + target,
            async: true,
            dataType: 'json',
            type: 'POST',
            beforeSend: function() {
                item.empty();
            },
            success: function(res) {
                response(res)
            },
        });
    }, 2000);

    function response(res) {
        if (res.length == 0) {
            hideLoading();
        } else {
            let li_str = '';
            if (res.notifikasi.code) {
                for (let i = 0; i < res.notifikasi.data.length; i++) {
                    var msg = res.notifikasi.data[i].msg;
                    var code = res.notifikasi.data[i].code;
                    var trgt = res.notifikasi.data[i].trgt;
                    li_str +=   "<li>" + 
                                    "<a href=\"javascript:void()\" id=\"detail-notif\" data-target=\"" + trgt + "\" data-content=\"" + code + "\">" + 
                                        "<i class=\"fa fa-warning text-yellow\"></i> " + msg + "" + 
                                    "</a>" + 
                                "</li>";
                }
                no.textContent = res.notifikasi.data.length;
                header.textContent = "Kamu memiliki " +res.notifikasi.data.length+ " notifikasi";
            } else {
                var msg = res.notifikasi.message;
                no.textContent = 0;
                header.textContent = "Kamu tidak memiliki notifikasi";
                li_str +=   "<li>" + 
                                    "<a href=\"javascript:void()\">" + 
                                        "<i class=\"fa fa-warning text-yellow\"></i> " + msg + "" + 
                                    "</a>" + 
                                "</li>";
            }
            item.prepend(li_str);
        }
    }

    $(document).on('click','#detail-notif', function(e) {
        e.preventDefault();
        var uuid = $(this).attr('data-target');
        var uid = $(this).attr('data-content');
        var pengembali = $('#detail-notifikasi').empty();
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
                } else {
                    if (res.notifikasi.code == 1) {
                        hideLoading();
                        $('#detailNotif').modal({
                            'show': true,
                            'backdrop': 'static'
                        });
                        let tr_pengembali = '';
                        tr_pengembali += "<tr><td style=\"width: 25% !important;\">Kode notifikasi</td><td>" + res.notifikasi.data.peminjam.code_return + "</td></tr>" +
                                         "<tr><td>Kode peminjaman</td><td>" + res.notifikasi.data.peminjam.code_loan + "</td></tr>" +
                                         "<tr><td>Nama Pengembali</td><td>" + res.notifikasi.data.peminjam.name + "</td></tr>" +
                                         "<tr><td>Ketepatan notifikasi</td><td>" + res.notifikasi.data.peminjam.pin + "</td></tr>" +
                                         "<tr><td>Lama peminjaman</td><td>" + res.notifikasi.data.peminjam.period + "</td></tr>" +
                                         "<tr><td>Penggantian rusak atau hilang</td><td>" + res.notifikasi.data.peminjam.change + "</td></tr>" +
                                         "<tr><td>Info keterlambatan</td><td>" + res.notifikasi.data.peminjam.info + "</td></tr>" +
                                         "<tr><td>Tanggal Pinjam</td><td>" + res.notifikasi.data.peminjam.pinjam + "</td></tr>" +
                                         "<tr><td>Tanggal Tempo</td><td>" + res.notifikasi.data.peminjam.due + "</td></tr>" +
                                         "<tr><td>Tanggal Dikembalikan</td><td>" + res.notifikasi.data.peminjam.create + "</td></tr>";
                        pengembali.append(tr_pengembali);

                        let tr_peralatan = '';
                        let jmlh = res.notifikasi.data.peralatan;
                        let no = 1;
                        let unit = null;
                        let total = 0;
                        let rusak = 0;
                        let hilang = 0;
                        for (let i = 0; i < jmlh.length; i++) {
                            unit = res.notifikasi.data.peralatan[i].unit;
                            tr_peralatan += "<tr>" +
                                                "<td>" + no + ".</td>" +
                                                "<td>" + res.notifikasi.data.peralatan[i].code_item + "</td>" +
                                                "<td>" + res.notifikasi.data.peralatan[i].name_item + "</td>" +
                                                "<td>" + res.notifikasi.data.peralatan[i].category + "</td>" +
                                                "<td>" + res.notifikasi.data.peralatan[i].amount + " " + unit + "</td>" +
                                                "<td>" + res.notifikasi.data.peralatan[i].broken_status + "</td>" +
                                                "<td style=\"text-align: center\">" + res.notifikasi.data.peralatan[i].broken_amount + " " + unit + "</td>" +
                                                "<td>" + res.notifikasi.data.peralatan[i].lost_status + "</td>" +
                                                "<td>" + res.notifikasi.data.peralatan[i].lost_amount + " " + unit + "</td>" +
                                            "</tr>";
                            total += parseInt(res.notifikasi.data.peralatan[i].amount);
                            rusak += parseInt(res.notifikasi.data.peralatan[i].broken_amount);
                            hilang += parseInt(res.notifikasi.data.peralatan[i].lost_amount);
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
                    }
                }
            },
        });
    });
});