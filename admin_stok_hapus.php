<?php
include("inc_koneksi.php");

$id = $_GET['id'] ?? '';

if ($id != '') {
    $sql = "DELETE FROM bahan_baku WHERE id = '$id'";
    mysqli_query($koneksi, $sql);
}

// Setelah hapus, kembali ke halaman stok
header("Location: admin_stok.php");
exit();
?>
