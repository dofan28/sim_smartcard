<?php
require_once '../src/config/db.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');


if ($uri === '') {
    $title = 'Beranda';
    $content =  __DIR__ . '/../src/views/home.php';
    include __DIR__ . '/../src/views/layouts/home-layout.php';
} elseif ($uri === 'login') {
    $title = 'Masuk';
    $content =  __DIR__ . '/../src/views/auth/login.php';
    include __DIR__ . '/../src/views/layouts/home-layout.php';
} elseif ($uri === 'logout') {
    include __DIR__ . '/../src/views/auth/logout.php';
} elseif ($uri === 'dashboard') {
    $title = 'Dashboard';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/log_queries.php';
    require_once '../src/queries/transaction_queries.php';
    $content =  __DIR__ . '/../src/views/dashboard.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'scanners') {
    $title = 'Scan Kartu';
    require_once '../src/queries/scan_queries.php';
    $content = __DIR__ . '/../src/views/scanners/index.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'students') {
    $title = 'Kelola Siswa';
    require_once '../src/queries/student_queries.php';
    $content =  __DIR__ . '/../src/views/students/index.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'students/create') {
    $title = 'Buat Siswa';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/log_queries.php';
    $content = __DIR__ . '/../src/views/students/create.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'transactions') {
    $title = 'Kelola Rekaptulasi Kehadiran Siswa';
    require_once '../src/queries/transaction_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/index.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'transactions/create') {
    $title = 'Kelola Rekaptulasi Kehadiran Siswa';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/create.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^transactions\/(\d+)\/edit$/', $uri, $matches)) {
    $title = 'Edit Rekaptulasi Kehadiran Siswa';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/edit.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^transactions\/(\d+)\/delete$/', $uri, $matches)) {
    require_once '../src/queries/transaction_queries.php';
    include __DIR__ . '/../src/views/transactions/delete.php';
} elseif ($uri === 'logs') {
    $title = 'Log Aktivitas';
    require_once '../src/queries/log_queries.php';
    $content = __DIR__ . '/../src/views/logs/index.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^logs\/(\d+)\/delete$/', $uri, $matches)) {
    require_once '../src/queries/log_queries.php';
    include __DIR__ . '/../src/views/logs/delete.php';
} elseif (preg_match('/^transactions\/(\d+)\/edit$/', $uri, $matches)) {
    $title = 'Edit Rekaptulasi Data Siswa';
    require_once '../src/queries/transactions_queries.php';
    $content = __DIR__ . '/../src/views/transactions/edit.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'api/logs/latest') {
    require_once '../src/functions/helpers.php';
    require_once '../src/queries/log_queries.php';
    include __DIR__ . '/../src/api/log_latest.php';
} elseif (preg_match('/^students\/(\d+)\/edit$/', $uri, $matches)) {
    $title = 'Edit Siswa';
    require_once '../src/queries/student_queries.php';
    $content = __DIR__ . '/../src/views/students/edit.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^students\/(\d+)\/delete$/', $uri, $matches)) {
    require_once '../src/queries/student_queries.php';
    include __DIR__ . '/../src/views/students/delete.php';
} elseif (preg_match('/^students\/(\d+)$/', $uri, $matches)) {
    $title = 'Detail Siswa';
    require_once '../src/queries/student_queries.php';
    $content = __DIR__ . '/../src/views/students/show.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'api/logs') {
    require_once '../src/queries/log_queries.php';
    include __DIR__ . '/../src/api/log.php';
} elseif (preg_match('/^api\/students\/([a-zA-Z0-9]+)\/verify$/', $uri, $matches)) {
    require_once '../src/functions/helpers.php';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_queries.php';
    include __DIR__ . '/../src/api/student_verify.php';
} else {
    http_response_code(404);
    echo '<h1>404 - Halaman tidak ditemukan</h1>';
}
