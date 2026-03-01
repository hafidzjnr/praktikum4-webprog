<?php
// Header wajib untuk API RESTful
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Memanggil file konfigurasi dan model
include_once '../../config/Database.php';
include_once '../../models/Barang.php';

// Inisialisasi database dan objek Barang
$database = new Database();
$db = $database->getConnection();
$barang = new Barang($db);

// Eksekusi fungsi read()
$stmt = $barang->read();
$num = $stmt->rowCount();

if($num > 0) {
    // Array penampung data
    $barang_arr = array();
    $barang_arr["pesan"] = "Data inventaris ditemukan";
    $barang_arr["data"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $barang_item = array(
            "id" => $id,
            "kode_barang" => $kode_barang,
            "nama_barang" => $nama_barang,
            "stok" => $stok
        );
        array_push($barang_arr["data"], $barang_item);
    }

    // Ubah ke format JSON
    http_response_code(200);
    echo json_encode($barang_arr);
} else {
    http_response_code(404);
    echo json_encode(array("pesan" => "Barang tidak ditemukan."));
}
?>