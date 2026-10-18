<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $nama_satuan = $_POST['nama_satuan'];
    $status = $_POST['status'];

    
    $sql = "INSERT INTO satuan (nama_satuan, status) VALUES ('$nama_satuan', '$status')";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: index.php");
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Tambah Satuan</title></head>
<body>
    <h2>Tambah Satuan Barang (Create)</h2>
    <form method="POST" action="">
        <label>Nama Satuan:</label><br>
        <input type="text" name="nama_satuan" required><br><br>
        
        <label>Status:</label><br>
        <select name="status">
            <option value="1">Aktif</option>
            <option value="0">Non-Aktif</option>
        </select><br><br>

        <button type="submit" name="submit">Simpan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>