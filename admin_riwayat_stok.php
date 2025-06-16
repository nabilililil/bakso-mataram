<?php
include("inc_header.php");
include("inc_koneksi.php");

$sql = "SELECT * FROM riwayat_stok ORDER BY tanggal DESC";
$q = mysqli_query($koneksi, $sql);
?>

<h1>📈 Riwayat Stok</h1>

<div class="slide-in-box">
<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr style="background-color:#f2f2f2;">
        <th>Tanggal</th>
        <th>Nama Bahan</th>
        <th>Jumlah</th>
        <th>Jenis</th>
        <th>Keterangan</th>
    </tr>
    <?php while ($r = mysqli_fetch_array($q)) : ?>
    <tr>
        <td><?= date("d-m-Y H:i", strtotime($r['tanggal'])) ?></td>
        <td><?= htmlspecialchars($r['nama_bahan']) ?></td>
        <td><?= $r['jumlah'] ?></td>
        <td style="color:<?= $r['jenis'] == 'masuk' ? 'green' : 'red' ?>;font-weight:bold;">
            <?= ucfirst($r['jenis']) ?>
        </td>
        <td><?= htmlspecialchars($r['keterangan']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>
</div>

<?php include("inc_footer.php"); ?>
