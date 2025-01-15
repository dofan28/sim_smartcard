<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: /login");
    exit;
}


if (isset($matches[1]) && is_numeric($matches[1])) {
    $transactionId = (int)$matches[1];
    if (deleteTransaction($db, $transactionId)) {
        header("Location: /transactions");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus Rekaptulasi Kehadiran Siswa');</script>";
        echo "<a href='/students'>Kembali ke Daftar Siswa</a>";
    }
} else {
    echo "<script>alert('ID tidak valid');</script>";
    echo "<a href='/students'>Kembali ke Daftar Siswa</a>";
}
