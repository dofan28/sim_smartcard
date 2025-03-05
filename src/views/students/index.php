<?php
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$offset = ($page - 1) * $limit;

$students = getStudents($db, $limit, $offset, $search);
$totalStudents = getTotalStudents($db, $search);
$totalPages = ceil($totalStudents / $limit);
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


<!-- Main Content -->
<main class="container px-6 py-3 mx-auto mb-8">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-2xl font-semibold tracking-normal text-blue-900 font-poppins">Mengelola Data Siswa</h1>
    </header>

    <!-- Aksi Cepat -->
    <!-- Header dengan Search dan Tombol Create -->
    <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:justify-between sm:items-center">
        <a href="students/create"
            class="w-full px-3 py-2 text-sm text-center text-white rounded-md sm:w-auto font-poppins bg-amber-400 hover:bg-amber-500">
            Buat Data Siswa Baru
        </a>
        <form action="" method="GET" class="flex w-full gap-2 sm:w-auto">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                placeholder="Cari siswa ..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md sm:w-64 focus:outline-none focus:ring focus:ring-blue-300">
            <button type="submit"
                class="px-4 py-2 text-white bg-blue-800 rounded-md whitespace-nowrap hover:bg-blue-900">
                Cari
            </button>
        </form>
    </div>

    <div class="overflow-hidden bg-white border rounded-md shadow">
        <div class="hidden md:block">
            <table class="min-w-full text-left border-collapse">
                <thead class="text-white bg-blue-900">
                    <tr>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">UID</th>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">NIS</th>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">Nama</th>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">Kelas</th>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">Status</th>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students)): ?>
                        <?php foreach ($students as $index => $student) : ?>
                            <tr class="border-t hover:bg-gray-100">
                                <td class="px-6 py-4 text-sm font-poppins"><?= $student['uid'] ?></td>
                                <td class="px-6 py-4 text-sm font-poppins"><?= $student['nis'] ?></td>
                                <td class="px-6 py-4 text-sm font-poppins"><?= $student['full_name'] ?></td>
                                <td class="px-6 py-4 text-sm font-poppins"><?= $student['class'] ?></td>
                                <td class="px-6 py-4 text-sm font-poppins">
                                    <?php if ($student['status'] == 'active'): ?>
                                        <span class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded-full">Aktif</span>
                                    <?php elseif ($student['status'] == 'inactive'): ?>
                                        <span class="px-2 py-1 text-xs text-red-800 bg-red-100 rounded-full">Tidak Aktif</span>
                                    <?php endif ?>
                                </td>
                                <td class="px-6 py-4 space-x-2 text-sm font-poppins">
                                    <a href="students/<?= $student['id'] ?>" class="px-4 py-2 text-white bg-green-500 rounded-md hover:bg-green-600">Detail</a>
                                    <a href="students/<?= $student['id'] ?>/edit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Edit</a>
                                    <a href="students/<?= $student['id'] ?>/delete" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-sm text-center text-red-400 font-poppins">
                                --- Tidak ada data. ---
                            </td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>

        <!-- Card untuk Mobile -->
        <div class="block md:hidden font-poppins">
            <?php if (!empty($students)): ?>
                <div class="divide-y">
                    <?php foreach ($students as $student): ?>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between">
                                <div class="font-medium font-poppins"><?= $student['full_name'] ?></div>
                                <?php if ($student['status'] == 'active'): ?>
                                    <span class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded-full">Aktif</span>
                                <?php elseif ($student['status'] == 'inactive'): ?>
                                    <span class="px-2 py-1 text-xs text-red-800 bg-red-100 rounded-full">Tidak Aktif</span>
                                <?php endif ?>
                            </div>
                            <div class="space-y-1 text-sm text-gray-600">
                                <div>UID: <?= $student['uid'] ?></div>
                                <div>NIS: <?= $student['nis'] ?></div>
                                <div>Kelas: <?= $student['class'] ?></div>
                            </div>
                            <div class="flex flex-wrap gap-2 pt-2">
                                <a href="students/<?= $student['id'] ?>" class="px-4 py-2 text-sm text-white bg-green-500 rounded-md hover:bg-green-600">Detail</a>
                                <a href="students/<?= $student['id'] ?>/edit" class="px-4 py-2 text-sm text-white bg-blue-500 rounded-md hover:bg-blue-600">Edit</a>
                                <a href="students/<?= $student['id'] ?>/delete" class="px-4 py-2 text-sm text-white bg-red-500 rounded-md hover:bg-red-600">Hapus</a>
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