<?php


$transactionGates = getAllTransactionGateJoinStudents($db);
?>


<!-- Main Content -->
<main class="container h-screen px-6 py-3 mx-auto">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-2xl font-semibold tracking-normal text-blue-900 font-poppins">Mengelola Log Akses Gerbang</h1>
    </header>

    <!-- Aksi Cepat -->
    <div class="flex flex-col items-center justify-between mb-6 sm:flex-row">
        <div class="flex items-center gap-4 p-4 bg-white shadow rounded-md">
            <a href="/transaction/gates/create"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-amber-500 rounded-md shadow hover:bg-amber-600 transition-all duration-300 font-poppins">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Buat Log Akses Gerbang
            </a>
            <span class="w-1 h-6 bg-gray-400 rounded-md"></span>
            <div class="relative inline-block text-left">
                <button type="button" onclick="toggleDropdown()" class="inline-flex items-center px-4 py-2 text-sm font-poppins text-white bg-blue-500 border border-gray-300 rounded-md hover:bg-blue-600 ">
                    Cetak
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <!-- Dropdown Menu -->
                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-72 rounded-xl bg-white shadow-lg ring-1 ring-black/5 divide-y divide-gray-100">
                    <div class="p-1">
                        <!-- PDF Option -->
                        <a href="/transaction/gate/print/pdf" class="flex items-center px-2 py-3 text-sm text-gray-700 hover:bg-red-200 rounded-md transition-all duration-200 group">
                            <svg class="w-6 h-6 mr-3 text-red-400 group-hover:text-red-500 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 4C4 3.44772 4.44772 3 5 3H14H14.5858C14.851 3 15.1054 3.10536 15.2929 3.29289L19.7071 7.70711C19.8946 7.89464 20 8.149 20 8.41421V20C20 20.5523 19.5523 21 19 21H5C4.44772 21 4 20.5523 4 20V4Z" stroke="#dc2626" stroke-width="2" stroke-linecap="round" />
                                <path d="M20 8H15V3" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11.5 13H11V17H11.5C12.6046 17 13.5 16.1046 13.5 15C13.5 13.8954 12.6046 13 11.5 13Z" stroke="#dc2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15.5 17V13L17.5 13" stroke="#dc2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16 15H17" stroke="#dc2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M7 17L7 15.5M7 15.5L7 13L7.75 13C8.44036 13 9 13.5596 9 14.25V14.25C9 14.9404 8.44036 15.5 7.75 15.5H7Z" stroke="#dc2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div>
                                <p class="font-semibold text-red-400 group-hover:text-red-600 font-poppins text-xs">Unduh PDF</p>
                                <p class="text-xs text-gray-400 mt-0.5 font-poppins">Simpan sebagai Dokumen PDF</p>
                            </div>
                        </a>
                        <!-- Excel Option -->
                        <a href="/transaction/gate/print/excel" class="flex items-center px-2 py-3 text-sm text-gray-700 hover:bg-green-200 rounded-md transition-all duration-200 group">
                            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-green-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.29289 1.29289C9.48043 1.10536 9.73478 1 10 1H18C19.6569 1 21 2.34315 21 4V9C21 9.55228 20.5523 10 20 10C19.4477 10 19 9.55228 19 9V4C19 3.44772 18.5523 3 18 3H11V8C11 8.55228 10.5523 9 10 9H5V20C5 20.5523 5.44772 21 6 21H7C7.55228 21 8 21.4477 8 22C8 22.5523 7.55228 23 7 23H6C4.34315 23 3 21.6569 3 20V8C3 7.73478 3.10536 7.48043 3.29289 7.29289L9.29289 1.29289ZM6.41421 7H9V4.41421L6.41421 7ZM19 12C19.5523 12 20 12.4477 20 13V19H23C23.5523 19 24 19.4477 24 20C24 20.5523 23.5523 21 23 21H19C18.4477 21 18 20.5523 18 20V13C18 12.4477 18.4477 12 19 12ZM11.8137 12.4188C11.4927 11.9693 10.8682 11.8653 10.4188 12.1863C9.96935 12.5073 9.86526 13.1318 10.1863 13.5812L12.2711 16.5L10.1863 19.4188C9.86526 19.8682 9.96935 20.4927 10.4188 20.8137C10.8682 21.1347 11.4927 21.0307 11.8137 20.5812L13.5 18.2205L15.1863 20.5812C15.5073 21.0307 16.1318 21.1347 16.5812 20.8137C17.0307 20.4927 17.1347 19.8682 16.8137 19.4188L14.7289 16.5L16.8137 13.5812C17.1347 13.1318 17.0307 12.5073 16.5812 12.1863C16.1318 11.8653 15.5073 11.9693 15.1863 12.4188L13.5 14.7795L11.8137 12.4188Z" fill="#16a34a" />
                            </svg>
                            <div>
                                <p class="font-semibold text-green-400 group-hover:text-green-600 font-poppins text-xs">Unduh Excel</p>
                                <p class="text-xs text-gray-400 mt-0.5 font-poppins">Ekspor data sebagai Excel</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

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
        <!-- Tabel untuk Desktop -->
        <div class="hidden md:block">
            <table class="min-w-full text-left border-collapse">
                <thead class="text-white bg-blue-900">
                    <tr>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">Nama</th>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">Tanggal</th>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">Waktu Masuk</th>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">Waktu Pulang</th>
                        <th class="px-6 py-4 text-sm font-medium font-poppins">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactionGates)): ?>
                        <?php foreach ($transactionGates as $transactionGate): ?>
                            <tr class="border-t hover:bg-gray-100">
                                <td class="px-6 py-4 text-sm font-poppins"><?= $transactionGate['full_name'] ?></td>
                                <td class="px-6 py-4 text-sm font-poppins"><?= $transactionGate['date'] ?></td>
                                <td class="px-6 py-4 text-sm font-poppins"><?= $transactionGate['check_in'] ?></td>
                                <td class="px-6 py-4 text-sm font-poppins"><?= $transactionGate['check_out'] ?></td>
                                <td class="px-6 py-4 text-sm space-x-2 font-poppins">
                                    <a href="/transaction/gates/<?= $transactionGate['id'] ?>" class="px-4 py-2 text-white bg-green-500 rounded-md hover:bg-green-600">Detail</a>
                                    <a href="/transaction/gates/<?= $transactionGate['id'] ?>/edit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Edit</a>
                                    <a href="/transaction/gates/<?= $transactionGate['id'] ?>/delete" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">Hapus</a>
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

        <!-- Card untuk Mobile -->
        <div class="block md:hidden font-poppins">
            <?php if (!empty($transactionGates)): ?>
                <div class="divide-y">
                    <?php foreach ($transactionGates as $transactionGate): ?>
                        <div class="p-4 space-y-3">
                            <!-- Nama -->
                            <div class="font-medium font-poppins">
                                <?= $transactionGate['full_name'] ?>
                            </div>

                            <!-- Informasi Waktu -->
                            <div class="space-y-1 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Tanggal:</span>
                                    <span><?= $transactionGate['date'] ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Waktu Masuk:</span>
                                    <span><?= $transactionGate['check_in'] ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Waktu Pulang:</span>
                                    <span><?= $transactionGate['check_out'] ?></span>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex flex-wrap gap-2 pt-2">
                                <a href="/transaction/gates/<?= $transactionGate['id'] ?>"
                                    class="px-4 py-2 text-sm text-white bg-green-500 rounded-md hover:bg-green-600">Detail</a>
                                <a href="/transaction/gates/<?= $transactionGate['id'] ?>/edit"
                                    class="px-4 py-2 text-sm text-white bg-blue-500 rounded-md hover:bg-blue-600">Edit</a>
                                <a href="/transaction/gates/<?= $transactionGate['id'] ?>/delete"
                                    class="px-4 py-2 text-sm text-white bg-red-500 rounded-md hover:bg-red-600">Hapus</a>
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
</main>
<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdownMenu');
        const button = event.target.closest('button');
        if (!button && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>