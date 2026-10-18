<?php
include 'koneksi.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'satuan';

switch ($page) {
    case 'role':
        $title = "Data Role (view_role)";
        $query = "SELECT * FROM view_role";
        break;
    case 'user':
        $title = "Data User (view_user)";
        $query = "SELECT * FROM view_user";
        break;
    case 'vendor':
        $title = "Data Vendor (view_vendor)";
        $query = "SELECT * FROM view_vendor";
        break;
    case 'barang':
        $title = "Data Barang (view_barang)";
        $query = "SELECT * FROM view_barang";
        break;
    case 'margin':
        $title = "Data Margin Penjualan (view_margin)";
        $query = "SELECT * FROM view_margin";
        break;
    default:
        $title = "Data Satuan Barang (view_satuan)";
        $query = "SELECT * FROM view_satuan";
        break;
}

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans flex min-h-screen">

    <!-- Sidebar Navigasi Kiri -->
    <aside class="w-64 bg-slate-800 text-white min-h-screen flex flex-col justify-between p-4">
        <div>
            <!-- Logo / Judul Sistem -->
            <div class="px-3 py-4 border-b border-slate-700 mb-4">
                <h1 class="text-lg font-bold text-teal-400 flex items-center gap-2">
                    <i class="fa-solid fa-store"></i> Toko Remaja
                </h1>
                <p class="text-xs text-slate-400 mt-1">Sistem Informasi Master Data</p>
            </div>

            <!-- Menu Navigasi View -->
            <nav class="space-y-1">
                <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Master View</p>
                
                <a href="index.php?page=satuan" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= ($page == 'satuan') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-700' ?>">
                    <i class="fa-solid fa-ruler-combined w-5"></i> Satuan Barang
                </a>

                <a href="index.php?page=barang" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= ($page == 'barang') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-700' ?>">
                    <i class="fa-solid fa-boxes-stacked w-5"></i> Data Barang
                </a>

                <a href="index.php?page=vendor" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= ($page == 'vendor') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-700' ?>">
                    <i class="fa-solid fa-truck-field w-5"></i> Data Vendor
                </a>

                <a href="index.php?page=role" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= ($page == 'role') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-700' ?>">
                    <i class="fa-solid fa-user-shield w-5"></i> Role Akses
                </a>

                <a href="index.php?page=user" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= ($page == 'user') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-700' ?>">
                    <i class="fa-solid fa-users w-5"></i> Data User
                </a>

                <a href="index.php?page=margin" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= ($page == 'margin') ? 'bg-teal-600 text-white' : 'text-slate-300 hover:bg-slate-700' ?>">
                    <i class="fa-solid fa-percent w-5"></i> Margin Penjualan
                </a>
            </nav>
        </div>

        <div class="px-3 py-3 border-t border-slate-700 text-xs text-slate-400">
            &copy; 2026 Toko Remaja PBD
        </div>
    </aside>

    <!-- Konten Utama Kanan -->
    <main class="flex-1 p-8">
        
        <!-- Header Atas -->
        <div class="flex justify-between items-center mb-6 bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <div>
                <h2 class="text-xl font-bold text-slate-800"><?= $title; ?></h2>
                <p class="text-xs text-slate-500 mt-0.5">Menampilkan data langsung dari database View MySQL</p>
            </div>
            <?php if ($page == 'satuan') : ?>
                <a href="tambah.php" class="bg-teal-600 hover:bg-teal-700 text-white text-xs px-4 py-2.5 rounded-lg font-semibold shadow-sm transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Satuan
                </a>
            <?php endif; ?>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-gray-200 text-xs uppercase text-slate-500 font-semibold">
                            <?php if ($page == 'satuan') : ?>
                                <th class="py-3.5 px-5">ID Satuan</th>
                                <th class="py-3.5 px-5">Nama Satuan</th>
                                <th class="py-3.5 px-5">Status</th>
                                <th class="py-3.5 px-5">Aksi</th>
                            <?php elseif ($page == 'role') : ?>
                                <th class="py-3.5 px-5">ID Role</th>
                                <th class="py-3.5 px-5">Nama Role</th>
                            <?php elseif ($page == 'user') : ?>
                                <th class="py-3.5 px-5">ID User</th>
                                <th class="py-3.5 px-5">Username</th>
                                <th class="py-3.5 px-5">Nama Role</th>
                            <?php elseif ($page == 'vendor') : ?>
                                <th class="py-3.5 px-5">ID Vendor</th>
                                <th class="py-3.5 px-5">Nama Vendor</th>
                                <th class="py-3.5 px-5">Status Hukum</th>
                                <th class="py-3.5 px-5">Status</th>
                            <?php elseif ($page == 'barang') : ?>
                                <th class="py-3.5 px-5">ID Barang</th>
                                <th class="py-3.5 px-5">Jenis</th>
                                <th class="py-3.5 px-5">Nama Barang</th>
                                <th class="py-3.5 px-5">Satuan</th>
                                <th class="py-3.5 px-5">Harga</th>
                                <th class="py-3.5 px-5">Status</th>
                            <?php elseif ($page == 'margin') : ?>
                                <th class="py-3.5 px-5">ID Margin</th>
                                <th class="py-3.5 px-5">Persen (%)</th>
                                <th class="py-3.5 px-5">Status</th>
                                <th class="py-3.5 px-5">Dibuat Oleh</th>
                                <th class="py-3.5 px-5">Waktu Dibuat</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-slate-700">
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr class="hover:bg-slate-50 transition">
                            <?php if ($page == 'satuan') : ?>
                                <td class="py-3.5 px-5 font-mono text-xs"><?= $row['idsatuan']; ?></td>
                                <td class="py-3.5 px-5 font-medium"><?= $row['nama_satuan']; ?></td>
                                <td class="py-3.5 px-5">
                                    <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-md font-semibold"><?= $row['status_text']; ?></span>
                                </td>
                                <td class="py-3.5 px-5 space-x-2">
                                    <a href="edit.php?id=<?= $row['idsatuan']; ?>" class="text-teal-600 hover:underline font-semibold text-xs">Edit</a>
                                    <a href="hapus.php?id=<?= $row['idsatuan']; ?>" onclick="return confirm('Hapus?');" class="text-rose-600 hover:underline font-semibold text-xs">Hapus</a>
                                </td>
                            <?php elseif ($page == 'role') : ?>
                                <td class="py-3.5 px-5 font-mono text-xs"><?= $row['ID_ROLE']; ?></td>
                                <td class="py-3.5 px-5 font-medium"><?= $row['NAMA_ROLE']; ?></td>
                            <?php elseif ($page == 'user') : ?>
                                <td class="py-3.5 px-5 font-mono text-xs"><?= $row['iduser']; ?></td>
                                <td class="py-3.5 px-5 font-medium"><?= $row['username']; ?></td>
                                <td class="py-3.5 px-5"><?= $row['nama_role']; ?></td>
                            <?php elseif ($page == 'vendor') : ?>
                                <td class="py-3.5 px-5 font-mono text-xs"><?= $row['idvendor']; ?></td>
                                <td class="py-3.5 px-5 font-medium"><?= $row['nama_vendor']; ?></td>
                                <td class="py-3.5 px-5"><?= $row['status_hukum']; ?></td>
                                <td class="py-3.5 px-5">
                                    <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-md font-semibold"><?= $row['status_text']; ?></span>
                                </td>
                            <?php elseif ($page == 'barang') : ?>
                                <td class="py-3.5 px-5 font-mono text-xs"><?= $row['idbarang']; ?></td>
                                <td class="py-3.5 px-5"><?= $row['jenis']; ?></td>
                                <td class="py-3.5 px-5 font-medium"><?= $row['nama_barang']; ?></td>
                                <td class="py-3.5 px-5"><?= $row['nama_satuan']; ?></td>
                                <td class="py-3.5 px-5">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td class="py-3.5 px-5">
                                    <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-md font-semibold"><?= $row['status_text']; ?></span>
                                </td>
                            <?php elseif ($page == 'margin') : ?>
                                <td class="py-3.5 px-5 font-mono text-xs"><?= $row['idmargin_penjualan']; ?></td>
                                <td class="py-3.5 px-5 font-medium"><?= $row['persen']; ?>%</td>
                                <td class="py-3.5 px-5">
                                    <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-md font-semibold"><?= $row['status_text']; ?></span>
                                </td>
                                <td class="py-3.5 px-5"><?= $row['dibuat_oleh']; ?></td>
                                <td class="py-3.5 px-5 text-xs text-slate-500"><?= $row['created_at']; ?></td>
                            <?php endif; ?>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>