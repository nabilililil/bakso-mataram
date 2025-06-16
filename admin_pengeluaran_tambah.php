<?php
include("inc_header.php");
include("inc_koneksi.php");

$err = "";
$sukses = "";

if (isset($_POST['simpan'])) {
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];
    $tanggal = date("Y-m-d H:i:s");

    if ($keterangan == '' || $jumlah == '') {
        $err = "Silakan isi semua kolom!";
    } else {
        $sql = "INSERT INTO pengeluaran (tanggal, keterangan, jumlah) 
                VALUES ('$tanggal', '$keterangan', '$jumlah')";
        $q = mysqli_query($koneksi, $sql);
        if ($q) {
            $sukses = "✅ Pengeluaran berhasil ditambahkan!";
        } else {
            $err = "❌ Gagal menyimpan!";
        }
    }
}
?>

<h1>📝 Tambah Pengeluaran</h1>

<?php if ($err) echo "<div style='color:red'>$err</div>"; ?>
<?php if ($sukses) echo "<div style='color:green'>$sukses</div>"; ?>

<form method="post">
    <label>Keterangan:</label><br>
    <input type="text" name="keterangan" class="input"><br><br>

    <label>Jumlah (Rp):</label><br>
    <input type="number" name="jumlah" class="input"><br><br>

    <input type="submit" name="simpan" value="Simpan">
</form>

<?php include("inc_footer.php"); ?>
