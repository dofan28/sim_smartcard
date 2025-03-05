<?php


$studentId = $matches[1];
$student = getStudentById($db, $studentId);
?>



<!-- Main Content -->
<main class="container px-6 py-12 mx-auto">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-3xl font-semibold tracking-wide text-blue-900 font-poppins">Detail Data Siswa</h1>
        <p class="mt-2 text-sm text-gray-700 font-poppins">Berikut adalah informasi lengkap dari siswa yang dipilih.</p>
    </header>

    <!-- Detail Siswa -->
    <div class="p-6 bg-white rounded-md shadow-md">
        <!-- Foto Profil Siswa (opsional) -->
        <div class="flex items-center mb-6">
            <div class="ml-6">
                <h2 class="text-2xl font-semibold text-blue-800 uppercase font-poppins" id="nama-siswa"><?= htmlspecialchars($student['full_name']) ?></h2>
                <p class="text-gray-400 font-poppins" id="id-siswa">UID: <?= htmlspecialchars($student['uid']) ?></p>
            </div>
        </div>

        <table class="w-full border border-collapse border-gray-300 rounded-md">
            <tbody>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">NIS:</td>
                    <td class="px-4 py-2 text-sm text-gray-600 font-poppins" id="nama"><?= htmlspecialchars($student['nis']) ?></td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">Email:</td>
                    <td class="px-4 py-2 text-sm text-gray-600 font-poppins" id="nama"><?= htmlspecialchars($student['email']) ?></td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">Kelas:</td>
                    <td class="px-4 py-2 text-gray-600" id="kelas"><?= htmlspecialchars($student['class']) ?></td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">Alamat:</td>
                    <td class="px-4 py-2 text-gray-600" id="alamat"><?= htmlspecialchars($student['address']) ?></td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">Nomor Telepon:</td>
                    <td class="px-4 py-2 text-gray-600" id="phone"><?= htmlspecialchars($student['phone']) ?></td>
                </tr>
                <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">Status:</td>
                <td class="px-4 py-2 text-gray-600" id="alamat">
                    <?php if (htmlspecialchars($student['status']) == 'active'): ?>
                        Aktif
                    <?php elseif (htmlspecialchars($student['status']) == 'inactive'): ?>
                        Tidak Aktif
                    <?php endif ?>
                    </tr>
            </tbody>
        </table>

        <!-- Tombol Aksi -->
        <div class="flex items-center justify-between mt-6">
            <a href="/students"
                class="px-4 py-2 text-sm text-gray-800 bg-gray-300 rounded-md font-poppins hover:bg-gray-400">
                Kembali
            </a>
            <div class="flex space-x-2">
                <a href="/students/<?= $student['id'] ?>/edit"
                    class="px-4 py-2 text-sm text-white bg-blue-500 rounded-md font-poppins hover:bg-blue-600">
                    Edit
                </a>
                <a href="/students/<?= $student['id'] ?>/delete"
                    class="px-4 py-2 text-sm text-white bg-red-500 rounded-md font-poppins hover:bg-red-600">
                    Delete
                </a>
            </div>
        </div>
    </div>
</main>