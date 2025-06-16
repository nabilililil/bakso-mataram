<?php
include("inc_header.php");
include("inc_koneksi.php");

// Proses simpan transaksi
if (isset($_POST['simpan'])) {
    $nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $menu = mysqli_real_escape_string($koneksi, $_POST['menu']);
    $jumlah = intval($_POST['jumlah']);
    $harga = intval($_POST['harga']);
    $total = $jumlah * $harga;

    if ($nama_pelanggan && $menu && $jumlah > 0 && $harga > 0) {
        $sql = "INSERT INTO transaksi (nama_pelanggan, menu, jumlah, harga, total)
                VALUES ('$nama_pelanggan', '$menu', '$jumlah', '$harga', '$total')";
        mysqli_query($koneksi, $sql);

        echo "<div class='slide-in-box success-box'>✅ Transaksi berhasil disimpan!</div>";
    } else {
        echo "<div class='slide-in-box' style='color:red;'>❌ Pastikan semua data terisi dengan benar.</div>";
    }
}
?>

<div class="slide-in-box">
    <h1>🧾 Halaman Kasir</h1>
    <p><strong>Gunakan form di bawah ini untuk mencatat transaksi pelanggan.</strong></p>

    <h2>➕ Tambah Transaksi</h2>
    <form method="post">
        <label>Nama Pelanggan:</label><br>
        <input type="text" name="nama_pelanggan" class="input" required><br><br>

        <label>Nama Menu:</label><br>
        <input type="text" name="menu" class="input" required><br><br>

        <label>Jumlah:</label><br>
        <input type="number" name="jumlah" class="input" min="1" required><br><br>

        <label>Harga Satuan:</label><br>
        <input type="number" name="harga" class="input" min="0" required><br><br>

        <input type="submit" name="simpan" value="💾 Simpan Transaksi">
    </form>

    <hr style="margin: 30px 0;">

    <h2>📜 Riwayat Transaksi</h2>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; background-color: #fff;">
        <tr style="background-color: #6d4c41; color: #fff;">
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Total</th>
        </tr>
        <?php
        $result = mysqli_query($koneksi, "SELECT * FROM transaksi ORDER BY id DESC");
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$no}</td>
                <td>" . htmlspecialchars($row['nama_pelanggan']) . "</td>
                <td>" . htmlspecialchars($row['menu']) . "</td>
                <td>{$row['jumlah']}</td>
                <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                <td>Rp " . number_format($row['total'], 0, ',', '.') . "</td>
            </tr>";
            $no++;
        }
        ?>
    </table>
</div>

<?php include("inc_footer.php"); ?>
