<?php
include 'koneksi.php';


$query_kartu = mysqli_query($koneksi, "SELECT k.*, b.nama FROM kartu_stok k LEFT JOIN barang b ON k.idbarang = b.idbarang");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Stok Barang (Trigger Active)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 font-sans min-h-screen p-8">

    <div class="max-w-6xl mx-auto">
        <a href="index.php?page=barang" class="inline-flex items-center gap-2 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 px-3 py-2 rounded-lg mb-6 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Barang
        </a>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-6 flex justify-between items-center">
            <div>
                <span class="text-xs font-bold text-teal-600 uppercase tracking-widest">Inventory Management</span>
                <h2 class="text-2xl font-bold text-slate-800 mt-1">Kartu Stok Otomatis (Trigger Database)</h2>
                <p class="text-xs text-slate-500 mt-1">Seluruh transaksi Masuk & Keluar dicatat otomatis oleh Trigger tanpa pemanggilan manual di PHP.</p>
            </div>
            <div class="bg-teal-50 border border-teal-200 px-4 py-3 rounded-xl text-center">
                <i class="fa-solid fa-boxes-stacked text-teal-600 text-xl mb-1"></i>
                <p class="text-xs text-teal-600 font-bold">Auto Card Sync</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-gray-200 text-xs uppercase text-slate-500 font-semibold">
                            <th class="py-3.5 px-5">ID Kartu</th>
                            <th class="py-3.5 px-5">Nama Barang</th>
                            <th class="py-3.5 px-5">Jenis Transaksi</th>
                            <th class="py-3.5 px-5 text-emerald-600">Masuk (+Stok)</th>
                            <th class="py-3.5 px-5 text-rose-600">Keluar (-Stok)</th>
                            <th class="py-3.5 px-5">Sisa Stok Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-slate-700">
                        <?php if ($query_kartu && mysqli_num_rows($query_kartu) > 0) : ?>
                            <?php while ($row = mysqli_fetch_assoc($query_kartu)) : ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3.5 px-5 font-mono text-xs text-slate-500">#<?= isset($row['idkartu']) ? $row['idkartu'] : '-'; ?></td>
                                <td class="py-3.5 px-5 font-bold text-slate-800"><?= !empty($row['nama']) ? $row['nama'] : 'Barang ID #'.$row['idbarang']; ?></td>
                                <td class="py-3.5 px-5">
                                    <?php if (isset($row['jenis_transaksi']) && $row['jenis_transaksi'] == 'PENERIMAAN') : ?>
                                        <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-0.5 rounded-full font-semibold">PENERIMAAN</span>
                                    <?php else : ?>
                                        <span class="bg-rose-100 text-rose-800 text-xs px-2.5 py-0.5 rounded-full font-semibold">PENJUALAN</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-5 font-semibold text-emerald-600">+<?= isset($row['masuk']) ? $row['masuk'] : 0; ?></td>
                                <td class="py-3.5 px-5 font-semibold text-rose-600">-<?= isset($row['keluar']) ? $row['keluar'] : 0; ?></td>
                                <td class="py-3.5 px-5 font-bold text-slate-900"><?= isset($row['sisa_stok']) ? $row['sisa_stok'] : (isset($row['stok']) ? $row['stok'] : 0); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="py-6 text-center text-slate-400 text-xs">
                                    Belum ada catatan kartu stok transaksi.
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