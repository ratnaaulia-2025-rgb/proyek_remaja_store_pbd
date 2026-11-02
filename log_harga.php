<?php
include 'koneksi.php';

$query_log = mysqli_query($koneksi, "SELECT * FROM log_perubahan_harga ORDER BY waktu_perubahan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log Perubahan Harga (Trigger)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 font-sans min-h-screen p-8">

    <div class="max-w-5xl mx-auto">
        <a href="index.php?page=barang" class="inline-flex items-center gap-2 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 px-3 py-2 rounded-lg mb-6 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Barang
        </a>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-6 flex justify-between items-center">
            <div>
                <span class="text-xs font-bold text-rose-600 uppercase tracking-widest">Database Security & Audit Log</span>
                <h2 class="text-2xl font-bold text-slate-800 mt-1">Riwayat Perubahan Harga (Trigger MySQL)</h2>
                <p class="text-xs text-slate-500 mt-1">Data di bawah ini dicatat secara otomatis oleh Trigger tanpa melalui kodingan pemanggilan manual di PHP[cite: 11, 12].</p>
            </div>
            <div class="bg-rose-50 border border-rose-200 px-4 py-3 rounded-xl text-center">
                <i class="fa-solid fa-user-ninja text-rose-600 text-xl mb-1"></i>
                <p class="text-xs text-rose-600 font-bold">Auto Trigger Active</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-gray-200 text-xs uppercase text-slate-500 font-semibold">
                            <th class="py-3.5 px-5">Waktu Update</th>
                            <th class="py-3.5 px-5">Nama Barang</th>
                            <th class="py-3.5 px-5">Harga Lama</th>
                            <th class="py-3.5 px-5">Harga Baru</th>
                            <th class="py-3.5 px-5">User Database</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-slate-700">
                        <?php if ($query_log && mysqli_num_rows($query_log) > 0) : ?>
                            <?php while ($log = mysqli_fetch_assoc($query_log)) : ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3.5 px-5 font-mono text-xs text-slate-500"><?= $log['waktu_perubahan']; ?></td>
                                <td class="py-3.5 px-5 font-bold text-slate-800"><?= $log['nama_barang']; ?></td>
                                <td class="py-3.5 px-5 text-rose-600 font-semibold">Rp <?= number_format($log['harga_lama'], 0, ',', '.'); ?></td>
                                <td class="py-3.5 px-5 text-emerald-600 font-semibold">Rp <?= number_format($log['harga_baru'], 0, ',', '.'); ?></td>
                                <td class="py-3.5 px-5 font-mono text-xs text-slate-500"><?= $log['diubah_oleh']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400 text-xs">
                                    Belum ada riwayat perubahan harga barang.
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