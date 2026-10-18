<?php
include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM satuan WHERE idsatuan='$id'");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama_satuan = $_POST['nama_satuan'];
    $status_satuan = $_POST['status_satuan'];

    $sql = "UPDATE satuan SET nama_satuan='$nama_satuan', status_satuan='$status_satuan' WHERE idsatuan='$id'";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: index.php");
    } else {
        echo "Gagal mengupdate: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Satuan</title></head>
<body>
    <h2>Edit Satuan Barang (Update)</h2>
    <form method="POST" action="">
        <label>Nama Satuan:</label><br>
        <input type="text" name="nama_satuan" value="<?= $row['nama_satuan']; ?>" required><br><br>

        <label>Status:</label><br>
        <select name="status_satuan">
            <option value="1" <?= $row['status_satuan'] == 1 ? 'selected' : ''; ?>>Aktif</option>
            <option value="0" <?= $row['status_satuan'] == 0 ? 'selected' : ''; ?>>Non-Aktif</option>
        </select><br><br>

        <button type="submit" name="update">Update</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>