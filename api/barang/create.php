<?php
// Header wajib untuk API RESTful (metode POST)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Memanggil file konfigurasi dan model
include_once '../../config/Database.php';
include_once '../../models/Barang.php';

// Inisialisasi koneksi database
$database = new Database();
$db = $database->getConnection();

// Inisialisasi objek Barang
$barang = new Barang($db);

// Mengambil data raw JSON yang dikirimkan oleh klien
$data = json_decode(file_get_contents("php://input"));

// Memastikan data tidak kosong
if(
    !empty($data->kode_barang) &&
    !empty($data->nama_barang) &&
    isset($data->stok)
){
    // Memasukkan nilai dari JSON ke dalam properti objek barang
    $barang->kode_barang = $data->kode_barang;
    $barang->nama_barang = $data->nama_barang;
    $barang->stok = $data->stok;

    // Menjalankan fungsi create() dari model
    if($barang->create()){
        // Set response code - 201 Created
        http_response_code(201);
        echo json_encode(array("pesan" => "Barang berhasil ditambahkan."));
    } else {
        // Set response code - 503 Service Unavailable
        http_response_code(503);
        echo json_encode(array("pesan" => "Gagal menambahkan barang."));
    }
} else {
    // Set response code - 400 Bad Request
    http_response_code(400);
    echo json_encode(array("pesan" => "Data tidak lengkap. Gagal menambahkan barang."));
}
?>