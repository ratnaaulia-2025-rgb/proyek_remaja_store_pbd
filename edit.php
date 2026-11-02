<?php
include 'koneksi.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'barang';
$id   = isset($_GET['id']) ? $_GET['id'] : '';


if (isset($_POST['submit'])) {
    $page_form = $_POST['page_form'];
    $id_form   = $_POST['id_form'];

    if ($page_form == 'satuan') {
        $nama_satuan   = $_POST['nama_satuan'];
        $status_satuan = $_POST['status_satuan'];
        
        $query = "UPDATE satuan SET nama_satuan='$nama_satuan', status_satuan='$status_satuan' WHERE idsatuan='$id_form'";
    } elseif ($page_form == 'barang') {
        $nama_barang = $_POST['nama_barang'];
        $jenis       = $_POST['jenis'];
        $idsatuan    = $_POST['idsatuan'];
        $harga       = $_POST['harga'];

        
        $query = "UPDATE barang SET nama='$nama_barang', jenis='$jenis', idsatuan='$idsatuan', harga='$harga' WHERE idbarang='$id_form'";
    }

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: index.php?page=" . $page_form);
        exit;
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}


$data_satuan = null;
$data_barang = null;

if ($page == 'satuan' && !empty($id)) {
    $q = mysqli_query($koneksi, "SELECT * FROM satuan WHERE idsatuan='$id'");
    $data_satuan = mysqli_fetch_assoc($q);
} elseif ($page == 'barang' && !empty($id)) {
    $q = mysqli_query($koneksi, "SELECT * FROM barang WHERE idbarang='$id'");
    $data_barang = mysqli_fetch_assoc($q);
}


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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 w-full max-w-md">
        <div class="mb-5 border-b pb-3 border-gray-100">
            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-teal-600"></i> Edit Data <?= ucfirst($page); ?>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Perbarui informasi data master Toko Remaja</p>
        </div>

        <form method="POST" action="edit.php" class="space-y-4">
            <input type="hidden" name="page_form" value="<?= $page; ?>">
            <input type="hidden" name="id_form" value="<?= $id; ?>">

            <?php if ($page == 'satuan' && $data_satuan) : ?>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Satuan</label>
                    <input type="text" name="nama_satuan" value="<?= $data_satuan['nama_satuan']; ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status Satuan</label>
                    <select name="status_satuan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                        <option value="1" <?= $data_satuan['status_satuan'] == 1 ? 'selected' : ''; ?>>Aktif</option>
                        <option value="0" <?= $data_satuan['status_satuan'] == 0 ? 'selected' : ''; ?>>Non-Aktif</option>
                    </select>
                </div>

            <?php elseif ($page == 'barang' && $data_barang) : ?>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Barang</label>
                    <input type="text" name="nama_barang" value="<?= isset($data_barang['nama']) ? $data_barang['nama'] : (isset($data_barang['nama_barang']) ? $data_barang['nama_barang'] : ''); ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis / Kategori</label>
                    <input type="text" name="jenis" value="<?= isset($data_barang['jenis']) ? $data_barang['jenis'] : 'M'; ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Satuan Takaran</label>
                    <select name="idsatuan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                        <?php while ($s = mysqli_fetch_assoc($list_satuan)) : ?>
                            <option value="<?= $s['idsatuan']; ?>" <?= $s['idsatuan'] == $data_barang['idsatuan'] ? 'selected' : ''; ?>><?= $s['nama_satuan']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Perusahaan / Vendor Penyuplai</label>
                    <select name="idvendor" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                        <?php while ($v = mysqli_fetch_assoc($list_vendor)) : ?>
                            <option value="<?= $v['idvendor']; ?>" <?= isset($data_barang['idvendor']) && $v['idvendor'] == $data_barang['idvendor'] ? 'selected' : ''; ?>><?= $v['nama_vendor']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" value="<?= $data_barang['harga']; ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                    <p class="text-[10px] text-rose-500 mt-1">*Jika harga diubah, Trigger MySQL akan otomatis mencatat riwayat ke tabel log[cite: 11, 12].</p>
                </div>
            <?php else : ?>
                <p class="text-xs text-rose-500">Data tidak ditemukan.</p>
            <?php endif; ?>

            <div class="flex justify-end gap-2 pt-3">
                <a href="index.php?page=<?= $page; ?>" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-200 transition">Batal</a>
                <button type="submit" name="submit" class="px-4 py-2 bg-teal-600 text-white text-xs font-semibold rounded-lg hover:bg-teal-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>

</body>
</html>