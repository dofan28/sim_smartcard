<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /login");
    exit;
}


if (isset($matches[1]) && is_numeric($matches[1])) {
    $logId = (int)$matches[1];
    if (deleteLog($db, $logId)) {
        header("Location: /logs");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus siswa');</script>";
        echo "<a href='/students'>Kembali ke Daftar Siswa</a>";
    }
} else {
    echo "<script>alert('ID tidak valid');</script>";
    echo "<a href='/students'>Kembali ke Daftar Siswa</a>";
}
