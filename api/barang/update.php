<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(["pesan" => "Method tidak diizinkan. Gunakan PUT."]);
    exit;
}

include_once '../../config/database.php';
include_once '../../models/barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

$data = json_decode(file_get_contents("php://input"));


if(
    !empty($data->id) &&
    !empty($data->kode_barang) &&
    !empty($data->nama_barang) &&
    isset($data->stok)
){
    $barang->id = $data->id;
    $barang->kode_barang = $data->kode_barang;
    $barang->nama_barang = $data->nama_barang;
    $barang->stok = $data->stok;

    if($barang->update()){
        http_response_code(200);
        echo json_encode(array("pesan" => "Data barang berhasil diperbarui."));
    } else {
        http_response_code(503);
        echo json_encode(array("pesan" => "Gagal memperbarui data barang."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("pesan" => "Data tidak lengkap. Sertakan ID dan data baru."));
}
?>