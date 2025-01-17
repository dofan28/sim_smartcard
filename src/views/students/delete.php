<?php
session_start();



if (isset($matches[1]) && is_numeric($matches[1])) {
    $studentId = (int)$matches[1];
    if (deleteStudent($db, $studentId)) {
        header("Location: /students");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus siswa');</script>";
        echo "<a href='/students'>Kembali ke Daftar Siswa</a>";
    }
} else {
    echo "<script>alert('ID tidak valid');</script>";
    echo "<a href='/students'>Kembali ke Daftar Siswa</a>";
}
