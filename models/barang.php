<?php
class Barang
{
    private $conn;
    private $table_name = "barang";

    public $id;
    public $kode_barang;
    public $nama_barang;
    public $stok;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT id, kode_barang, nama_barang, stok FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " SET kode_barang=:kode_barang, nama_barang=:nama_barang, stok=:stok";
        $stmt = $this->conn->prepare($query);

        $this->kode_barang = htmlspecialchars(strip_tags($this->kode_barang));
        $this->nama_barang = htmlspecialchars(strip_tags($this->nama_barang));
        $this->stok = htmlspecialchars(strip_tags($this->stok));

        $stmt->bindParam(":kode_barang", $this->kode_barang);
        $stmt->bindParam(":nama_barang", $this->nama_barang);
        $stmt->bindParam(":stok", $this->stok);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                SET kode_barang = :kode_barang, nama_barang = :nama_barang, stok = :stok 
                WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->kode_barang = htmlspecialchars(strip_tags($this->kode_barang));
        $this->nama_barang = htmlspecialchars(strip_tags($this->nama_barang));
        $this->stok = htmlspecialchars(strip_tags($this->stok));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":kode_barang", $this->kode_barang);
        $stmt->bindParam(":nama_barang", $this->nama_barang);
        $stmt->bindParam(":stok", $this->stok);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
