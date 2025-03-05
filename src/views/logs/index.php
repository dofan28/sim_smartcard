<?php
if (!isset($_SESSION['login'])) {
    header("Location: /login");
    exit;
}

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$offset = ($page - 1) * $limit;

$logs = getAllLogPaginated($db, $limit, $offset, $search);
$totalLogs = getTotalLogs($db, $search);
$totalPages = ceil($totalLogs / $limit);
$no = $offset + 1;

$queryString = $_GET;
unset($queryString['page']);
$queryUrl = '?' . http_build_query($queryString);

$showPagination = $totalPages > 1;

// Pengaturan range pagination
$range = 2;
$start = max(1, $page - $range);
$end = min($totalPages, $page + $range);

?>

<main class="container px-6 py-3 mx-auto mb-8">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-2xl font-semibold tracking-normal text-blue-900 font-poppins">Mengelola Data Log Aktivitas</h1>
    </header>

    <!-- Aksi Cepat -->
    <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:justify-between sm:items-center">
        <form action="" method="GET" class="flex items-center">
            <input type="text" name="search"
                placeholder="Cari ..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300">
            <button type="submit"
                class="px-4 py-2 ml-2 text-white bg-blue-800 rounded-md hover:bg-blue-900">
                Cari
            </button>
        </form>
    </div>

    <!-- Tabel Data Siswa -->
    <div class="overflow-hidden bg-white border rounded-md shadow">
        <!-- Tabel untuk Desktop -->
        <div class="hidden md:block">
            <table class="min-w-full text-left border-collapse">
                <thead class="text-white bg-blue-900">
                    <tr>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">UID</th>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">Waktu Dibuat</th>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">Waktu Diperbarui</th>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)): ?>
                        <?php foreach ($logs as $log): ?>
                            <tr class="border-t hover:bg-gray-100">
                                <td class="px-6 py-4 text-sm font-poppins"><?= $log['uid'] ?></td>
                                <td class="px-6 py-4 text-sm font-poppins"><?= $log['created_at'] ?></td>
                                <td class="px-6 py-4 text-sm font-poppins"><?= $log['updated_at'] ?></td>
                                <td class="px-6 py-4 text-sm font-poppins">
                                    <a href="logs/<?= $log['id'] ?>/delete" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-sm text-center text-red-400 font-poppins">
                                --- Tidak ada data. ---
                            </td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>

        <!-- Card untuk Mobile -->
        <div class="block md:hidden font-poppins">
            <?php if (!empty($logs)): ?>
                <div class="divide-y">
                    <?php foreach ($logs as $log): ?>
                        <div class="p-4 space-y-3">
                            <!-- UID -->
                            <div class="font-medium font-poppins">
                                UID: <?= $log['uid'] ?>
                            </div>

                            <!-- Informasi Waktu -->
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex flex-col">
                                    <span class="text-gray-500">Waktu Dibuat:</span>
                                    <span class="mt-1"><?= $log['created_at'] ?></span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-gray-500">Waktu Diperbarui:</span>
                                    <span class="mt-1"><?= $log['updated_at'] ?></span>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="pt-2">
                                <a href="logs/<?= $log['id'] ?>/delete"
                                    class="inline-block px-4 py-2 text-sm text-white bg-red-500 rounded-md hover:bg-red-600">Hapus</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="px-6 py-4 text-sm text-center text-red-400 font-poppins">
                    --- Tidak ada data. ---
                </div>
            <?php endif ?>
        </div>
    </div>
    <!-- Pagination -->
    <?php if ($showPagination): ?>
        <!-- Desktop Pagination -->
        <div class="items-center justify-center hidden mt-6 space-x-2 text-sm md:flex font-poppins">
            <?php if ($page > 1): ?>
                <a href="<?= $queryUrl . '&page=1' ?>" class="px-3 py-2 bg-gray-200 rounded-md hover:bg-blue-200">« Pertama</a>
                <a href="<?= $queryUrl . '&page=' . ($page - 1) ?>" class="px-3 py-2 bg-gray-200 rounded-md hover:bg-blue-200">‹ Sebelumnya</a>
            <?php endif; ?>

            <?php if ($start > 1): ?>
                <span class="px-3 py-2">...</span>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
                <a href="<?= $queryUrl . '&page=' . $i ?>"
                    class="px-3 py-2 rounded-md transition-all <?= $i === $page ? 'bg-blue-800 text-white font-bold' : 'bg-gray-200 hover:bg-blue-200' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($end < $totalPages): ?>
                <span class="px-3 py-2">...</span>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <a href="<?= $queryUrl . '&page=' . ($page + 1) ?>" class="px-3 py-2 bg-gray-200 rounded-md hover:bg-blue-200">Selanjutnya ›</a>
                <a href="<?= $queryUrl . '&page=' . $totalPages ?>" class="px-3 py-2 bg-gray-200 rounded-md hover:bg-blue-200">Terakhir »</a>
            <?php endif; ?>
        </div>

        <!-- Mobile Pagination -->
        <div class="flex items-center justify-center mt-6 space-x-4 text-sm md:hidden font-poppins">
            <?php if ($page > 1): ?>
                <a href="<?= $queryUrl . '&page=' . ($page - 1) ?>" class="px-4 py-2 bg-gray-200 rounded-md font-poppins hover:bg-blue-200">‹ Sebelumnya</a>
            <?php endif; ?>

            <span class="text-gray-700">
                Halaman <?= $page ?> dari <?= $totalPages ?>
            </span>

            <?php if ($page < $totalPages): ?>
                <a href="<?= $queryUrl . '&page=' . ($page + 1) ?>" class="px-4 py-2 bg-gray-200 rounded-md font-poppins hover:bg-blue-200">Selanjutnya ›</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>