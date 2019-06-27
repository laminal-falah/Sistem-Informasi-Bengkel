<?php
require_once '../path.php';
require_once(ABSPATH . '../config/config.php');
require_once(ABSPATH . '../config/database.php');
require_once(ABSPATH . '../config/enkripsi.php');
require_once(ABSPATH . '../config/header-json.php');
require_once(ABSPATH . '../config/functions.php');
require_once(ABSPATH . '../vendor/autoload.php');

$data = array();
$requestData = $_REQUEST;

if (isset($_GET['f']) && isset($_GET['d'])) {
    $route = base64_decode($_GET['f']);
    $dest = base64_decode($_GET['d']);
    if ($route == $enc['data-shopping']['remote'] && $dest == $enc['data-shopping']['sha1'][0]) {
        $sql = "SELECT created_at,code_item,name_item,cover,name_category FROM tb_items AS i
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                WHERE good_item > 0 ORDER BY created_at DESC LIMIT 0,6";
        $query = mysqli_query($link, $sql) or die("error1");
        if (mysqli_num_rows($query) > 0) {
            $a = array();
            $i = 0;
            $rmt = base64_encode($enc['data-shopping']['remote']);
            $tgt = base64_encode($enc['data-shopping']['sha1'][1]);
            while ($r = mysqli_fetch_assoc($query)) {
                $a[] = array(
                    'code' => $r['code_item'],
                    'items' => $r['name_item'],
                    'cover' => $r['cover'],
                    'cats' => $r['name_category'],
                    'remote' => $rmt,
                    'target' => $tgt
                );
                $i++;
            }
            $data['shopping'] = array(
                'code' => 1,
                'total' => mysqli_num_rows(mysqli_query($link, "SELECT * FROM tb_items WHERE good_item > 0")),
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
        $sql = "SELECT created_at,code_item,name_item,location,cover,description,good_item,name_unit,name_category FROM tb_items AS i
                INNER JOIN tb_unit AS u ON u.id_unit = i.id_unit
                INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                WHERE good_item > 0 AND code_item='$id'";
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
                'location' => $r['location'],
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
    } elseif ($route == $enc['data-shopping']['remote'] && ($dest == $enc['data-shopping']['sha1'][4] || $dest == $enc['data-shopping']['sha1'][3]) && isset($_GET['s']) && isset($_GET['q'])) {
        $awal = $requestData['s'];
        $query = $requestData['q'];
        if ($query == "") {
            
            $sql = "SELECT created_at,code_item,name_item,cover,name_category FROM tb_items AS i
                    INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                    WHERE good_item > 0 ORDER BY created_at DESC LIMIT $awal,6";
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
                        'cover' => $r['cover'],
                        'cats' => $r['name_category'],
                        'remote' => $rmt,
                        'target' => $tgt
                    );
                }
                $data['shopping'] = array(
                    'code' => 1,
                    'total' => mysqli_num_rows(mysqli_query($link, "SELECT * FROM tb_items WHERE good_item > 0")),
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
            $sql = "SELECT created_at,code_item,name_item,cover,name_category FROM tb_items AS i
                    INNER JOIN tb_categories AS c ON c.code_category = i.code_category
                    WHERE good_item > 0 AND name_item LIKE '%$query%' 
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
                        'cats' => $r['name_category'],
                        'cover' => $r['cover'],
                        'remote' => $rmt,
                        'target' => $tgt
                    );
                }
                $data['shopping'] = array(
                    'code' => 1,
                    'total' => mysqli_num_rows(mysqli_query($link, "SELECT * FROM tb_items WHERE good_item > 0")),
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
    }
} else {
    $data = array('code' => 404, 'message' => 'Invalid Url');
}

echo json_encode($data);
