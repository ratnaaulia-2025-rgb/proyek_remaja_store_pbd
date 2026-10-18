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
<html>
<head>
    <title><?= $title; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .nav { margin-bottom: 20px; padding: 10px; background-color: #f4f4f4; border-radius: 5px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #0066cc; font-weight: bold; }
        .nav a:hover { text-decoration: underline; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #e2e2e2; }
    </style>
</head>
<body>

    <h2>Aplikasi Toko Remaja - Modul View</h2>

    <!-- Navigasi 6 Tabel View Master -->
    <div class="nav">
        <b>Pilih View Master:</b> 
        <a href="index.php?page=satuan">Satuan</a> | 
        <a href="index.php?page=role">Role</a> | 
        <a href="index.php?page=user">User</a> | 
        <a href="index.php?page=vendor">Vendor</a> | 
        <a href="index.php?page=barang">Barang</a> | 
        <a href="index.php?page=margin">Margin Penjualan</a>
    </div>

    <h3><?= $title; ?></h3>

    <?php if ($page == 'satuan') : ?>
        <a href="tambah.php">+ Tambah Data Satuan (Create)</a><br><br>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <?php if ($page == 'satuan') : ?>
                    <th>ID Satuan</th>
                    <th>Nama Satuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                <?php elseif ($page == 'role') : ?>
                    <th>ID Role</th>
                    <th>Nama Role</th>
                <?php elseif ($page == 'user') : ?>
                    <th>ID User</th>
                    <th>Username</th>
                    <th>Nama Role</th>
                <?php elseif ($page == 'vendor') : ?>
                    <th>ID Vendor</th>
                    <th>Nama Vendor</th>
                    <th>Status Hukum</th>
                    <th>Status</th>
                <?php elseif ($page == 'barang') : ?>
                    <th>ID Barang</th>
                    <th>Jenis</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Status</th>
                <?php elseif ($page == 'margin') : ?>
                    <th>ID Margin</th>
                    <th>Persen (%)</th>
                    <th>Status</th>
                    <th>Dibuat Oleh</th>
                    <th>Waktu Dibuat</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <?php if ($page == 'satuan') : ?>
                    <td><?= $row['idsatuan']; ?></td>
                    <td><?= $row['nama_satuan']; ?></td>
                    <td><?= $row['status_text']; ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['idsatuan']; ?>">Edit</a> | 
                        <a href="hapus.php?id=<?= $row['idsatuan']; ?>" onclick="return confirm('Hapus?');">Hapus</a>
                    </td>
                <?php elseif ($page == 'role') : ?>
                    <td><?= $row['ID_ROLE']; ?></td>
                    <td><?= $row['NAMA_ROLE']; ?></td>
                <?php elseif ($page == 'user') : ?>
                    <td><?= $row['iduser']; ?></td>
                    <td><?= $row['username']; ?></td>
                    <td><?= $row['nama_role']; ?></td>
                <?php elseif ($page == 'vendor') : ?>
                    <td><?= $row['idvendor']; ?></td>
                    <td><?= $row['nama_vendor']; ?></td>
                    <td><?= $row['status_hukum']; ?></td>
                    <td><?= $row['status_text']; ?></td>
                <?php elseif ($page == 'barang') : ?>
                    <td><?= $row['idbarang']; ?></td>
                    <td><?= $row['jenis']; ?></td>
                    <td><?= $row['nama_barang']; ?></td>
                    <td><?= $row['nama_satuan']; ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= $row['status_text']; ?></td>
                <?php elseif ($page == 'margin') : ?>
                    <td><?= $row['idmargin_penjualan']; ?></td>
                    <td><?= $row['persen']; ?>%</td>
                    <td><?= $row['status_text']; ?></td>
                    <td><?= $row['dibuat_oleh']; ?></td>
                    <td><?= $row['created_at']; ?></td>
                <?php endif; ?>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>