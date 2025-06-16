<?php
include("inc_header.php");
include("inc_koneksi.php");

$sql = "SELECT * FROM pengeluaran ORDER BY tanggal DESC";
$q = mysqli_query($koneksi, $sql);
?>

<h1>💸 Data Pengeluaran</h1>
<p>
    <div class="slide-in-box">
    <a href="admin_pengeluaran_tambah.php" style="background:#333;color:#fff;padding:8px 12px;border-radius:5px;text-decoration:none;">➕ Tambah Pengeluaran</a>
</p>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr style="background-color:#f2f2f2;">
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Jumlah</th>
    </tr>
    <?php while ($r = mysqli_fetch_array($q)) : ?>
    <tr>
        <td><?= $r['tanggal'] ?></td>
        <td><?= htmlspecialchars($r['keterangan']) ?></td>
        <td>Rp <?= number_format($r['jumlah'], 0, ',', '.') ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include("inc_footer.php"); ?>
