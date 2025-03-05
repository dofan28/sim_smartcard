<?php

function getTotalStudents2($db)
{
    $students = getAllStudents($db);
    return count($students);
}


function getTotalTransactions($db)
{
    $students = getAllTransactions($db);
    return count($students);
}


function getTotalLogs2($db)
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
                    <h3 class="font-semibold text-white text-md font-poppins">Total Siswa</h3>
                    <p class="mt-2 text-2xl font-bold text-amber-400"><?= getTotalStudents2($db); ?></p>
                </div>
                <div class="p-4 bg-blue-900 border-2 rounded-md shadow border-amber-400">
                    <h3 class="font-semibold text-white text-md font-poppins">Total Log Akses</h3>
                    <p class="mt-2 text-2xl font-bold text-amber-400"><?= getTotalTransactions($db); ?></p>
                </div>
                <div class="p-4 bg-blue-900 border-2 rounded-md shadow border-amber-400">
                    <h3 class="font-semibold text-white text-md font-poppins">Total Log Aktivitas</h3>
                    <p class="mt-2 text-2xl font-bold text-amber-400"><?= getTotalLogs2($db); ?></p>
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
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div class="space-y-6 md:col-span-2">
                <!-- Data Siswa Section -->
                <section id="data-siswa">
                    <div class="flex flex-col items-center justify-between mb-4 md:flex-row">
                        <h2 class="mb-2 text-xl font-semibold text-blue-900 font-poppins md:mb-0">Data Siswa</h2>
                        <a href="/students" class="text-sm text-blue-900 font-poppins hover:font-semibold">Lihat Selengkapnya ></a>
                    </div>

                    <!-- Tampilan Desktop -->
                    <div class="hidden overflow-x-auto bg-white border rounded-md shadow md:block">
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
                                                    <span class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded-full">Aktif</span>
                                                <?php elseif ($limitedStudent['status'] == 'inactive'): ?>
                                                    <span class="px-2 py-1 text-xs text-red-800 bg-red-100 rounded-full">Tidak Aktif</span>
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
                    <div class="space-y-4 md:hidden">
                        <?php if (!empty($limitedStudents)): ?>
                            <?php foreach ($limitedStudents as $limitedStudent): ?>
                                <div class="p-4 bg-white border rounded-md shadow-md">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h3 class="text-base font-bold text-blue-900 font-poppins"><?= $limitedStudent['full_name'] ?></h3>
                                            <p class="text-sm text-gray-600 font-poppins">Kelas: <?= $limitedStudent['class'] ?></p>
                                        </div>
                                        <span class="
                                <?= $limitedStudent['status'] == 'active' ? 'bg-green-100 text-green-800 font-poppins' : 'bg-red-100 font-poppins text-red-800' ?> 
                                px-2 py-1 rounded-full text-xs">
                                            <?= $limitedStudent['status'] == 'active' ? 'Aktif' : 'Tidak Aktif' ?>
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 pt-2 mt-2 text-sm border-t">
                                        <div class="text-gray-600">
                                            <span class="text-xs font-medium font-poppins">UID:</span>
                                            <p class="text-xs"><?= $limitedStudent['uid'] ?></p>
                                        </div>
                                        <div class="text-gray-600">
                                            <span class="text-xs font-medium font-poppins">NIS:</span>
                                            <p class="text-xs"><?= $limitedStudent['nis'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="p-4 text-center text-red-400 bg-white rounded-md shadow-md font-poppins">
                                --- Tidak ada data. ---
                            </div>
                        <?php endif ?>
                    </div>
                </section>

                <!-- Log Akses Section -->
                <section>
                    <div class="flex flex-col items-center justify-between mb-4 md:flex-row">
                        <h2 class="mb-2 text-xl font-semibold text-blue-900 font-poppins md:mb-0">Log Akses</h2>
                    </div>

                    <!-- Tampilan Desktop -->
                    <div class="hidden overflow-x-auto bg-white border rounded-md shadow md:block">
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
                                                    <span class="px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full">Transportasi</span>
                                                <?php elseif ($limitedStudent['type_transaction'] == 'gate'): ?>
                                                    <span class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded-full">Gerbang</span>
                                                <?php elseif ($limitedStudent['type_transaction'] == 'class'): ?>
                                                    <span class="px-2 py-1 text-xs text-yellow-800 bg-yellow-100 rounded-full">Kelas</span>
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
                    <div class="space-y-4 md:hidden">
                        <?php if (!empty($limitedTransactionJoinStudents)): ?>
                            <?php foreach ($limitedTransactionJoinStudents as $limitedStudent): ?>
                                <div class="p-4 bg-white border rounded-md shadow-md font-poppins">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h3 class="text-base font-bold text-blue-900"><?= $limitedStudent['full_name'] ?></h3>
                                            <div class="mt-1">
                                                <?php if ($limitedStudent['type_transaction'] == 'transportation'): ?>
                                                    <span class="px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full">Transportasi</span>
                                                <?php elseif ($limitedStudent['type_transaction'] == 'gate'): ?>
                                                    <span class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded-full">Gerbang</span>
                                                <?php elseif ($limitedStudent['type_transaction'] == 'class'): ?>
                                                    <span class="px-2 py-1 text-xs text-yellow-800 bg-yellow-100 rounded-full">Kelas</span>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-600"><?= $limitedStudent['date'] ?></span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 pt-2 mt-2 text-sm border-t">
                                        <div class="text-green-600">
                                            <span class="text-xs font-medium">Waktu Masuk:</span>
                                            <p class="text-xs"><?= $limitedStudent['check_in'] ?></p>
                                        </div>
                                        <div class="text-red-600">
                                            <span class="text-xs font-medium">Waktu Pulang:</span>
                                            <p class="text-xs"><?= $limitedStudent['check_out'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="p-4 text-center text-red-400 bg-white rounded-md shadow-md">
                                --- Tidak ada data. ---
                            </div>
                        <?php endif ?>
                    </div>
                </section>
            </div>

            <!-- Log Aktivitas Section -->
            <div class="container md:col-span-1">
                <section>
                    <div class="flex flex-col items-center justify-between mb-4 md:flex-row">
                        <h2 class="mb-2 text-xl font-semibold text-blue-900 font-poppins md:mb-0">Log Aktivitas</h2>
                        <a href="/logs" class="text-sm text-blue-900 font-poppins hover:font-semibold">Lihat Selengkapnya ></a>
                    </div>

                    <!-- Tampilan Desktop -->
                    <div class="hidden overflow-x-auto bg-white border rounded-md shadow md:block font-poppins">
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
                                                <span class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded-full">
                                                    <?= $limitedLog['created_at'] ?>
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm font-poppins">
                                                <span class="px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full">
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
                    <div class="space-y-4 md:hidden font-poppins">
                        <?php if (!empty($limitedLogs)): ?>
                            <?php foreach ($limitedLogs as $limitedLog): ?>
                                <div class="p-4 bg-white border rounded-md shadow-md">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <h3 class="text-base font-bold text-blue-900">UID: <?= $limitedLog['uid'] ?></h3>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2 pt-2 mt-2 text-sm border-t">
                                        <div class="text-green-600">
                                            <span class="text-xs font-medium">Dibuat:</span>
                                            <p class="text-xs"><?= $limitedLog['created_at'] ?></p>
                                        </div>
                                        <div class="text-blue-600">
                                            <span class="text-xs font-medium">Diperbarui:</span>
                                            <p class="text-xs"><?= $limitedLog['updated_at'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="p-4 text-center text-red-400 bg-white rounded-md shadow-md font-poppins">
                                --- Tidak ada data. ---
                            </div>
                        <?php endif ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

</main>