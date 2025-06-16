<?php
include_once("inc_header.php");
include_once("inc_koneksi.php");

// Data Transaksi Hari Ini
$sql_today = "SELECT COUNT(*) AS total_transaksi, SUM(total) AS pendapatan_kotor 
              FROM transaksi 
              WHERE DATE(waktu) = CURDATE()";
$q_today = mysqli_query($koneksi, $sql_today);
$data_today = mysqli_fetch_assoc($q_today);

$total_transaksi = $data_today['total_transaksi'] ?? 0;
$pendapatan_kotor = $data_today['pendapatan_kotor'] ?? 0;

// Pengeluaran Hari Ini
$sql_pengeluaran = "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran WHERE DATE(tanggal) = CURDATE()";
$q_pengeluaran = mysqli_query($koneksi, $sql_pengeluaran);
$data_pengeluaran = mysqli_fetch_assoc($q_pengeluaran);
$total_pengeluaran = $data_pengeluaran['total_pengeluaran'] ?? 0;

$pendapatan_bersih = $pendapatan_kotor - $total_pengeluaran;

// Data Kemarin
$sql_yesterday = "SELECT SUM(total) AS pendapatan FROM transaksi WHERE DATE(waktu) = CURDATE() - INTERVAL 1 DAY";
$data_yesterday = mysqli_fetch_assoc(mysqli_query($koneksi, $sql_yesterday));
$pendapatan_kemarin = $data_yesterday['pendapatan'] ?? 0;

// Notifikasi
$notifikasi = "";
if ($pendapatan_kotor == 0) {
    $notifikasi .= "<li>❌ Belum ada transaksi hari ini.</li>";
} elseif ($pendapatan_kotor < $pendapatan_kemarin) {
    $notifikasi .= "<li>⚠️ Pendapatan hari ini <strong>lebih rendah</strong> dari kemarin.</li>";
} else {
    $notifikasi .= "<li>✅ Pendapatan hari ini <strong>meningkat</strong> dibanding kemarin.</li>";
}

if ($total_pengeluaran > 0) {
    $notifikasi .= "<li>📉 Total pengeluaran hari ini: <strong>Rp " . number_format($total_pengeluaran, 0, ',', '.') . "</strong></li>";
}
?>
<div class="slide-in-box">
<h1>Halaman Manajer</h1>
<p>Selamat datang di halaman <strong>Manajer Bakso Mataram</strong>.</p>

<?php if (!empty($notifikasi)): ?>
    <div class="notifikasi-box">
        <h3>🔔 Notifikasi Manajer</h3>
        <ul><?= $notifikasi ?></ul>
    </div>
<?php endif; ?>


    <!-- Ringkasan Penjualan Hari Ini -->
    <h2>📊 Ringkasan Penjualan Hari Ini</h2>
    <ul>
        <li><strong>Total Transaksi:</strong> <?= $total_transaksi ?></li>
        <li><strong>Pendapatan Kotor:</strong> Rp <?= number_format($pendapatan_kotor, 0, ',', '.') ?></li>
        <li><strong>Pengeluaran:</strong> Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></li>
        <li><strong>Pendapatan Bersih:</strong> Rp <?= number_format($pendapatan_bersih, 0, ',', '.') ?></li>
    </ul>

    <!-- Daftar Menu Favorit -->
    <h2>🍜 Menu Favorit Pelanggan</h2>
    <ol>
        <li>Bakso BrotoYudho</li>
        <li>Bakso Semar Mendem</li>
        <li>Bakso Petruk</li>
    </ol>

    <!-- Daftar Karyawan Hari Ini -->
    <h2>👥 Petugas Hari Ini</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Nama</th>
            <th>Jabatan</th>
        </tr>
        <tr><td>Queen</td><td>Kasir</td></tr>
        <tr><td>King</td><td>Koki</td></tr>
        <tr><td>Prince</td><td>Bagian Jus</td></tr>
        <tr><td>Princess</td><td>Pelayan</td></tr>
    </table>

    <!-- Catatan Manajer -->
    <h2>📝 Catatan Manajer</h2>
    <p>
        <strong>•</strong> Pastikan semua bahan baku cukup hingga malam. <br>
        <strong>•</strong> Evaluasi kinerja karyawan dilakukan setiap hari Jumat. <br>
        <strong>•</strong> Laporan harian harap dikumpulkan sebelum pukul <strong>21.00 WIB</strong>.
    </p>
</div>

<?php include_once("inc_footer.php"); ?>
