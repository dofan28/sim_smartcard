<?php
$transactionId = $matches[1];
$transaction = getTransactionClassById($db, $transactionId);
?>



<!-- Main Content -->
<main class="container px-6 py-12 mx-auto">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-3xl font-semibold tracking-wide text-blue-900 font-poppins">Detail Data Log Akses Kelas</h1>
        <p class="mt-2 text-sm text-gray-700 font-poppins">Berikut adalah informasi lengkap dari log akses kelas yang dipilih.</p>
    </header>

    <!-- Detail Siswa -->
    <div class="p-6 bg-white rounded-md shadow-md">
        <h2 class="mb-6 text-3xl font-semibold text-blue-800 uppercase  font-poppins" id="nama-siswa">Data Siswa</h2>
        <table class="w-full border border-collapse border-gray-300 rounded-md">
            <tbody>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">Nama:</td>
                    <td class="px-4 py-2 text-sm text-gray-600 font-poppins" id="nama"><?= htmlspecialchars($transaction['full_name']) ?></td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">UID:</td>
                    <td class="px-4 py-2 text-sm text-gray-600 font-poppins" id="nama"><?= htmlspecialchars($transaction['uid']) ?></td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">NIS:</td>
                    <td class="px-4 py-2 text-sm text-gray-600 font-poppins" id="nama"><?= htmlspecialchars($transaction['nis']) ?></td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">Kelas:</td>
                    <td class="px-4 py-2 text-gray-600" id="kelas"><?= htmlspecialchars($transaction['class']) ?></td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">Alamat:</td>
                    <td class="px-4 py-2 text-gray-600" id="alamat"><?= htmlspecialchars($transaction['address']) ?></td>
                </tr>
                <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">Status:</td>
                <td class="px-4 py-2 text-gray-600" id="alamat">
                    <?php if (htmlspecialchars($transaction['status']) == 'active'): ?>
                        Aktif
                    <?php elseif (htmlspecialchars($transaction['status']) == 'inactive'): ?>
                        Tidak Aktif
                    <?php endif ?>
                    </tr>
            </tbody>
        </table>
    </div>

    <div class="p-6 mt-6 bg-white rounded-md shadow-md">
        <h2 class="mb-6 text-3xl font-semibold text-blue-800 uppercase  font-poppins" id="nama-siswa">Data Log Akses Kelas</h2>
        <table class="w-full border border-collapse border-gray-300 rounded-md">
            <tbody>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">Tanggal Log Akses Kelas:</td>
                    <td class="px-4 py-2 text-sm text-gray-600 font-poppins" id="nama"><?= htmlspecialchars($transaction['date']) ?></td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">Waktu Masuk:</td>
                    <td class="px-4 py-2 text-sm text-gray-600 font-poppins" id="nama"><?= htmlspecialchars($transaction['check_in']) ?></td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 text-sm font-semibold text-gray-700 font-poppins">Waktu Pulang:</td>
                    <td class="px-4 py-2 text-sm text-gray-600 font-poppins" id="nama"><?= htmlspecialchars($transaction['check_out']) ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Tombol Aksi -->
        <div class="flex items-center justify-between mt-6">
            <a href="/transaction/classes"
                class="px-4 py-2 text-sm text-gray-800 bg-gray-300 rounded-md font-poppins hover:bg-gray-400">
                Kembali
            </a>
            <div class="flex space-x-2">
                <a href="/transaction/classes/<?= $transaction['id'] ?>/edit"
                    class="px-4 py-2 text-sm text-white bg-blue-500 rounded-md font-poppins hover:bg-blue-600">
                    Edit
                </a>
                <a href="/transaction/classes/<?= $transaction['id'] ?>/delete"
                    class="px-4 py-2 text-sm text-white bg-red-500 rounded-md font-poppins hover:bg-red-600">
                    Delete
                </a>
            </div>
        </div>
    </div>
</main>