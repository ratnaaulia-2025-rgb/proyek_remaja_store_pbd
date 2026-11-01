<?php
include 'koneksi.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'satuan';
$id   = isset($_GET['id']) ? $_GET['id'] : '';

$query = "";

if (isset($_POST['update'])) {
    $page = $_POST['page'];
    $id   = $_POST['id'];

    if ($page == 'satuan') {
        $nama_satuan   = $_POST['nama_satuan'];
        $status_satuan = $_POST['status_satuan'];
        $query = "UPDATE satuan SET nama_satuan='$nama_satuan', status_satuan='$status_satuan' WHERE idsatuan='$id'";
    } elseif ($page == 'role') {
        $nama_role = $_POST['nama_role'];
        $query = "UPDATE role SET nama_role='$nama_role' WHERE idrole='$id'";
    } elseif ($page == 'user') {
        $username = $_POST['username'];
        $query = "UPDATE user SET username='$username' WHERE iduser='$id'";
    } elseif ($page == 'vendor') {
        $nama_vendor = $_POST['nama_vendor'];
        $query = "UPDATE vendor SET nama_vendor='$nama_vendor' WHERE idvendor='$id'";
    } elseif ($page == 'barang') {
        $nama_barang = $_POST['nama_barang'];
        $harga       = $_POST['harga'];
        $idsatuan    = $_POST['idsatuan'];
        $jenis       = $_POST['jenis'];
        $query = "UPDATE barang SET nama_barang='$nama_barang', harga='$harga', idsatuan='$idsatuan', jenis='$jenis' WHERE idbarang='$id'";
    } elseif ($page == 'margin') {
        $persen = $_POST['persen'];
        $query  = "UPDATE margin_penjualan SET persen='$persen' WHERE idmargin_penjualan='$id'";
    }

    if (!empty($query) && mysqli_query($koneksi, $query)) {
        header("Location: index.php?page=" . $page);
        exit;
    }
}

$data = [];
if (!empty($id)) {
    if ($page == 'satuan') {
        $res = mysqli_query($koneksi, "SELECT * FROM satuan WHERE idsatuan='$id'");
        $data = $res ? mysqli_fetch_assoc($res) : [];
    } elseif ($page == 'role') {
        $res = mysqli_query($koneksi, "SELECT * FROM role WHERE idrole='$id'");
        $data = $res ? mysqli_fetch_assoc($res) : [];
    } elseif ($page == 'user') {
        $res = mysqli_query($koneksi, "SELECT * FROM user WHERE iduser='$id'");
        $data = $res ? mysqli_fetch_assoc($res) : [];
    } elseif ($page == 'vendor') {
        $res = mysqli_query($koneksi, "SELECT * FROM vendor WHERE idvendor='$id'");
        $data = $res ? mysqli_fetch_assoc($res) : [];
    } elseif ($page == 'barang') {
        $res = mysqli_query($koneksi, "SELECT * FROM barang WHERE idbarang='$id'");
        $data = $res ? mysqli_fetch_assoc($res) : [];
    } elseif ($page == 'margin') {
        $res = mysqli_query($koneksi, "SELECT * FROM margin_penjualan WHERE idmargin_penjualan='$id'");
        $data = $res ? mysqli_fetch_assoc($res) : [];
    }
}

// Ambil list satuan & vendor untuk pilihan dropdown
$list_satuan = mysqli_query($koneksi, "SELECT * FROM satuan");
$list_vendor = mysqli_query($koneksi, "SELECT * FROM vendor");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data <?= ucfirst($page); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-md border border-gray-200">
        <h2 class="text-xl font-bold text-slate-800 mb-4">Edit Data <?= ucfirst($page); ?></h2>
        
        <form method="POST" action="edit.php" class="space-y-4">
            <input type="hidden" name="page" value="<?= $page; ?>">
            <input type="hidden" name="id" value="<?= $id; ?>">

            <?php if ($page == 'satuan') : ?>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Satuan</label>
                    <input type="text" name="nama_satuan" value="<?= isset($data['nama_satuan']) ? $data['nama_satuan'] : ''; ?>" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Status Satuan</label>
                    <select name="status_satuan" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                        <option value="1" <?= (isset($data['status_satuan']) && $data['status_satuan'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                        <option value="0" <?= (isset($data['status_satuan']) && $data['status_satuan'] == 0) ? 'selected' : ''; ?>>Non-Aktif</option>
                    </select>
                </div>
            <?php elseif ($page == 'barang') : ?>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Barang</label>
                    <input type="text" name="nama_barang" value="<?= isset($data['nama_barang']) ? $data['nama_barang'] : ''; ?>" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jenis / Kategori</label>
                    <input type="text" name="jenis" value="<?= isset($data['jenis']) ? $data['jenis'] : 'M'; ?>" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Pilih Satuan</label>
                    <select name="idsatuan" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                        <?php while ($s = mysqli_fetch_assoc($list_satuan)) : ?>
                            <option value="<?= $s['idsatuan']; ?>" <?= (isset($data['idsatuan']) && $data['idsatuan'] == $s['idsatuan']) ? 'selected' : ''; ?>>
                                <?= $s['nama_satuan']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Perusahaan / Vendor Penyuplai</label>
                    <select name="idvendor" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                        <?php while ($v = mysqli_fetch_assoc($list_vendor)) : ?>
                            <option value="<?= $v['idvendor']; ?>">
                                <?= $v['nama_vendor']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" value="<?= isset($data['harga']) ? $data['harga'] : ''; ?>" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>
            <?php elseif ($page == 'role') : ?>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Role</label>
                    <input type="text" name="nama_role" value="<?= isset($data['nama_role']) ? $data['nama_role'] : ''; ?>" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>
            <?php elseif ($page == 'user') : ?>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Username</label>
                    <input type="text" name="username" value="<?= isset($data['username']) ? $data['username'] : ''; ?>" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>
            <?php elseif ($page == 'vendor') : ?>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Vendor</label>
                    <input type="text" name="nama_vendor" value="<?= isset($data['nama_vendor']) ? $data['nama_vendor'] : ''; ?>" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>
            <?php elseif ($page == 'margin') : ?>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Persen Margin (%)</label>
                    <input type="number" step="0.01" name="persen" value="<?= isset($data['persen']) ? $data['persen'] : ''; ?>" required class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>
            <?php endif; ?>

            <div class="flex justify-end gap-2 pt-3">
                <a href="index.php?page=<?= $page; ?>" class="px-4 py-2 bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-300">Batal</a>
                <button type="submit" name="update" class="px-4 py-2 bg-teal-600 text-white text-xs font-semibold rounded-lg hover:bg-teal-700">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>