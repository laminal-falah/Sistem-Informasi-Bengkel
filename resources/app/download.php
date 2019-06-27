<?php
    session_start();
    require_once '../path.php';
    require_once (ABSPATH . '../config/config.php');
    require_once (ABSPATH . '../config/database.php');
    require_once (ABSPATH . '../config/pdf.php');
    require_once (ABSPATH . '../config/enkripsi.php');
    require_once (ABSPATH . '../config/functions.php');
    $file = hash('sha1',strtotime('now'));
    header('Content-type: application/pdf');
    header('Content-type: application/force-download');

    if (!isset($_SESSION['is_logged'])) {
        echo "<script>window.location.href= '".$url."login/';</script>";
        exit();
    } else {
        if (isset($_GET['f']) && isset($_GET['d'])) {
            $f = base64_decode($_GET['f']);
            $d = base64_decode($_GET['d']);
    
            if ($f == $enc['data-user']['remote'] && $d == $enc['data-user']['download'] && isset($_GET['start']) && isset($_GET['end']) && isset($_GET['filter']) && isset($_GET['range'])) {
                $awal = $_GET['start'];
                $akhir = $_GET['end'];
                $filter = $_GET['filter'];
                $sql = "SELECT nip,name,username,name_rule,status,created_at FROM tb_users AS u INNER JOIN tb_rules AS r ON r.id_rule = u.id_rule";
                $res = "";
                $pdf = new PDF('P','cm','A4');
                if ($filter == 1) {
                    $day = date('d',strtotime('now'));
                    $sql .= " WHERE DAY(created_at) = '$day' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan harian data user pada hari ".tanggal(date('N-Y-n-d',strtotime('now'))));
                } 
                elseif ($filter == 2) {
                    $mnt = date('m',strtotime('now'));
                    $yr = date('Y',strtotime('now'));
                    $sql .= " WHERE MONTH(created_at) = '$mnt' AND YEAR(created_at) = '$yr' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan bulanan data user pada bulan ".bulan(date('m',strtotime('now')))." tahun ".$yr);
                }
                elseif ($filter == 3) {
                    $range = $_GET['range'];
                    $ganti = str_replace('/','-',$range);
                    $pch = explode(' - ',$ganti);
                    $range1 = strtotime($pch[0]);
                    $range2 = strtotime($pch[1]);
                    $sql .= " WHERE created_at BETWEEN FROM_UNIXTIME($range1) AND FROM_UNIXTIME($range2+(((60*60)*23)+(60*59))) LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan data user pada hari ".tanggal(date('N-Y-n-d',strtotime($pch[0])))." sampai dengan hari ".tanggal(date('N-Y-n-d',strtotime($pch[1]))));
                }
                else {
                    $pdf->setJudul("Laporan data user");
                    $sql .= " ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                }
                $pdf->AddPage();
                $pdf->AliasNbPages();
                $pdf->SetFont('Arial','B',8);
                $pdf->SetX(1);
                $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                $pdf->Cell(3.04,0.5,'NIP',1,0,'C');
                $pdf->Cell(3.73,0.5,'Nama',1,0,'C');
                $pdf->Cell(3.73,0.5,'Username',1,0,'C');
                $pdf->Cell(2.2,0.5,'Level',1,0,'C');
                $pdf->Cell(1.5,0.5,'Status',1,0,'C');
                $pdf->Cell(4,0.5,'Tanggal Buat Akun',1,1,'C');
                $pdf->SetFont('Arial','',6.5);
                $i = 1;
                while ($r = mysqli_fetch_assoc($res)) {
                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,$i++.".",1,0,'C');
                    $pdf->Cell(3.04,0.5,$r['nip'],1,0,'L');
                    $pdf->Cell(3.73,0.5,ucwords(substr($r['name'],0,25)),1,0,'L');
                    $pdf->Cell(3.73,0.5,$r['username'],1,0,'C');
                    $pdf->Cell(2.2,0.5,ucwords(str_replace("_"," ",$r['name_rule'])),1,0,'C');
                    $pdf->Cell(1.5,0.5,$r['status'] == 1 ? ucwords('aktif') : ucwords('tidak aktif'),1, 0,'C');
                    $pdf->Cell(4,0.5,date('d-m-Y H:i:s',strtotime($r['created_at'])),1, 1, 'C');
                }
                $pdf->Output('',$file.".pdf","I",true);
            } elseif ($f == $enc['data-alat']['remote'] && $d == $enc['data-alat']['download'] && isset($_GET['start']) && isset($_GET['end']) && isset($_GET['filter']) && isset($_GET['range'])) {
                $awal = $_GET['start'];
                $akhir = $_GET['end'];
                $filter = $_GET['filter'];
                $sql = "SELECT code_item,name_item,total_stock,status,location,name_unit,created_at FROM tb_items AS i INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit";
                $res = "";
                $pdf = new PDF('P','cm','A4');
                if ($filter == 1) {
                    $day = date('d',strtotime('now'));
                    $sql .= " WHERE code_category='alt' AND DAY(created_at) = '$day' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan harian data alat pada hari ".tanggal(date('N-Y-n-d',strtotime('now'))));
                } 
                elseif ($filter == 2) {
                    $mnt = date('m',strtotime('now'));
                    $yr = date('Y',strtotime('now'));
                    $sql .= " WHERE code_category='alt' AND MONTH(created_at) = '$mnt' AND YEAR(created_at) = '$yr' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan bulanan data alat pada bulan ".bulan(date('m',strtotime('now')))." tahun ".$yr);
                }
                elseif ($filter == 3) {
                    $range = $_GET['range'];
                    $ganti = str_replace('/','-',$range);
                    $pch = explode(' - ',$ganti);
                    $range1 = strtotime($pch[0]);
                    $range2 = strtotime($pch[1]);
                    $sql .= " WHERE code_category='alt' AND created_at BETWEEN FROM_UNIXTIME($range1) AND FROM_UNIXTIME($range2+(((60*60)*23)+(60*59))) LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan data alat pada hari ".tanggal(date('N-Y-n-d',strtotime($pch[0])))." sampai dengan hari ".tanggal(date('N-Y-n-d',strtotime($pch[1]))));
                }
                else {
                    $pdf->setJudul("Laporan data alat");
                    $sql .= " WHERE code_category='alt' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                }
                $pdf->AddPage();
                $pdf->AliasNbPages();
                $pdf->SetFont('Arial','B',8);
                $pdf->SetX(1);
                $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                $pdf->Cell(2.85,0.5,'Kode Alat',1,0,'C');
                $pdf->Cell(7.24,0.5,'Nama Alat',1,0,'C');
                $pdf->Cell(1.7,0.5,'Stok',1,0,'C');
                $pdf->Cell(1.5,0.5,'Kondisi',1,0,'C');
                $pdf->Cell(1.9,0.5,'Lokasi',1,0,'C');
                $pdf->Cell(3,0.5,'Keterangan',1,1,'C');
                $pdf->SetFont('Arial','',6.5);
                $i = 1;
                while ($r = mysqli_fetch_assoc($res)) {
                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,$i++.".",1,0,'C');
                    $pdf->Cell(2.85,0.5,$r['code_item'],1,0,'L');
                    $pdf->Cell(7.24,0.5,ucwords(substr($r['name_item'],0,25)),1,0,'L');
                    $pdf->Cell(1.7,0.5,$r['total_stock'] . " " . $r['name_unit'],1,0,'C');
                    $pdf->Cell(1.5,0.5,$r['status'] == 1 ? ucwords('baik') : ucwords('buruk'),1,0,'C');
                    $pdf->Cell(1.9,0.5,$r['location'],1, 0,'C');
                    $pdf->Cell(3,0.5,"",1, 1, 'C');
                }
                $pdf->Output('',$file.".pdf","I",true);
            } elseif ($f == $enc['data-sparepart']['remote'] && $d == $enc['data-sparepart']['download'] && isset($_GET['start']) && isset($_GET['end']) && isset($_GET['filter']) && isset($_GET['range'])) {
                $awal = $_GET['start'];
                $akhir = $_GET['end'];
                $filter = $_GET['filter'];
                $sql = "SELECT code_item,name_item,total_stock,status,location,name_unit,created_at FROM tb_items AS i INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit";
                $res = "";
                $pdf = new PDF('P','cm','A4');
                if ($filter == 1) {
                    $day = date('d',strtotime('now'));
                    $sql .= " WHERE code_category='smt' OR code_category='smb' AND DAY(created_at) = '$day' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan harian data sparepart pada hari ".tanggal(date('N-Y-n-d',strtotime('now'))));
                } 
                elseif ($filter == 2) {
                    $mnt = date('m',strtotime('now'));
                    $yr = date('Y',strtotime('now'));
                    $sql .= " WHERE code_category='smt' OR code_category='smb' AND MONTH(created_at) = '$mnt' AND YEAR(created_at) = '$yr' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan bulanan data sparepart pada bulan ".bulan(date('m',strtotime('now')))." tahun ".$yr);
                }
                elseif ($filter == 3) {
                    $range = $_GET['range'];
                    $ganti = str_replace('/','-',$range);
                    $pch = explode(' - ',$ganti);
                    $range1 = strtotime($pch[0]);
                    $range2 = strtotime($pch[1]);
                    $sql .= " WHERE code_category='smt' OR code_category='smb' AND created_at BETWEEN FROM_UNIXTIME($range1) AND FROM_UNIXTIME($range2+(((60*60)*23)+(60*59))) LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan data sparepart pada hari ".tanggal(date('N-Y-n-d',strtotime($pch[0])))." sampai dengan hari ".tanggal(date('N-Y-n-d',strtotime($pch[1]))));
                }
                else {
                    $pdf->setJudul("Laporan data sparepart");
                    $sql .= " WHERE code_category='smt' OR code_category='smb' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                }
                $pdf->AddPage();
                $pdf->AliasNbPages();
                $pdf->SetFont('Arial','B',8);
                $pdf->SetX(1);
                $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                $pdf->Cell(2.85,0.5,'Kode Sparepart',1,0,'C');
                $pdf->Cell(7.24,0.5,'Nama Sparepart',1,0,'C');
                $pdf->Cell(1.7,0.5,'Stok',1,0,'C');
                $pdf->Cell(1.5,0.5,'Kondisi',1,0,'C');
                $pdf->Cell(1.9,0.5,'Lokasi',1,0,'C');
                $pdf->Cell(3,0.5,'Keterangan',1,1,'C');
                $pdf->SetFont('Arial','',6.5);
                $i = 1;
                while ($r = mysqli_fetch_assoc($res)) {
                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,$i++.".",1,0,'C');
                    $pdf->Cell(2.85,0.5,$r['code_item'],1,0,'L');
                    $pdf->Cell(7.24,0.5,ucwords(substr($r['name_item'],0,25)),1,0,'L');
                    $pdf->Cell(1.7,0.5,$r['total_stock'] . " " . $r['name_unit'],1,0,'C');
                    $pdf->Cell(1.5,0.5,$r['status'] == 1 ? ucwords('baik') : ucwords('buruk'),1,0,'C');
                    $pdf->Cell(1.9,0.5,$r['location'],1, 0,'C');
                    $pdf->Cell(3,0.5,"",1, 1, 'C');
                }
                $pdf->Output('',$file.".pdf","I",true);
            } elseif ($f == $enc['data-peminjaman']['remote'] && $d == $enc['data-peminjaman']['download'] && isset($_GET['start']) && isset($_GET['end']) && isset($_GET['filter']) && isset($_GET['range'])) {
                $awal = $_GET['start'];
                $akhir = $_GET['end'];
                $filter = $_GET['filter'];
                $sql = "SELECT * FROM tb_loan";
                $res = "";
                $pdf = new PDF('P','cm','A4');
                if ($filter == 1) {
                    $day = date('d',strtotime('now'));
                    $sql .= " WHERE DAY(created_at) = '$day' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan harian data peminjaman pada hari ".tanggal(date('N-Y-n-d',strtotime('now'))));
                } 
                elseif ($filter == 2) {
                    $mnt = date('m',strtotime('now'));
                    $yr = date('Y',strtotime('now'));
                    $sql .= " WHERE MONTH(created_at) = '$mnt' AND YEAR(created_at) = '$yr' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan bulanan data peminjaman pada bulan ".bulan(date('m',strtotime('now')))." tahun ".$yr);
                }
                elseif ($filter == 3) {
                    $range = $_GET['range'];
                    $ganti = str_replace('/','-',$range);
                    $pch = explode(' - ',$ganti);
                    $range1 = strtotime($pch[0]);
                    $range2 = strtotime($pch[1]);
                    $sql .= " WHERE created_at BETWEEN FROM_UNIXTIME($range1) AND FROM_UNIXTIME($range2+(((60*60)*23)+(60*59))) LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan data peminjaman pada hari ".tanggal(date('N-Y-n-d',strtotime($pch[0])))." sampai dengan hari ".tanggal(date('N-Y-n-d',strtotime($pch[1]))));
                }
                else {
                    $pdf->setJudul("Laporan data peminjaman");
                    $sql .= " ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                }
                $pdf->AddPage();
                $pdf->AliasNbPages();
                $pdf->SetFont('Arial','B',8);
                $no = 1;
                while ($r = mysqli_fetch_assoc($res)) {
                    $status = $r['status'];
                    if ($status == 1) {
                        $msg = 'Telah dikembalikan';
                    } else {
                        $today = new DateTime(date('Y-m-d H:i:s',strtotime('now')));
                        $exp = new DateTime(date('Y-m-d H:i:s',strtotime($r["due_date"])));
                        if ($today > $exp) {
                            $msg = 'Telah lewat jatuh tempo';
                        } else {
                            $msg = 'Masih dipinjam';
                        }
                    }
                    $pdf->SetX(1);
                    $pdf->Cell(0.62,0.5,'No.',0,0,'L');
                    $pdf->Cell(2.85,0.5,$no,0,1,'L');
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Kode Peminjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$r['code_loan'],0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Nama Peminjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords($r['name_loan']),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Tanggal Peminjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i:s',strtotime($r['created_at'])),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Tanggal Tempo',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i:s',strtotime($r['due_date'])),0,1,'L');
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Status Pinjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$msg,0,1,'L');

                    $pdf->ln(0.25);

                    // table
                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                    $pdf->Cell(4.7,0.5,'Kode Peralatan',1,0,'C');
                    $pdf->Cell(7.3,0.5,'Nama Peralatan',1,0,'C');
                    $pdf->Cell(4.7,0.5,'Jenis Peralatan',1,0,'C');
                    $pdf->Cell(1.5,0.5,'Jumlah',1,1,'C');
                    
                    $kode = $r['code_loan'];
                    $sqlTable ="SELECT d.code_item,name_item,name_category,amount FROM tb_loan_details AS d
                                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                                WHERE d.code_loan='$kode'";
                    $tablenyo = mysqli_query($link,$sqlTable);
                    $pdf->SetFont('Arial','',6.5);
                    $total = 0;
                    if (mysqli_num_rows($tablenyo) > 0) {
                        $t = 1;
                        while ($row = mysqli_fetch_assoc($tablenyo)) {
                            $pdf->SetX(1);
                            $pdf->Cell(0.8,0.5,$t,1,0,'C');
                            $pdf->Cell(4.7,0.5,$row['code_item'],1,0,'C');
                            $pdf->Cell(7.3,0.5,ucwords($row['name_item']),1,0,'C');
                            $pdf->Cell(4.7,0.5,ucwords($row['name_category']),1,0,'C');
                            $pdf->Cell(1.5,0.5,$row['amount'],1,1,'C');
                            $total+=$row['amount'];
                            $t++;
                        }
                    } else {
                        $pdf->SetX(1);
                        $pdf->Cell(19,0.5,'Data tidak tersedia',1,1,'C');
                    }
                    $pdf->SetX(1);
                    $pdf->Cell(17.5,0.5,'Jumlah Peralatan yang dipinjam',1,0,'R');
                    $pdf->Cell(1.5,0.5,$total,1,1,'C');

                    $pdf->ln(0.25);
                    $pdf->SetFont('Arial','B',8);
                    $no++;
                }
                $pdf->Output('',$file.".pdf","I",true);
            } elseif ($f == $enc['data-pengembalian']['remote'] && $d == $enc['data-pengembalian']['download'] && isset($_GET['start']) && isset($_GET['end']) && isset($_GET['filter']) && isset($_GET['range'])) {
                $awal = $_GET['start'];
                $akhir = $_GET['end'];
                $filter = $_GET['filter'];
                $sql = "SELECT code_return, r.code_loan, name_return, pin, long_period, penalty, rechange, info, l.created_at AS pinjam, due_date, r.created_at FROM tb_return AS r
                        INNER JOIN tb_loan AS l ON l.code_loan = r.code_loan";
                $res = "";
                $pdf = new PDF('P','cm','A4');
                if ($filter == 1) {
                    $day = date('d',strtotime('now'));
                    $sql .= " WHERE DAY(r.created_at) = '$day' ORDER BY r.created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan harian data pengembalian pada hari ".tanggal(date('N-Y-n-d',strtotime('now'))));
                } 
                elseif ($filter == 2) {
                    $mnt = date('m',strtotime('now'));
                    $yr = date('Y',strtotime('now'));
                    $sql .= " WHERE MONTH(r.created_at) = '$mnt' AND YEAR(r.created_at) = '$yr' ORDER BY r.created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan bulanan data pengembalian pada bulan ".bulan(date('m',strtotime('now')))." tahun ".$yr);
                }
                elseif ($filter == 3) {
                    $range = $_GET['range'];
                    $ganti = str_replace('/','-',$range);
                    $pch = explode(' - ',$ganti);
                    $range1 = strtotime($pch[0]);
                    $range2 = strtotime($pch[1]);
                    $sql .= " WHERE r.created_at BETWEEN FROM_UNIXTIME($range1) AND FROM_UNIXTIME($range2+(((60*60)*23)+(60*59))) LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan data pengembalian pada hari ".tanggal(date('N-Y-n-d',strtotime($pch[0])))." sampai dengan hari ".tanggal(date('N-Y-n-d',strtotime($pch[1]))));
                }
                else {
                    $pdf->setJudul("Laporan data pengembalian");
                    $sql .= " ORDER BY r.created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                }
                $pdf->AddPage();
                $pdf->AliasNbPages();
                $pdf->SetFont('Arial','B',8);
                $no = 1;
                while ($r = mysqli_fetch_assoc($res)) {
                    $pin = $r['pin'] == 1 ? 'Tepat waktu' : 'Terlambat';
                    if ($r['rechange'] == 2) {
                        $change = 'Sudah diganti';
                    } elseif ($r['rechange'] == 1) {
                        $change = 'Belum diganti';
                    } else {
                        $change = 'Tidak ada penggantian';
                    }
                    $pdf->SetX(1);
                    $pdf->Cell(0.62,0.5,'No.',0,0,'L');
                    $pdf->Cell(2.85,0.5,$no,0,1,'L');
                    
                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Kode Pengembalian',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$r['code_return'],0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Kode Peminjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$r['code_loan'],0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Nama Pengembali',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords($r['name_return']),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Ketepatan Pengembalian',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords($pin),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Lama Peminjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords($r['long_period']),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Penggantian rusak atau hilang',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords($change),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Info',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords(strip_tags($r['info'])),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Tanggal Peminjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i',strtotime($r['pinjam'])),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Tanggal Tempo',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i',strtotime($r['due_date'])),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Tanggal Dikembalikan',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i',strtotime($r['created_at'])),0,1,'L');
                    
                    $pdf->ln(0.25);

                    // table
                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                    $pdf->Cell(7.3,0.5,'Nama Peralatan',1,0,'C');
                    $pdf->Cell(2.5,0.5,'Jumlah Pinjam',1,0,'C');
                    $pdf->Cell(4.2,0.5,'Ket. Rusak/Hilang',1,0,'C');
                    $pdf->Cell(4.2,0.5,'Jumlah Rusak/Hilang',1,1,'C');

                    $kode = $r['code_return'];
                    $sqlTable ="SELECT name_item,amount_loan,broken_amount,broken_status,lost_amount,lost_status,name_unit FROM tb_return_details AS d
                                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                                WHERE d.code_return='$kode'";
                    $tablenyo = mysqli_query($link,$sqlTable);
                    $pdf->SetFont('Arial','',6.5);
                    $total = 0;
                    if (mysqli_num_rows($tablenyo) > 0) {
                        $t = 1;
                        $unit = "";
                        $rusak = 0;
                        $hilang = 0;
                        while ($row = mysqli_fetch_assoc($tablenyo)) {
                            if ($row['broken_status'] == 2) {
                                $broken = 'Tidak sengaja';
                            } elseif ($row['broken_status'] == 1) {
                                $broken = 'Disengaja';
                            } else {
                                $broken = '-';
                            }
                            if ($row['lost_status'] == 2) {
                                $lost = 'Tidak sengaja';
                            } elseif ($row['lost_status'] == 1) {
                                $lost = 'Disengaja';
                            } else {
                                $lost = '-';
                            }
                            $pdf->SetX(1);
                            $pdf->Cell(0.8,0.5,$t.".",1,0,'C');
                            $pdf->Cell(7.3,0.5,$row['name_item'],1,0,'L');
                            $pdf->Cell(2.5,0.5,$row['amount_loan'] ." ". ucwords($row['name_unit']),1,0,'C');
                            $pdf->Cell(4.2,0.5,ucwords($broken) . " / " . ucwords($lost),1,0,'C');
                            $pdf->Cell(4.2,0.5,$row['broken_amount'] . " / " .$row['lost_amount'] . " " .ucwords($row['name_unit']),1,1,'C');
                            $rusak+= $row['broken_amount'];
                            $hilang+= $row['lost_amount'];
                            $total+=$row['amount_loan'];
                            $unit = ucwords($row['name_unit']);
                            $t++;
                        }
                    } else {
                        $pdf->SetX(1);
                        $pdf->Cell(19,0.5,'Data tidak tersedia',1,1,'C');
                    }
                    $pdf->SetX(1);
                    $pdf->Cell(8.1,0.5,'Jumlah Peralatan yang dipinjam',1,0,'R');
                    $pdf->Cell(2.5,0.5,$total . " " . $unit,1,0,'C');
                    $pdf->Cell(4.2,0.5,'Jumlah Rusak/Hilang',1,0,'R');
                    $pdf->Cell(4.2,0.5,$rusak . " / " . $hilang . " " .$unit,1,1,'C');

                    $pdf->ln(0.25);
                    $pdf->SetFont('Arial','B',8);

                    $no++;
                }
                $pdf->Output('',$file.".pdf","I",true);
            } elseif ($f == $enc['data-penjualan']['remote'] && $d == $enc['data-penjualan']['download'] && isset($_GET['start']) && isset($_GET['end']) && isset($_GET['filter']) && isset($_GET['range'])) {
                $awal = $_GET['start'];
                $akhir = $_GET['end'];
                $filter = $_GET['filter'];
                $sql = "SELECT * FROM tb_selling";
                $res = "";
                $pdf = new PDF('P','cm','A4');
                if ($filter == 1) {
                    $day = date('d',strtotime('now'));
                    $sql .= " WHERE DAY(created_at) = '$day' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan harian data penjualan pada hari ".tanggal(date('N-Y-n-d',strtotime('now'))));
                } 
                elseif ($filter == 2) {
                    $mnt = date('m',strtotime('now'));
                    $yr = date('Y',strtotime('now'));
                    $sql .= " WHERE MONTH(created_at) = '$mnt' AND YEAR(created_at) = '$yr' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan bulanan data penjualan pada bulan ".bulan(date('m',strtotime('now')))." tahun ".$yr);
                }
                elseif ($filter == 3) {
                    $range = $_GET['range'];
                    $ganti = str_replace('/','-',$range);
                    $pch = explode(' - ',$ganti);
                    $range1 = strtotime($pch[0]);
                    $range2 = strtotime($pch[1]);
                    $sql .= " WHERE created_at BETWEEN FROM_UNIXTIME($range1) AND FROM_UNIXTIME($range2+(((60*60)*23)+(60*59))) LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan data penjualan pada hari ".tanggal(date('N-Y-n-d',strtotime($pch[0])))." sampai dengan hari ".tanggal(date('N-Y-n-d',strtotime($pch[1]))));
                }
                else {
                    $pdf->setJudul("Laporan data penjualan");
                    $sql .= " ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                }
                $pdf->AddPage();
                $pdf->AliasNbPages();
                $pdf->SetFont('Arial','B',8);
                $no = 1;
                while ($r = mysqli_fetch_assoc($res)) {
                    $status = $r['status'];
                    if ($status == 1) {
                        $msg = 'Sudah dibayar';
                    } else {
                        $msg = 'Belum dibayar';
                    }
                    $pdf->SetX(1);
                    $pdf->Cell(0.62,0.5,'No.',0,0,'L');
                    $pdf->Cell(2.85,0.5,$no,0,1,'L');
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Kode Penjualan',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$r['code_selling'],0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Nama Pembeli',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords($r['name_buyer']),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Tanggal Jual',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i',strtotime($r['created_at'])),0,1,'L');
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Status Pembayaran',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$msg,0,1,'L');

                    $pdf->ln(0.25);

                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                    $pdf->Cell(7.3,0.5,'Nama Barang',1,0,'C');
                    $pdf->Cell(3.7,0.5,'Harga',1,0,'C');
                    $pdf->Cell(2.2,0.5,'Jumlah',1,0,'C');
                    $pdf->Cell(2.5,0.5,'Subtotal',1,0,'C');
                    $pdf->Cell(2.5,0.5,'Keuntungan',1,1,'C');
                    
                    $kode = $r['code_selling'];
                    $sqlTable ="SELECT name_item,price_sale,amount,sub_total,profit,name_unit FROM tb_selling_details AS d
                                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                                WHERE d.code_selling='$kode'";
                    $tablenyo = mysqli_query($link,$sqlTable);
                    $pdf->SetFont('Arial','',6.5);
                    $laba = 0;
                    $items = 0;
                    $total = 0;
                    $unit = "";
                    if (mysqli_num_rows($tablenyo) > 0) {
                        $t = 1;
                        while ($row = mysqli_fetch_assoc($tablenyo)) {
                            $pdf->SetX(1);
                            $pdf->Cell(0.8,0.5,$t.".",1,0,'C');
                            $pdf->Cell(7.3,0.5,ucwords($row['name_item']),1,0,'L');
                            $pdf->Cell(3.7,0.5,"Rp. " . number_format($row['price_sale'],0,".",","),1,0,'C');
                            $pdf->Cell(2.2,0.5,$row['amount'] . " " . ucwords($row['name_unit']),1,0,'C');
                            $pdf->Cell(2.5,0.5,"Rp. ". number_format($row['sub_total'],0,".",","),1,0,'C');
                            $pdf->Cell(2.5,0.5,"Rp. " . number_format($row['profit'],0,".",","),1,1,'C');
                            $items+=$row['amount'];
                            $total+=$row['sub_total'];
                            $laba+=$row['profit'];
                            $unit = ucwords($row['name_unit']);
                            $t++;
                        }
                    } else {
                        $pdf->SetX(1);
                        $pdf->Cell(19,0.5,'Data tidak tersedia',1,1,'C');
                    }
                    $pdf->SetX(1);
                    $pdf->Cell(11.8,0.5,'Jumlah',1,0,'R');
                    $pdf->Cell(2.2,0.5,$items . " " . $unit,1,0,'C');
                    $pdf->Cell(2.5,0.5,"Rp. " . number_format($total,0,".",","),1,0,'C');
                    $pdf->Cell(2.5,0.5,"Rp. " . number_format($laba,0,".",","),1,1,'C');

                    $pdf->ln(0.25);
                    $pdf->SetFont('Arial','B',8);
                    $no++;
                }
                $pdf->Output('',$file.".pdf","I",true);
            } elseif ($f == $enc['data-pembelian']['remote'] && $d == $enc['data-pembelian']['download'] && isset($_GET['start']) && isset($_GET['end']) && isset($_GET['filter']) && isset($_GET['range'])) {
                $awal = $_GET['start'];
                $akhir = $_GET['end'];
                $filter = $_GET['filter'];
                $sql = "SELECT * FROM tb_buying";
                $res = "";
                $pdf = new PDF('P','cm','A4');
                if ($filter == 1) {
                    $day = date('d',strtotime('now'));
                    $sql .= " WHERE DAY(created_at) = '$day' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan harian data pembelian pada hari ".tanggal(date('N-Y-n-d',strtotime('now'))));
                } 
                elseif ($filter == 2) {
                    $mnt = date('m',strtotime('now'));
                    $yr = date('Y',strtotime('now'));
                    $sql .= " WHERE MONTH(created_at) = '$mnt' AND YEAR(created_at) = '$yr' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan bulanan data pembelian pada bulan ".bulan(date('m',strtotime('now')))." tahun ".$yr);
                }
                elseif ($filter == 3) {
                    $range = $_GET['range'];
                    $ganti = str_replace('/','-',$range);
                    $pch = explode(' - ',$ganti);
                    $range1 = strtotime($pch[0]);
                    $range2 = strtotime($pch[1]);
                    $sql .= " WHERE created_at BETWEEN FROM_UNIXTIME($range1) AND FROM_UNIXTIME($range2+(((60*60)*23)+(60*59))) LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan data pembelian pada hari ".tanggal(date('N-Y-n-d',strtotime($pch[0])))." sampai dengan hari ".tanggal(date('N-Y-n-d',strtotime($pch[1]))));
                }
                else {
                    $pdf->setJudul("Laporan data pembelian");
                    $sql .= " ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                }
                $pdf->AddPage();
                $pdf->AliasNbPages();
                $pdf->SetFont('Arial','B',8);
                $no = 1;
                while ($r = mysqli_fetch_assoc($res)) {
                    $pdf->SetX(1);
                    $pdf->Cell(0.62,0.5,'No.',0,0,'L');
                    $pdf->Cell(2.85,0.5,$no,0,1,'L');
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Kode Pembelian',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$r['code_buying'],0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Tanggal Pembelian',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i',strtotime($r['created_at'])),0,1,'L');

                    $pdf->ln(0.25);

                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                    $pdf->Cell(11.0,0.5,'Nama Barang',1,0,'C');
                    $pdf->Cell(2.2,0.5,'Jumlah',1,0,'C');
                    $pdf->Cell(5.0,0.5,'Subtotal',1,1,'C');
                    
                    $kode = $r['code_buying'];
                    $sqlTable ="SELECT name_item,amount,subtotal,name_unit FROM tb_buying_details AS d
                                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                                WHERE d.code_buying='$kode'";
                    $tablenyo = mysqli_query($link,$sqlTable);
                    $pdf->SetFont('Arial','',6.5);
                    $items = 0;
                    $total = 0;
                    $unit = "";
                    if (mysqli_num_rows($tablenyo) > 0) {
                        $t = 1;
                        while ($row = mysqli_fetch_assoc($tablenyo)) {
                            $pdf->SetX(1);
                            $pdf->Cell(0.8,0.5,$t.".",1,0,'C');
                            $pdf->Cell(11.0,0.5,ucwords($row['name_item']),1,0,'L');
                            $pdf->Cell(2.2,0.5,$row['amount'] . " " . ucwords($row['name_unit']),1,0,'C');
                            $pdf->Cell(5.0,0.5,"Rp. ". number_format($row['subtotal'],0,".",","),1,1,'C');
                            $items+=$row['amount'];
                            $total+=$row['subtotal'];
                            $unit = ucwords($row['name_unit']);
                            $t++;
                        }
                    } else {
                        $pdf->SetX(1);
                        $pdf->Cell(19,0.5,'Data tidak tersedia',1,1,'C');
                    }
                    $pdf->SetX(1);
                    $pdf->Cell(11.8,0.5,'Jumlah',1,0,'R');
                    $pdf->Cell(2.2,0.5,$items . " " . $unit,1,0,'C');
                    $pdf->Cell(5.0,0.5,"Rp. " . number_format($total,0,".",","),1,1,'C');

                    $pdf->ln(0.25);
                    $pdf->SetFont('Arial','B',8);
                    $no++;
                }
                $pdf->Output('',$file.".pdf","I",true);
            } elseif ($f == $enc['data-pengadaan']['remote'] && $d == $enc['data-pengadaan']['download'] && isset($_GET['start']) && isset($_GET['end']) && isset($_GET['filter']) && isset($_GET['range'])) {
                $awal = $_GET['start'];
                $akhir = $_GET['end'];
                $filter = $_GET['filter'];
                $sql = "SELECT * FROM tb_pengadaan";
                $res = "";
                $pdf = new PDF('P','cm','A4');
                if ($filter == 1) {
                    $day = date('d',strtotime('now'));
                    $sql .= " WHERE DAY(created_at) = '$day' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan harian data pengadaan pada hari ".tanggal(date('N-Y-n-d',strtotime('now'))));
                } 
                elseif ($filter == 2) {
                    $mnt = date('m',strtotime('now'));
                    $yr = date('Y',strtotime('now'));
                    $sql .= " WHERE MONTH(created_at) = '$mnt' AND YEAR(created_at) = '$yr' ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan bulanan data pengadaan pada bulan ".bulan(date('m',strtotime('now')))." tahun ".$yr);
                }
                elseif ($filter == 3) {
                    $range = $_GET['range'];
                    $ganti = str_replace('/','-',$range);
                    $pch = explode(' - ',$ganti);
                    $range1 = strtotime($pch[0]);
                    $range2 = strtotime($pch[1]);
                    $sql .= " WHERE created_at BETWEEN FROM_UNIXTIME($range1) AND FROM_UNIXTIME($range2+(((60*60)*23)+(60*59))) LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                    $pdf->setJudul("Laporan data pengadaan pada hari ".tanggal(date('N-Y-n-d',strtotime($pch[0])))." sampai dengan hari ".tanggal(date('N-Y-n-d',strtotime($pch[1]))));
                }
                else {
                    $pdf->setJudul("Laporan data pengadaan");
                    $sql .= " ORDER BY created_at DESC LIMIT $awal,$akhir";
                    $res = mysqli_query($link,$sql);
                }
                $pdf->AddPage();
                $pdf->AliasNbPages();
                $pdf->SetFont('Arial','B',8);
                $no = 1;
                while ($r = mysqli_fetch_assoc($res)) {
                    $status = $r['status'];
                    if ($status == 1) {
                        $msg = 'Telah diterima';
                    } else {
                        $msg = 'Sedang diproses';
                    }

                    $pdf->SetX(1);
                    $pdf->Cell(0.62,0.5,'No.',0,0,'L');
                    $pdf->Cell(2.85,0.5,$no,0,1,'L');
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Kode Pengadaan',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$r['code_pengadaan'],0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Tanggal Pengadaan',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i',strtotime($r['created_at'])),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Status Pengadaan',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$msg,0,1,'L');

                    $pdf->ln(0.25);

                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                    $pdf->Cell(6.3,0.5,'Nama Barang',1,0,'C');
                    $pdf->Cell(4.7,0.5,'Jenis',1,0,'C');
                    $pdf->Cell(2.2,0.5,'Jumlah',1,0,'C');
                    $pdf->Cell(2.5,0.5,'Harga',1,0,'C');
                    $pdf->Cell(2.5,0.5,'Subtotal',1,1,'C');

                    $pdf->SetFont('Arial','',6.5);

                    $t = 1;
                    $items = 0;
                    $total = 0;
                    $kode = $r['code_pengadaan'];
                    $table = "SELECT name_item,name_category,amount,price_buy,subtotal,name_unit FROM tb_pengadaan_details AS d
                                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                                WHERE d.code_pengadaan='$kode'";
                    $exec = mysqli_query($link,$table);
                    while ($r = mysqli_fetch_assoc($exec)) {
                        $pdf->SetX(1);
                        $pdf->Cell(0.8,0.5,$t.".",1,0,'C');
                        $pdf->Cell(6.3,0.5,ucwords($r['name_item']),1,0,'L');
                        $pdf->Cell(4.7,0.5,ucwords($r['name_category']),1,0,'C');
                        $pdf->Cell(2.2,0.5,$r['amount'] . " " . ucwords($r['name_unit']),1,0,'C');
                        $pdf->Cell(2.5,0.5,"Rp. ". number_format($r['price_buy'],0,".","."),1,0,'C');
                        $pdf->Cell(2.5,0.5,"Rp. ". number_format($r['subtotal'],0,".","."),1,1,'C');
                        $items+=$r['amount'];
                        $total+=$r['subtotal'];
                        $t++;
                    }

                    $pdf->SetX(1);
                    $pdf->Cell(11.8,0.5,'Jumlah',1,0,'R');
                    $pdf->Cell(2.2,0.5,number_format($items,0,".","."),1,0,'C');
                    $pdf->Cell(2.5,0.5,"Total",1,0,'R');
                    $pdf->Cell(2.5,0.5,"Rp. " . number_format($total,0,".",","),1,1,'C');

                    $pdf->ln(0.25);
                    $pdf->SetFont('Arial','B',8);
                    $no++;
                }
                $pdf->Output('',$file.".pdf","I",true);
            } elseif ($f == $enc['data-peminjaman']['remote'] && $d == $enc['data-peminjaman']['unduh'] && isset($_GET['id'])) {
                $id = $_GET['id'];
                $query = "SELECT * FROM tb_loan WHERE code_loan='$id'";
                $sql = mysqli_query($link,$query);
                if (mysqli_num_rows($sql)) {
                    $r = mysqli_fetch_assoc($sql);
                    $pdf = new PDF('P','cm','A4');
                    $pdf->setJudul("Laporan peminjaman " . $r['code_loan']);
                    $pdf->AddPage();
                    $pdf->AliasNbPages();
                    $pdf->SetFont('Arial','B',8);

                    $status = $r['status'];
                    if ($status == 1) {
                        $msg = 'Telah dikembalikan';
                    } else {
                        $today = new DateTime(date('Y-m-d H:i:s',strtotime('now')));
                        $exp = new DateTime(date('Y-m-d H:i:s',strtotime($r["due_date"])));
                        if ($today > $exp) {
                            $msg = 'Telah lewat jatuh tempo';
                        } else {
                            $msg = 'Masih dipinjam';
                        }
                    }
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Kode Peminjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$r['code_loan'],0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Nama Peminjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords($r['name_loan']),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Tanggal Peminjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i:s',strtotime($r['created_at'])),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Tanggal Tempo',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i:s',strtotime($r['due_date'])),0,1,'L');
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Status Pinjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$msg,0,1,'L');

                    $pdf->ln(0.25);

                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                    $pdf->Cell(4.7,0.5,'Kode Peralatan',1,0,'C');
                    $pdf->Cell(7.3,0.5,'Nama Peralatan',1,0,'C');
                    $pdf->Cell(4.7,0.5,'Jenis Peralatan',1,0,'C');
                    $pdf->Cell(1.5,0.5,'Jumlah',1,1,'C');
                    
                    $sqlTable ="SELECT d.code_item,name_item,name_category,amount FROM tb_loan_details AS d
                                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                                WHERE d.code_loan='$id'";
                    $tablenyo = mysqli_query($link,$sqlTable);
                    $pdf->SetFont('Arial','',6.5);
                    $total = 0;
                    if (mysqli_num_rows($tablenyo) > 0) {
                        $t = 1;
                        while ($row = mysqli_fetch_assoc($tablenyo)) {
                            $pdf->SetX(1);
                            $pdf->Cell(0.8,0.5,$t,1,0,'C');
                            $pdf->Cell(4.7,0.5,$row['code_item'],1,0,'C');
                            $pdf->Cell(7.3,0.5,ucwords($row['name_item']),1,0,'C');
                            $pdf->Cell(4.7,0.5,ucwords($row['name_category']),1,0,'C');
                            $pdf->Cell(1.5,0.5,$row['amount'],1,1,'C');
                            $total+=$row['amount'];
                            $t++;
                        }
                    } else {
                        $pdf->SetX(1);
                        $pdf->Cell(19,0.5,'Data tidak tersedia',1,1,'C');
                    }
                    $pdf->SetX(1);
                    $pdf->Cell(17.5,0.5,'Jumlah Peralatan yang dipinjam',1,0,'R');
                    $pdf->Cell(1.5,0.5,$total,1,1,'C');

                    $pdf->ln(0.25);
                    $pdf->SetFont('Arial','B',8);
                }
                $pdf->Output('',$file.".pdf","I",true);
            } elseif ($f == $enc['data-pengembalian']['remote'] && $d == $enc['data-pengembalian']['unduh'] && isset($_GET['id'])) {
                $id = $_GET['id'];
                $query = "SELECT *,l.due_date, l.created_at AS pinjam, r.created_at FROM tb_return AS r
                            INNER JOIN tb_loan AS l ON l.code_loan = r.code_loan
                            WHERE r.code_return='$id'";
                $sql = mysqli_query($link, $query);
                if (mysqli_num_rows($sql) > 0) {
                    $r = mysqli_fetch_assoc($sql);
                    $pdf = new PDF('P','cm','A4');
                    $pdf->setJudul("Laporan pengembalian " . $r['code_return']);
                    $pdf->AddPage();
                    $pdf->AliasNbPages();
                    $pdf->SetFont('Arial','B',8);

                    $pin = $r['pin'] == 1 ? 'Tepat waktu' : 'Terlambat';
                    if ($r['rechange'] == 2) {
                        $change = 'Sudah diganti';
                    } elseif ($r['rechange'] == 1) {
                        $change = 'Belum diganti';
                    } else {
                        $change = 'Tidak ada penggantian';
                    }
                    
                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Kode Pengembalian',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$r['code_return'],0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Kode Peminjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$r['code_loan'],0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Nama Pengembali',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords($r['name_return']),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Ketepatan Pengembalian',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords($pin),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Lama Peminjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords($r['long_period']),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Penggantian rusak atau hilang',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords($change),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Info',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords(strip_tags($r['info'])),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Tanggal Peminjaman',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i',strtotime($r['pinjam'])),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Tanggal Tempo',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i',strtotime($r['due_date'])),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(4.51,0.5,'Tanggal Dikembalikan',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i',strtotime($r['created_at'])),0,1,'L');
                    
                    $pdf->ln(0.25);

                    // table
                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                    $pdf->Cell(7.3,0.5,'Nama Peralatan',1,0,'C');
                    $pdf->Cell(2.5,0.5,'Jumlah Pinjam',1,0,'C');
                    $pdf->Cell(4.2,0.5,'Ket. Rusak/Hilang',1,0,'C');
                    $pdf->Cell(4.2,0.5,'Jumlah Rusak/Hilang',1,1,'C');

                    $table = "SELECT d.code_return, r.code_loan, name_return, pin, long_period, penalty, rechange, info, l.due_date, l.created_at AS pinjam, r.created_at, 
                                d.code_item, name_item, name_category, amount_loan, broken_amount, broken_status, lost_amount, lost_status, name_unit FROM tb_return_details AS d
                                INNER JOIN tb_return AS r ON r.code_return = d.code_return
                                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                                INNER JOIN tb_loan AS l ON l.code_loan = r.code_loan
                                WHERE r.code_return='$id'";
                    $exec = mysqli_query($link,$table);
                    $total = 0;
                    $t = 1;
                    $unit = "";
                    $rusak = 0;
                    $hilang = 0;
                    
                    $pdf->SetFont('Arial','',6.5);

                    while ($row = mysqli_fetch_assoc($exec)) {
                        if ($row['broken_status'] == 2) {
                            $broken = 'Tidak sengaja';
                        } elseif ($row['broken_status'] == 1) {
                            $broken = 'Disengaja';
                        } else {
                            $broken = '-';
                        }
                        if ($row['lost_status'] == 2) {
                            $lost = 'Tidak sengaja';
                        } elseif ($row['lost_status'] == 1) {
                            $lost = 'Disengaja';
                        } else {
                            $lost = '-';
                        }
                        $pdf->SetX(1);
                        $pdf->Cell(0.8,0.5,$t.".",1,0,'C');
                        $pdf->Cell(7.3,0.5,$row['name_item'],1,0,'L');
                        $pdf->Cell(2.5,0.5,$row['amount_loan'] ." ". ucwords($row['name_unit']),1,0,'C');
                        $pdf->Cell(4.2,0.5,ucwords($broken) . " / " . ucwords($lost),1,0,'C');
                        $pdf->Cell(4.2,0.5,$row['broken_amount'] . " / " .$row['lost_amount'] . " " .ucwords($row['name_unit']),1,1,'C');
                        $rusak+= $row['broken_amount'];
                        $hilang+= $row['lost_amount'];
                        $total+=$row['amount_loan'];
                        $unit = ucwords($row['name_unit']);
                        $t++;
                    }
                    $pdf->SetX(1);
                    $pdf->Cell(8.1,0.5,'Jumlah Peralatan yang dipinjam',1,0,'R');
                    $pdf->Cell(2.5,0.5,$total . " " . $unit,1,0,'C');
                    $pdf->Cell(4.2,0.5,'Jumlah Rusak/Hilang',1,0,'R');
                    $pdf->Cell(4.2,0.5,$rusak . " / " . $hilang . " " .$unit,1,1,'C');

                    $pdf->ln(0.25);
                    $pdf->SetFont('Arial','B',8);
                }
                $pdf->Output('',$file.".pdf","I",true);
            } elseif ($f == $enc['data-penjualan']['remote'] && $d == $enc['data-penjualan']['unduh'] && isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM tb_selling WHERE code_selling='$id'";
                $query = mysqli_query($link,$sql);
                if (mysqli_num_rows($query) > 0) {
                    $r = mysqli_fetch_assoc($query);

                    $pdf = new PDF('P','cm','A4');
                    $pdf->setJudul("Laporan penjualan " . $r['code_selling']);
                    $pdf->AddPage();
                    $pdf->AliasNbPages();
                    $pdf->SetFont('Arial','B',8);
                    $status = $r['status'];
                    if ($status == 1) {
                        $msg = 'Sudah dibayar';
                    } else {
                        $msg = 'Belum dibayar';
                    }
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Kode Penjualan',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$r['code_selling'],0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Nama Pembeli',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,ucwords($r['name_buyer']),0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Tanggal Jual',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i',strtotime($r['created_at'])),0,1,'L');
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Status Pembayaran',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$msg,0,1,'L');

                    $pdf->ln(0.25);

                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                    $pdf->Cell(7.3,0.5,'Nama Barang',1,0,'C');
                    $pdf->Cell(3.7,0.5,'Harga',1,0,'C');
                    $pdf->Cell(2.2,0.5,'Jumlah',1,0,'C');
                    $pdf->Cell(5.0,0.5,'Subtotal',1,1,'C');

                    $pdf->SetFont('Arial','',6.5);
                    $items = 0;
                    $total = 0;
                    $unit = "";
                    $t = 1;
                    $kode = $r['code_selling'];
                    $table = "SELECT d.code_selling, name_buyer, total, s.status, s.created_at, name_item, amount, price_sale, sub_total, name_unit FROM tb_selling_details AS d
                            INNER JOIN tb_selling AS s ON s.code_selling = d.code_selling
                                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                                WHERE d.code_selling='$kode'";
                    $exec = mysqli_query($link,$table);
                    while ($r = mysqli_fetch_assoc($exec)) {
                        $pdf->SetX(1);
                        $pdf->Cell(0.8,0.5,$t.".",1,0,'C');
                        $pdf->Cell(7.3,0.5,ucwords($r['name_item']),1,0,'L');
                        $pdf->Cell(3.7,0.5,"Rp. " . number_format($r['price_sale'],0,".",","),1,0,'C');
                        $pdf->Cell(2.2,0.5,$r['amount'] . " " . ucwords($r['name_unit']),1,0,'C');
                        $pdf->Cell(5.0,0.5,"Rp. ". number_format($r['sub_total'],0,".",","),1,1,'C');
                        $items+=$r['amount'];
                        $total+=$r['sub_total'];
                        $unit = ucwords($r['name_unit']);
                        $t++;
                    }
                    $pdf->SetX(1);
                    $pdf->Cell(11.8,0.5,'Jumlah',1,0,'R');
                    $pdf->Cell(2.2,0.5,$items . " " . $unit,1,0,'C');
                    $pdf->Cell(5.0,0.5,"Rp. " . number_format($total,0,".",","),1,1,'C');

                    $pdf->ln(0.25);
                    $pdf->SetFont('Arial','B',8);
                }
                $pdf->Output('',$file.".pdf","I",true);
            } elseif ($f == $enc['data-pembelian']['remote'] && $d == $enc['data-pembelian']['unduh'] && isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT b.code_buying,b.total,b.created_at,name_item,name_category,amount,price,subtotal,name_unit FROM tb_buying_details AS d
                        INNER JOIN tb_buying AS b ON b.code_buying = d.code_buying
                        INNER JOIN tb_items AS i ON i.code_item = d.code_item
                        INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                        INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                        WHERE b.code_buying='$id'";
                $query = mysqli_query($link,$sql);
                if (mysqli_num_rows($query) > 0) {
                    $r = mysqli_fetch_assoc($query);
                    $pdf = new PDF('P','cm','A4');
                    $pdf->setJudul("Laporan pembelian " . $r['code_buying']);
                    $pdf->AddPage();
                    $pdf->AliasNbPages();
                    $pdf->SetFont('Arial','B',8);
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Kode Pembelian',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$r['code_buying'],0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Tanggal Pembelian',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i',strtotime($r['created_at'])),0,1,'L');
                    
                    $pdf->ln(0.25);

                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                    $pdf->Cell(11.0,0.5,'Nama Barang',1,0,'C');
                    $pdf->Cell(2.2,0.5,'Jumlah',1,0,'C');
                    $pdf->Cell(5.0,0.5,'Subtotal',1,1,'C');

                    $pdf->SetFont('Arial','',6.5);

                    $t = 1;
                    $items = 0;
                    $total = 0;
                    $unit = "";
                    $kode = $r['code_buying'];
                    $table = "SELECT b.code_buying,b.total,b.created_at,name_item,name_category,amount,price,subtotal,name_unit FROM tb_buying_details AS d
                                INNER JOIN tb_buying AS b ON b.code_buying = d.code_buying
                                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                                WHERE b.code_buying='$kode'";
                    $exec = mysqli_query($link,$table);
                    while ($r = mysqli_fetch_assoc($exec)) {
                        $pdf->SetX(1);
                        $pdf->Cell(0.8,0.5,$t.".",1,0,'C');
                        $pdf->Cell(11.0,0.5,ucwords($r['name_item']),1,0,'L');
                        $pdf->Cell(2.2,0.5,$r['amount'] . " " . ucwords($r['name_unit']),1,0,'C');
                        $pdf->Cell(5.0,0.5,"Rp. ". number_format($r['subtotal'],0,".",","),1,1,'C');
                        $items+=$r['amount'];
                        $total+=$r['subtotal'];
                        $unit = ucwords($r['name_unit']);
                        $t++;
                    }

                    $pdf->SetX(1);
                    $pdf->Cell(11.8,0.5,'Jumlah',1,0,'R');
                    $pdf->Cell(2.2,0.5,$items . " " . $unit,1,0,'C');
                    $pdf->Cell(5.0,0.5,"Rp. " . number_format($total,0,".",","),1,1,'C');

                    $pdf->ln(0.25);
                    $pdf->SetFont('Arial','B',8);
                }
                $pdf->Output('',$file.".pdf","I",true);
            } elseif ($f == $enc['data-pengadaan']['remote'] && $d == $enc['data-pengadaan']['unduh'] && isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM tb_pengadaan WHERE code_pengadaan='$id'";
                $query = mysqli_query($link,$sql);
                if (mysqli_num_rows($query) > 0) {
                    $r = mysqli_fetch_assoc($query);
                    $status = $r['status'];
                    if ($status == 1) {
                        $msg = 'Telah diterima';
                    } else {
                        $msg = 'Sedang diproses';
                    }

                    $pdf = new PDF('P','cm','A4');
                    $pdf->setJudul("Laporan pengadaan " . $r['code_pengadaan']);
                    $pdf->AddPage();
                    $pdf->AliasNbPages();
                    $pdf->SetFont('Arial','B',8);
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Kode Pembelian',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$r['code_pengadaan'],0,1,'L');

                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Tanggal Pengadaan',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,date('d-m-Y, H:i',strtotime($r['created_at'])),0,1,'L');
                    
                    $pdf->SetX(1);
                    $pdf->Cell(3.01,0.5,'Status Pengadaan',0,0,'L');
                    $pdf->Cell(0.1,0.5,':',0,0,'C');
                    $pdf->Cell(6.0,0.5,$msg,0,1,'L');

                    $pdf->ln(0.25);

                    $pdf->SetX(1);
                    $pdf->Cell(0.8,0.5,'No.',1,0,'C');
                    $pdf->Cell(6.3,0.5,'Nama Barang',1,0,'C');
                    $pdf->Cell(4.7,0.5,'Jenis',1,0,'C');
                    $pdf->Cell(2.2,0.5,'Jumlah',1,0,'C');
                    $pdf->Cell(2.5,0.5,'Harga',1,0,'C');
                    $pdf->Cell(2.5,0.5,'Subtotal',1,1,'C');

                    $pdf->SetFont('Arial','',6.5);

                    $t = 1;
                    $items = 0;
                    $total = 0;
                    $kode = $r['code_pengadaan'];
                    $table = "SELECT name_item,name_category,amount,price_buy,subtotal,name_unit FROM tb_pengadaan_details AS d
                                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                                WHERE d.code_pengadaan='$kode'";
                    $exec = mysqli_query($link,$table);
                    while ($r = mysqli_fetch_assoc($exec)) {
                        $pdf->SetX(1);
                        $pdf->Cell(0.8,0.5,$t.".",1,0,'C');
                        $pdf->Cell(6.3,0.5,ucwords($r['name_item']),1,0,'L');
                        $pdf->Cell(4.7,0.5,ucwords($r['name_category']),1,0,'C');
                        $pdf->Cell(2.2,0.5,$r['amount'] . " " . ucwords($r['name_unit']),1,0,'C');
                        $pdf->Cell(2.5,0.5,"Rp. ". number_format($r['price_buy'],0,".","."),1,0,'C');
                        $pdf->Cell(2.5,0.5,"Rp. ". number_format($r['subtotal'],0,".","."),1,1,'C');
                        $items+=$r['amount'];
                        $total+=$r['subtotal'];
                        $t++;
                    }

                    $pdf->SetX(1);
                    $pdf->Cell(11.8,0.5,'Jumlah',1,0,'R');
                    $pdf->Cell(2.2,0.5,number_format($items,0,".","."),1,0,'C');
                    $pdf->Cell(2.5,0.5,"Total",1,0,'R');
                    $pdf->Cell(2.5,0.5,"Rp. " . number_format($total,0,".",","),1,1,'C');

                    $pdf->ln(0.25);
                    $pdf->SetFont('Arial','B',8);
                }
                $pdf->Output('',$file.".pdf","I",true);
            } else {
                $pdf = new PDF('P','cm','A4');
            }
        } else {
            echo "Invalid Url";
        }
    }
    