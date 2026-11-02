<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $idvendor = $_POST['idvendor'];
    $idbarang = $_POST['idbarang'];
    $jumlah   = $_POST['jumlah'];
    $harga    = $_POST['harga_beli'];

    // 1. Simpan Penerimaan
    mysqli_query($koneksi, "INSERT INTO penerimaan (tgl_penerimaan, idvendor) VALUES (NOW(), '$idvendor')");
    $idpenerimaan = mysqli_insert_id($koneksi);

    // 2. Simpan Detail (TRIGGER STOK + KARTU STOK)
    $q_detail = mysqli_query($koneksi, "INSERT INTO penerimaan_detail (idpenerimaan, idbarang, jumlah, harga_beli) 
                                        VALUES ('$idpenerimaan', '$idbarang', '$jumlah', '$harga')");

    if ($q_detail) {
        header("Location: kartu_stok.php");
        exit;
    }
}

$list_barang = mysqli_query($koneksi, "SELECT * FROM barang");
$list_vendor = mysqli_query($koneksi, "SELECT * FROM vendor");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Transaksi Penerimaan Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 w-full max-w-md">
        <div class="mb-5 border-b pb-3 border-gray-100 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-truck-ramp-box text-emerald-600"></i> Penerimaan Barang
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Input stok barang masuk dari vendor</p>
            </div>
            <a href="index.php?page=barang" class="text-xs text-slate-400 hover:text-slate-600">Batal</a>
        </div>

        <form method="POST" action="penerimaan.php" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Vendor Penyuplai</label>
                <select name="idvendor" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-emerald-500">
                    <?php while ($v = mysqli_fetch_assoc($list_vendor)) : ?>
                        <option value="<?= $v['idvendor']; ?>"><?= $v['nama_vendor']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Barang Diterima</label>
                <select name="idbarang" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-emerald-500">
                    <?php while ($b = mysqli_fetch_assoc($list_barang)) : ?>
                        <option value="<?= $b['idbarang']; ?>"><?= isset($b['nama']) ? $b['nama'] : $b['nama_barang']; ?> (Stok Sekarang: <?= $b['stok']; ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Masuk (Qty)</label>
                <input type="number" name="jumlah" min="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-emerald-500" placeholder="Misal: 10">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Harga Beli Beli Satuan (Rp)</label>
                <input type="number" name="harga_beli" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-emerald-500" placeholder="Misal: 15000">
                <p class="text-[10px] text-emerald-600 mt-1">*Disubmit akan otomatis memicu Trigger penambahan stok & pencatatan kartu stok[cite: 6, 10].</p>
            </div>

            <div class="flex justify-end gap-2 pt-3">
                <button type="submit" name="submit" class="w-full py-2.5 bg-emerald-600 text-white text-xs font-semibold rounded-lg hover:bg-emerald-700 transition">Proses Penerimaan Barang</button>
            </div>
        </form>
    </div>

</body>
</html>