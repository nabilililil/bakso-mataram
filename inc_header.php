<?php
// Mulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("inc_koneksi.php");

// Cek apakah user sudah login
if (!isset($_SESSION['admin_username'])) {
    header("location:login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin - Bakso Mataram</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="app">

    <!-- ✅ Logo -->
    <div style="text-align:center; margin: 15px 0;">
     <img src="images/logo.jpg" alt="Logo Bakso Mataram" style="max-height: 180px; width: auto;">
    </div>

    <!-- ✅ Tombol Dark Mode -->
    <div style="text-align: right; margin: 10px;">
        <button onclick="toggleDarkMode()" style="padding: 6px 12px; background-color: #444; color: white; border: none; border-radius: 5px; cursor: pointer;">
            🌓 Mode Gelap
        </button>
    </div>

    <!-- ✅ Navigasi -->
    <nav>
        <ul>
            <li><a href="admin_depan.php">Home</a></li>
            <li><a href="admin_manajer.php">Halaman Manajer</a></li>
            <li><a href="admin_kasir.php">Halaman Kasir</a></li>
            <li><a href="admin_karyawan.php">Halaman Karyawan</a></li>
            <li><a href="admin_stok.php">Halaman Stok</a></li>
            <li><a href="admin_pengeluaran.php">Halaman Pengeluaran</a></li>
            <li><a href="logout.php">Logout >></a></li>
        </ul>
    </nav>
