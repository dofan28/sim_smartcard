<?php

if (!isset($_SESSION['login'])) {
    header("Location: /login");
    exit;
}

$transactionId = $matches[1];
$transactions = getStudentById($db, $transactionId);
?>



<!-- Main Content -->
<main class="container px-6 py-12 mx-auto">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-blue-900">Detail Data Siswa</h1>
    </header>

    <!-- Detail Siswa -->
    <div class="p-6 bg-white rounded-md shadow-md">
        <!-- Foto Profil Siswa (opsional) -->
        <div class="flex items-center mb-6">
            <img src="/public/assets/images/default-avatar.png"
                alt="Foto Siswa"
                class="w-24 h-24 border border-gray-300 rounded-full">
            <div class="ml-6">
                <h2 class="text-2xl font-semibold text-blue-700" id="nama-siswa"><?= htmlspecialchars($student['full_name']) ?></h2>
                <p class="text-gray-500" id="id-siswa">UID: <?= htmlspecialchars($student['uid']) ?></p>
            </div>
        </div>

        <!-- Tabel Detail -->
        <table class="w-full border border-collapse border-gray-300">
            <tbody>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 font-semibold text-gray-700">Nama</td>
                    <td class="px-4 py-2 text-gray-600" id="nama"><?= htmlspecialchars($student['full_name']) ?></td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 font-semibold text-gray-700">Kelas</td>
                    <td class="px-4 py-2 text-gray-600" id="kelas"><?= htmlspecialchars($student['class']) ?></td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 font-semibold text-gray-700">Alamat</td>
                    <td class="px-4 py-2 text-gray-600" id="alamat"><?= htmlspecialchars($student['address']) ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Tombol Aksi -->
        <div class="flex justify-between mt-6">
            <a href="/templates/dashboard.php"
                class="px-6 py-2 text-gray-800 bg-gray-300 rounded-md hover:bg-gray-400">
                Kembali
            </a>
            <div>
                <a href="/templates/edit-student.php?id=12345"
                    class="px-6 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600">
                    Edit
                </a>
                <form action="/src/controllers/deleteStudent.php" method="POST" class="inline">
                    <input type="hidden" name="id_siswa" value="12345">
                    <button type="submit"
                        class="px-6 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>