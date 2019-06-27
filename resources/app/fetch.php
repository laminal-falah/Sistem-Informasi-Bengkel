<?php
session_start();
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

require_once '../path.php';
require_once(ABSPATH . '../config/config.php');
require_once(ABSPATH . '../config/database.php');
require_once(ABSPATH . '../config/enkripsi.php');
require_once(ABSPATH . '../config/header-json.php');
require_once(ABSPATH . '../config/functions.php');
require_once(ABSPATH . '../vendor/autoload.php');

$data = array();
function sanitate($v){
  global $link;
  return mysqli_real_escape_string($link, $v);
}

if (isset($_SESSION['is_logged'])) {
  $requestData = $_REQUEST;
  if (isset($_GET['f']) && isset($_GET['d'])) {
    $route = base64_decode($_GET['f']);
    $dest = base64_decode($_GET['d']);

    // API Export Start //
    if ($route == $enc['export'][0] && $dest == $enc['export'][1] && isset($_GET['tipe'])) {
      $tipe = $_GET['tipe'];
      if ($tipe == "user") {
        $sql = mysqli_query($link, "SELECT * FROM tb_users");
        $data['download'] = array(
          'code' => 1,
          'count' => mysqli_num_rows($sql)
        );
      } else if ($tipe == "alat") {
        $sql = mysqli_query($link, "SELECT * FROM tb_items WHERE code_category='alt'");
        $data['download'] = array(
          'code' => 1,
          'count' => mysqli_num_rows($sql)
        );
      } else if ($tipe == "sparepart") {
        $sql = mysqli_query($link, "SELECT * FROM tb_items WHERE code_category='smt' OR code_category='smb'");
        $data['download'] = array(
          'code' => 1,
          'count' => mysqli_num_rows($sql)
        );
      } elseif ($tipe == "peminjaman") {
        $sql = mysqli_query($link, "SELECT * FROM tb_loan");
        $data['download'] = array(
          'code' => 1,
          'count' => mysqli_num_rows($sql)
        );
      } elseif ($tipe == "pengembalian") {
        $sql = mysqli_query($link, "SELECT * FROM tb_return");
        $data['download'] = array(
          'code' => 1,
          'count' => mysqli_num_rows($sql)
        );
      } elseif ($tipe == "penjualan") {
        $sql = mysqli_query($link, "SELECT * FROM tb_selling");
        $data['download'] = array(
          'code' => 1,
          'count' => mysqli_num_rows($sql)
        );
      } elseif ($tipe == "pembelian") {
        $sql = mysqli_query($link, "SELECT * FROM tb_buying");
        $data['download'] = array(
          'code' => 1,
          'count' => mysqli_num_rows($sql)
        );
      } elseif ($tipe == "pengadaan") {
        $sql = mysqli_query($link, "SELECT * FROM tb_pengadaan");
        $data['download'] = array(
          'code' => 1,
          'count' => mysqli_num_rows($sql)
        );
      } else {
        $data['download'] = array(
          'code' => 0,
          'message' => 'Request invalid'
        );
      }
    } elseif ($route == $enc['export'][0] && $dest == $enc['export'][2] && isset($_GET['id'])) {
      $tipe = $_GET['id'];
      $awal = $requestData['awal'];
      $akhir = $requestData['akhir'];
      $filter = $requestData['filter'];
      $url = "";
      $awal -= 1; //$akhir==1?$akhir:$akhir-=1;
      if ($tipe == "user") {
        $a = base64_encode($enc['data-user']['remote']);
        $b = base64_encode($enc['data-user']['download']);
        if ($filter == "1" || $filter == "2") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=';
        } elseif ($filter == "3") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=' . $requestData['range'];
        } else {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=&range=';
        }
        $data['download'] = array(
          'code' => 1,
          'url' => $url
        );
      } elseif ($tipe == "alat") {
        $a = base64_encode($enc['data-alat']['remote']);
        $b = base64_encode($enc['data-alat']['download']);
        if ($filter == "1" || $filter == "2") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=';
        } elseif ($filter == "3") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=' . $requestData['range'];
        } else {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=&range=';
        }
        $data['download'] = array(
          'code' => 1,
          'url' => $url
        );
      } elseif ($tipe == "sparepart") {
        $a = base64_encode($enc['data-sparepart']['remote']);
        $b = base64_encode($enc['data-sparepart']['download']);
        if ($filter == "1" || $filter == "2") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=';
        } elseif ($filter == "3") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=' . $requestData['range'];
        } else {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=&range=';
        }
        $data['download'] = array(
          'code' => 1,
          'url' => $url
        );
      } elseif ($tipe == "peminjaman") {
        $a = base64_encode($enc['data-peminjaman']['remote']);
        $b = base64_encode($enc['data-peminjaman']['download']);
        if ($filter == "1" || $filter == "2") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=';
        } elseif ($filter == "3") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=' . $requestData['range'];
        } else {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=&range=';
        }
        $data['download'] = array(
          'code' => 1,
          'url' => $url
        );
      } elseif ($tipe == "pengembalian") {
        $a = base64_encode($enc['data-pengembalian']['remote']);
        $b = base64_encode($enc['data-pengembalian']['download']);
        if ($filter == "1" || $filter == "2") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=';
        } elseif ($filter == "3") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=' . $requestData['range'];
        } else {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=&range=';
        }
        $data['download'] = array(
          'code' => 1,
          'url' => $url
        );
      } elseif ($tipe == "penjualan") {
        $a = base64_encode($enc['data-penjualan']['remote']);
        $b = base64_encode($enc['data-penjualan']['download']);
        if ($filter == "1" || $filter == "2") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=';
        } elseif ($filter == "3") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=' . $requestData['range'];
        } else {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=&range=';
        }
        $data['download'] = array(
          'code' => 1,
          'url' => $url
        );
      } elseif ($tipe == "pembelian") {
        $a = base64_encode($enc['data-pembelian']['remote']);
        $b = base64_encode($enc['data-pembelian']['download']);
        if ($filter == "1" || $filter == "2") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=';
        } elseif ($filter == "3") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=' . $requestData['range'];
        } else {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=&range=';
        }
        $data['download'] = array(
          'code' => 1,
          'url' => $url
        );
      } elseif ($tipe == "pengadaan") {
        $a = base64_encode($enc['data-pengadaan']['remote']);
        $b = base64_encode($enc['data-pengadaan']['download']);
        if ($filter == "1" || $filter == "2") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=';
        } elseif ($filter == "3") {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=' . $filter . '&range=' . $requestData['range'];
        } else {
          $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&start=' . $awal . '&end=' . $akhir . '&filter=&range=';
        }
        $data['download'] = array(
          'code' => 1,
          'url' => $url
        );
      } else {
        $data['download'] = array(
          'code' => 0,
          'message' => 'Request invalid'
        );
      }
    }
    // API Export End //
    
    // API Manajemen Data Satuan Start //
    elseif ($route == $enc['data-satuan']['remote'] && $dest == $enc['data-satuan']['sha1'][0]) {
      $columns = array(
        'name_unit',
        'name_unit',
      );
      $sql = "SELECT * FROM tb_unit";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty(sanitate($requestData['search']['value']))) {
        $sql .= " WHERE name_unit LIKE '%" . sanitate($requestData['search']['value']) . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = base64_encode($enc['data-satuan']['sha1'][3]);
        $delete = base64_encode($enc['data-satuan']['sha1'][6]);

        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["name_unit"];
        if (hasPermit('update_user') && hasPermit('delete_user')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['id_unit'] . '" data-target="' . $edit . '">
              <i class="fa fa-edit"></i>
              <span>Edit</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['name_unit'] . '" data-content="' . $row['id_unit'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] = '';
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-satuan']['remote'] && $dest == $enc['data-satuan']['sha1'][2]) {
      $name = $requestData['nama'];
      $sql = mysqli_query($link,"INSERT INTO tb_unit VALUES(NULL,'$name')");
      if ($sql) {
        $data['satuan'] = array(
          'code' => 1,
          'message' => 'Data berhasil ditambahkan !'
        );
      } else {
        $data['satuan'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-satuan']['remote'] && $dest == $enc['data-satuan']['sha1'][3] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link,"SELECT * FROM tb_unit WHERE id_unit='$id'");
      if (mysqli_num_rows($sql) == 1) {
        $r = mysqli_fetch_assoc($sql);
        $data['satuan'] = array(
          'code' => 1,
          'data' => array(
              'id' => $r['id_unit'],
              'name' => $r['name_unit']
            )
        );
      } else {
        $data['satuan'] = array(
          'code' => 1,
          'message' => "Data ditemukan"
        );
      }
    } elseif ($route == $enc['data-satuan']['remote'] && $dest == $enc['data-satuan']['sha1'][4] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $nama = $requestData['nama'];
      $sql = mysqli_query($link,"UPDATE tb_unit SET name_unit='$nama' WHERE id_unit='$id'");
      if ($sql) {
        $data['satuan'] = array(
          'code' => 1,
          'message' => 'Data berhasil diubah !'
        );
      } else {
        $data['satuan'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-satuan']['remote'] && $dest == $enc['data-satuan']['sha1'][6] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $check = mysqli_query($link,"SELECT id_unit FROM tb_items WHERE id_unit='$id'");
      if (mysqli_num_rows($check) > 0) {
        $data['satuan'] = array(
          'code' => 0,
          'message' => 'Data tidak bisa dihapus !'
        );
      } else {
        $sql = mysqli_query($link,"DELETE FROM tb_unit WHERE id_unit='$id'");
        if ($sql) {
          $data['satuan'] = array(
            'code' => 1,
            'message' => 'Data berhasil di hapus !'
          );
        } else {
          $data['satuan'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    }
    // API Manajemen Data Satuan Start //

    // API Manajemen Data User Start //
    elseif ($route == $enc['data-user']['remote'] && $dest == $enc['data-user']['sha1'][0]) {
      $columns = array(
        'created_at',
        'nip',
        'name',
        'username',
        'display_rule',
        'status'
      );
      $sql = "SELECT id_user,nip,name,username,name_rule,status,created_at FROM tb_users AS u INNER JOIN tb_rules AS r ON u.id_rule = r.id_rule";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty(sanitate($requestData['search']['value']))) {
        $sql .= " WHERE name LIKE '%" . sanitate($requestData['search']['value']) . "%' ";
        $sql .= " OR username LIKE '%" . sanitate($requestData['search']['value']) . "%' ";
        $sql .= " OR nip LIKE '%" . sanitate($requestData['search']['value']) . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = base64_encode($enc['data-user']['sha1'][3]);
        $detail = base64_encode($enc['data-user']['sha1'][5]);
        $delete = base64_encode($enc['data-user']['sha1'][6]);
        $reset = base64_encode($enc['data-user']['sha1'][7]);

        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["nip"];
        $nestedData[] = $row["name"];
        $nestedData[] = $row["username"];
        $nestedData[] = ucwords(str_replace("_", "\r", $row['name_rule']));
        $nestedData[] = $row["status"] == 1 ? '<label class="label label-success">Aktif</label>' : '<label class="label label-danger">Tidak Aktif</label>';
        if (hasPermit('update_user') && hasPermit('delete_user')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['id_user'] . '" data-target="' . $edit . '">
              <i class="fa fa-edit"></i>
              <span>Edit</span>
            </a>&nbsp;
            <a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['id_user'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>&nbsp;
            <a id="reset" name="reset" class="btn btn-xs btn-default" title="Reset Data" title-content="' . $row['name'] . '" data-content="' . $row['id_user'] . '" data-target="' . $reset . '">
              <i class="fa fa-refresh"></i>
              <span>Reset Password</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['name'] . '" data-content="' . $row['id_user'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] =
            '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['id_user'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-user']['remote'] && $dest == $enc['data-user']['check'][2] && isset($_GET['nip'])) {
      $nip = sanitate($requestData['nip']);
      $sql = mysqli_query($link, "SELECT nip FROM tb_users WHERE nip='$nip'");
      if (mysqli_num_rows($sql) == 1) {
        $data = false;
      } else {
        $data = true;
      }
    } elseif ($route == $enc['data-user']['remote'] && $dest == $enc['data-user']['check'][0] && isset($_GET['username'])) {
      $username = sanitate($requestData['username']);
      $sql = mysqli_query($link, "SELECT username FROM tb_users WHERE username='$username'");
      if (mysqli_num_rows($sql) == 1) {
        $data = false;
      } else {
        $data = true;
      }
    } elseif ($route == $enc['data-user']['remote'] && $dest == $enc['data-user']['sha1'][2]) {
      $uuid = Uuid::uuid4();
      $id = $uuid->toString();
      $nip = sanitate($requestData['nip']);
      $name = ucwords(sanitate($requestData['nama']));
      $level = sanitate($requestData['level']);
      $stts = sanitate($requestData['status']);
      $user = sanitate($requestData['username']);
      $pass = sanitate($requestData['password']);
      $conf = sanitate($requestData['password_confirm']);
      $date = date('Y-m-d H:i:s', strtotime('now'));
      if ($pass == $conf) {
        $passnew = hash('sha512', $pass);
        $sql = mysqli_query($link, "INSERT INTO tb_users VALUES ('$id','$level','$name','$nip','$user','$passnew','$stts','$date','$date')");
        if ($sql) {
          $data['user'] = array(
            'code' => 1,
            'message' => 'Pengguna telah ditambahkan !'
          );
        } else {
          $data['user'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      } else {
        $data['user'] = array(
          'code' => 0,
          'message' => 'Konfirmasi password tidak sama dengan field password'
        );
      }
    } elseif ($route == $enc['data-user']['remote'] && $dest == $enc['data-user']['sha1'][3] && isset($_GET['id'])) {
      $id = sanitate($requestData['id']);
      $sql = mysqli_query($link, "SELECT id_user,nip,name,id_rule,status,username FROM tb_users WHERE id_user='$id' LIMIT 1");
      if (mysqli_num_rows($sql) == 1) {
        $r = mysqli_fetch_array($sql, MYSQLI_NUM);
        $data['user'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['user'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-user']['remote'] && $dest == $enc['data-user']['check'][3] && isset($_GET['id']) && isset($_GET['nip'])) {
      $id = sanitate($requestData['id']);
      $nip = sanitate($requestData['nip']);
      $sql = mysqli_query($link, "SELECT id_user,nip FROM tb_users WHERE id_user='$id' AND nip='$nip'");
      if (mysqli_num_rows($sql) == 1) {
        $data = true;
      } else {
        $sql = mysqli_query($link, "SELECT nip FROM tb_users WHERE nip='$nip'");
        if (mysqli_num_rows($sql) == 1) {
          $data = false;
        } else {
          $data = true;
        }
      }
    } elseif ($route == $enc['data-user']['remote'] && $dest == $enc['data-user']['check'][1] && isset($_GET['id']) && isset($_GET['username'])) {
      $id = sanitate($requestData['id']);
      $username = sanitate($requestData['username']);
      $sql = mysqli_query($link, "SELECT id_user,username FROM tb_users WHERE id_user='$id' AND username='$username'");
      if (mysqli_num_rows($sql) == 1) {
        $data = true;
      } else {
        $sql = mysqli_query($link, "SELECT username FROM tb_users WHERE username='$username'");
        if (mysqli_num_rows($sql) == 1) {
          $data = false;
        } else {
          $data = true;
        }
      }
    } elseif ($route == $enc['data-user']['remote'] && $dest == $enc['data-user']['sha1'][4] && isset($_GET['id'])) {
      $id = sanitate($requestData['id']);
      $nip = sanitate($requestData['nip']);
      $name = ucwords(sanitate($requestData['nama']));
      $level = sanitate($requestData['level']);
      $stts = sanitate($requestData['status']);
      $user = sanitate($requestData['username']);
      $date = date('Y-m-d H:i:s', strtotime('now'));
      $sql = mysqli_query($link, "UPDATE tb_users SET nip='$nip', name='$name', id_rule='$level', status='$stts', username='$user', updated_at='$date' WHERE id_user='$id'");
      if ($sql) {
        if ($_SESSION['id'] == $id) {
          $ch = mysqli_fetch_assoc(mysqli_query($link, "SELECT id_user, name FROM tb_users WHERE id_user='$id' LIMIT 1"));
          $_SESSION['name'] = $ch['name'];
        }
        $data['user'] = array(
          'code' => 1,
          'message' => 'Data berhasil diubah !'
        );
      } else {
        $data['user'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-user']['remote'] && $dest == $enc['data-user']['sha1'][5] && isset($_GET['id'])) {
      $id = sanitate($requestData['id']);
      $query = "SELECT id_user,nip,name,username,name_rule,status,created_at FROM tb_users AS u
                INNER JOIN tb_rules AS r ON u.id_rule = r.id_rule
                WHERE id_user='$id'";
      $sql = mysqli_query($link, $query);
      if (mysqli_num_rows($sql) == 1) {
        $r = mysqli_fetch_assoc($sql);
        $data['user'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['user'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-user']['remote'] && $dest == $enc['data-user']['sha1'][6] && isset($_GET['id'])) {
      $id = sanitate($requestData['id']);
      $sql = mysqli_query($link, "DELETE FROM tb_users WHERE id_user='$id'");
      if ($sql) {
        $data['user'] = array(
          'code' => 1,
          'message' => 'Data berhasil dihapus'
        );
      } else {
        $data['user'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-user']['remote'] && $dest == $enc['data-user']['sha1'][7] && isset($_GET['id'])) {
      $id = sanitate($requestData['id']);
      $passnew = hash('sha512', '12345678');
      $date = date('Y-m-d H:i:s', strtotime('now'));
      $sql = mysqli_query($link, "UPDATE tb_users SET password='$passnew', updated_at='$date' WHERE id_user='$id'");
      if ($sql) {
        $data['user'] = array(
          'code' => 1,
          'message' => '<p>Password sudah direset &nbsp;"<b>12345678</b></p>"'
        );
      } else {
        $data['user'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }
    // API Manajemen Data User End //

    // API Manajemen Data Alat Start //
    elseif ($route == $enc['data-alat']['remote'] && $dest == $enc['data-alat']['sha1'][0]) {
      $columns = array(
        'created_at',
        'code_item',
        'name_item',
        'total_stock',
        'status'
      );
      $sql = "SELECT created_at,code_item,name_item,total_stock,status,name_unit FROM tb_items AS i
              INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
              INNER JOIN tb_categories AS c ON c.code_category = i.code_category
              WHERE c.name_category='Alat'";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value'])) {
        $sql .= " AND code_item LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR name_item LIKE '%" . $requestData['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = base64_encode($enc['data-alat']['sha1'][3]);
        $detail = base64_encode($enc['data-alat']['sha1'][5]);
        $delete = base64_encode($enc['data-alat']['sha1'][6]);
        $penggunaan = base64_encode($enc['data-alat']['sha1'][7]);

        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["code_item"];
        $nestedData[] = $row["name_item"];
        $nestedData[] = $row["total_stock"] . " " . $row['name_unit'];
        $nestedData[] = $row["status"] == 1 ? '<label class="label label-success">Baik</label>' : '<label class="label label-danger">Buruk</label>';
        if (hasPermit('update_tool') && hasPermit('delete_tool')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['code_item'] . '" data-target="' . $edit . '">
              <i class="fa fa-edit"></i>
              <span>Edit</span>
            </a>&nbsp;
            <a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_item'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>&nbsp;
            <a id="penggunaan" name="penggunaan" class="btn btn-xs btn-success" title="Penggunaan Data" data-content="' . $row['code_item'] . '" data-target="' . $penggunaan . '">
              <i class="fa fa-gears"></i>
              <span>penggunaan</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['name_item'] . '" data-content="' . $row['code_item'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] =
            '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_item'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-alat']['remote'] && $dest == $enc['data-alat']['sha1'][2]) {
      $nama = ucwords($requestData['nama']);
      $stok = str_replace('.', '', $requestData['stok']);
      $unit = $requestData['satuan'];
      $beli = str_replace('.', '', $requestData['harga_beli']);
      $loct = ucwords($requestData['lokasi']);
      $cond = $requestData['kondisi'];
      $desc = $requestData['description'] != "" ? $requestData['description'] : '<p>-</p>';
      $imge = $_FILES['gambar']['name'];
      $date = date('Y-m-d H:i:s', strtotime('now'));

      $kode = buatkode(1, $nama);
      if ($imge != "") {
        $ext = explode(".", $imge);
        if ($ext[1] == "jpg" || $ext[1] == "jpeg" || $ext[1] == "png" || $ext[1] == "gif" || $ext[1] == "bmp") {
          $tmp = $_FILES['gambar']['tmp_name'];
          $cover = uniqid() . "." . $ext[1];
          $path = ABSPATH . "../assets/img/alat/" . $cover;
          if (move_uploaded_file($tmp, $path)) {
            $sql = "INSERT INTO tb_items VALUES('$kode','alt','$unit','$nama','$stok','0','0','$stok','0','$beli','$cover','$cond','$loct','$desc','$date','$date')";
            $exec = mysqli_query($link, $sql);
            if ($exec) {
              $data['alat'] = array(
                'code' => 1,
                'message' => 'Data berhasil disimpan'
              );
            } else {
              $data['alat'] = array(
                'code' => 0,
                'message' => mysqli_error($link)
              );
            }
          } else {
            $data['alat'] = array(
              'code' => 0,
              'message' => 'Gagal upload gambar ' . $imge . ' !'
            );
          }
        } else {
          $data['alat'] = array(
            'code' => 0,
            'message' => 'Format gambar harus *.jpg, *.jpeg, *.png, *.bmp, *.gif !'
          );
        }
      } else {
        $sql = "INSERT INTO tb_items VALUES('$kode','alt','$unit','$nama','$stok','0','0','$stok','0','$beli','default.png','$cond','$loct','$desc','$date','$date')";
        $exec = mysqli_query($link, $sql);
        if ($exec) {
          $data['alat'] = array(
            'code' => 1,
            'message' => 'Data berhasil disimpan'
          );
        } else {
          $data['alat'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    } elseif ($route == $enc['data-alat']['remote'] && $dest == $enc['data-alat']['sha1'][3] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link, "SELECT code_item,name_item,total_stock,id_unit,price_buy,location,status,description,
              cover FROM tb_items WHERE code_item='$id' LIMIT 1");
      if (mysqli_num_rows($sql) == 1) {
        $r = mysqli_fetch_array($sql, MYSQLI_NUM);
        $data['alat'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['alat'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-alat']['remote'] && $dest == $enc['data-alat']['sha1'][4] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $nama = ucwords($requestData['nama']);
      $stok = str_replace('.', '', $requestData['stok']);
      $unit = $requestData['satuan'];
      $beli = str_replace('.', '', $requestData['harga_beli']);
      $loct = ucwords($requestData['lokasi']);
      $cond = $requestData['kondisi'];
      $desc = $requestData['description'] != "" ? $requestData['description'] : '<p>-</p>';
      $imge = $_FILES['gambar']['name'];
      $date = date('Y-m-d H:i:s', strtotime('now'));

      if ($imge != "") {
        $ext = explode(".", $imge);
        if ($ext[1] == "jpg" || $ext[1] == "jpeg" || $ext[1] == "png" || $ext[1] == "gif" || $ext[1] == "bmp") {
          $tmp = $_FILES['gambar']['tmp_name'];
          $cover = uniqid() . "." . $ext[1];
          $path = ABSPATH . "../assets/img/alat/" . $cover;
          if (move_uploaded_file($tmp, $path)) {
            $sql = "UPDATE tb_items SET name_item='$nama',good_item=good_item+'$stok',total_stock=total_stock+'$stok',id_unit='$unit',
                    price_buy='$beli',location='$loct',status='$cond',description='$desc',cover='$cover',updated_at='$date'
                    WHERE code_item='$id'";
            $exec = mysqli_query($link, $sql);
            if ($exec) {
              $data['alat'] = array(
                'code' => 1,
                'message' => 'Data berhasil diubah'
              );
            } else {
              $data['alat'] = array(
                'code' => 0,
                'message' => mysqli_error($link)
              );
            }
          } else {
            $data['alat'] = array(
              'code' => 0,
              'message' => 'Gagal upload gambar ' . $imge . ' !'
            );
          }
        } else {
          $data['alat'] = array(
            'code' => 0,
            'message' => 'Format gambar harus *.jpg, *.jpeg, *.png, *.bmp, *.gif !'
          );
        }
      } else {
        $sql = "UPDATE tb_items SET name_item='$nama',good_item=good_item+'$stok',total_stock=total_stock+'$stok',id_unit='$unit',
                price_buy='$beli',location='$loct',status='$cond',description='$desc',updated_at='$date'
                WHERE code_item='$id'";
        $exec = mysqli_query($link, $sql);
        if ($exec) {
          $data['alat'] = array(
            'code' => 1,
            'message' => 'Data berhasil diubah'
          );
        } else {
          $data['alat'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    } elseif ($route == $enc['data-alat']['remote'] && $dest == $enc['data-alat']['sha1'][7] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $q = "SELECT code_item,good_item,broken_item,lost_item,code_item,name_item,total_stock,name_unit FROM tb_items AS i 
            INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit 
            WHERE i.code_item='$id' LIMIT 1";
      $sql = mysqli_query($link, $q);
      if (mysqli_num_rows($sql) == 1) {
        $r = mysqli_fetch_array($sql, MYSQLI_NUM);
        $data['alat'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['alat'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-alat']['remote'] && $dest == $enc['data-alat']['sha1'][8] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $good = str_replace('.', '', $requestData['good']);
      $broken = str_replace('.', '', $requestData['broken']);
      $lost = str_replace('.', '', $requestData['lost']);
      $sql = "UPDATE tb_items SET good_item='$good', broken_item='$broken', lost_item='$lost' WHERE code_item='$id'";
      $exec = mysqli_query($link, $sql);
      if ($exec) {
        $data['alat'] = array(
          'code' => 1,
          'message' => 'Data berhasil diubah'
        );
      } else {
        $data['alat'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-alat']['remote'] && $dest == $enc['data-alat']['sha1'][5] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $query = "SELECT cover,code_item,name_item,name_category,good_item,broken_item,lost_item,total_stock,
                name_unit,price_sale,price_buy,location,status,description,created_at,updated_at FROM tb_items AS i
                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                WHERE i.code_item = '$id'";
      $sql = mysqli_query($link, $query);
      if (mysqli_num_rows($sql) == 1) {
        $r = mysqli_fetch_array($sql, MYSQLI_NUM);
        $data['alat'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['alat'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-alat']['remote'] && $dest == $enc['data-alat']['sha1'][6] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = "SELECT i.code_item FROM tb_items AS i
              INNER JOIN tb_loan_details AS l ON l.code_item = i.code_item
              INNER JOIN tb_return_details AS r ON r.code_item = i.code_item
              INNER JOIN tb_selling_details AS s ON s.code_item = i.code_item
              INNER JOIN tb_buying_details AS b ON b.code_item = i.code_item
              INNER JOIN tb_pengadaan_details AS p ON p.code_item = i.code_item
              WHERE i.code_item='$id'";
      $check = mysqli_query($link,$sql);
      if (mysqli_num_rows($check) > 0) {
        $data['alat'] = array(
          'code' => 0,
          'message' => 'Data masih dikaitkan dengan data lainnya !'
        );
      } else {
        $img = mysqli_fetch_assoc(mysqli_query($link, "SELECT cover FROM tb_items WHERE code_item='$id'"));
        if ($img['cover'] != "default.png" || $img['cover'] == "") {
          unlink(ABSPATH . "../assets/img/alat/" . $img['cover']) or die("Failed to delete");
        }
        $sql = mysqli_query($link, "DELETE FROM tb_items WHERE code_item='$id'");
        if ($sql) {
          $data['alat'] = array(
            'code' => 1,
            'message' => 'Data berhasil dihapus'
          );
        } else {
          $data['alat'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    }
    // API Manajemen Data Alat End //

    // API Manajemen Data Sparepart Start //
    elseif ($route == $enc['data-sparepart']['remote'] && $dest == $enc['data-sparepart']['sha1'][0]) {
      $columns = array(
        'created_at',
        'code_item',
        'name_item',
        'total_stock',
        'status'
      );
      $sql = "SELECT created_at,code_item,name_item,total_stock,status,name_unit FROM tb_items AS i
              INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
              INNER JOIN tb_categories AS c ON c.code_category = i.code_category
              WHERE c.name_category='Sparepart Motor' OR c.name_category='Sparepart Mobil'";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value'])) {
        $sql .= " AND code_item LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR name_item LIKE '%" . $requestData['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = base64_encode($enc['data-sparepart']['sha1'][3]);
        $detail = base64_encode($enc['data-sparepart']['sha1'][5]);
        $delete = base64_encode($enc['data-sparepart']['sha1'][6]);
        $penggunaan = base64_encode($enc['data-sparepart']['sha1'][7]);

        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["code_item"];
        $nestedData[] = $row["name_item"];
        $nestedData[] = $row["total_stock"] . " " . $row['name_unit'];
        $nestedData[] = $row["status"] == 1 ? '<label class="label label-success">Baik</label>' : '<label class="label label-danger">Buruk</label>';
        if (hasPermit('update_sparepart') && hasPermit('delete_sparepart')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['code_item'] . '" data-target="' . $edit . '">
            <i class="fa fa-edit"></i>
            <span>Edit</span>
          </a>&nbsp;
          <a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_item'] . '" data-target="' . $detail . '">
            <i class="fa fa-list"></i>
            <span>Detail</span>
          </a>&nbsp;
          <a id="penggunaan" name="penggunaan" class="btn btn-xs btn-success" title="Penggunaan Data" data-content="' . $row['code_item'] . '" data-target="' . $penggunaan . '">
            <i class="fa fa-gears"></i>
            <span>penggunaan</span>
          </a>&nbsp;
          <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['name_item'] . '" data-content="' . $row['code_item'] . '" data-target="' . $delete . '">
            <i class="fa fa-trash"></i>
            <span>Hapus</span>
          </a>';
        } else {
          $nestedData[] =
            '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_item'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-sparepart']['remote'] && $dest == $enc['data-sparepart']['sha1'][2]) {
      $idSp = $requestData['sparepart'];
      $nama = ucwords($requestData['nama']);
      $stok = str_replace('.', '', $requestData['stok']);
      $unit = $requestData['satuan'];
      $beli = str_replace('.', '', $requestData['harga_beli']);
      $jual = str_replace('.', '', $requestData['harga_jual']);
      $loct = ucwords($requestData['lokasi']);
      $cond = $requestData['kondisi'];
      $desc = $requestData['description'] != "" ? $requestData['description'] : '<p>-</p>';
      $imge = $_FILES['gambar']['name'];
      $date = date('Y-m-d H:i:s', strtotime('now'));
      $id = $idSp == "smt" ? 2 : 3;
      $kode = buatkode($id, $nama);
      if ($imge != "") {
        $ext = explode(".", $imge);
        if ($ext[1] == "jpg" || $ext[1] == "jpeg" || $ext[1] == "png" || $ext[1] == "gif" || $ext[1] == "bmp") {
          $tmp = $_FILES['gambar']['tmp_name'];
          $cover = uniqid() . "." . $ext[1];
          $path = ABSPATH . "../assets/img/sparepart/" . $cover;
          if (move_uploaded_file($tmp, $path)) {
            $sql = "INSERT INTO tb_items VALUES('$kode','$idSp','$unit','$nama','$stok','0','0','$stok','$jual','$beli','$cover','$cond','$loct','$desc','$date','$date')";
            $exec = mysqli_query($link, $sql);
            if ($exec) {
              $data['sparepart'] = array(
                'code' => 1,
                'message' => 'Data berhasil disimpan'
              );
            } else {
              $data['sparepart'] = array(
                'code' => 0,
                'message' => mysqli_error($link)
              );
            }
          } else {
            $data['sparepart'] = array(
              'code' => 0,
              'message' => 'Gagal upload gambar ' . $imge . ' !'
            );
          }
        } else {
          $data['sparepart'] = array(
            'code' => 0,
            'message' => 'Format gambar harus *.jpg, *.jpeg, *.png, *.bmp, *.gif !'
          );
        }
      } else {
        $sql = "INSERT INTO tb_items VALUES('$kode','$idSp','$unit','$nama','$stok','0','0','$stok','$jual','$beli','default.png','$cond','$loct','$desc','$date','$date')";
        $exec = mysqli_query($link, $sql);
        if ($exec) {
          $data['sparepart'] = array(
            'code' => 1,
            'message' => 'Data berhasil disimpan'
          );
        } else {
          $data['sparepart'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    } elseif ($route == $enc['data-sparepart']['remote'] && $dest == $enc['data-sparepart']['sha1'][3] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link, "SELECT code_item,name_item,total_stock,id_unit,price_buy,price_sale,location,status,description,
              cover FROM tb_items WHERE code_item='$id' LIMIT 1");
      if (mysqli_num_rows($sql) == 1) {
        $r = mysqli_fetch_array($sql, MYSQLI_NUM);
        $data['sparepart'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['sparepart'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-sparepart']['remote'] && $dest == $enc['data-sparepart']['sha1'][4] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $nama = ucwords($requestData['nama']);
      $stok = str_replace('.', '', $requestData['stok']);
      $unit = $requestData['satuan'];
      $beli = str_replace('.', '', $requestData['harga_beli_edit']);
      $jual = str_replace('.', '', $requestData['harga_jual_edit']);
      $loct = ucwords($requestData['lokasi']);
      $cond = $requestData['kondisi'];
      $desc = $requestData['description'] != "" ? $requestData['description'] : '<p>-</p>';
      $imge = $_FILES['gambar']['name'];
      $date = date('Y-m-d H:i:s', strtotime('now'));

      if ($imge != "") {
        $ext = explode(".", $imge);
        if ($ext[1] == "jpg" || $ext[1] == "jpeg" || $ext[1] == "png" || $ext[1] == "gif" || $ext[1] == "bmp") {
          $tmp = $_FILES['gambar']['tmp_name'];
          $cover = uniqid() . "." . $ext[1];
          $path = ABSPATH . "../assets/img/sparepart/" . $cover;
          if (move_uploaded_file($tmp, $path)) {
            $sql = "UPDATE tb_items SET name_item='$nama',good_item=good_item+'$stok',total_stock=total_stock+'$stok',id_unit='$unit',
                    price_buy='$beli',price_sale='$jual',location='$loct',status='$cond',description='$desc',cover='$cover',updated_at='$date'
                    WHERE code_item='$id'";
            $exec = mysqli_query($link, $sql);
            if ($exec) {
              $data['sparepart'] = array(
                'code' => 1,
                'message' => 'Data berhasil diubah'
              );
            } else {
              $data['sparepart'] = array(
                'code' => 0,
                'message' => mysqli_error($link)
              );
            }
          } else {
            $data['sparepart'] = array(
              'code' => 0,
              'message' => 'Gagal upload gambar ' . $imge . ' !'
            );
          }
        } else {
          $data['sparepart'] = array(
            'code' => 0,
            'message' => 'Format gambar harus *.jpg, *.jpeg, *.png, *.bmp, *.gif !'
          );
        }
      } else {
        $sql = "UPDATE tb_items SET name_item='$nama',good_item=good_item+'$stok',total_stock=total_stock+'$stok',id_unit='$unit',
                price_buy='$beli',price_sale='$jual',location='$loct',status='$cond',description='$desc',updated_at='$date'
                WHERE code_item='$id'";
        $exec = mysqli_query($link, $sql);
        if ($exec) {
          $data['sparepart'] = array(
            'code' => 1,
            'message' => 'Data berhasil diubah'
          );
        } else {
          $data['sparepart'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    } elseif ($route == $enc['data-sparepart']['remote'] && $dest == $enc['data-sparepart']['sha1'][7] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $q = "SELECT code_item,good_item,broken_item,lost_item,code_item,name_item,total_stock,name_unit FROM tb_items AS i 
            INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit 
            WHERE i.code_item='$id' LIMIT 1";
      $sql = mysqli_query($link, $q);
      if (mysqli_num_rows($sql) == 1) {
        $r = mysqli_fetch_array($sql, MYSQLI_NUM);
        $data['sparepart'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['sparepart'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-sparepart']['remote'] && $dest == $enc['data-sparepart']['sha1'][8] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $good = str_replace('.', '', $requestData['good']);
      $broken = str_replace('.', '', $requestData['broken']);
      $lost = str_replace('.', '', $requestData['lost']);
      $sql = "UPDATE tb_items SET good_item='$good', broken_item='$broken', lost_item='$lost' WHERE code_item='$id'";
      $exec = mysqli_query($link, $sql);
      if ($exec) {
        $data['sparepart'] = array(
          'code' => 1,
          'message' => 'Data berhasil diubah'
        );
      } else {
        $data['sparepart'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-sparepart']['remote'] && $dest == $enc['data-sparepart']['sha1'][5] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $query = "SELECT cover,code_item,name_item,name_category,good_item,broken_item,lost_item,total_stock,name_unit,
                price_sale,price_buy,location,status,description,created_at,updated_at FROM tb_items AS i
                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                WHERE i.code_item = '$id'";
      $sql = mysqli_query($link, $query);
      if (mysqli_num_rows($sql) == 1) {
        $r = mysqli_fetch_array($sql, MYSQLI_NUM);
        $data['sparepart'] = array(
          'code' => 1,
          'data' => $r,
        );
      } else {
        $data['sparepart'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-sparepart']['remote'] && $dest == $enc['data-sparepart']['sha1'][6] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = "SELECT i.code_item FROM tb_items AS i
              INNER JOIN tb_loan_details AS l ON l.code_item = i.code_item
              INNER JOIN tb_return_details AS r ON r.code_item = i.code_item
              INNER JOIN tb_selling_details AS s ON s.code_item = i.code_item
              INNER JOIN tb_buying_details AS b ON b.code_item = i.code_item
              INNER JOIN tb_pengadaan_details AS p ON p.code_item = i.code_item
              WHERE i.code_item='$id'";
      $check = mysqli_query($link,$sql);
      if (mysqli_num_rows($check) > 0) {
        $data['sparepart'] = array(
          'code' => 0,
          'message' => 'Data masih dikaitkan dengan data lainnya !'
        );
      } else {
        $img = mysqli_fetch_assoc(mysqli_query($link, "SELECT cover FROM tb_items WHERE code_item='$id'"));
        if ($img['cover'] != "default.png" || $img['cover'] == "") {
          unlink(ABSPATH . "../assets/img/sparepart/" . $img['cover']) or die("Failed to delete");
        }
        $sql = mysqli_query($link, "DELETE FROM tb_items WHERE code_item='$id'");
        if ($sql) {
          $data['sparepart'] = array(
            'code' => 1,
            'message' => 'Data berhasil dihapus'
          );
        } else {
          $data['sparepart'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    }
    // API Manajemen Data Sparepart End //

    // API Transaksi Peminjaman Start //
    elseif ($route == $enc['data-peminjaman']['remote'] && $dest == $enc['data-peminjaman']['sha1'][0]) {
      $columns = array(
        'created_at',
        'code_loan',
        'name_loan',
        'created_at',
        'due_date',
        'status'
      );
      $sql = "SELECT created_at,code_loan,name_loan,due_date,status FROM tb_loan";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value'])) {
        $sql .= " WHERE code_loan LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR name_loan LIKE '%" . $requestData['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = base64_encode($enc['data-peminjaman']['sha1'][3]);
        $detail = base64_encode($enc['data-peminjaman']['sha1'][5]);
        $delete = base64_encode($enc['data-peminjaman']['sha1'][6]);
        $status = $row['status'];
        if ($status == 1) {
          $msg = '<label class="label label-success">Telah dikembalikan</label>';
        } else {
          $today = new DateTime(date('Y-m-d H:i:s',strtotime('now')));
          $exp = new DateTime(date('Y-m-d H:i:s',strtotime($row["due_date"])));
          if ($today > $exp) {
            $msg = '<label class="label label-danger">Telah lewat jatuh tempo</label>';
          } else {
            $msg = '<label class="label label-warning">Masih dipinjam</label>';
          }
        }
        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["code_loan"];
        $nestedData[] = $row["name_loan"];
        $nestedData[] = date("d-m-Y, H:i", strtotime($row["created_at"]));
        $nestedData[] = date("d-m-Y, H:i", strtotime($row["due_date"]));
        $nestedData[] = $msg;
        if (hasPermit('update_loaning') && hasPermit('delete_loaning')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['code_loan'] . '" data-target="' . $edit . '">
            <i class="fa fa-edit"></i>
            <span>Edit</span>
            </a>&nbsp;
            <a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_loan'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['name_loan'] . '" data-content="' . $row['code_loan'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] =
            '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_loan'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-peminjaman']['remote'] && $dest == $enc['data-peminjaman']['sha1'][1]) {
      $sql = "SELECT created_at,name_item,name_category,good_item,code_item,name_unit FROM tb_items AS i
              INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
              INNER JOIN tb_categories AS c ON c.code_category = i.code_category
              WHERE i.good_item > 0
              ORDER BY i.created_at DESC LIMIT 0,3";
      $query = mysqli_query($link, $sql) or die("error1");
      if (mysqli_num_rows($query) > 0) {
        $a = array();
        $i = 0;
        while ($r = mysqli_fetch_assoc($query)) {
          $max = $r['good_item'];
          $code = $r['code_item'];
          $i++;
          $a[] = array(
            'no' => $i . ".",
            'items' => $r['name_item'],
            'category' => $r['name_category'],
            'stock' => $max . " " . $r['name_unit'],
            'checkbox' => "<input type=\"checkbox\" id=\"pinjam\" name=\"pinjam[$code]\"> Ya</div>",
            'amount' => "<input type=\"number\" id=\"jumlah\" name=\"jumlah[$code]\" class=\"form-control input-sm\" placeholder=\"Jumlah\" value=\"1\" min=\"1\" max=\"$max\" disabled required>"
          );
        }
        $data['peminjaman'] = array(
          'code' => 1,
          'total' => mysqli_num_rows(mysqli_query($link,"SELECT * FROM tb_items WHERE good_item > 0")),
          'filter' => $i,
          'data' => $a
        );
      } else {
        $data['peminjaman'] = array(
          'code' => 0,
          'message' => 'Stok Peralatan Kosong !',
        );
      }
    } elseif ($route == $enc['data-peminjaman']['remote'] && $dest == $enc['data-peminjaman']['sha1'][7]) {
      $awal = $requestData['awal'];
      $sql = "SELECT created_at,name_item,name_category,good_item,code_item,name_unit FROM tb_items AS i
              INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
              INNER JOIN tb_categories AS c ON c.code_category = i.code_category
              WHERE good_item > 0
              ORDER BY i.created_at DESC LIMIT $awal,3";
      $query = mysqli_query($link, $sql) or die("error1");
      if (mysqli_num_rows($query) > 0) {
        $a = array();
        $i = $awal;
        while ($r = mysqli_fetch_assoc($query)) {
          $max = $r['good_item'];
          $code = $r['code_item'];
          $i++;
          $a[] = array(
            'no' => $i . ".",
            'items' => $r['name_item'],
            'category' => $r['name_category'],
            'stock' => $max . " " . $r['name_unit'],
            'checkbox' => "<input type=\"checkbox\" id=\"pinjam\" name=\"pinjam[$code]\"> Ya",
            'amount' => "<input type=\"number\" id=\"jumlah\" name=\"jumlah[$code]\" class=\"form-control input-sm\" placeholder=\"Jumlah\" value=\"1\" min=\"1\" max=\"$max\" disabled required>"
          );
        }
        $data['peminjaman'] = array(
          'code' => 1,
          'total' => mysqli_num_rows(mysqli_query($link,"SELECT code_item FROM tb_items WHERE good_item > 0")),
          'filter' => $i,
          'data' => $a
        );
      } else {
        $data['peminjaman'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-peminjaman']['remote'] && $dest == $enc['data-peminjaman']['sha1'][2]) {
      if (!(@$requestData['pinjam'] || @$requestData['jumlah'])) {
        $data['peminjaman'] = array(
          'code' => 0,
          'message' => 'Checklist items !',
        );
      } else {
        $nama = ucwords($requestData['nama']);
        $pjmn = $requestData['pinjam'];
        $jmlh = $requestData['jumlah'];
        $drsi = $requestData['durasi'];
        $due = date('Y-m-d H:i:s',strtotime($drsi));
        $date = date('Y-m-d H:i:s', strtotime('now'));
        $kode = kodetransaksi(1);
        $sql = mysqli_query($link,"INSERT INTO tb_loan VALUES('$kode','$nama','0','$due','$date')");
        if ($sql) {
          foreach ($jmlh as $key => $value) {
            mysqli_query($link,"INSERT INTO tb_loan_details VALUES(NULL,'$kode','$key','$value')");
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item-'$value',total_stock=total_stock-'$value' WHERE code_item='$key'");
          }
          $data['peminjaman'] = array(
            'code' => 1,
            'message' => 'Data berhasil disimpan !',
          );
        } else {
          $data['peminjaman'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    } elseif ($route == $enc['data-peminjaman']['remote'] && $dest == $enc['data-peminjaman']['sha1'][3] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $check = mysqli_query($link,"SELECT code_loan,status FROM tb_loan WHERE code_loan='$id'");
      $row = mysqli_fetch_assoc($check);

      if (mysqli_num_rows($check) > 0 && $row['status'] == 0) {
        $a = array();
        $b = array();
        $query = "SELECT l.code_loan, name_loan, due_date, l.status, d.code_item, name_item, name_category, amount, i.good_item, u.name_unit FROM tb_loan_details AS d
                INNER JOIN tb_loan AS l ON l.code_loan = d.code_loan
                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                WHERE l.code_loan='$id'";
        $sql = mysqli_query($link, $query);
        while ($r = mysqli_fetch_assoc($sql)) {
          $max = $r['good_item'];
          $code = $r['code_item'];
          $a[] = array(
            'name' => $r['name_item'],
            'category' => $r['name_category'],
            'stock' => $max . " " . $r['name_unit'],
            'amount' => $r['amount'] . " " . $r['name_unit'],
            'checkbox' => "<input type=\"checkbox\" id=\"tambah\" name=\"tambah[$code]\"> Ya</div>",
            'jumlah' => "<input type=\"number\" id=\"jumlah_edit\" name=\"jumlah[$code]\" class=\"form-control input-sm\" placeholder=\"Jumlah\" value=\"1\" min=\"1\" max=\"$max\" disabled required>"
          );
          $b = array(
            'code' => $r['code_loan'],
            'name' => $r['name_loan'],
            'exp' => $r['due_date'],
          );
        }
        $data['peminjaman'] = array(
          'code' => 1,
          'data' => array(
            'peminjam' => $b,
            'peralatan' => $a
          )
        );
      } elseif ($row['status'] == 1) {
        $data['peminjaman'] = array(
          'code' => 0,
          'message' => 'Peralatan atau sparepart sudah dikembalikan !',
        );
      } else {
        $data['peminjaman'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-peminjaman']['remote'] && $dest == $enc['data-peminjaman']['sha1'][4] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $nama = ucwords($requestData['nama']);
      $drsi = $requestData['durasi_edit'];
      $due = date('Y-m-d H:i:s',strtotime($drsi));
      $jumlah = @$requestData['jumlah'];
      $sql = mysqli_query($link,"UPDATE tb_loan SET name_loan='$nama', due_date='$due' WHERE code_loan='$id'");
      if ($sql) {
        if ($jumlah != 0) {
          foreach ($jumlah as $key => $value) {
            mysqli_query($link,"UPDATE tb_loan_details SET amount=amount+'$value' WHERE code_loan='$id' AND code_item='$key'");
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item-'$value',total_stock=total_stock-'$value' WHERE code_item='$key'");
          }
        }
        $data['peminjaman'] = array(
          'code' => 1,
          'message' => 'Data berhasil diubah !',
        );
      } else {
        $data['peminjaman'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-peminjaman']['remote'] && $dest == $enc['data-peminjaman']['sha1'][5] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $query = "SELECT d.code_loan, name_loan, due_date, l.created_at, d.code_item, name_item, name_category, amount, name_unit, l.status FROM tb_loan_details AS d
                INNER JOIN tb_loan AS l ON l.code_loan = d.code_loan
                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                WHERE l.code_loan='$id'";
      $sql = mysqli_query($link, $query);
      if (mysqli_num_rows($sql) > 0) {
        $a = array();
        $b = array();
        while ($r = mysqli_fetch_assoc($sql)) {
          $status = $r['status'];
          if ($status == 1) {
            $msg = '<label class="label label-success">Telah dikembalikan</label>';
          } else {
            $today = new DateTime(date('Y-m-d H:i:s',strtotime('now')));
            $exp = new DateTime(date('Y-m-d H:i:s',strtotime($r["due_date"])));
            if ($today > $exp) {
              $msg = '<label class="label label-danger">Telah lewat jatuh tempo</label>';
            } else {
              $msg = '<label class="label label-warning">Masih dipinjam</label>';
            }
          }
          $a[] = array(
            'code' => $r['code_item'],
            'name' => $r['name_item'],
            'category' => $r['name_category'],
            'amount' => $r['amount'],
            'unit' => $r['name_unit']
          );
          $b = array(
            'code' => $r['code_loan'],
            'name' => $r['name_loan'],
            'create' => $r['created_at'],
            'exp' => $r['due_date'],
            'status' => $msg,
          );
        }
        $data['peminjaman'] = array(
          'code' => 1,
          'data' => array(
            'peminjam' => $b,
            'peralatan' => $a
          )
        );
      } else {
        $data['peminjaman'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-peminjaman']['remote'] && $dest == $enc['data-peminjaman']['sha1'][6] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $check = mysqli_query($link,"SELECT * FROM tb_loan WHERE code_loan='$id' AND status='0'");
      if (mysqli_num_rows($check) == 1) {
        $sqlUpdateItem = mysqli_query($link,"SELECT code_item,amount FROM tb_loan_details WHERE code_loan='$id'");
        while ($a = mysqli_fetch_assoc($sqlUpdateItem)) {
          $code = $a['code_item'];
          $item = $a['amount'];
          mysqli_query($link,"UPDATE tb_items SET good_item=good_item+'$item', total_stock=total_stock+'$item' WHERE code_item='$code'");
        }
      }
      $sql = mysqli_query($link, "DELETE FROM tb_loan WHERE code_loan='$id'");
      if ($sql) {
        $data['peminjaman'] = array(
          'code' => 1,
          'message' => 'Data berhasil dihapus'
        );
      } else {
        $data['peminjaman'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }
    // API Transaksi Peminjaman End //

    // API Transaksi Pengembalian Start //
    elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['sha1'][0]) {
      $columns = array(
        'created_at',
        'code_return',
        'code_loan',
        'name_return',
        'pin',
        'created_at'
      );
      $sql = "SELECT created_at,code_return,code_loan,name_return,pin FROM tb_return";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value'])) {
        $sql .= " WHERE code_return LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR code_loan LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR name_return LIKE '%" . $requestData['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = base64_encode($enc['data-pengembalian']['sha1'][3]);
        $detail = base64_encode($enc['data-pengembalian']['sha1'][5]);
        $delete = base64_encode($enc['data-pengembalian']['sha1'][6]);
        $ganti = base64_encode($enc['data-pengembalian']['sha1'][9]);

        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["code_return"];
        $nestedData[] = $row["code_loan"];
        $nestedData[] = $row["name_return"];
        $nestedData[] = date("d-m-Y, H:i", strtotime($row["created_at"]));
        $nestedData[] = $row['pin'] == 1 ? '<label class="text-success">Tepat waktu</label>' : '<label class="text-red">Terlambat</label>';
        if (hasPermit('update_loaning') && hasPermit('delete_loaning')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['code_return'] . '" data-target="' . $edit . '">
            <i class="fa fa-edit"></i>
            <span>Edit</span>
            </a>&nbsp;
            <a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_return'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>&nbsp;
            <a id="ganti" name="ganti" class="btn btn-xs btn-default" title="Ganti Data" data-content="' . $row['code_return'] . '" data-target="' . $ganti . '">
              <i class="fa fa-refresh"></i>
              <span>Ganti</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['name_return'] . '" data-content="' . $row['code_return'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] =
            '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_loan'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['sha1'][1]) {
      $sql = "SELECT * FROM tb_loan WHERE status='0'";
      $query = mysqli_query($link, $sql) or die("error1");
      if (mysqli_num_rows($query) > 0) {
        $data['pengembalian'] = array(
          'code' => 1,
        );
      } else {
        $data['pengembalian'] = array(
          'code' => 0,
          'message' => 'Daftar peminjaman kosong !',
        );
      }
    } elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['sha1'][7] && isset($_GET['code'])) {
      $id = $requestData['code'];
      $query = "SELECT d.code_loan, name_loan, due_date, l.created_at, d.code_item, name_item, name_category, amount FROM tb_loan_details AS d
                INNER JOIN tb_loan AS l ON l.code_loan = d.code_loan
                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                WHERE l.code_loan='$id'";
      $sql = mysqli_query($link, $query);
      if (mysqli_num_rows($sql) > 0) {
        $a = array();
        $b = array();
        while ($r = mysqli_fetch_assoc($sql)) {
          $a[] = array(
            'code' => $r['code_item'],
            'name' => $r['name_item'],
            'category' => $r['name_category'],
            'amount' => $r['amount']
          );
          $b = array(
            'code' => $r['code_loan'],
            'name' => $r['name_loan'],
            'create' => $r['created_at'],
            'exp' => $r['due_date']
          );
        }
        $data['pengembalian'] = array(
          'code' => 1,
          'data' => array(
            'peminjam' => $b,
            'peralatan' => $a
          )
        );
      } else {
        $data['pengembalian'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['sha1'][8] && isset($_GET['q'])) {
      $q = $requestData['q'];
      $sql = "SELECT code_loan,name_loan FROM tb_loan WHERE status='0' AND code_loan LIKE '%$q%' OR name_loan LIKE '%$q%' ORDER BY created_at DESC";
      $check = mysqli_query($link,$sql);
      if (mysqli_num_rows($check) > 0) {
        $list = array();
        $i = 0;
        while ($r = mysqli_fetch_assoc($check)) {
          $list[] = array(
            'id' => $r['code_loan'],
            'text' => $r['code_loan'] . " - " . $r['name_loan']
          );
          $i++;
        }
        $data = $list;
      } else {
        $data = "";
      }
    } elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['sha1'][2]) {
      $kode = kodetransaksi(2);
      $kodePinjam = $requestData['kode'];
      $namaKembali = $requestData['nama'];
      $rusak = @$requestData['rusak'];
      $jmlhRusak = @$requestData['jumlah_rusak'];
      $hilang = @$requestData['hilang'];
      $jmlhHilang = @$requestData['jumlah_hilang'];
      $date = date('Y-m-d H:i:s',strtotime('now'));

      $tepat = 0;
      $ganti = 0;
      $denda = 0;
      $msg = "";
      //tanggal
      $sqlLoan = mysqli_query($link,"SELECT * FROM tb_loan WHERE code_loan='$kodePinjam'");
      $rowLoan = mysqli_fetch_assoc($sqlLoan);
      $today = new DateTime(date('Y-m-d H:i',strtotime('now')));
      $taken = new DateTime(date('Y-m-d H:i',strtotime($rowLoan['created_at'])));
      $exp = new DateTime(date('Y-m-d H:i',strtotime($rowLoan['due_date'])));
      $durationPeminjaman = $today->diff($taken);
      $durationKetelambatan = $today->diff($exp);
      if ($today > $exp) {
        $denda = $durationKetelambatan->days * 5000 == 0 ? 5000 : $durationKetelambatan->days * 5000;
        $long = $durationKetelambatan->format("%d Hari, %H Jam, %I Menit");
        $tepat = 0;
        $msg = "<em class=\"text-center text-red\">Dikenakan biaya penalti keterlambatan <i>Rp. 5.000</i> per hari ! Total yang harus dibayarkan Rp <b>" .number_format($denda,0,".",","). "</b></em>";
      } else {
        $tepat = 1;
        $long = $durationPeminjaman->format("%d Hari, %H Jam, %I Menit");
        $msg = "<em class=\"text-center text-success\">Tidak dikenakan biaya penalti !</em>";
      }

      if ($rusak != "" && $hilang != "") {
        $check = mysqli_num_rows(mysqli_query($link,"SELECT * FROM tb_return WHERE code_loan='$kodePinjam'"));
        if ($check == 0) {
          $i = 0;
          $ganti = 1;
          mysqli_query($link,"UPDATE tb_loan SET status='1' WHERE code_loan='$kodePinjam'");
          mysqli_query($link,"INSERT INTO tb_return VALUES('$kode','$kodePinjam','$namaKembali','$tepat','$long','$denda','$ganti','$msg','$date')");
          $sqlDetailLoan = mysqli_query($link,"SELECT * FROM tb_loan_details WHERE code_loan='$kodePinjam'");
          while ($a = mysqli_fetch_assoc($sqlDetailLoan)) {
            $codeItem = $a['code_item'];
            $amount = $a['amount'];
            mysqli_query($link,"INSERT INTO tb_return_details VALUES(NULL,'$kode','$codeItem','$amount','0','0','0','0')");
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item+'$amount', total_stock=total_stock+'$amount' WHERE code_item='$codeItem'");
            $i++;
          }
          if ((count($rusak) || count($hilang)) <= $i) {
            foreach ($rusak as $key => $value) {
              $ketRusak = $value;
              $jmlh = $jmlhRusak[$key];
              mysqli_query($link,"UPDATE tb_return_details SET broken_status='$ketRusak', broken_amount=broken_amount+'$jmlh' WHERE code_return='$kode' AND code_item='$key'");
              mysqli_query($link,"UPDATE tb_items SET good_item=good_item-'$jmlh', broken_item=broken_item+'$jmlh' WHERE code_item='$key'");
            }
            foreach ($hilang as $key => $value) {
              $ketHilang = $value;
              $jmlh = $jmlhHilang[$key];
              mysqli_query($link,"UPDATE tb_return_details SET lost_status='$ketHilang', lost_amount=lost_amount+'$jmlh' WHERE code_return='$kode' AND code_item='$key'");
              mysqli_query($link,"UPDATE tb_items SET good_item=good_item-'$jmlh', lost_item=lost_item+'$jmlh' WHERE code_item='$key'");
            }
            $selesai = true;
          }
        }
      } elseif ($rusak != "" && $hilang == "") {
        $check = mysqli_num_rows(mysqli_query($link,"SELECT * FROM tb_return WHERE code_loan='$kodePinjam'"));
        if ($check == 0) {
          $i = 0;
          $ganti = 1;
          mysqli_query($link,"UPDATE tb_loan SET status='1' WHERE code_loan='$kodePinjam'");
          mysqli_query($link,"INSERT INTO tb_return VALUES('$kode','$kodePinjam','$namaKembali','$tepat','$long','$denda','$ganti','$msg','$date')");
          $sqlDetailLoan = mysqli_query($link,"SELECT * FROM tb_loan_details WHERE code_loan='$kodePinjam'");
          while ($a = mysqli_fetch_assoc($sqlDetailLoan)) {
            $codeItem = $a['code_item'];
            $amount = $a['amount'];
            mysqli_query($link,"INSERT INTO tb_return_details VALUES(NULL,'$kode','$codeItem','$amount','0','0','0','0')");
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item+'$amount', total_stock=total_stock+'$amount' WHERE code_item='$codeItem'");
            $i++;
          }
          if (count($rusak) <= $i) {
            foreach ($rusak as $key => $value) {
              $listRusak[] = array($key => $value, "jumlah" => $jmlhRusak[$key]);
              $ketRusak = $value;
              $jmlh = $jmlhRusak[$key];
              mysqli_query($link,"UPDATE tb_return_details SET broken_status='$ketRusak', broken_amount=broken_amount+'$jmlh' WHERE code_return='$kode' AND code_item='$key'");
              mysqli_query($link,"UPDATE tb_items SET good_item=good_item-'$jmlh', broken_item=broken_item+'$jmlh' WHERE code_item='$key'");
            }
            $selesai = true;
          }
        }
      } elseif ($rusak == "" && $hilang != "") {
        $check = mysqli_num_rows(mysqli_query($link,"SELECT * FROM tb_return WHERE code_loan='$kodePinjam'"));
        if ($check == 0) {
          $i = 0;
          $ganti = 1;
          mysqli_query($link,"UPDATE tb_loan SET status='1' WHERE code_loan='$kodePinjam'");
          mysqli_query($link,"INSERT INTO tb_return VALUES('$kode','$kodePinjam','$namaKembali','$tepat','$long','$denda','$ganti','$msg','$date')");
          $sqlDetailLoan = mysqli_query($link,"SELECT * FROM tb_loan_details WHERE code_loan='$kodePinjam'");
          while ($a = mysqli_fetch_assoc($sqlDetailLoan)) {
            $codeItem = $a['code_item'];
            $amount = $a['amount'];
            mysqli_query($link,"INSERT INTO tb_return_details VALUES(NULL,'$kode','$codeItem','$amount','0','0','0','0')");
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item+'$amount', total_stock=total_stock+'$amount' WHERE code_item='$codeItem'");
            $i++;
          }
          if (count($hilang) <= $i) {
            foreach ($hilang as $key => $value) {
              $ketHilang = $value;
              $jmlh = $jmlhHilang[$key];
              mysqli_query($link,"UPDATE tb_return_details SET lost_status='$ketHilang', lost_amount=lost_amount+'$jmlh' WHERE code_return='$kode' AND code_item='$key'");
              mysqli_query($link,"UPDATE tb_items SET good_item=good_item-'$jmlh', lost_item=lost_item+'$jmlh' WHERE code_item='$key'");
            }
            $selesai = true;
          }
        }
      } else {
        $check = mysqli_num_rows(mysqli_query($link,"SELECT * FROM tb_return WHERE code_loan='$kodePinjam'"));
        if ($check == 0) {
          mysqli_query($link,"UPDATE tb_loan SET status='1' WHERE code_loan='$kodePinjam'");
          mysqli_query($link,"INSERT INTO tb_return VALUES('$kode','$kodePinjam','$namaKembali','$tepat','$long','$denda','$ganti','$msg','$date')");
          $sqlDetailLoan = mysqli_query($link,"SELECT * FROM tb_loan_details WHERE code_loan='$kodePinjam'");
          while ($a = mysqli_fetch_assoc($sqlDetailLoan)) {
            $codeItem = $a['code_item'];
            $amount = $a['amount'];
            mysqli_query($link,"INSERT INTO tb_return_details VALUES(NULL,'$kode','$codeItem','$amount','0','0','0','0')");
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item+'$amount', total_stock=total_stock+'$amount' WHERE code_item='$codeItem'");
          }
          $selesai = true;
        }
      }

      if ($selesai) {
        $data['pengembalian'] = array(
          'code' => 1,
          'message' => 'Data berhasil disimpan !',
        );
      } else {
        $data['pengembalian'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['sha1'][3] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $query = "SELECT d.code_return, code_loan, name_return, pin, long_period, penalty, rechange, info, r.created_at, d.code_item, name_item, 
                name_category, amount_loan, broken_amount, broken_status, lost_amount, lost_status, name_unit FROM tb_return_details AS d
                INNER JOIN tb_return AS r ON r.code_return = d.code_return
                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                WHERE r.code_return='$id'";
      $sql = mysqli_query($link, $query);
      if (mysqli_num_rows($sql) > 0) {
        $a = array();
        $b = array();
        while ($r = mysqli_fetch_assoc($sql)) {
          if ($r['rechange'] == 2) {
            $change = '<label class="text-info">Sudah diganti</label>';
          } elseif ($r['rechange'] == 1) {
            $change = '<label class="text-danger">Belum diganti</label>';
          } else {
            $change = '<label class="text-success">Tidak ada penggantian</label>';
          }
          $a[] = array(
            'code_item' => $r['code_item'],
            'name_item' => $r['name_item'],
            'category' => $r['name_category'],
            'amount' => $r['amount_loan'],
            'broken_status' => $r['broken_status'],
            'broken_amount' => $r['broken_amount'],
            'lost_status' => $r['lost_status'],
            'lost_amount' => $r['lost_amount'],
            'unit' => $r['name_unit']
          );

          $b = array(
            'code_return' => $r['code_return'],
            'code_loan' => $r['code_loan'],
            'name' => $r['name_return'],
            'pin' => $r['pin'] == 1 ? '<label class="text-success">Tepat waktu</label>' : '<label class="text-red">Terlambat</label>',
            'period' => $r['long_period'],
            'change' => $change,
            'penalty' => $r['penalty'],
            'info' => $r['info'],
            'create' => date('d-m-Y, H:i',strtotime($r['created_at'])),
          );
        }
        $data['pengembalian'] = array(
          'code' => 1,
          'data' => array(
            'peminjam' => $b,
            'peralatan' => $a
          )
        );
      } else {
        $data['pengembalian'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['sha1'][4] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $nama = ucwords($requestData['nama']);
      $rusak = @$requestData['rusak'];
      $jmlhRusak = @$requestData['jumlah_rusak'];
      $hilang = @$requestData['hilang'];
      $jmlhHilang = @$requestData['jumlah_hilang'];

      if ($rusak != "" && $hilang != "") {
        foreach ($rusak as $key => $value) {
          $ketRusak = $value;
          $jmlh = $jmlhRusak[$key];
          $banding = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM tb_return_details WHERE code_return='$id' AND code_item='$key'"));
          if ($banding['broken_amount'] >= $jmlh) {
            $total = $banding['lost_amount'] - $jmlh;
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item+'$total', broken_item-'$total' WHERE code_item='$key'");
          } else {
            $total = $jmlh - $banding['lost_amount'];
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item-'$total', broken_item=broken_item+'$total' WHERE code_item='$key'");
          }
          mysqli_query($link,"UPDATE tb_return_details SET broken_status='$ketRusak', broken_amount='$jmlh' WHERE code_return='$id' AND code_item='$key'");
        }
        foreach ($hilang as $key => $value) {
          $ketHilang = $value;
          $jmlh = $jmlhHilang[$key];
          $banding = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM tb_return_details WHERE code_return='$id' AND code_item='$key'"));
          if ($banding['lost_amount'] >= $jmlh) {
            $total = $banding['lost_amount'] - $jmlh;
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item+'$total', lost_item=lost_item-'$total' WHERE code_item='$key'");
          } else {
            $total = $jmlh - $banding['lost_amount'];
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item-'$total', lost_item=lost_item+'$total' WHERE code_item='$key'");
          }
          mysqli_query($link,"UPDATE tb_return_details SET lost_status='$ketHilang', lost_amount='$jmlh' WHERE code_return='$id' AND code_item='$key'");
        }
        mysqli_query($link,"UPDATE tb_return SET rechange='1' WHERE code_return='$id'");
        $selesai = true;
      } elseif ($rusak != "" && $hilang == "") {
        foreach ($rusak as $key => $value) {
          $ketRusak = $value;
          $jmlh = $jmlhRusak[$key];
          $banding = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM tb_return_details WHERE code_return='$id' AND code_item='$key'"));
          if ($banding['broken_amount'] >= $jmlh) {
            $total = $banding['lost_amount'] - $jmlh;
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item+'$total', broken_item-'$total' WHERE code_item='$key'");
          } else {
            $total = $jmlh - $banding['lost_amount'];
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item-'$total', broken_item=broken_item+'$total' WHERE code_item='$key'");
          }
          mysqli_query($link,"UPDATE tb_return_details SET broken_status='$ketRusak', broken_amount='$jmlh' WHERE code_return='$id' AND code_item='$key'");
        }
        mysqli_query($link,"UPDATE tb_return SET rechange='1' WHERE code_return='$id'");
        $selesai = true;
      } elseif ($rusak == "" && $hilang != "") {
        foreach ($hilang as $key => $value) {
          $ketHilang = $value;
          $jmlh = $jmlhHilang[$key];
          $banding = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM tb_return_details WHERE code_return='$id' AND code_item='$key'"));
          if ($banding['lost_amount'] >= $jmlh) {
            $total = $banding['lost_amount'] - $jmlh;
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item+'$total', lost_item=lost_item-'$total' WHERE code_item='$key'");
          } else {
            $total = $jmlh - $banding['lost_amount'];
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item-'$total', lost_item=lost_item+'$total' WHERE code_item='$key'");
          }
          mysqli_query($link,"UPDATE tb_return_details SET lost_status='$ketHilang', lost_amount='$jmlh' WHERE code_return='$id' AND code_item='$key'");
        }
        mysqli_query($link,"UPDATE tb_return SET rechange='1' WHERE code_return='$id'");
        $selesai = true;
      } else {
        $selesai = true;
      }
      if ($selesai) {
        $sql = mysqli_query($link,"UPDATE tb_return SET name_return='$nama' WHERE code_return='$id'");
      }
      if ($sql) {
        $data['pengembalian'] = array(
          'code' => 1,
          'message' => 'Data berhasil disimpan !'
        );
      } else {
        $data['pengembalian'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['sha1'][5] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $query = "SELECT d.code_return, r.code_loan, name_return, pin, long_period, penalty, rechange, info, l.due_date, l.created_at AS pinjam, r.created_at, 
                d.code_item, name_item, name_category, amount_loan, broken_amount, broken_status, lost_amount, lost_status, name_unit FROM tb_return_details AS d
                INNER JOIN tb_return AS r ON r.code_return = d.code_return
                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                INNER JOIN tb_loan AS l ON l.code_loan = r.code_loan
                WHERE r.code_return='$id'";
      $sql = mysqli_query($link, $query);
      if (mysqli_num_rows($sql) > 0) {
        $a = array();
        $b = array();
        while ($r = mysqli_fetch_assoc($sql)) {
          if ($r['rechange'] == 2) {
            $change = '<label class="text-info">Sudah diganti</label>';
          } elseif ($r['rechange'] == 1) {
            $change = '<label class="text-danger">Belum diganti</label>';
          } else {
            $change = '<label class="text-success">Tidak ada penggantian</label>';
          }
          if ($r['broken_status'] == 2) {
            $broken = '<label class="text-danger">Tidak sengaja</label>';
          } elseif ($r['broken_status'] == 1) {
            $broken = '<label class="text-danger">Disengaja</label>';
          } else {
            $broken = '-';
          }
          if ($r['lost_status'] == 2) {
            $lost = '<label class="text-danger">Tidak sengaja</label>';
          } elseif ($r['lost_status'] == 1) {
            $lost = '<label class="text-danger">Disengaja</label>';
          } else {
            $lost = '-';
          }
          $a[] = array(
            'code_item' => $r['code_item'],
            'name_item' => $r['name_item'],
            'category' => $r['name_category'],
            'amount' => $r['amount_loan'],
            'broken_status' => $broken,
            'broken_amount' => $r['broken_amount'],
            'lost_status' => $lost,
            'lost_amount' => $r['lost_amount'],
            'unit' => $r['name_unit']
          );

          $b = array(
            'code_return' => $r['code_return'],
            'code_loan' => $r['code_loan'],
            'name' => $r['name_return'],
            'pin' => $r['pin'] == 1 ? '<label class="text-success">Tepat waktu</label>' : '<label class="text-red">Terlambat</label>',
            'period' => $r['long_period'],
            'change' => $change,
            'penalty' => $r['penalty'],
            'info' => $r['info'],
            'pinjam' => date('d-m-Y, H:i', strtotime($r['pinjam'])),
            'due' => date('d-m-Y, H:i', strtotime($r['due_date'])),
            'create' => date('d-m-Y, H:i',strtotime($r['created_at'])),
          );
        }
        $data['pengembalian'] = array(
          'code' => 1,
          'data' => array(
            'peminjam' => $b,
            'peralatan' => $a
          )
        );
      } else {
        $data['pengembalian'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['sha1'][6] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $check = mysqli_query($link,"SELECT rechange FROM tb_return WHERE code_return='$id' AND rechange='1'");
      if (mysqli_num_rows($check) == 1) {
        $data['pengembalian'] = array(
          'code' => 0,
          'message' => 'Peralatan belum diganti !'
        );
      } else {
        $sql = mysqli_query($link, "DELETE FROM tb_return WHERE code_return='$id'");
        if ($sql) {
          $data['pengembalian'] = array(
            'code' => 1,
            'message' => 'Data berhasil dihapus'
          );
        } else {
          $data['pengembalian'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    } elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['sha1'][9] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $query = "SELECT d.code_return, code_loan, name_return, pin, long_period, penalty, rechange, info, r.created_at, d.code_item, name_item, 
                name_category, amount_loan, broken_amount, broken_status, lost_amount, lost_status, name_unit FROM tb_return_details AS d
                INNER JOIN tb_return AS r ON r.code_return = d.code_return
                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                WHERE r.rechange='1' AND r.code_return='$id'";
      $sql = mysqli_query($link, $query);
      if (mysqli_num_rows($sql) > 0) {
        $a = array();
        $b = array();
        while ($r = mysqli_fetch_assoc($sql)) {
          if ($r['rechange'] == 2) {
            $change = '<label class="text-info">Sudah diganti</label>';
          } elseif ($r['rechange'] == 1) {
            $change = '<label class="text-danger">Belum diganti</label>';
          } else {
            $change = '<label class="text-success">Tidak ada penggantian</label>';
          }
          $a[] = array(
            'code_item' => $r['code_item'],
            'name_item' => $r['name_item'],
            'category' => $r['name_category'],
            'amount' => $r['amount_loan'],
            'broken_amount' => $r['broken_amount'],
            'lost_amount' => $r['lost_amount'],
            'unit' => $r['name_unit']
          );

          $b = array(
            'code_return' => $r['code_return'],
            'code_loan' => $r['code_loan'],
            'name' => $r['name_return'],
            'pin' => $r['pin'] == 1 ? '<label class="text-success">Tepat waktu</label>' : '<label class="text-red">Terlambat</label>',
            'period' => $r['long_period'],
            'change' => $change,
            'penalty' => $r['penalty'],
            'info' => $r['info'],
            'create' => date('d-m-Y, H:i',strtotime($r['created_at'])),
          );
        }
        $data['pengembalian'] = array(
          'code' => 1,
          'data' => array(
            'peminjam' => $b,
            'peralatan' => $a
          )
        );
      } else {
        $data['pengembalian'] = array(
          'code' => 0,
          'message' => 'Tidak ada peralatan yang diganti !',
        );
      }
    } elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['sha1'][10] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $ganti = $requestData['ganti'];
      if (count($ganti) > 0) {
        $i = 0;
        foreach ($ganti as $key => $value) {
          $check = mysqli_fetch_assoc(mysqli_query($link,"SELECT broken_amount, lost_amount FROM tb_return_details WHERE code_return='$id' AND code_item='$key'"));
          $rusak = $check['broken_amount'];
          $hilang = $check['lost_amount'];
          $good = $rusak + $hilang;
          mysqli_query($link,"UPDATE tb_items SET good_item=good_item+'$good',broken_item=broken_item-'$rusak', lost_item=lost_item-'$hilang' WHERE code_item='$key'");
          $sqlDetails = "UPDATE tb_return_details SET broken_status='0', lost_status='0', broken_amount=broken_amount-'$rusak', lost_amount=lost_amount-'$hilang' 
                         WHERE code_return='$id' AND code_item='$key'";
          mysqli_query($link,$sqlDetails);
          mysqli_query($link,"UPDATE tb_return SET rechange='2' WHERE code_return='$id'");
          $i++;
        }
        if (count($ganti) == $i) {
          $data['pengembalian'] = array(
            'code' => 1,
            'message' => 'Peralatan berhasil diganti !',
          );
        } else {
          $data['pengembalian'] = array(
            'code' => 0,
            'message' => mysqli_error($link),
          );
        }
      } else {
        $data['pengembalian'] = array(
          'code' => 0,
          'message' => 'Checklist item !'
        );
      }
    }
    // API Transaksi Pengembalian End //

    // API Transaksi Penjualan Start //
    elseif ($route == $enc['data-penjualan']['remote'] && $dest == $enc['data-penjualan']['sha1'][0]) {
      $columns = array(
        'created_at',
        'code_selling',
        'name_buyer',
        'total',
        'status'
      );
      $sql = "SELECT created_at,code_selling,name_buyer,total,status FROM tb_selling";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value'])) {
        $sql .= " WHERE code_selling LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR name_buyer LIKE '%" . $requestData['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = base64_encode($enc['data-penjualan']['sha1'][3]);
        $detail = base64_encode($enc['data-penjualan']['sha1'][5]);
        $delete = base64_encode($enc['data-penjualan']['sha1'][6]);

        if ($row['status'] == 1) {
          $stts = '<label class="label label-success">Sudah lunas</label>';
        } else {
          $stts = '<label class="label label-warning">Belum bayar</label>';
        }
        
        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["code_selling"];
        $nestedData[] = $row["name_buyer"];
        $nestedData[] = "Rp. " . number_format($row["total"],0,".",",");
        $nestedData[] = $stts;
        if (hasPermit('update_selling') && hasPermit('delete_selling')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['code_selling'] . '" data-target="' . $edit . '">
              <i class="fa fa-edit"></i>
              <span>Edit</span>
            </a>&nbsp;
            <a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_selling'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['name_buyer'] . '" data-content="' . $row['code_selling'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] =
            '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_selling'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-penjualan']['remote'] && $dest == $enc['data-penjualan']['sha1'][1]) {
      $sql = "SELECT * FROM tb_items WHERE good_item > 0 AND price_sale > 0 ORDER BY created_at DESC LIMIT 0,4";
      $query = mysqli_query($link, $sql) or die("error1");
      if (mysqli_num_rows($query) > 0) {
        $data['penjualan'] = array(
          'code' => 1,
          'url' => BASE_URL . "dashboard/" . strtolower(str_replace(' ', '-', $menu[5])) . "/" . strtolower(str_replace(' ', '-', $submenu[8])) . "/",
        );
      } else {
        $data['penjualan'] = array(
          'code' => 0,
          'message' => 'Stok Sparepart Kosong !',
        );
      }
    } elseif ($route == $enc['data-penjualan']['remote'] && $dest == $enc['data-penjualan']['sha1'][3] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link,"SELECT * FROM tb_selling WHERE code_selling='$id'");
      if ($sql) {
        $r = mysqli_fetch_assoc($sql);
        $a = array(
          'code' => $id,
          'name' => $r['name_buyer'],
          'stts' => $r['status']
        );
        $data['penjualan'] = array(
          'code' => 1,
          'data' => $a
        );
      } else {
        $data['penjualan'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan'
        );
      }
    } elseif ($route == $enc['data-penjualan']['remote'] && $dest == $enc['data-penjualan']['sha1'][4] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $name = $requestData['nama'];
      $stts = $requestData['status'];
      $sql = mysqli_query($link,"UPDATE tb_selling SET name_buyer='$name', status='$stts' WHERE code_selling='$id'");
      if ($sql) {
        $data['penjualan'] = array(
          'code' => 1,
          'message' => 'Data berhasil diubah'
        );
      } else {
        $data['penjualan'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-penjualan']['remote'] && $dest == $enc['data-penjualan']['sha1'][5] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = "SELECT d.code_selling, name_buyer, total, s.status, s.created_at, name_item, amount, price_sale, sub_total, name_unit FROM tb_selling_details AS d
              INNER JOIN tb_selling AS s ON s.code_selling = d.code_selling
              INNER JOIN tb_items AS i ON i.code_item = d.code_item
              INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
              WHERE d.code_selling='$id'";
      $query = mysqli_query($link,$sql);
      if (mysqli_num_rows($query) > 0) {
        while ($r = mysqli_fetch_assoc($query)) {
          $a[] = array(
            'name' => $r['name_item'],
            'price' => $r['price_sale'],
            'amount' => $r['amount'],
            'unit' => $r['name_unit'],
            'subtotal' => $r['sub_total']
          );
          $b = array(
            'code' => $r['code_selling'],
            'name' => $r['name_buyer'],
            'status' => $r['status'],
            'date' => $r['created_at'],
            'total' => $r['total']
          );
        }
        $data['penjualan'] = array(
          'code' => 1,
          'data' => array(
            'pembeli' => $b,
            'items' => $a
          )
        );
      } else {
        $data['penjualan'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-penjualan']['remote'] && $dest == $enc['data-penjualan']['sha1'][6] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link,"DELETE FROM tb_selling WHERE code_selling='$id'");
      if ($sql) {
        $data['penjualan'] = array(
          'code' => 1,
          'message' => 'Data telah dihapus'
        );
      } else {
        $data['penjualan'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }
    // API Transaksi Penjualan End //
    
    // API Transaksi Pembelian Start //
    elseif ($route == $enc['data-pembelian']['remote'] && $dest == $enc['data-pembelian']['sha1'][0]) {
      $columns = array(
        'created_at',
        'code_buying',
        'total',
      );
      $sql = "SELECT created_at,code_buying,total FROM tb_buying";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value'])) {
        $sql .= " WHERE code_buying LIKE '%" . $requestData['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = base64_encode($enc['data-pembelian']['sha1'][3]);
        $detail = base64_encode($enc['data-pembelian']['sha1'][5]);
        $delete = base64_encode($enc['data-pembelian']['sha1'][6]);

        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["code_buying"];
        $nestedData[] = "Rp. " . number_format($row["total"],0,".",",");
        if (hasPermit('update_buying') && hasPermit('delete_buying')) {
          $nestedData[] =
            '<!--a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['code_buying'] . '" data-target="' . $edit . '">
              <i class="fa fa-edit"></i>
              <span>Edit</span>
            </a-->&nbsp;
            <a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_buying'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['code_buying'] . '" data-content="' . $row['code_buying'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] =
            '<a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_selling'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-pembelian']['remote'] && $dest == $enc['data-pembelian']['sha1'][2] && isset($_GET['tipe'])) {
      $tipe = $requestData['tipe'];
      $date = date('Y-m-d H:i:s', strtotime('now'));
      if ($tipe == "lama") {
        $jmlh = @$requestData['jumlah'];
        $beli = @$requestData['beli'];
        $jual = @$requestData['jual'];

        if (count($jmlh) > 0) {
          $kode = kodetransaksi(4);
          $total = 0;
          mysqli_query($link,"INSERT INTO tb_buying VALUES('$kode','0','$date')");
          foreach ($jmlh as $key => $value) {
            $a = $jmlh[$key];
            $b = $beli[$key];
            $c = @$jual[$key] != null ? $jual[$key] : 0;
            $sum = $a * $b;
            mysqli_query($link,"UPDATE tb_items SET good_item=good_item+'$a', total_stock=total_stock+'$a', price_buy='$b', price_sale='$c', updated_at='$date' WHERE code_item='$key'");
            mysqli_query($link,"INSERT INTO tb_buying_details VALUES(NULL,'$kode','$key','$a','$b','$sum')");
            $total+= $sum;
          }
          mysqli_query($link,"UPDATE tb_buying SET total='$total' WHERE code_buying='$kode'");
          
          $data['pembelian'] = array(
            'code' => 1,
            'message' => 'Data berhasil disimpan',
          );
        } else {
          $data['pembelian'] = array(
            'code' => 0,
            'message' => 'Check kembali'
          );
        }
      } elseif ($tipe == "baru") {
        $kategori = @$requestData['kategori'];
        $nama = @$requestData['nama'];
        $stok = @$requestData['stok'];
        $satuan = @$requestData['satuan'];
        $hrgBeli = @$requestData['harga_beli'];
        $hrgJual = @$requestData['harga_jual'];

        if (count($kategori) > 0) {
          $kodeBeli = kodetransaksi(4);
          mysqli_query($link,"INSERT INTO tb_buying VALUES('$kodeBeli','0','$date')");
          $index = 0;
          $total = 0;
          foreach ($kategori as $key => $value) {
            $ktg = $kategori[$index];
            $nm = $nama[$index];
            $sk = $stok[$index];
            if ($ktg == "alt") {
              $kodeItem = buatkode(1,$nm);
            } elseif ($ktg == "smt") {
              $kodeItem = buatkode(2,$nm);
            } elseif ($ktg == "smb") {
              $kodeItem = buatkode(3,$nm);
            }
            $st = $satuan[$index];
            $beli1 = str_replace('.', '', $hrgBeli[$index]);
            $jual1 = str_replace('.', '', @$hrgJual[$index] != null ? $hrgJual[$index] : 0);

            mysqli_query($link,"INSERT INTO tb_items VALUES('$kodeItem','$ktg','$st','$nm','$sk','0','0','$sk','$jual1','$beli1','default.png','1','-','-','$date','$date')");
            $sum = $sk * $beli1;
            mysqli_query($link,"INSERT INTO tb_buying_details VALUES(NULL,'$kodeBeli','$kodeItem','$sk','$beli1','$sum')");
            $index++;
            $total+=$sum;
          }
          mysqli_query($link,"UPDATE tb_buying SET total='$total' WHERE code_buying='$kodeBeli'");
          $data['pembelian'] = array(
            'code' => 1,
            'message' => 'Data berhasil disimpan',
          );
        } else {
          $data['pembelian'] = array(
            'code' => 0,
            'message' => 'Check kembali'
          );
        }
      } else {
        $data['pembelian'] = array(
          'code' => 0,
          'message' => 'Invalid request'
        );
      }
    } elseif ($route == $enc['data-pembelian']['remote'] && $dest == $enc['data-pembelian']['sha1'][5] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = "SELECT b.code_buying,b.total,b.created_at,name_item,name_category,amount,price,subtotal,name_unit FROM tb_buying_details AS d
              INNER JOIN tb_buying AS b ON b.code_buying = d.code_buying
              INNER JOIN tb_items AS i ON i.code_item = d.code_item
              INNER JOIN tb_categories AS c ON c.code_category = i.code_category
              INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
              WHERE b.code_buying='$id'";
      $query = mysqli_query($link,$sql);
      if (mysqli_num_rows($query) > 0) {
        $a = array();
        $b = array();
        while ($r = mysqli_fetch_assoc($query)) {
          $a = array(
            'kode' => $r['code_buying'],
            'tgl' => date('d-m-Y, H:i',strtotime($r['created_at'])),
            'total' => $r['total']
          );
          $b[] = array(
            'nama' => $r['name_item'],
            'jenis' => $r['name_category'],
            'jmlh' => $r['amount'],
            'satuan' => $r['name_unit'],
            'harga' => $r['price'],
            'subtotal' => $r['subtotal']
          );
        }
        $data['pembelian'] = array(
          'code' => 1,
          'ket' => $a,
          'data' => $b
        );
      } else {
        $data['pembelian'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan'
        );
      }
    } elseif ($route == $enc['data-pembelian']['remote'] && $dest == $enc['data-pembelian']['sha1'][6] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link,"DELETE FROM tb_buying WHERE code_buying='$id'");
      if ($sql) {
        $data['pembelian'] = array(
          'code' => 1,
          'message' => 'Data telah dihapus'
        );
      } else {
        $data['pembelian'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-pembelian']['remote'] && $dest == $enc['data-pembelian']['sha1'][7]) {
      $sqlCategory = mysqli_query($link,"SELECT * FROM tb_categories ORDER BY name_category ASC");
      $sqlUnit = mysqli_query($link,"SELECT * FROM tb_unit ORDER BY name_unit ASC");
      $c = array();
      $u = array();
      while ($r = mysqli_fetch_assoc($sqlCategory)) {
        $c[] = array(
          'value' => $r['code_category'],
          'text' => $r['name_category']
        );
      }
      while ($r = mysqli_fetch_assoc($sqlUnit)) {
        $u[] = array(
          'value' => $r['id_unit'],
          'text' => $r['name_unit']
        );
      }
      $data['pembelian'] = array(
        'category' => $c,
        'unit' => $u
      );
    } elseif ($route == $enc['data-pembelian']['remote'] && $dest == $enc['data-pembelian']['sha1'][8] && isset($_GET['q'])) {
      $q = $requestData['q'];
      $sql = "SELECT code_item,name_item FROM tb_items WHERE code_item LIKE '%$q%' OR name_item LIKE '%$q%' ORDER BY created_at DESC";
      $check = mysqli_query($link,$sql);
      if (mysqli_num_rows($check) > 0) {
        $list = array();
        $i = 0;
        while ($r = mysqli_fetch_assoc($check)) {
          $list[] = array(
            'id' => $r['code_item'],
            'text' => ucwords($r['name_item'])
          );
          $i++;
        }
        $data = $list;
      } else {
        $data = "";
      }
    } elseif ($route == $enc['data-pembelian']['remote'] && $dest == $enc['data-pembelian']['sha1'][8] && isset($_GET['c'])) {
      $id = $requestData['c'];
      $query = "SELECT code_item,name_item,price_buy,price_sale,name_category,c.code_category FROM tb_items AS i
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                WHERE code_item='$id'";
      $sql = mysqli_query($link, $query);
      if (mysqli_num_rows($sql) > 0) {
        $a = array();
        $r = mysqli_fetch_assoc($sql);
        $hrg_beli = $r['price_buy'];
        $hrg_jual = $r['price_sale'];
        $code = $r['code_item'];
        $disb = $r['code_category'] == "alt" ? "disabled" : "";
        $beli = '<input type="text" id="beli" name="beli['.$code.']" class="form-control auto" value="'.$hrg_beli.'" required>';
        $jual = '<input type="text" id="jual" name="jual['.$code.']" class="form-control auto" value="'.$hrg_jual.'" '.$disb.' required>';
        $jmlh = '<input type="number" id="jumlah" name="jumlah['.$code.']" class="form-control auto" value="1" min="1" required>';
        $a = array(
          'name' => $r['name_item'],
          'tipe' => $r['name_category'],
          'jmlh' => $jmlh,
          'buy' => $beli,
          'sell' => $jual,
        );
        $data['pembelian'] = array(
          'code' => 1,
          'data' => $a
        );
      } else {
        $data['pembelian'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    }
    // API Transaksi Pembelian End //

    // API Laporan Peminjaman Start //
    elseif ($route == $enc['data-peminjaman']['remote'] && $dest == $enc['data-peminjaman']['laporan']) {
      $columns = array(
        'created_at',
        'code_loan',
        'name_loan',
        'created_at',
        'due_date',
        'status'
      );
      $sql = "SELECT created_at,code_loan,name_loan,due_date,status FROM tb_loan";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value'])) {
        $sql .= " WHERE code_loan LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR name_loan LIKE '%" . $requestData['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $download = base64_encode($enc['data-peminjaman']['unduh']);
        $status = $row['status'];
        if ($status == 1) {
          $msg = '<label class="label label-success">Telah dikembalikan</label>';
        } else {
          $today = new DateTime(date('Y-m-d H:i:s',strtotime('now')));
          $exp = new DateTime(date('Y-m-d H:i:s',strtotime($row["due_date"])));
          if ($today > $exp) {
            $msg = '<label class="label label-danger">Telah lewat jatuh tempo</label>';
          } else {
            $msg = '<label class="label label-warning">Masih dipinjam</label>';
          }
        }
        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["code_loan"];
        $nestedData[] = $row["name_loan"];
        $nestedData[] = date("d-m-Y, H:i", strtotime($row["created_at"]));
        $nestedData[] = date("d-m-Y, H:i", strtotime($row["due_date"]));
        $nestedData[] = $msg;
        if (hasPermit('submenu_laporan_peminjaman')) {
          $nestedData[] =
            '<a id="download" name="download" class="btn btn-xs btn-info" title="Download" data-content="' . $row['code_loan'] . '" data-target="' . $download . '">
              <i class="fa fa-download"></i>
              <span>Unduh</span>
            </a>';
        } else {
          $nestedData[] = "";
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-peminjaman']['remote'] && $dest == $enc['data-peminjaman']['unduh'] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link,"SELECT code_loan FROM tb_loan WHERE code_loan='$id'");
      $a = base64_encode($enc['data-peminjaman']['remote']);
      $b = base64_encode($enc['data-peminjaman']['unduh']);
      if (mysqli_num_rows($sql) == 1) {
        $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&id=' . $id;
        $data['peminjaman'] = array(
          'code' => 1,
          'url' => $url,
          'message' => 'Tunggu sebentar !',
        );
      } else {
        $data['peminjaman'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    }
    // API Laporan Peminjaman End //

    // API Laporan Pengembalian Start //
    elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['laporan']) {
      $columns = array(
        'created_at',
        'code_return',
        'code_loan',
        'name_return',
        'pin',
        'created_at'
      );
      $sql = "SELECT created_at,code_return,code_loan,name_return,pin FROM tb_return";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value'])) {
        $sql .= " WHERE code_return LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR code_loan LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR name_return LIKE '%" . $requestData['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $download = base64_encode($enc['data-pengembalian']['unduh']);

        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["code_return"];
        $nestedData[] = $row["code_loan"];
        $nestedData[] = $row["name_return"];
        $nestedData[] = date("d-m-Y, H:i", strtotime($row["created_at"]));
        $nestedData[] = $row['pin'] == 1 ? '<label class="text-success">Tepat waktu</label>' : '<label class="text-red">Terlambat</label>';
        if (hasPermit('submenu_laporan_peminjaman')) {
          $nestedData[] =
            '<a id="download" name="download" class="btn btn-xs btn-info" title="Download" data-content="' . $row['code_return'] . '" data-target="' . $download . '">
              <i class="fa fa-download"></i>
              <span>Unduh</span>
            </a>';
        } else {
          $nestedData[] = "";
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-pengembalian']['remote'] && $dest == $enc['data-pengembalian']['unduh'] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link,"SELECT code_return FROM tb_return WHERE code_return='$id'");
      $a = base64_encode($enc['data-pengembalian']['remote']);
      $b = base64_encode($enc['data-pengembalian']['unduh']);
      if (mysqli_num_rows($sql) == 1) {
        $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&id=' . $id;
        $data['pengembalian'] = array(
          'code' => 1,
          'url' => $url,
          'message' => 'Tunggu sebentar !',
        );
      } else {
        $data['pengembalian'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    }
    // API Laporan Pengembalian End //

    // API Laporan Penjualan Start //
    elseif ($route == $enc['data-penjualan']['remote'] && $dest == $enc['data-penjualan']['laporan']) {
      $columns = array(
        'created_at',
        'code_selling',
        'name_buyer',
        'total',
        'status'
      );
      $sql = "SELECT created_at,code_selling,name_buyer,total,status FROM tb_selling";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value'])) {
        $sql .= " WHERE code_selling LIKE '%" . $requestData['search']['value'] . "%' ";
        $sql .= " OR name_buyer LIKE '%" . $requestData['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $download = base64_encode($enc['data-penjualan']['unduh']);

        if ($row['status'] == 1) {
          $stts = '<label class="label label-success">Sudah lunas</label>';
        } else {
          $stts = '<label class="label label-warning">Belum bayar</label>';
        }
        
        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["code_selling"];
        $nestedData[] = $row["name_buyer"];
        $nestedData[] = "Rp. " . number_format($row["total"],0,".",",");
        $nestedData[] = $stts;
        if (hasPermit('submenu_laporan_peminjaman')) {
          $nestedData[] =
            '<a id="download" name="download" class="btn btn-xs btn-info" title="Download" data-content="' . $row['code_selling'] . '" data-target="' . $download . '">
              <i class="fa fa-download"></i>
              <span>Unduh</span>
            </a>';
        } else {
          $nestedData[] = "";
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-penjualan']['remote'] && $dest == $enc['data-penjualan']['unduh'] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link,"SELECT code_selling FROM tb_selling WHERE code_selling='$id'");
      $a = base64_encode($enc['data-penjualan']['remote']);
      $b = base64_encode($enc['data-penjualan']['unduh']);
      if (mysqli_num_rows($sql) == 1) {
        $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&id=' . $id;
        $data['penjualan'] = array(
          'code' => 1,
          'url' => $url,
          'message' => 'Tunggu sebentar !',
        );
      } else {
        $data['penjualan'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    }
    // API Laporan Penjualan End //

    // API Laporan Pembelian Start //
    elseif ($route == $enc['data-pembelian']['remote'] && $dest == $enc['data-pembelian']['laporan']) {
      $columns = array(
        'created_at',
        'code_buying',
        'total',
      );
      $sql = "SELECT created_at,code_buying,total FROM tb_buying";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value'])) {
        $sql .= " WHERE code_buying LIKE '%" . $requestData['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $download = base64_encode($enc['data-pembelian']['unduh']);

        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["code_buying"];
        $nestedData[] = "Rp. " . number_format($row["total"],0,".",",");
        if (hasPermit('submenu_laporan_peminjaman')) {
          $nestedData[] =
            '<a id="download" name="download" class="btn btn-xs btn-info" title="Download" data-content="' . $row['code_buying'] . '" data-target="' . $download . '">
              <i class="fa fa-download"></i>
              <span>Unduh</span>
            </a>';
        } else {
          $nestedData[] = "";
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-pembelian']['remote'] && $dest == $enc['data-pembelian']['unduh'] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link,"SELECT code_buying FROM tb_buying WHERE code_buying='$id'");
      $a = base64_encode($enc['data-pembelian']['remote']);
      $b = base64_encode($enc['data-pembelian']['unduh']);
      if (mysqli_num_rows($sql) == 1) {
        $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&id=' . $id;
        $data['pembelian'] = array(
          'code' => 1,
          'url' => $url,
          'message' => 'Tunggu sebentar !',
        );
      } else {
        $data['pembelian'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    }
    // API Laporan Pembelian End //

    // API Laporan Pengadaan Start //
    elseif ($route == $enc['data-pengadaan']['remote'] && $dest == $enc['data-pengadaan']['sha1'][0]) {
      $columns = array(
        'created_at',
        'code_pengadaan',
        'status',
        'total'
      );
      $sql = "SELECT created_at,code_pengadaan,status,total FROM tb_pengadaan";
      $query = mysqli_query($link, $sql) or die("error1");
      $totalData = mysqli_num_rows($query);
      $totalFiltered = $totalData;
      if (!empty($requestData['search']['value'])) {
        $sql .= " WHERE code_pengadaan LIKE '%" . $requestData['search']['value'] . "%' ";
        $query = mysqli_query($link, $sql) or die("error2");
        $totalFiltered = mysqli_num_rows($query);
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error3");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error4");
        }
      } else {
        if ($requestData['length'] != -1) {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
          $query = mysqli_query($link, $sql) or die("error5");
        } else {
          $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . ", $totalData";
          $query = mysqli_query($link, $sql) or die("error6");
        }
      }
      $i = 1;
      $dataTable = array();
      while ($row = mysqli_fetch_array($query)) {
        $edit = base64_encode($enc['data-pengadaan']['sha1'][3]);
        $detail = base64_encode($enc['data-pengadaan']['sha1'][5]);
        $delete = base64_encode($enc['data-pengadaan']['sha1'][6]);
        $download = base64_encode($enc['data-pengadaan']['unduh']);

        $nestedData = array();
        $nestedData[] = "";
        $nestedData[] = $row["code_pengadaan"];
        $nestedData[] = $row["status"] == 1 ? '<label class="label label-success">Telah diterima</label>' : '<label class="label label-info">Sedang diproses</label>';
        $nestedData[] = "Rp. " . number_format($row["total"],0,".",".");
        if (hasPermit('update_pengadaan') && hasPermit('delete_pengadaan')) {
          $nestedData[] =
            '<a id="edit" name="edit" class="btn btn-xs btn-warning" title="Edit Data" data-content="' . $row['code_pengadaan'] . '" data-target="' . $edit . '">
              <i class="fa fa-edit"></i>
              <span>Edit</span>
            </a>&nbsp;
            <a id="detail" name="detail" class="btn btn-xs btn-info" title="Detail Data" data-content="' . $row['code_pengadaan'] . '" data-target="' . $detail . '">
              <i class="fa fa-list"></i>
              <span>Detail</span>
            </a>&nbsp;
            <a id="download" name="download" class="btn btn-xs btn-info" title="Download" data-content="' . $row['code_pengadaan'] . '" data-target="' . $download . '">
              <i class="fa fa-download"></i>
              <span>Unduh</span>
            </a>&nbsp;
            <a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $row['code_pengadaan'] . '" data-content="' . $row['code_pengadaan'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';
        } else {
          $nestedData[] = '
            <a id="download" name="download" class="btn btn-xs btn-info" title="Download" data-content="' . $row['code_pengadaan'] . '" data-target="' . $download . '">
              <i class="fa fa-download"></i>
              <span>Unduh</span>
            </a>';
        }
        $dataTable[] = $nestedData;
      }

      $data = array(
        "draw"            => intval($requestData['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $dataTable
      );
    } elseif ($route == $enc['data-pengadaan']['remote'] && $dest == $enc['data-pengadaan']['sha1'][1]) {
      $sql = "SELECT good_item, broken_item, lost_item, total_stock FROM tb_items
              WHERE good_item < total_stock AND broken_item > 0 OR lost_item > 0";
      $exec = mysqli_query($link,$sql);
      if (mysqli_num_rows($exec) > 0) {
        $data['pengadaan'] = array(
          'code' => 1,
        );
      } else {
        $data['pengadaan'] = array(
          'code' => 0,
          'message' => 'Data rusak / hilang tidak tersedia !'
        );
      }
    } elseif ($route == $enc['data-pengadaan']['remote'] && $dest == $enc['data-pengadaan']['sha1'][2]) {
      $item = $requestData['itemnyo'];
      $date = date('Y-m-d H:i:s', strtotime('now'));
      if (count($item) > 0) {
        $kode = kodetransaksi(5);
        $total = 0;
        mysqli_query($link,"INSERT INTO tb_pengadaan VALUES('$kode','0','0','$date')");
        foreach ($item as $key => $value) {
          $a= mysqli_fetch_assoc(mysqli_query($link,"SELECT broken_item, lost_item, price_buy FROM tb_items WHERE code_item='$value'"));
          $price = $a['price_buy'];
          $rusak = $a['broken_item'];
          $hilang = $a['lost_item'];
          $sum = $rusak + $hilang;
          $sub = $price * $sum;
          mysqli_query($link,"INSERT INTO tb_pengadaan_details VALUES(NULL,'$kode','$value','$sum','$sub')");
          $total+=$sub;
        }
        $sql = mysqli_query($link,"UPDATE tb_pengadaan SET total='$total' WHERE code_pengadaan='$kode'");
        if ($sql) {
          $data['pengadaan'] = array(
            'code' => 1,
            'message' => 'Data berhasil disimpan'
          );
        } else {
          $data['pengadaan'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      } else {
        $data['pengadaan'] = array(
          'code' => 0,
          'message' => 'Masukkan data !'
        );
      }
    } elseif ($route == $enc['data-pengadaan']['remote'] && $dest == $enc['data-pengadaan']['sha1'][3] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link,"SELECT code_pengadaan, status FROM tb_pengadaan WHERE code_pengadaan='$id'");
      if (mysqli_num_rows($sql) == 1) {
        $r = mysqli_fetch_assoc($sql);
        $a = array(
          'code' => $r['code_pengadaan'],
          'stts' => $r['status']
        );
        $data['pengadaan'] = array(
          'code' => 1,
          'data' => $a,
        );
      } else {
        $data['pengadaan'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !'
        );
      }
    } elseif ($route == $enc['data-pengadaan']['remote'] && $dest == $enc['data-pengadaan']['sha1'][4] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $stts = $requestData['status'];
      $sql = mysqli_query($link,"UPDATE tb_pengadaan SET status='$stts' WHERE code_pengadaan='$id'");
      if ($sql) {
        $data['pengadaan'] = array(
          'code' => 1,
          'message' => 'Data berhasil diubah'
        );
      } else {
        $data['pengadaan'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-pengadaan']['remote'] && $dest == $enc['data-pengadaan']['sha1'][5] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = "SELECT p.code_pengadaan, p.status, total, i.created_at, name_item, amount, subtotal, name_unit, name_category, price_buy FROM tb_pengadaan_details AS d
              INNER JOIN tb_pengadaan AS p ON p.code_pengadaan = d.code_pengadaan
              INNER JOIN tb_items AS i ON i.code_item = d.code_item
              INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
              INNER JOIN tb_categories AS c ON c.code_category = i.code_category
              WHERE p.code_pengadaan='$id'";
      $query = mysqli_query($link,$sql);
      if (mysqli_num_rows($query) > 0) {
        while ($r = mysqli_fetch_assoc($query)) {
          $a = array(
            'code' => $r['code_pengadaan'],
            'status' => $r['status'] == 1 ? '<label class="label label-success">Telah diterima</label>' : '<label class="label label-info">Sedang diproses</label>'
          );
          $b[] = array(
            'name' => $r['name_item'],
            'jenis' => $r['name_category'],
            'jmlh' => number_format($r['amount'],0,".","."),
            'unit' => $r['name_unit'],
            'price' => number_format($r['price_buy'],0,".","."),
            'sub' => number_format($r['subtotal'],0,".",".")
          );
        }
        $data['pengadaan'] = array(
          'code' => 1,
          'data' => array(
            'detail' => $a,
            'list' => $b
          )
        );
      } else {
        $data['pengadaan'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan'
        );
      }
    } elseif ($route == $enc['data-pengadaan']['remote'] && $dest == $enc['data-pengadaan']['sha1'][6] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link,"DELETE FROM tb_pengadaan WHERE code_pengadaan='$id'");
      if ($sql) {
        $data['pengadaan'] = array(
          'code' => 1,
          'message' => 'Data berhasil dihapus !'
        );
      } else {
        $data['pengadaan'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    } elseif ($route == $enc['data-pengadaan']['remote'] && $dest == $enc['data-pengadaan']['sha1'][7] && isset($_GET['q'])) {
      $q = $requestData['q'];
      $sql = "SELECT code_item,name_item FROM tb_items WHERE code_item LIKE '%$q%' OR name_item LIKE '%$q%' AND broken_item > 0 OR lost_item > 0 ORDER BY created_at DESC";
      $check = mysqli_query($link,$sql);
      if (mysqli_num_rows($check) > 0) {
        $list = array();
        $i = 0;
        while ($r = mysqli_fetch_assoc($check)) {
          $list[] = array(
            'id' => $r['code_item'],
            'text' => ucwords($r['name_item'])
          );
          $i++;
        }
        $data = $list;
      } else {
        $data = "";
      }
    } elseif ($route == $enc['data-pengadaan']['remote'] && $dest == $enc['data-pengadaan']['sha1'][7] && isset($_GET['c'])) {
      $id = $requestData['c'];
      $query = "SELECT code_item,name_item,price_buy,name_category,broken_item,lost_item,name_unit FROM tb_items AS i
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                WHERE code_item='$id'";
      $sql = mysqli_query($link, $query);
      if (mysqli_num_rows($sql) > 0) {
        $a = array();
        $r = mysqli_fetch_assoc($sql);
        $hrg_beli = $r['price_buy'];
        $code = $r['code_item'];
        $rusak = $r['broken_item'];
        $hilang = $r['lost_item'];
        $sum = $rusak + $hilang;
        $sub = $sum * $hrg_beli;
        $item = '<input type="hidden" id="code" name="itemnyo[]" value="'.$code.'">';
        $a = array(
          'code' => $item,
          'name' => $r['name_item'],
          'tipe' => $r['name_category'] . " " . $r['name_unit'],
          'sum' => $sum,
          'buy' => $hrg_beli,
          'sub' => $sub
        );
        $data['pengadaan'] = array(
          'code' => 1,
          'data' => $a
        );
      } else {
        $data['pengadaan'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    } elseif ($route == $enc['data-pengadaan']['remote'] && $dest == $enc['data-pengadaan']['unduh'] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = mysqli_query($link,"SELECT code_pengadaan FROM tb_pengadaan WHERE code_pengadaan='$id'");
      $a = base64_encode($enc['data-pengadaan']['remote']);
      $b = base64_encode($enc['data-pengadaan']['unduh']);
      if (mysqli_num_rows($sql) == 1) {
        $url = BASE_URL . 'download?f=' . $a . '&d=' . $b . '&id=' . $id;
        $data['pengadaan'] = array(
          'code' => 1,
          'url' => $url,
          'message' => 'Tunggu sebentar !',
        );
      } else {
        $data['pengadaan'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    }
    // API Laporan Pengadaan End //
    
    // API Data Shopping Start //
    elseif ($route == $enc['data-shopping']['remote'] && $dest == $enc['data-shopping']['sha1'][0]) {
      $sql = "SELECT created_at,code_item,name_item,price_sale,cover FROM tb_items WHERE good_item > 0 AND price_sale > 0 ORDER BY created_at DESC LIMIT 0,12";
      $query = mysqli_query($link, $sql) or die("error1");
      if (mysqli_num_rows($query) > 0) {
        $user = $_SESSION['id'];
        $cart = mysqli_query($link,"SELECT * FROM tb_cart WHERE id_user='$user'");
        $a = array();
        $i = 0;
        $rmt = base64_encode($enc['data-shopping']['remote']);
        $tgt = base64_encode($enc['data-shopping']['sha1'][1]);
        while ($r = mysqli_fetch_assoc($query)) {
          $a[] = array(
            'code' => $r['code_item'],
            'items' => $r['name_item'],
            'price' => $r['price_sale'],
            'cover' => $r['cover'],
            'remote' => $rmt,
            'target' => $tgt
          );
          $i++;
        }
        $data['shopping'] = array(
          'code' => 1,
          'cart' => mysqli_num_rows($cart),
          'total' => mysqli_num_rows(mysqli_query($link,"SELECT * FROM tb_items WHERE good_item > 0 AND price_sale > 0")),
          'filter' => $i,
          'data' => $a
        );
      } else {
        $data['shopping'] = array(
          'code' => 0,
          'message' => 'Stok Sparepart Kosong !',
        );
      }
    } elseif ($route == $enc['data-shopping']['remote'] && $dest == $enc['data-shopping']['sha1'][1] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $sql = "SELECT created_at,code_item,name_item,price_sale,cover,description,good_item,name_unit,name_category FROM tb_items AS i 
              INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
              INNER JOIN tb_categories AS c ON c.code_category = i.code_category
              WHERE good_item > 0 AND price_sale > 0 AND code_item='$id'";
      $query = mysqli_query($link, $sql) or die("error1");
      if (mysqli_num_rows($query) > 0) {
        $rmt = base64_encode($enc['data-shopping']['remote']);
        $tgt = base64_encode($enc['data-shopping']['sha1'][2]);
        $a = array();
        $r = mysqli_fetch_assoc($query);
        $a = array(
          'code' => $r['code_item'],
          'items' => $r['name_item'],
          'cat' => $r['name_category'],
          'price' => $r['price_sale'],
          'cover' => $r['cover'],
          'stok' => $r['good_item'],
          'unit' => $r['name_unit'],
          'desc' => $r['description']
        );
        $data['shopping'] = array(
          'code' => 1,
          'data' => $a
        );
      } else {
        $data['shopping'] = array(
          'code' => 0,
          'message' => 'Stok Sparepart Kosong !',
        );
      }
    } elseif ($route == $enc['data-shopping']['remote'] && $dest == $enc['data-shopping']['sha1'][2] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $user = $_SESSION['id'];
      $uuid = Uuid::uuid4();
      $id_cart = $uuid->toString();
      $check = mysqli_query($link,"SELECT id_user,code_item FROM tb_cart WHERE id_user='$user' AND code_item='$id'");
      if (mysqli_num_rows($check) == 1) {
        $data['shopping'] = array(
          'code' => 0,
          'message' => 'Item telah ada di keranjang !'
        );
      } else {
        $sql = mysqli_query($link,"INSERT INTO tb_cart VALUES('$id_cart','$user','$id','1')");
        if ($sql) {
          $cart = mysqli_query($link,"SELECT * FROM tb_cart WHERE id_user='$user'");
          $data['shopping'] = array(
            'code' => 1,
            'message' => 'Item telah dimasukkan ke keranjang',
            'cart' => mysqli_num_rows($cart)
          );
        } else {
          $data['shopping'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      }
    } elseif ($route == $enc['data-shopping']['remote'] && ($dest == $enc['data-shopping']['sha1'][4] || $dest == $enc['data-shopping']['sha1'][3]) && isset($_GET['s']) && isset($_GET['q'])) {
      $awal = $requestData['s'];
      $query = $requestData['q'];
      $user = $_SESSION['id'];
      $cart = mysqli_query($link,"SELECT * FROM tb_cart WHERE id_user='$user'");
      if ($query == "") {
        $sql = "SELECT created_at,code_item,name_item,price_sale,cover FROM tb_items WHERE good_item > 0 AND price_sale > 0 ORDER BY created_at DESC LIMIT $awal,12";
        $query = mysqli_query($link, $sql) or die("error1");
        if (mysqli_num_rows($query) > 0) {
          $rmt = base64_encode($enc['data-shopping']['remote']);
          $tgt = base64_encode($enc['data-shopping']['sha1'][1]);
          $a = array();
          $i = $awal;
          while ($r = mysqli_fetch_assoc($query)) {
            $i++;
            $a[] = array(
              'code' => $r['code_item'],
              'items' => $r['name_item'],
              'price' => $r['price_sale'],
              'cover' => $r['cover'],
              'remote' => $rmt,
              'target' => $tgt
            );
          }
          $data['shopping'] = array(
            'code' => 1,
            'cart' => mysqli_num_rows($cart),
            'total' => mysqli_num_rows(mysqli_query($link,"SELECT * FROM tb_items WHERE good_item > 0 AND price_sale > 0")),
            'filter' => $i,
            'data' => $a
          );
        } else {
          $data['shopping'] = array(
            'code' => 0,
            'message' => 'Stok Sparepart Kosong !',
          );
        }
      } else {
        $sql = "SELECT created_at,code_item,name_item,price_sale,cover FROM tb_items 
                WHERE good_item > 0 AND price_sale > 0 AND name_item LIKE '%$query%' 
                ORDER BY created_at DESC LIMIT $awal,12";
        $query = mysqli_query($link, $sql) or die("error1");
        if (mysqli_num_rows($query) > 0) {
          $rmt = base64_encode($enc['data-shopping']['remote']);
          $tgt = base64_encode($enc['data-shopping']['sha1'][1]);
          $a = array();
          $i = $awal;
          while ($r = mysqli_fetch_assoc($query)) {
            $i++;
            $a[] = array(
              'code' => $r['code_item'],
              'items' => $r['name_item'],
              'price' => $r['price_sale'],
              'cover' => $r['cover'],
              'remote' => $rmt,
              'target' => $tgt
            );
          }
          $data['shopping'] = array(
            'code' => 1,
            'cart' => mysqli_num_rows($cart),
            'total' => mysqli_num_rows(mysqli_query($link,"SELECT * FROM tb_items WHERE good_item > 0 AND price_sale > 0")),
            'filter' => $i,
            'data' => $a
          );
        } else {
          $data['shopping'] = array(
            'code' => 0,
            'message' => 'Stok Sparepart Kosong !',
          );
        }
      }
    } elseif ($route == $enc['data-shopping']['remote'] && $dest == $enc['data-cart']['sha1'][0]) {
      $user = $_SESSION['id'];
      $sql = "SELECT * FROM tb_cart WHERE id_user='$user'";
      $cart = mysqli_query($link,"SELECT * FROM tb_cart WHERE id_user='$user'");
      $query = mysqli_query($link, $sql) or die("error1");
      if (mysqli_num_rows($query) > 0) {
        $data['shopping'] = array(
          'code' => 1,
          'cart' => mysqli_num_rows($cart),
          'url' => BASE_URL . "dashboard/" . strtolower(str_replace(' ', '-', $menu[5])) . "/" . strtolower(str_replace(' ', '-', $submenu[9])) . "/",
        );
      } else {
        $data['shopping'] = array(
          'code' => 0,
          'cart' => mysqli_num_rows($cart),
          'message' => 'Keranjang Kosong !',
        );
      }
    }
    // API Data Shopping End //

    // API Data Cart Start //
    elseif ($route == $enc['data-cart']['remote'] && $dest == $enc['data-cart']['sha1'][0]) {
      $user = $_SESSION['id'];
      $sql = "SELECT c.code_item,name_item,price_sale,amount,good_item FROM `tb_cart` AS c
              INNER JOIN tb_items AS i ON i.code_item = c.code_item
              INNER JOIN tb_users AS u ON u.id_user = c.id_user
              WHERE c.id_user='$user'";
      $query = mysqli_query($link,$sql);
      if (mysqli_num_rows($query) > 0) {
        $a = array();
        while ($r = mysqli_fetch_assoc($query)) {
          $edit = base64_encode($enc['data-cart']['sha1'][1]);
          $delete = base64_encode($enc['data-cart']['sha1'][4]);

          $nestedData =
            '<a id="hapus" name="hapus" class="btn btn-xs btn-danger" title="Hapus Data" title-content="' . $r['name_item'] . '" data-content="' . $r['code_item'] . '" data-target="' . $delete . '">
              <i class="fa fa-trash"></i>
              <span>Hapus</span>
            </a>';

          $a[] = array(
            'code' => $r['code_item'],
            'name' => $r['name_item'],
            'price' => $r['price_sale'],
            'stock' => $r['good_item'],
            'amount' => $r['amount'],
            'target' => $edit,
            'action' => $nestedData
          );
        }
        $data['cart'] = array(
          'code' => 1,
          'data' => $a
        );
      } else {
        $data['cart'] = array(
          'code' => 0,
          'data' => 'Data keranjang kosong !'
        );
      }
    } elseif ($route == $enc['data-cart']['remote'] && $dest == $enc['data-cart']['sha1'][1] && isset($_GET['id'])) {
      $user = $_SESSION['id'];
      $id = $requestData['id'];
      $jmlh = $requestData['jumlah'];
      $sql = mysqli_query($link,"UPDATE tb_cart SET amount='$jmlh' WHERE id_user='$user' AND code_item='$id'");
      if ($sql) {
        $data = true;
      } else {
        $data = false;
      }
    } elseif ($route == $enc['data-cart']['remote'] && $dest == $enc['data-cart']['sha1'][2]) {
      $user = $_SESSION['id'];
      $kode = kodetransaksi(3);
      $nama = $requestData['nama'];
      $stts = $requestData['status'];
      $pilih = $requestData['pilih'];
      $jmlh = $requestData['jumlah'];
      $date = date('Y-m-d H:i:s',strtotime('now'));
      $total = 0;
      $i = 0;
      mysqli_query($link,"INSERT INTO tb_selling VALUES('$kode','$nama','$total','$stts','$date')");
      foreach ($pilih as $key => $value) {
        $check = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM tb_items WHERE code_item='$value'"));
        $buy = $check['price_buy'];
        $sale = $check['price_sale'];
        $amount = $jmlh[$key];
        $sub = $sale * $amount;
        $profit = ($sale - $buy) * $amount;
        mysqli_query($link,"INSERT INTO tb_selling_details VALUES(NULL,'$kode','$value','$amount','$sub','$profit')");
        mysqli_query($link,"UPDATE tb_items SET good_item=good_item-'$amount', total_stock=total_stock-'$amount' WHERE code_item='$value'");
        $total += $sub;
        mysqli_query($link,"DELETE FROM tb_cart WHERE id_user='$user' AND code_item='$value'");
        $i++;
      }
      if ($i == count($pilih)) {
        $sql = mysqli_query($link,"UPDATE tb_selling SET total='$total' WHERE code_selling='$kode'");
      }
      if ($sql) {
        $url = BASE_URL . "dashboard/" . strtolower(str_replace(' ', '-', $menu[1])) . "/" . strtolower(str_replace(' ', '-', $submenu[5])) . "/";
        $data['cart'] = array(
          'code' => 1,
          'message' => 'Data berhasil disimpan !',
          'url' => $url,
        );
      } else {
        $data['cart'] = array(
          'code' => 0,
          'message' => mysqli_error($link),
        );
      }
    } elseif ($route == $enc['data-cart']['remote'] && $dest == $enc['data-cart']['sha1'][4] && isset($_GET['id'])) {
      $user = $_SESSION['id'];
      $id = $requestData['id'];
      $sql = mysqli_query($link,"DELETE FROM tb_cart WHERE id_user='$user' AND code_item='$id'");
      if ($sql) {
        $data['cart'] = array(
          'code' => 1,
          'message' => 'Item telah dihapus dari cart'
        );
      } else {
        $data['cart'] = array(
          'code' => 0,
          'message' => mysqli_error($link)
        );
      }
    }
    // API Data Cart End //

    // API Ubah Password Start //
    elseif ($route == $enc['data-password']['remote'] && $dest == $enc['data-password']['sha1'][1] && isset($_GET['u'])) {
      $id = base64_decode($requestData['u']);
      $pass = hash('sha512', $requestData['passwordlama']);
      $sql = mysqli_query($link, "SELECT username,password FROM tb_users WHERE username='$id' AND password='$pass' LIMIT 1");
      if (mysqli_num_rows($sql) == 1) {
        $data = true;
      } else {
        $data = false;
      }
    } elseif ($route == $enc['data-password']['remote'] && $dest == $enc['data-password']['sha1'][0] && isset($_GET['u'])) {
      $id = base64_decode($requestData['u']);
      $passnew = $requestData['passwordbaru'];
      $passcon = $requestData['konfirmasipassword'];
      if ($passnew == $passcon) {
        $a = hash('sha512', $passnew);
        $sql = mysqli_query($link, "UPDATE tb_users SET password='$a' WHERE username='$id'");
        if ($sql) {
          $data['password'] = array(
            'code' => 1,
            'message' => 'Password berhasil diubah !'
          );
        } else {
          $data['password'] = array(
            'code' => 0,
            'message' => mysqli_error($link)
          );
        }
      } else {
        $data['password'] = array(
          'code' => 0,
          'message' => "Invalid request"
        );
      }
    }
    // API Ubah Password End //

    // API Notifikasi Start //
    elseif ($route == $enc['data-notifikasi']['remote'] && $dest == $enc['data-notifikasi']['sha1'][0]) {
      $sql = "SELECT r.created_at,r.code_return,r.name_return FROM tb_return AS r
              WHERE r.rechange = '1'
              ORDER BY r.created_at DESC";
      $query = mysqli_query($link,$sql);
      $target = base64_encode($enc['data-notifikasi']['sha1'][1]);
      if (mysqli_num_rows($query) > 0) {
        while ($r = mysqli_fetch_assoc($query)) {
          $dt[] = array(
            'msg' => $r['code_return'] . " " . $r['name_return'],
            'trgt' => $target,
            'code' => $r['code_return']
          );
        }
        $data['notifikasi'] = array(
          'code' => true,
          'data' => $dt
        );
      } else {
        $data['notifikasi'] = array(
          'code' => false,
          'message' => 'Tidak ada pemberitahuan'
        );
      }
    }
    elseif ($route == $enc['data-notifikasi']['remote'] && $dest == $enc['data-notifikasi']['sha1'][1] && isset($_GET['id'])) {
      $id = $requestData['id'];
      $query = "SELECT d.code_return, r.code_loan, name_return, pin, long_period, penalty, rechange, info, l.due_date, l.created_at AS pinjam, r.created_at, 
                d.code_item, name_item, name_category, amount_loan, broken_amount, broken_status, lost_amount, lost_status, name_unit FROM tb_return_details AS d
                INNER JOIN tb_return AS r ON r.code_return = d.code_return
                INNER JOIN tb_items AS i ON i.code_item = d.code_item
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                INNER JOIN tb_loan AS l ON l.code_loan = r.code_loan
                WHERE r.code_return='$id'";
      $sql = mysqli_query($link, $query);
      if (mysqli_num_rows($sql) > 0) {
        $a = array();
        $b = array();
        while ($r = mysqli_fetch_assoc($sql)) {
          if ($r['rechange'] == 2) {
            $change = '<label class="text-info">Sudah diganti</label>';
          } elseif ($r['rechange'] == 1) {
            $change = '<label class="text-danger">Belum diganti</label>';
          } else {
            $change = '<label class="text-success">Tidak ada penggantian</label>';
          }
          if ($r['broken_status'] == 2) {
            $broken = '<label class="text-danger">Tidak sengaja</label>';
          } elseif ($r['broken_status'] == 1) {
            $broken = '<label class="text-danger">Disengaja</label>';
          } else {
            $broken = '-';
          }
          if ($r['lost_status'] == 2) {
            $lost = '<label class="text-danger">Tidak sengaja</label>';
          } elseif ($r['lost_status'] == 1) {
            $lost = '<label class="text-danger">Disengaja</label>';
          } else {
            $lost = '-';
          }
          $a[] = array(
            'code_item' => $r['code_item'],
            'name_item' => $r['name_item'],
            'category' => $r['name_category'],
            'amount' => $r['amount_loan'],
            'broken_status' => $broken,
            'broken_amount' => $r['broken_amount'],
            'lost_status' => $lost,
            'lost_amount' => $r['lost_amount'],
            'unit' => $r['name_unit']
          );

          $b = array(
            'code_return' => $r['code_return'],
            'code_loan' => $r['code_loan'],
            'name' => $r['name_return'],
            'pin' => $r['pin'] == 1 ? '<label class="text-success">Tepat waktu</label>' : '<label class="text-red">Terlambat</label>',
            'period' => $r['long_period'],
            'change' => $change,
            'penalty' => $r['penalty'],
            'info' => $r['info'],
            'pinjam' => date('d-m-Y, H:i', strtotime($r['pinjam'])),
            'due' => date('d-m-Y, H:i', strtotime($r['due_date'])),
            'create' => date('d-m-Y, H:i',strtotime($r['created_at'])),
          );
        }
        $data['notifikasi'] = array(
          'code' => 1,
          'data' => array(
            'peminjam' => $b,
            'peralatan' => $a
          )
        );
      } else {
        $data['notifikasi'] = array(
          'code' => 0,
          'message' => 'Data tidak ditemukan !',
        );
      }
    }
    // API Notifikasi End //
  } else {
    $data = array('code' => 404, 'message' => 'Invalid Url');
  }
} else {
  $data = array('code' => 403, 'message' => 'Access Forbidden');
}

echo json_encode($data);
