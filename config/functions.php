<?php

function tanggal($tgl) {
    $hari = array(
        1 => 'Senen', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Minggu'
    );
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    $arr = explode('-', $tgl);
    return $hari[(int)$arr[0]] . ', ' . $arr[3] . '-' . $bulan[(int)$arr[2]] . '-' . $arr[1];
}

function bulan($bln) {
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    return $bulan[(int)$bln];
}

function hasPermit($p) {
    global $link;
    $r = $_SESSION['level'];
    $sqlevel = "SELECT tb_rules.*, tb_rule_permission.*, tb_permissions.* FROM tb_rules
                INNER JOIN tb_rule_permission ON tb_rule_permission.id_rule = tb_rules.id_rule
                INNER JOIN tb_permissions ON tb_permissions.id_permission = tb_rule_permission.id_permission
                WHERE tb_rules.name_rule='$r' AND tb_permissions.name_permission='$p'";
    $exc = mysqli_query($link, $sqlevel);
    return mysqli_num_rows($exc) == 1 ? true : false;
}

function execute($sql) {
    global $link;
    $query = null;
    $query = mysqli_query($link, $sql);
    return $query;
}

function result($code, $msg) {
    return array(
        'code' => $code,
        'message' => $msg,
    );
}

function tombol_tambah($ex = 1, array $box = null) {
    $dl = "";
    if ($ex == 1) {
        $dl .= '
        <a id="'.$box['box-download']['id'].'" name="'.$box['box-download']['name'].'" class="'.$box['box-download']['class'].'" title="'.$box['box-download']['title'].'" data-remote="'.$box['box-download']['data-remote'].'" data-target="'.$box['box-download']['data-target'].'">
            <i class="fa fa-file-pdf-o"></i>&nbsp;
            <span>'.$box['box-download']['title'].'</span>
        </a>
        ';
    }
    $html = '
        <div class="box">
            <div class="box-body">
                <a id="'.$box['box-add']['id'].'" name="'.$box['box-add']['name'].'" class="'.$box['box-add']['class'].'" title="'.$box['box-add']['title'].'" data-target="'.$box['box-add']['data-target'].'">
                    <i class="fa fa-plus"></i>&nbsp;
                    <span>'.$box['box-add']['title'].'</span>
                </a>
                '.$dl.'
            </div>
        </div>
    ';
    return $html;
}

function tombol_keranjang(array $box = null, $remote, $target) {
    $html = '
        <div class="box">
            <div class="box-body">
                <div class="col-md-6 col-xs-12">
                    <a id="'.$box['id'].'" name="'.$box['name'].'" class="'.$box['class'].'" title="'.$box['title'].'" data-target="'.$box['data-target'].'">
                        <i class="fa fa-shopping-cart"></i>&nbsp;
                        <span id="title_keranjang">'.$box['title'].'</span>
                    </a>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="pull-right">
                        <form method="POST" id="form-cari" class="form-inline" data-remote="'.base64_encode($remote).'" data-target="'.base64_encode($target).'">
                            <div class="input-group">
                                <input type="text" id="cari" name="cari" class="form-control" placeholder="Cari" title="Masukkan nama sparepart yang ingin dibeli" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    ';
    return $html;
}
/**
 * Method table
 * @param array $data table
 * @return $html
 */
function table(array $data = null) {
    $th = null;
    foreach ($data['field'] as $k => $v) {
        $th .= "<th>".$v."</th>\n";
    }
    $html = '<div id="boxnyo" class="box box-solid box-primary">
                <div class="box-body">
                    <div class="col-md-12 col-xs-12 table-responsive">
                        <table id="'.$data['id'].'" name="'.$data['name'].'" class="'.$data['class'].'" data-remote="'.$data['data-remote'].'" data-target="'.$data['data-target'].'" data-laporan="'.@$data['data-laporan'].'">
                            <thead>
                                <tr> 
                                    '.$th.'
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>';
    return $html;
}

/**
 * Method generate code items
 * @param $category = 1. ALT, 2. SMT 3. SMB
 * @param $nama = Name item
 * @return $kode 
 */
