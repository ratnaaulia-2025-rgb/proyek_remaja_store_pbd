<?php
include 'koneksi.php';

$id = $_GET['id'];

$sql = "DELETE FROM satuan WHERE idsatuan='$id'";

if (mysqli_query($koneksi, $sql)) {
    header("Location: index.php");
} else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
}
?>