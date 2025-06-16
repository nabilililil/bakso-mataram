<?php
include("inc_header.php");
include("inc_koneksi.php");

$id = $_GET['id'] ?? '';
$err = "";
$sukses = "";

// Ambil data lama
if ($id != '') {
    $sql1 = "SELECT * FROM bahan_baku WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);

    if ($r1) {
        $nama_bahan = $r1['nama_bahan'];
        $satuan = $r1['satuan'];
        $stok_lama = $r1['stok'];
        $batas_minimal = $r1['batas_minimal'];
    } else {
        $err = "Data tidak ditemukan!";
    }
}

// Proses update
if (isset($_POST['simpan'])) {
    $nama_bahan = $_POST['nama_bahan'];
    $satuan = $_POST['satuan'];
    $stok_baru = $_POST['stok'];
    $batas_minimal = $_POST['batas_minimal'];

    if ($nama_bahan == '' || $satuan == '' || $stok_baru == '' || $batas_minimal == '') {
        $err = "Silakan isi semua data!";
    } else {
        $sql2 = "UPDATE bahan_baku SET 
                    nama_bahan = '$nama_bahan',
                    satuan = '$satuan',
                    stok = '$stok_baru',
                    batas_minimal = '$batas_minimal'
                 WHERE id = '$id'";
        $q2 = mysqli_query($koneksi, $sql2);
        if ($q2) {
            // ✅ Tambah riwayat perubahan stok
            $tanggal = date("Y-m-d H:i:s");
            $selisih = $stok_baru - $stok_lama;

            if ($selisih != 0) {
                $jenis = ($selisih > 0) ? 'masuk' : 'keluar';
                $jumlah = abs($selisih);
                $nama_aman = mysqli_real_escape_string($koneksi, $nama_bahan);

                $sql_riwayat = "INSERT INTO riwayat_stok (tanggal, nama_bahan, jumlah, jenis, keterangan)
                                VALUES ('$tanggal', '$nama_aman', '$jumlah', '$jenis', 'Perubahan dari admin')";
                mysqli_query($koneksi, $sql_riwayat);
            }

            $sukses = "✅ Data berhasil diupdate dan dicatat ke riwayat.";
        } else {
            $err = "❌ Gagal update data!";
        }
    }
}
?>

<h1>✏️ Edit Bahan Baku</h1>

<?php if ($err) echo "<div style='color:red'>$err</div>"; ?>
<?php if ($sukses) echo "<div style='color:green'>$sukses</div>"; ?>

<form method="post">
    <label>Nama Bahan:</label><br>
    <input type="text" name="nama_bahan" class="input" value="<?= htmlspecialchars($nama_bahan ?? '') ?>"><br><br>

    <label>Satuan:</label><br>
    <input type="text" name="satuan" class="input" value="<?= htmlspecialchars($satuan ?? '') ?>"><br><br>

    <label>Stok:</label><br>
    <input type="number" name="stok" class="input" value="<?= $stok_lama ?? 0 ?>"><br><br>

    <label>Batas Minimal:</label><br>
    <input type="number" name="batas_minimal" class="input" value="<?= $batas_minimal ?? 0 ?>"><br><br>

    <input type="submit" name="simpan" value="Update">
</form>

<?php include("inc_footer.php"); ?>
