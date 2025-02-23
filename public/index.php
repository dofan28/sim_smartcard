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
    $title = 'Mengelola Siswa';
    require_once '../src/queries/student_queries.php';
    $content =  __DIR__ . '/../src/views/students/index.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'students/create') {
    $title = 'Buat Siswa';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/log_queries.php';
    $content = __DIR__ . '/../src/views/students/create.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
}elseif (preg_match('/^students\/(\d+)\/edit$/', $uri, $matches)) {
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
}  elseif ($uri === 'transactions') {
    $title = 'Log Akses';
    require_once '../src/queries/transaction_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/index.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'transactions/create') {
    $title = 'Mengelola Log Akses';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/create.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^transactions\/(\d+)\/edit$/', $uri, $matches)) {
    $title = 'Edit Log Akses';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/edit.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^transactions\/(\d+)\/delete$/', $uri, $matches)) {
    require_once '../src/queries/transaction_queries.php';
    include __DIR__ . '/../src/views/transactions/delete.php';
} elseif (preg_match('/^transactions\/(\d+)$/', $uri, $matches)) {
    $title = 'Detail Log Akses';
    require_once '../src/queries/transaction_queries.php';
    $content = __DIR__ . '/../src/views/transactions/show.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'transaction/transports') {
    $title = 'Log Akses Transportasi';
    require_once '../src/queries/transaction_transport_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/transport/index.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'transaction/transports/create') {
    $title = 'Buat Log Akses Transportasi';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_transport_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/transport/create.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^transaction\/transports\/(\d+)\/edit$/', $uri, $matches)) {
    $title = 'Edit Log Akses Transportasi';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_transport_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/transport/edit.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^transaction\/transports\/(\d+)\/delete$/', $uri, $matches)) {
    require_once '../src/queries/transaction_transport_queries.php';
    include __DIR__ . '/../src/views/transactions/transport/delete.php';
} elseif (preg_match('/^transaction\/transports\/(\d+)$/', $uri, $matches)) {
    $title = 'Detail Log Akses Transportasi';
    require_once '../src/queries/transaction_transport_queries.php';
    $content = __DIR__ . '/../src/views/transactions/transport/show.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'transaction/gates') {
    $title = 'Log Akses Gerbang';
    require_once '../src/queries/transaction_gate_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/gate/index.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'transaction/gates/create') {
    $title = 'Buat Log Akses Gerbang';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_gate_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/gate/create.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^transaction\/gates\/(\d+)\/edit$/', $uri, $matches)) {
    $title = 'Edit Log Akses Gerbang';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_gate_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/gate/edit.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^transaction\/gates\/(\d+)\/delete$/', $uri, $matches)) {
    require_once '../src/queries/transaction_gate_queries.php';
    include __DIR__ . '/../src/views/transactions/gate/delete.php';
} elseif (preg_match('/^transaction\/gates\/(\d+)$/', $uri, $matches)) {
    $title = 'Detail Log Akses Gerbang';
    require_once '../src/queries/transaction_gate_queries.php';
    $content = __DIR__ . '/../src/views/transactions/gate/show.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'transaction/classes') {
    $title = 'Log Akses Kelas';
    require_once '../src/queries/transaction_class_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/class/index.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif ($uri === 'transaction/classes/create') {
    $title = 'Buat Log Akses Kelas';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_class_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/class/create.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^transaction\/classes\/(\d+)\/edit$/', $uri, $matches)) {
    $title = 'Edit Log Akses Kelas';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_class_queries.php';
    $content =  __DIR__ . '/../src/views/transactions/class/edit.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^transaction\/classes\/(\d+)\/delete$/', $uri, $matches)) {
    require_once '../src/queries/transaction_class_queries.php';
    include __DIR__ . '/../src/views/transactions/class/delete.php';
} elseif (preg_match('/^transaction\/classes\/(\d+)$/', $uri, $matches)) {
    $title = 'Detail Log Akses Kelas';
    require_once '../src/queries/transaction_class_queries.php';
    $content = __DIR__ . '/../src/views/transactions/class/show.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^api\/transaction\/transports\/([a-zA-Z0-9]+)\/verify$/', $uri, $matches)) {
    require_once '../src/functions/helpers.php';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_transport_queries.php';
    include __DIR__ . '/../src/api/log_access_transport.php';
} elseif (preg_match('/^api\/transaction\/gates\/([a-zA-Z0-9]+)\/verify$/', $uri, $matches)) {
    require_once '../src/functions/helpers.php';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_gate_queries.php';
    include __DIR__ . '/../src/api/log_access_gate.php';
} elseif (preg_match('/^api\/transaction\/classes\/([a-zA-Z0-9]+)\/verify$/', $uri, $matches)) {
    require_once '../src/functions/helpers.php';
    require_once '../src/queries/student_queries.php';
    require_once '../src/queries/transaction_class_queries.php';
    include __DIR__ . '/../src/api/log_access_class.php';
} elseif ($uri === 'logs') {
    $title = 'Log Aktivitas';
    require_once '../src/queries/log_queries.php';
    $content = __DIR__ . '/../src/views/logs/index.php';
    include __DIR__ . '/../src/views/layouts/dashboard-layout.php';
} elseif (preg_match('/^logs\/(\d+)\/delete$/', $uri, $matches)) {
    require_once '../src/queries/log_queries.php';
    include __DIR__ . '/../src/views/logs/delete.php';
} elseif ($uri === 'api/logs/latest') {
    require_once '../src/functions/helpers.php';
    require_once '../src/queries/log_queries.php';
    include __DIR__ . '/../src/api/log_latest.php';
} elseif ($uri === 'api/logs') {
    require_once '../src/queries/log_queries.php';
    include __DIR__ . '/../src/api/log.php';
}elseif ($uri === 'transaction/transport/print/pdf') {
    require_once '../src/queries/transaction_transport_queries.php';
    require_once '../src/functions/print_pdf_log_access_transport.php';
}elseif ($uri === 'transaction/gate/print/pdf') {
    require_once '../src/queries/transaction_gate_queries.php';
    require_once '../src/functions/print_pdf_log_access_gate.php';
}elseif ($uri === 'transaction/class/print/pdf') {
    require_once '../src/queries/transaction_class_queries.php';
    require_once '../src/functions/print_pdf_log_access_class.php';
}elseif ($uri === 'transaction/transport/print/excel') {
    require_once '../src/queries/transaction_transport_queries.php';
    require_once '../src/functions/print_excel_log_access_transport.php';
}elseif ($uri === 'transaction/gate/print/excel') {
    require_once '../src/queries/transaction_gate_queries.php';
    require_once '../src/functions/print_excel_log_access_gate.php';
}elseif ($uri === 'transaction/class/print/excel') {
    require_once '../src/queries/transaction_class_queries.php';
    require_once '../src/functions/print_excel_log_access_class.php';
} else {
    http_response_code(404);
    echo '<h1>404 - Halaman tidak ditemukan</h1>';
}