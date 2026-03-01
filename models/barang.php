<?php
class Barang {
    private $conn;
    private $table_name = "barang";

    // Properti objek barang
    public $id;
    public $kode_barang;
    public $nama_barang;
    public $stok;

    // Konstruktor menerima koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi untuk membaca data (Read)
    public function read() {
        $query = "SELECT id, kode_barang, nama_barang, stok FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Fungsi untuk menambah data API (Create)
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET kode_barang=:kode_barang, nama_barang=:nama_barang, stok=:stok";
        $stmt = $this->conn->prepare($query);

        // Membersihkan data dari tag HTML/karakter berbahaya
        $this->kode_barang = htmlspecialchars(strip_tags($this->kode_barang));
        $this->nama_barang = htmlspecialchars(strip_tags($this->nama_barang));
        $this->stok = htmlspecialchars(strip_tags($this->stok));

        // Binding data
        $stmt->bindParam(":kode_barang", $this->kode_barang);
        $stmt->bindParam(":nama_barang", $this->nama_barang);
        $stmt->bindParam(":stok", $this->stok);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>