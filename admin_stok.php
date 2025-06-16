<?php
include("inc_header.php");
include("inc_koneksi.php");

// Handle pencarian dan filter status
$cari = $_GET['cari'] ?? '';
$status = $_GET['status'] ?? '';

$where = [];

if ($cari != '') {
    $where[] = "nama_bahan LIKE '%" . mysqli_real_escape_string($koneksi, $cari) . "%'";
}

if ($status == 'menipis') {
    $where[] = "stok <= batas_minimal";
} elseif ($status == 'cukup') {
    $where[] = "stok > batas_minimal";
}

$sql = "SELECT * FROM bahan_baku";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$q = mysqli_query($koneksi, $sql);

// Cek jumlah bahan yang menipis
$sql_warning = "SELECT COUNT(*) AS jml FROM bahan_baku WHERE stok <= batas_minimal";
$cek_warning = mysqli_fetch_assoc(mysqli_query($koneksi, $sql_warning));
?>

<h1>📦 Manajemen Stok</h1>
<div class="slide-in-box">
<!-- Notifikasi stok menipis -->
<?php if ($cek_warning['jml'] > 0): ?>
    <div style="background:#ffe0e0;color:red;padding:10px;margin-bottom:10px;border-radius:5px;">
        ⚠️ Ada <strong><?= $cek_warning['jml'] ?></strong> bahan yang stoknya menipis!
    </div>
<?php endif; ?>

<!-- Form Pencarian dan Filter -->
<form method="get" style="margin-bottom: 20px;">
    <input type="text" name="cari" class="input" placeholder="🔍 Cari bahan..." value="<?= htmlspecialchars($cari) ?>">
    <select name="status">
        <option value="">-- Semua Status --</option>
        <option value="cukup" <?= ($status == 'cukup') ? 'selected' : '' ?>>Cukup</option>
        <option value="menipis" <?= ($status == 'menipis') ? 'selected' : '' ?>>Menipis</option>
    </select>
    <input type="submit" value="Terapkan">
</form>

<!-- Tombol Tambah -->
<p>
    <a href="admin_stok_tambah.php" style="text-decoration:none;background:#333;color:#fff;padding:8px 12px;border-radius:5px;">
        ➕ Tambah Bahan Baku Baru
    </a>
</p>

<!-- Tabel Data Bahan -->
<div class="slide-in-box">
<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr style="background-color:#f2f2f2;">
        <th>Nama Bahan</th>
        <th>Satuan</th>
        <th>Stok</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php while ($r = mysqli_fetch_array($q)) : ?>
    <tr>
        <td><?= htmlspecialchars($r['nama_bahan']) ?></td>
        <td><?= htmlspecialchars($r['satuan']) ?></td>
        <td><?= $r['stok'] ?></td>
        <td>
            <?php if ($r['stok'] <= $r['batas_minimal']): ?>
                <span style='color:red;font-weight:bold;'>Menipis!</span>
            <?php else: ?>
                <span style='color:green;'>Cukup</span>
            <?php endif; ?>
        </td>
        <td>
            <a href="admin_stok_edit.php?id=<?= $r['id'] ?>">✏️ Edit</a> |
            <a href="admin_stok_hapus.php?id=<?= $r['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">🗑️ Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</div>

<?php include("inc_footer.php"); ?>
