<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

$query_satuan = mysqli_query($koneksi, "SELECT * FROM satuan WHERE idsatuan='$id'");
$satuan = $query_satuan ? mysqli_fetch_assoc($query_satuan) : null;

if (!$satuan) {
    header("Location: index.php?page=satuan");
    exit;
}

// EKSEKUSI STORED FUNCTION DARI HEIDISQL
$query_count = mysqli_query($koneksi, "SELECT func_total_barang_satuan('$id') AS total_item");
$res_count   = mysqli_fetch_assoc($query_count);
$total_item  = isset($res_count['total_item']) ? $res_count['total_item'] : 0;


$query_detail = mysqli_query($koneksi, "SELECT b.*, v.nama_vendor 
    FROM barang b 
    LEFT JOIN vendor v ON b.idsatuan = v.idvendor 
    WHERE b.idsatuan='$id'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang Satuan <?= $satuan['nama_satuan']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 font-sans min-h-screen p-8">

    <div class="max-w-5xl mx-auto">
        <a href="index.php?page=satuan" class="inline-flex items-center gap-2 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 px-3 py-2 rounded-lg mb-6 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Satuan
        </a>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-6 flex justify-between items-center">
            <div>
                <span class="text-xs font-bold text-teal-600 uppercase tracking-widest">Detail Modul Satuan</span>
                <h2 class="text-2xl font-bold text-slate-800 mt-1">Satuan: <?= $satuan['nama_satuan']; ?></h2>
                <p class="text-xs text-slate-500 mt-1">Daftar item produk barang yang menggunakan unit takaran ini.</p>
            </div>
            <!-- ANGKA HASIL PEMANGGILAN STORED FUNCTION -->
            <div class="bg-teal-50 border border-teal-200 px-4 py-3 rounded-xl text-center">
                <span class="text-2xl font-bold text-teal-700"><?= $total_item; ?></span>
                <p class="text-xs text-teal-600 font-medium">Total Item (Stored Function)</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-100 bg-slate-50">
                <h3 class="font-bold text-slate-700 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-teal-600"></i> Daftar Barang Terdaftar
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-gray-200 text-xs uppercase text-slate-500 font-semibold">
                            <th class="py-3.5 px-5">ID Barang</th>
                            <th class="py-3.5 px-5">Kategori / Jenis</th>
                            <th class="py-3.5 px-5">Nama Barang / Produk</th>
                            <th class="py-3.5 px-5">Harga Satuan</th>
                            <th class="py-3.5 px-5">Supplier / Vendor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-slate-700">
                        <?php if ($query_detail && mysqli_num_rows($query_detail) > 0) : ?>
                            <?php while ($row = mysqli_fetch_assoc($query_detail)) : ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3.5 px-5 font-mono text-xs text-slate-500"><?= $row['idbarang']; ?></td>
                                <td class="py-3.5 px-5">
                                    <span class="bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded-md font-medium"><?= isset($row['jenis']) ? $row['jenis'] : 'M'; ?></span>
                                </td>
                                <td class="py-3.5 px-5 font-bold text-slate-800"><?= isset($row['nama']) ? $row['nama'] : (isset($row['nama_barang']) ? $row['nama_barang'] : '-'); ?></td>
                                <td class="py-3.5 px-5 font-semibold text-emerald-600">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td class="py-3.5 px-5">
                                    <span class="text-xs font-semibold text-slate-700 block">
                                        <?= !empty($row['nama_vendor']) ? $row['nama_vendor'] : 'PT Remaja Sentosa Supplier'; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400 text-xs">
                                    Belum ada data barang terhubung yang menggunakan satuan ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>