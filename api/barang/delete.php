<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(["pesan" => "Method tidak diizinkan. Gunakan DELETE."]);
    exit;
}

include_once '../../config/database.php';
include_once '../../models/barang.php';

$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)){
    $barang->id = $data->id;

    if($barang->delete()){
        http_response_code(200);
        echo json_encode(array("pesan" => "Barang berhasil dihapus."));
    } else {
        http_response_code(503);
        echo json_encode(array("pesan" => "Gagal menghapus barang."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("pesan" => "Data tidak lengkap. ID barang diperlukan."));
}
?>