function buatkode($category,$nama) {
    global $link;
    static $tipe = array(
        1=>'ALT', 'SMT', 'SMB'
    );
    try {
        if (!empty($category)) {
            if (count($tipe) < $category) {
                throw new Exception("Array outbound ! choose 1, 2, and 3", 1);
            }
            else {
                if (!empty($nama)) {
                    $delSpace = trim(ucwords($nama));
                    foreach ($tipe as $k => $v) {
                        if ($category == $k) {
                            $rplc = preg_replace("([^A-Za-z0-9\s+]+)","",$delSpace);
                            $pecahkanNama = explode(' ', $rplc);
                            $joinNama = "";
                            $i = 0;
                            foreach ($pecahkanNama as $key => $value) {
                                $i++;
                                if ($i < 3) $joinNama .= substr($pecahkanNama[$key],0,1);
                            }
                            $thn = date('Y',strtotime('now'));
                            $cari = "/".$joinNama;$thnny = "/".$thn;
                            $sqlJmlh = "SELECT COUNT(code_item) AS jmlh FROM tb_items";
                            $sqlCari = "SELECT MAX(code_item) as TERAKHIR FROM tb_items";
                            if ($k == 1) {
                                $sqlJmlh .= " WHERE code_category = 'alt' AND SUBSTRING_INDEX(code_item,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_item,'/',3) LIKE '%$thnny%'";
                                $sqlCari .= " WHERE code_category = 'alt' AND SUBSTRING_INDEX(code_item,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_item,'/',3) LIKE '%$thnny%'";
                            } elseif ($k == 2) {
                                $sqlJmlh .= " WHERE code_category = 'smt' AND SUBSTRING_INDEX(code_item,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_item,'/',3) LIKE '%$thnny%'";
                                $sqlCari .= " WHERE code_category = 'smt' AND SUBSTRING_INDEX(code_item,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_item,'/',3) LIKE '%$thnny%'";
                            } elseif ($k == 3) {
                                $sqlJmlh .= " WHERE code_category = 'smb' AND SUBSTRING_INDEX(code_item,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_item,'/',3) LIKE '%$thnny%'";
                                $sqlCari .= " WHERE code_category = 'smb' AND SUBSTRING_INDEX(code_item,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_item,'/',3) LIKE '%$thnny%'";
                            }
                            $execJmlh = mysqli_query($link,$sqlJmlh);
                            $execCari = mysqli_query($link,$sqlCari);
                            $r = mysqli_fetch_assoc($execJmlh);
                            if ($r['jmlh'] > 0) {
                                $c = mysqli_fetch_assoc($execCari);
                                $s = explode('/',$c['TERAKHIR']);
                                $las = $s[3];
                            } else {
                                $las = 0;
                            }
                            $next = $las+1;
                            $kode = "$v/".$joinNama."/".$thn."/".sprintf('%05s',$next);
                            break;
                        }
                    }
                    return $kode;
                } else {
                    throw new Exception("Parameter {1} is null !", 2);
                }
            }
        } 
        else {
            throw new Exception("Parameter {0} is null !", 3);
        }
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}

/**
 * Method generate code transaction
 * @param $jenis = 1. Peminjaman, 2. Pengembalian, 3. Penjualan, 4. Pembelian, 5. Pengadaan
 * @return $kode
 */
function kodetransaksi($jenis) {
    global $link;
    $transaksi = null;
    static $tipe = array(
        1=>'PEMINJAMAN','PENGEMBALIAN','PENJUALAN','PEMBELIAN','PENGADAAN'
    );
    try {
        if (!empty($jenis)) {
            if (count($tipe) < $jenis) {
                throw new Exception("Array outbound {$jenis} ! choose 1 - 4", 1);
            } else {
                foreach ($tipe as $k => $v) {
                    if ($jenis == $k) {
                        $date = date('dmY',strtotime('now'));
                        $cari = "/".$v;
                        $thnny = "/".$date;
                        $sqlJmlh = "";
                        $sqlCari = "";
                        if ($k == 1) {
                            $sqlJmlh .= "SELECT COUNT(code_loan) AS jmlh FROM tb_loan WHERE SUBSTRING_INDEX(code_loan,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_loan,'/',3) LIKE '%$thnny%'";
                            $sqlCari .= "SELECT MAX(code_loan) as TERAKHIR FROM tb_loan WHERE SUBSTRING_INDEX(code_loan,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_loan,'/',3) LIKE '%$thnny%'";
                        } elseif ($k == 2) {
                            $sqlJmlh .= "SELECT COUNT(code_return) AS jmlh FROM tb_return WHERE SUBSTRING_INDEX(code_return,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_return,'/',3) LIKE '%$thnny%'";
                            $sqlCari .= "SELECT MAX(code_return) as TERAKHIR FROM tb_return WHERE SUBSTRING_INDEX(code_return,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_return,'/',3) LIKE '%$thnny%'";
                        } elseif ($k == 3) {
                            $sqlJmlh .= "SELECT COUNT(code_selling) AS jmlh FROM tb_selling WHERE SUBSTRING_INDEX(code_selling,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_selling,'/',3) LIKE '%$thnny%'";
                            $sqlCari .= "SELECT MAX(code_selling) as TERAKHIR FROM tb_selling WHERE SUBSTRING_INDEX(code_selling,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_selling,'/',3) LIKE '%$thnny%'";
                        } elseif ($k == 4) {
                            $sqlJmlh .= "SELECT COUNT(code_buying) AS jmlh FROM tb_buying WHERE SUBSTRING_INDEX(code_buying,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_buying,'/',3) LIKE '%$thnny%'";
                            $sqlCari .= "SELECT MAX(code_buying) as TERAKHIR FROM tb_buying WHERE SUBSTRING_INDEX(code_buying,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_buying,'/',3) LIKE '%$thnny%'";
                        } elseif ($k == 5) {
                            $sqlJmlh .= "SELECT COUNT(code_pengadaan) AS jmlh FROM tb_pengadaan WHERE SUBSTRING_INDEX(code_pengadaan,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_pengadaan,'/',3) LIKE '%$thnny%'";
                            $sqlCari .= "SELECT MAX(code_pengadaan) as TERAKHIR FROM tb_pengadaan WHERE SUBSTRING_INDEX(code_pengadaan,'/',2) LIKE '%$cari%' AND SUBSTRING_INDEX(code_pengadaan,'/',3) LIKE '%$thnny%'";
                        }
                        $execJmlh = mysqli_query($link,$sqlJmlh);
                        $execCari = mysqli_query($link,$sqlCari);
                        $r = mysqli_fetch_assoc($execJmlh);
                        if ($r['jmlh'] > 0) {
                            $c = mysqli_fetch_assoc($execCari);
                            $s = explode('/',$c['TERAKHIR']);
                            $las = $s[3];
                        } else {
                            $las = 0;
                        }
                        $next = $las+1;
                        $transaksi .= "TRK/".$v."/".$date."/".sprintf('%03s',$next);
                        break;
                    }
                }
                return $transaksi;
            }
        } else {
            throw new Exception("Parameter {$jenis} is invalid !",2);
        }
    } catch (\Execption $e) {
        echo $e->getMessage();
    }
}