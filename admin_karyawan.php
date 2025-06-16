<?php
session_start(); // Tambahkan session_start jika belum ada
include("inc_header.php");

// Buka akses untuk semua user login
if (!isset($_SESSION['admin_username'])) {
    echo "<h2>⚠️ Akses Ditolak</h2><p>Silakan login terlebih dahulu.</p>";
    include("inc_footer.php");
    exit();
}
?>

<h1>Halaman Karyawan</h1>
<div class="slide-in-box">
<p><strong>Selamat datang di halaman Karyawan Bakso Mataram.</strong></p>


<!-- Profil Karyawan -->
<h2>👤 Profil Saya</h2>
<ul>
    <li>Nama: <strong><?= $_SESSION['admin_username']; ?></strong></li>
    <li>Role: Karyawan</li>
</ul>

<!-- Jadwal Kerja -->
<h2>🗓️ Jadwal Kerja</h2>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Hari</th>
        <th>Jam Masuk</th>
        <th>Jam Keluar</th>
    </tr>
    <tr><td>Senin</td><td>10:45</td><td>22:00</td></tr>
    <tr><td>Selasa</td><td>10:45</td><td>22:00</td></tr>
    <tr><td>Rabu</td><td>Libur</td><td>-</td></tr>
    <tr><td>Kamis</td><td>10:45</td><td>22:00</td></tr>
    <tr><td>Jumat</td><td>13:40</td><td>22:00</td></tr>
    <tr><td>Sabtu</td><td>10:45</td><td>22:00</td></tr>
    <tr><td>Minggu</td><td>10:45</td><td>22:00</td></tr>
</table>

<!-- Tugas Harian -->
<h2>📌 Tugas Hari Ini</h2>
<ul>
    <li>Mempersiapkan bahan baku</li>
    <li>Menjaga kebersihan dapur</li>
    <li>Melayani pelanggan dengan sopan</li>
</ul>

<!-- Form Laporan -->
<h2>📝 Laporan Kegiatan</h2>
<form method="post">
    <textarea name="laporan" rows="5" cols="60" placeholder="Tulis laporan kegiatan hari ini..." required></textarea><br><br>
    <input type="submit" value="Kirim Laporan">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $laporan = trim($_POST["laporan"]);
    if (!empty($laporan)) {
        $laporan = htmlspecialchars($laporan);
        echo "<div class='success-box'>";
        echo "<h3>✅ Laporan berhasil dikirim!</h3>";
        echo "<p><strong>Isi Laporan:</strong><br>" . nl2br($laporan) . "</p>";
        echo "</div>";
    } else {
        echo "<p style='color:red;'>⚠️ Laporan tidak boleh kosong.</p>";
    }
}
?>
</div>

<?php include("inc_footer.php"); ?>
