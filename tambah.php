<?php
include 'koneksi.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'satuan';

if (isset($_POST['submit'])) {
    $page_form = $_POST['page_form'];

    if ($page_form == 'satuan') {
        $nama_satuan   = $_POST['nama_satuan'];
        $status_satuan = $_POST['status_satuan'];
        $query = "INSERT INTO satuan (nama_satuan, status_satuan) VALUES ('$nama_satuan', '$status_satuan')";
    } elseif ($page_form == 'barang') {
        $nama_barang = $_POST['nama_barang'];
        $jenis       = $_POST['jenis'];
        $idsatuan    = $_POST['idsatuan'];
        $harga       = $_POST['harga'];

        // Buat Eksekusi Stored Procedure dari Hedisql
        $query = "CALL sp_tambah_barang('$nama_barang', '$jenis', '$idsatuan', '$harga')";
    }

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: index.php?page=" . $page_form);
        exit;
    } else {
        echo "Gagal menambah data: " . mysqli_error($koneksi);
    }
}

$list_satuan = mysqli_query($koneksi, "SELECT * FROM satuan");
$list_vendor = mysqli_query($koneksi, "SELECT * FROM vendor");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data <?= ucfirst($page); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 w-full max-w-md">
        <div class="mb-5 border-b pb-3 border-gray-100">
            <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-plus text-teal-600"></i> Tambah Data <?= ucfirst($page); ?>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Diproses melalui Stored Procedure MySQL</p>
        </div>

        <form method="POST" action="tambah.php" class="space-y-4">
            <input type="hidden" name="page_form" value="<?= $page; ?>">

            <?php if ($page == 'satuan') : ?>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Satuan</label>
                    <input type="text" name="nama_satuan" placeholder="Contoh: Pcs, Dus, Pack, Liter" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Status Satuan</label>
                    <select name="status_satuan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                        <option value="1">Aktif</option>
                        <option value="0">Non-Aktif</option>
                    </select>
                </div>

            <?php elseif ($page == 'barang') : ?>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Barang</label>
                    <input type="text" name="nama_barang" placeholder="Contoh: Beras Ramos 5kg" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis / Kategori</label>
                    <input type="text" name="jenis" value="M" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Satuan Takaran</label>
                    <select name="idsatuan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                        <?php while ($s = mysqli_fetch_assoc($list_satuan)) : ?>
                            <option value="<?= $s['idsatuan']; ?>"><?= $s['nama_satuan']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Perusahaan / Vendor Penyuplai</label>
                    <select name="idvendor" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                        <?php while ($v = mysqli_fetch_assoc($list_vendor)) : ?>
                            <option value="<?= $v['idvendor']; ?>"><?= $v['nama_vendor']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" placeholder="Contoh: 75000" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-teal-500">
                </div>
            <?php endif; ?>

            <div class="flex justify-end gap-2 pt-3">
                <a href="index.php?page=<?= $page; ?>" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-200 transition">Batal</a>
                <button type="submit" name="submit" class="px-4 py-2 bg-teal-600 text-white text-xs font-semibold rounded-lg hover:bg-teal-700 transition">Simpan Data</button>
            </div>
        </form>
    </div>

</body>
</html>