<?php
include("inc_header.php");
include("inc_koneksi.php");

$err = "";
$sukses = "";

if (isset($_POST['simpan'])) {
    $nama_bahan = $_POST['nama_bahan'];
    $satuan = $_POST['satuan'];
    $stok = $_POST['stok'];
    $batas_minimal = $_POST['batas_minimal'];

    if ($nama_bahan == '' || $satuan == '' || $stok == '' || $batas_minimal == '') {
        $err = "Silakan lengkapi semua data!";
    } else {
        $sql = "INSERT INTO bahan_baku (nama_bahan, satuan, stok, batas_minimal) 
                VALUES ('$nama_bahan', '$satuan', '$stok', '$batas_minimal')";
        $q = mysqli_query($koneksi, $sql);
        if ($q) {
            $sukses = "✅ Data berhasil ditambahkan!";
        } else {
            $err = "❌ Gagal menambahkan data!";
        }
    }
}
?>

<h1>➕ Tambah Bahan Baku</h1>

<?php if ($err) echo "<div style='color:red'>$err</div>"; ?>
<?php if ($sukses) echo "<div style='color:green'>$sukses</div>"; ?>

<form method="post">
    <label>Nama Bahan:</label><br>
    <input type="text" name="nama_bahan" class="input"><br><br>

    <label>Satuan (kg/pack/etc):</label><br>
    <input type="text" name="satuan" class="input"><br><br>

    <label>Jumlah Stok:</label><br>
    <input type="number" name="stok" class="input"><br><br>

    <label>Batas Minimal:</label><br>
    <input type="number" name="batas_minimal" class="input"><br><br>

    <input type="submit" name="simpan" value="Simpan">
</form>

<?php include("inc_footer.php"); ?>
