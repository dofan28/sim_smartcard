<?php
if (!isset($_SESSION['login'])) {
    header("Location: /login");
    exit;
}

$logs = getAllLogs($db);
?>

<main class="container h-screen px-6 py-12 mx-auto">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-2xl font-semibold tracking-normal text-blue-900 font-poppins">Mengelola Data Log Aktivitas</h1>
    </header>

    <!-- Aksi Cepat -->
    <div class="flex flex-col items-center justify-between mb-6 sm:flex-row">
        <form action="" method="GET" class="flex items-center">
            <input type="text" name="search"
                placeholder="Cari ..."
                class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300">
            <button type="submit"
                class="px-4 py-2 ml-2 text-white bg-blue-800 rounded-md hover:bg-blue-900">
                Cari
            </button>
        </form>
    </div>

    <!-- Tabel Data Siswa -->
    <div class="overflow-hidden bg-white border rounded-md shadow">
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
                        <td colspan="5" class="px-6 py-4 text-sm text-center text-red-400 font-poppins">
                            --- Tidak ada data. ---
                        </td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</main>