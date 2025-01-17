<?php



$students = getAllStudents($db);
?>


<!-- Main Content -->
<main class="container h-screen px-6 py-12 mx-auto">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-2xl font-semibold tracking-normal text-blue-900 font-poppins">Mengelola Data Siswa</h1>
    </header>

    <!-- Aksi Cepat -->
    <div class="flex flex-col items-center justify-between mb-6 sm:flex-row">
        <a href="students/create"
            class="px-3 py-2 text-sm text-white rounded-md font-poppins bg-amber-400 hover:bg-amber-500 ">
            Buat Data Siswa Baru
        </a>
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
                    <th class="px-6 py-4 text-sm font-medium font-poppins">NIS</th>
                    <th class="px-6 py-4 text-sm font-medium font-poppins">Nama</th>
                    <th class="px-6 py-4 text-sm font-medium font-poppins">Kelas</th>
                    <th class="px-6 py-4 text-sm font-medium font-poppins">Status</th>
                    <th class="px-6 py-4 text-sm font-medium font-poppins">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($students)): ?>
                    <?php foreach ($students as $student): ?>
                        <tr class="border-t hover:bg-gray-100">
                            <td class="px-6 py-4 text-sm font-poppins"><?= $student['uid'] ?></td>
                            <td class="px-6 py-4 text-sm font-poppins"><?= $student['nis'] ?></td>
                            <td class="px-6 py-4 text-sm font-poppins"><?= $student['full_name'] ?></td>
                            <td class="px-6 py-4 text-sm font-poppins"><?= $student['class'] ?></td>
                            <td class="px-6 py-4 text-sm font-poppins">
                                <?php if ($student['status'] == 'active'): ?>
                                    Aktif
                                <?php elseif ($student['status'] == 'inactive'): ?>
                                    Tidak Aktif
                                <?php endif ?>
                            </td>
                            <td class="px-6 py-4 text-sm font-poppins">
                                <a href="students/<?= $student['id'] ?>" class="px-4 py-2 text-white bg-green-500 rounded-md hover:bg-green-600">Detail</a>
                                <a href="students/<?= $student['id'] ?>/edit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Edit</a>
                                <a href="students/<?= $student['id'] ?>/delete" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">Hapus</a>
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