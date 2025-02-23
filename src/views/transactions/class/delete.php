<?php
session_start();



if (isset($matches[1]) && is_numeric($matches[1])) {
    $transactionId = (int)$matches[1];
    if (deleteTransactionClasses($db, $transactionId)) {
        header("Location: /transaction/classes");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus log akses kelas');</script>";
        echo "<a href='/students'>Kembali ke Daftar Siswa</a>";
    }
} else {
    echo "<script>alert('ID tidak valid');</script>";
    echo "<a href='/students'>Kembali ke Daftar Siswa</a>";
}
