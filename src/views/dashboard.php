<?php

function getTotalStudents($db)
{
    $students = getAllStudents($db);
    return count($students);
}


function getTotalTransactions($db)
{
    $students = getAllTransactions($db);
    return count($students);
}


function getTotalLogs($db)
{
    $students = getAllLogs($db);
    return count($students);
}
$limitedStudents = getLimitedStudents($db);

$limitedTransactionJoinStudents = getLimitedTransactionJoinStudents($db);

$limitedLogs = getLimitedlLogs($db);

?>

<main class="container px-6 py-8 mx-auto">
    <section class="mb-12">
        <div class="p-6 bg-white border-2 rounded-md shadow ">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="p-4 bg-blue-900 border-2 rounded-md shadow border-amber-400">
                    <h3 class="text-md font-semibold text-white font-poppins">Total Siswa</h3>
                    <p class="mt-2 text-2xl font-bold text-amber-400"><?= getTotalStudents($db); ?></p>
                </div>
                <div class="p-4 bg-blue-900 border-2 rounded-md shadow border-amber-400">
                    <h3 class="text-md font-semibold text-white font-poppins">Total Log Akses</h3>
                    <p class="mt-2 text-2xl font-bold text-amber-400"><?= getTotalTransactions($db); ?></p>
                </div>
                <div class="p-4 bg-blue-900 border-2 rounded-md shadow border-amber-400">
                    <h3 class="text-md font-semibold text-white font-poppins">Total Log Aktivitas</h3>
                    <p class="mt-2 text-2xl font-bold text-amber-400"><?= getTotalLogs($db); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- <section id="scan-kartu" class="mb-12">
        <h2 class="mb-4 text-2xl font-semibold text-blue-900 font-poppins">Scan Kartu</h2>
        <div class="p-6 bg-white rounded-md shadow">
            <p class="mb-4 text-gray-700">Silakan tempelkan kartu Anda pada scanner untuk melanjutkan.</p>
            <button class="px-4 py-2 text-white rounded-md bg-amber-400 hover:bg-amber-500">Scan Kartu</button>
        </div>
    </section> -->
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <!-- Data Siswa Section -->
                <section id="data-siswa">
                    <div class="flex flex-col md:flex-row items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-blue-900 font-poppins mb-2 md:mb-0">Data Siswa</h2>
                        <a href="/students" class="text-sm text-blue-900 font-poppins hover:font-semibold">Lihat Selengkapnya ></a>
                    </div>

                    <!-- Tampilan Desktop -->
                    <div class="hidden md:block overflow-x-auto bg-white border rounded-md shadow">
                        <table class="min-w-full text-left border-collapse">
                            <thead class="text-white bg-blue-900">
                                <tr>
                                    <th class="px-4 py-3 text-sm font-medium font-poppins">UID</th>
                                    <th class="px-4 py-3 text-sm font-medium font-poppins">NIS</th>
                                    <th class="px-4 py-3 text-sm font-medium font-poppins">Nama</th>
                                    <th class="px-4 py-3 text-sm font-medium font-poppins">Kelas</th>
                                    <th class="px-4 py-3 text-sm font-medium font-poppins">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($limitedStudents)): ?>
                                    <?php foreach ($limitedStudents as $limitedStudent): ?>
                                        <tr class="border-t hover:bg-gray-100">
                                            <td class="px-4 py-3 text-sm font-poppins"><?= $limitedStudent['uid'] ?></td>
                                            <td class="px-4 py-3 text-sm font-poppins"><?= $limitedStudent['nis'] ?></td>
                                            <td class="px-4 py-3 text-sm font-poppins"><?= $limitedStudent['full_name'] ?></td>
                                            <td class="px-4 py-3 text-sm font-poppins"><?= $limitedStudent['class'] ?></td>
                                            <td class="px-4 py-3 text-sm font-poppins">
                                                <?php if ($limitedStudent['status'] == 'active'): ?>
                                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Aktif</span>
                                                <?php elseif ($limitedStudent['status'] == 'inactive'): ?>
                                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Tidak Aktif</span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-sm text-center text-red-400 font-poppins">
                                            --- Tidak ada data. ---
                                        </td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tampilan Mobile -->
                    <div class="md:hidden space-y-4">
                        <?php if (!empty($limitedStudents)): ?>
                            <?php foreach ($limitedStudents as $limitedStudent): ?>
                                <div class="bg-white shadow-md rounded-md p-4 border">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-bold font-poppins text-blue-900 text-base"><?= $limitedStudent['full_name'] ?></h3>
                                            <p class="text-sm font-poppins text-gray-600">Kelas: <?= $limitedStudent['class'] ?></p>
                                        </div>
                                        <span class="
                                <?= $limitedStudent['status'] == 'active' ? 'bg-green-100 text-green-800 font-poppins' : 'bg-red-100 font-poppins text-red-800' ?> 
                                px-2 py-1 rounded-full text-xs">
                                            <?= $limitedStudent['status'] == 'active' ? 'Aktif' : 'Tidak Aktif' ?>
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 text-sm border-t pt-2 mt-2">
                                        <div class="text-gray-600">
                                            <span class="font-medium font-poppins text-xs">UID:</span>
                                            <p class="text-xs"><?= $limitedStudent['uid'] ?></p>
                                        </div>
                                        <div class="text-gray-600">
                                            <span class="font-medium font-poppins text-xs">NIS:</span>
                                            <p class="text-xs"><?= $limitedStudent['nis'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="bg-white shadow-md font-poppins rounded-md p-4 text-center text-red-400">
                                --- Tidak ada data. ---
                            </div>
                        <?php endif ?>
                    </div>
                </section>

                <!-- Log Akses Section -->
                <section>
                    <div class="flex flex-col md:flex-row items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-blue-900 font-poppins mb-2 md:mb-0">Log Akses</h2>
                    </div>

                    <!-- Tampilan Desktop -->
                    <div class="hidden md:block overflow-x-auto bg-white border rounded-md shadow">
                        <table class="min-w-full text-left border-collapse">
                            <thead class="text-white bg-blue-900">
                                <tr>
                                    <th class="px-4 py-3 text-sm font-medium font-poppins">Nama</th>
                                    <th class="px-4 py-3 text-sm font-medium font-poppins">Tipe</th>
                                    <th class="px-4 py-3 text-sm font-medium font-poppins">Tanggal</th>
                                    <th class="px-4 py-3 text-sm font-medium font-poppins">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($limitedTransactionJoinStudents)): ?>
                                    <?php foreach ($limitedTransactionJoinStudents as $limitedStudent): ?>
                                        <tr class="border-t hover:bg-gray-100">
                                            <td class="px-4 py-3 text-sm font-poppins"><?= $limitedStudent['full_name'] ?></td>
                                            <td class="px-4 py-3 text-sm font-poppins">
                                                <?php if ($limitedStudent['type_transaction'] == 'transportation'): ?>
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Transportasi</span>
                                                <?php elseif ($limitedStudent['type_transaction'] == 'gate'): ?>
                                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Gerbang</span>
                                                <?php elseif ($limitedStudent['type_transaction'] == 'class'): ?>
                                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Kelas</span>
                                                <?php endif ?>
                                            </td>
                                            <td class="px-4 py-3 text-sm font-poppins"><?= $limitedStudent['date'] ?></td>
                                            <td class="px-4 py-3 text-sm font-poppins">
                                                <div class="flex flex-col">
                                                    <span class="text-green-600">Masuk: <?= $limitedStudent['check_in'] ?></span>
                                                    <span class="text-red-600">Pulang: <?= $limitedStudent['check_out'] ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-sm text-center text-red-400 font-poppins">
                                            --- Tidak ada data. ---
                                        </td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tampilan Mobile -->
                    <div class="md:hidden space-y-4">
                        <?php if (!empty($limitedTransactionJoinStudents)): ?>
                            <?php foreach ($limitedTransactionJoinStudents as $limitedStudent): ?>
                                <div class="bg-white shadow-md font-poppins rounded-md p-4 border">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-bold text-blue-900 text-base"><?= $limitedStudent['full_name'] ?></h3>
                                            <div class="mt-1">
                                                <?php if ($limitedStudent['type_transaction'] == 'transportation'): ?>
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Transportasi</span>
                                                <?php elseif ($limitedStudent['type_transaction'] == 'gate'): ?>
                                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Gerbang</span>
                                                <?php elseif ($limitedStudent['type_transaction'] == 'class'): ?>
                                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Kelas</span>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-600"><?= $limitedStudent['date'] ?></span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 text-sm border-t pt-2 mt-2">
                                        <div class="text-green-600">
                                            <span class="font-medium text-xs">Waktu Masuk:</span>
                                            <p class="text-xs"><?= $limitedStudent['check_in'] ?></p>
                                        </div>
                                        <div class="text-red-600">
                                            <span class="font-medium text-xs">Waktu Pulang:</span>
                                            <p class="text-xs"><?= $limitedStudent['check_out'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="bg-white shadow-md rounded-md p-4 text-center text-red-400">
                                --- Tidak ada data. ---
                            </div>
                        <?php endif ?>
                    </div>
                </section>
            </div>

            <!-- Log Aktivitas Section -->
            <div class="md:col-span-1 container">
                <section>
                    <div class="flex flex-col md:flex-row items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-blue-900 font-poppins mb-2 md:mb-0">Log Aktivitas</h2>
                        <a href="/logs" class="text-sm text-blue-900 font-poppins hover:font-semibold">Lihat Selengkapnya ></a>
                    </div>

                    <!-- Tampilan Desktop -->
                    <div class="hidden md:block overflow-x-auto font-poppins bg-white border rounded-md shadow">
                        <table class="min-w-full text-left border-collapse">
                            <thead class="text-white bg-blue-900">
                                <tr>
                                    <th class="px-4 py-3 text-sm font-medium font-poppins">UID</th>
                                    <th class="px-4 py-3 text-sm font-medium font-poppins">Dibuat</th>
                                    <th class="px-4 py-3 text-sm font-medium font-poppins">Diperbarui</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($limitedLogs)): ?>
                                    <?php foreach ($limitedLogs as $limitedLog): ?>
                                        <tr class="border-t hover:bg-gray-100">
                                            <td class="px-4 py-3 text-sm font-poppins"><?= $limitedLog['uid'] ?></td>
                                            <td class="px-4 py-3 text-sm font-poppins">
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                                    <?= $limitedLog['created_at'] ?>
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm font-poppins">
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                                                    <?= $limitedLog['updated_at'] ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-sm text-center text-red-400 font-poppins">
                                            --- Tidak ada data. ---
                                        </td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tampilan Mobile -->
                    <div class="md:hidden space-y-4 font-poppins">
                        <?php if (!empty($limitedLogs)): ?>
                            <?php foreach ($limitedLogs as $limitedLog): ?>
                                <div class="bg-white shadow-md rounded-md p-4 border">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-bold text-blue-900 text-base">UID: <?= $limitedLog['uid'] ?></h3>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 text-sm border-t pt-2 mt-2">
                                        <div class="text-green-600">
                                            <span class="font-medium text-xs">Dibuat:</span>
                                            <p class="text-xs"><?= $limitedLog['created_at'] ?></p>
                                        </div>
                                        <div class="text-blue-600">
                                            <span class="font-medium text-xs">Diperbarui:</span>
                                            <p class="text-xs"><?= $limitedLog['updated_at'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="bg-white shadow-md rounded-md font-poppins p-4 text-center text-red-400">
                                --- Tidak ada data. ---
                            </div>
                        <?php endif ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

</main>