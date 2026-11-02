<?php
include 'koneksi.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'barang';

// HAPUS DATA
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    if ($page == 'satuan') {
        $query_delete = "DELETE FROM satuan WHERE idsatuan='$id'";
    } elseif ($page == 'barang') {
        $query_delete = "DELETE FROM barang WHERE idbarang='$id'";
    }
    
    if (isset($query_delete)) {
        mysqli_query($koneksi, $query_delete);
        header("Location: index.php?page=" . $page);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Remaja - Master Data & Stok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 font-sans min-h-screen flex">

    <!-- SIDEBAR LEFT -->
    <aside class="w-64 bg-slate-900 text-slate-300 min-h-screen p-6 flex flex-col justify-between shrink-0">
        <div>
            <!-- LOGO BRAND -->
            <div class="flex items-center gap-3 mb-8">
                <div class="bg-teal-500 text-slate-900 p-2.5 rounded-xl font-bold text-lg">
                    <i class="fa-solid fa-store"></i>
                </div>
                <div>
                    <h1 class="font-bold text-white text-lg leading-none">Toko Remaja</h1>
                    <span class="text-[11px] text-slate-400">Sistem Informasi Master Data</span>
                </div>
            </div>

            <!-- MENU NAVIGASI MASTER VIEW -->
            <div class="space-y-1">
                <p class="text-[10px] uppercase font-bold text-slate-500 tracking-wider mb-2 px-3">Master View</p>

                <a href="index.php?page=satuan" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition <?= $page == 'satuan' ? 'bg-teal-600 text-white' : 'hover:bg-slate-800 text-slate-400 hover:text-white'; ?>">
                    <i class="fa-solid fa-scale-balanced w-4"></i> Satuan Barang
                </a>

                <a href="index.php?page=barang" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition <?= $page == 'barang' ? 'bg-teal-600 text-white' : 'hover:bg-slate-800 text-slate-400 hover:text-white'; ?>">
                    <i class="fa-solid fa-boxes-stacked w-4"></i> Data Barang
                </a>

                <a href="index.php?page=vendor" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition <?= $page == 'vendor' ? 'bg-teal-600 text-white' : 'hover:bg-slate-800 text-slate-400 hover:text-white'; ?>">
                    <i class="fa-solid fa-truck-field w-4"></i> Data Vendor
                </a>

                <a href="index.php?page=role" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition <?= $page == 'role' ? 'bg-teal-600 text-white' : 'hover:bg-slate-800 text-slate-400 hover:text-white'; ?>">
                    <i class="fa-solid fa-user-shield w-4"></i> Role Akses
                </a>

                <a href="index.php?page=user" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition <?= $page == 'user' ? 'bg-teal-600 text-white' : 'hover:bg-slate-800 text-slate-400 hover:text-white'; ?>">
                    <i class="fa-solid fa-users w-4"></i> Data User
                </a>

                <a href="index.php?page=margin" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition <?= $page == 'margin' ? 'bg-teal-600 text-white' : 'hover:bg-slate-800 text-slate-400 hover:text-white'; ?>">
                    <i class="fa-solid fa-percent w-4"></i> Margin Penjualan
                </a>

                <!-- MENU DATABASE AUDIT & TRANSAKSI (TRIGGER) -->
                <p class="text-[10px] uppercase font-bold text-slate-500 tracking-wider mt-6 mb-2 px-3">Database Audit & Stok</p>

                <!-- MENU HALAMAN KARTU STOK TRIGGER -->
                <a href="kartu_stok.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-teal-400 hover:bg-slate-800 hover:text-teal-300 transition">
                    <i class="fa-solid fa-boxes-stacked w-4"></i> Kartu Stok (Trigger)
                </a>

                <!-- MENU INPUT TRANSAKSI PENERIMAAN -->
                <a href="penerimaan.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-emerald-400 hover:bg-slate-800 hover:text-emerald-300 transition">
                    <i class="fa-solid fa-truck-ramp-box w-4"></i> Transaksi Penerimaan
                </a>

                <!-- MENU HALAMAN LOG HARGA TRIGGER -->
                <a href="log_harga.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-rose-400 hover:bg-slate-800 hover:text-rose-300 transition">
                    <i class="fa-solid fa-clock-rotate-left w-4"></i> Log Harga (Trigger)
                </a>
            </div>
        </div>

        <div class="text-[11px] text-slate-500 border-t border-slate-800 pt-4">
            &copy; 2026 Toko Remaja PBD
        </div>
    </aside>

    <!-- CONTENT AREA -->
    <main class="flex-1 p-8">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                
                <!-- HEADER CONTENT DAN TOMBOL AKSIS -->
                <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">
                            <?php 
                                if($page == 'satuan') echo "Data Satuan Barang (view_satuan)";
                                elseif($page == 'barang') echo "Data Barang (view_barang)";
                                elseif($page == 'vendor') echo "Data Vendor (view_vendor)";
                                elseif($page == 'role') echo "Data Role Akses (view_role)";
                                elseif($page == 'user') echo "Data User (view_user)";
                                elseif($page == 'margin') echo "Data Margin Penjualan (view_margin)";
                            ?>
                        </h2>
                        <p class="text-xs text-slate-500 mt-1">Menampilkan data langsung dari database View MySQL</p>
                    </div>

                    <div class="flex gap-2">
                        <?php if ($page == 'barang') : ?>
                            <!-- TOMBOL LINK KE KARTU STOK & LOG TRIGGER -->
                            <a href="kartu_stok.php" class="bg-teal-50 hover:bg-teal-100 text-teal-700 font-semibold text-xs py-2 px-3 rounded-xl border border-teal-200 flex items-center gap-1.5 transition">
                                <i class="fa-solid fa-boxes-stacked"></i> Kartu Stok
                            </a>
                            <a href="log_harga.php" class="bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold text-xs py-2 px-3 rounded-xl border border-rose-200 flex items-center gap-1.5 transition">
                                <i class="fa-solid fa-clock-rotate-left"></i> Log Harga
                            </a>
                        <?php endif; ?>

                        <?php if ($page == 'satuan' || $page == 'barang') : ?>
                            <a href="tambah.php?page=<?= $page; ?>" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-xs py-2 px-4 rounded-xl flex items-center gap-1.5 shadow-sm transition">
                                <i class="fa-solid fa-plus"></i> Tambah <?= ucfirst($page); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- TABEL DATA MASTER -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        
                        <!-- TABEL DATA SATUAN -->
                        <?php if ($page == 'satuan') : ?>
                            <thead>
                                <tr class="bg-slate-50 border-b border-gray-200 text-xs uppercase text-slate-500 font-semibold">
                                    <th class="py-3 px-4">ID Satuan</th>
                                    <th class="py-3 px-4">Nama Satuan</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-slate-700">
                                <?php
                                $q = mysqli_query($koneksi, "SELECT * FROM view_satuan");
                                while ($r = mysqli_fetch_assoc($q)) :
                                ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-4 text-slate-500 font-mono text-xs"><?= $r['idsatuan']; ?></td>
                                    <td class="py-3 px-4 font-bold text-teal-700">
                                        <a href="detail_satuan.php?id=<?= $r['idsatuan']; ?>" class="hover:underline flex items-center gap-1.5">
                                            <i class="fa-solid fa-box-open text-xs"></i> <?= $r['nama_satuan']; ?>
                                        </a>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="bg-emerald-100 text-emerald-800 text-[11px] px-2.5 py-0.5 rounded-full font-medium">Aktif</span>
                                    </td>
                                    <td class="py-3 px-4 flex gap-3 text-xs">
                                        <a href="edit.php?page=satuan&id=<?= $r['idsatuan']; ?>" class="text-teal-600 hover:underline font-medium">Edit</a>
                                        <a href="index.php?page=satuan&action=delete&id=<?= $r['idsatuan']; ?>" onclick="return confirm('Hapus satuan ini?')" class="text-rose-600 hover:underline font-medium">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>

                        <!-- TABEL DATA BARANG -->
                        <?php elseif ($page == 'barang') : ?>
                            <thead>
                                <tr class="bg-slate-50 border-b border-gray-200 text-xs uppercase text-slate-500 font-semibold">
                                    <th class="py-3 px-4">ID Barang</th>
                                    <th class="py-3 px-4">Jenis</th>
                                    <th class="py-3 px-4">Nama Barang</th>
                                    <th class="py-3 px-4">Satuan</th>
                                    <th class="py-3 px-4">Stok</th>
                                    <th class="py-3 px-4">Harga</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-slate-700">
                                <?php
                                $q = mysqli_query($koneksi, "SELECT * FROM view_barang");
                                while ($r = mysqli_fetch_assoc($q)) :
                                ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-4 text-slate-500 font-mono text-xs"><?= $r['idbarang']; ?></td>
                                    <td class="py-3 px-4"><?= isset($r['jenis']) ? $r['jenis'] : 'M'; ?></td>
                                    <td class="py-3 px-4 font-bold text-slate-800"><?= isset($r['nama']) ? $r['nama'] : (isset($r['nama_barang']) ? $r['nama_barang'] : '-'); ?></td>
                                    <td class="py-3 px-4"><?= isset($r['nama_satuan']) ? $r['nama_satuan'] : '-'; ?></td>
                                    <td class="py-3 px-4 font-bold text-teal-600"><?= isset($r['stok']) ? $r['stok'] : 0; ?></td>
                                    <td class="py-3 px-4 font-semibold text-slate-700">Rp <?= number_format($r['harga'], 0, ',', '.'); ?></td>
                                    <td class="py-3 px-4">
                                        <span class="bg-emerald-100 text-emerald-800 text-[11px] px-2.5 py-0.5 rounded-full font-medium">Aktif</span>
                                    </td>
                                    <td class="py-3 px-4 flex gap-3 text-xs">
                                        <a href="edit.php?page=barang&id=<?= $r['idbarang']; ?>" class="text-teal-600 hover:underline font-medium">Edit</a>
                                        <a href="index.php?page=barang&action=delete&id=<?= $r['idbarang']; ?>" onclick="return confirm('Hapus barang ini?')" class="text-rose-600 hover:underline font-medium">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>

                        <!-- TABEL DATA VENDOR -->
                        <?php elseif ($page == 'vendor') : ?>
                            <thead>
                                <tr class="bg-slate-50 border-b border-gray-200 text-xs uppercase text-slate-500 font-semibold">
                                    <th class="py-3 px-4">ID Vendor</th>
                                    <th class="py-3 px-4">Nama Vendor</th>
                                    <th class="py-3 px-4">Status Hukum</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-slate-700">
                                <?php
                                $q = mysqli_query($koneksi, "SELECT * FROM view_vendor");
                                while ($r = mysqli_fetch_assoc($q)) :
                                ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-4 text-slate-500 font-mono text-xs"><?= $r['idvendor']; ?></td>
                                    <td class="py-3 px-4 font-bold text-slate-800"><?= $r['nama_vendor']; ?></td>
                                    <td class="py-3 px-4"><span class="bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded-md font-mono"><?= isset($r['status_hukum']) ? $r['status_hukum'] : 'PT'; ?></span></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>

                        <!-- TABEL DATA USER -->
                        <?php elseif ($page == 'user') : ?>
                            <thead>
                                <tr class="bg-slate-50 border-b border-gray-200 text-xs uppercase text-slate-500 font-semibold">
                                    <th class="py-3 px-4">ID User</th>
                                    <th class="py-3 px-4">Username</th>
                                    <th class="py-3 px-4">Nama Role</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-slate-700">
                                <?php
                                $q = mysqli_query($koneksi, "SELECT * FROM view_user");
                                while ($r = mysqli_fetch_assoc($q)) :
                                ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-4 text-slate-500 font-mono text-xs"><?= $r['iduser']; ?></td>
                                    <td class="py-3 px-4 font-bold text-slate-800"><?= $r['username']; ?></td>
                                    <td class="py-3 px-4"><?= isset($r['nama_role']) ? $r['nama_role'] : '-'; ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>

                        <!-- TABEL LAINNYA (ROLE / MARGIN) -->
                        <?php else : ?>
                            <tbody>
                                <tr>
                                    <td class="py-6 text-center text-slate-400 text-xs">
                                        Data modul ini siap ditampilkan.
                                    </td>
                                </tr>
                            </tbody>
                        <?php endif; ?>

                    </table>
                </div>

            </div>
        </div>
    </main>

</body>
</html>