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
                    <h3 class="text-lg font-semibold text-white font-poppins">Total Siswa</h3>
                    <p class="mt-2 text-2xl font-bold text-amber-400"><?= getTotalStudents($db); ?></p>
                </div>
                <div class="p-4 bg-blue-900 border-2 rounded-md shadow border-amber-400">
                    <h3 class="text-lg font-semibold text-white font-poppins">Total Log Akses</h3>
                    <p class="mt-2 text-2xl font-bold text-amber-400"><?= getTotalTransactions($db); ?></p>
                </div>
                <div class="p-4 bg-blue-900 border-2 rounded-md shadow border-amber-400">
                    <h3 class="text-lg font-semibold text-white font-poppins">Total Log Aktivitas</h3>
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
    <div class="grid grid-cols-3 gap-12">
        <div class="col-span-2">
            <section id="data-siswa">
                <div class="flex items-center justify-between">
                    <h2 class="mb-4 text-xl font-semibold text-blue-900 font-poppins">Data Siswa</h2>
                    <a href="/students" class="mr-4 text-sm text-blue-900 font-poppins hover:font-semibold">Lihat Selengkapnya ></a>
                </div>
                <div class="overflow-hidden bg-white border rounded-md shadow">
                    <table class="min-w-full text-left border-collapse">
                        <thead class="text-white bg-blue-900">
                            <tr>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">UID</th>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">NIS</th>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">Nama</th>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">Kelas</th>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($limitedStudents)): ?>
                                <?php foreach ($limitedStudents as $limitedStudent): ?>
                                    <tr class="border-t hover:bg-gray-100">
                                        <td class="px-6 py-4 text-sm font-poppins"><?= $limitedStudent['uid'] ?></td>
                                        <td class="px-6 py-4 text-sm font-poppins"><?= $limitedStudent['nis'] ?></td>

                                        <td class="px-6 py-4 text-sm font-poppins"><?= $limitedStudent['full_name'] ?></td>
                                        <td class="px-6 py-4 text-sm font-poppins"><?= $limitedStudent['class'] ?></td>
                                        <td class="px-6 py-4 text-sm font-poppins">
                                            <?php if ($limitedStudent['status'] == 'active'): ?>
                                                Aktif
                                            <?php elseif ($limitedStudent['status'] == 'inactive'): ?>
                                                Tidak Aktif
                                            <?php endif ?>
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
            </section>
            <section id="" class="my-6">
                <div class="flex items-center justify-between">
                    <h2 class="mb-4 text-xl font-semibold text-blue-900 font-poppins">Log Akses</h2>
                    <!-- <a href="/transactions" class="mr-4 text-sm text-blue-900 font-poppins hover:font-semibold">Lihat Selengkapnya></a> -->
                </div>
                <div class="overflow-hidden bg-white border rounded-md shadow">
                    <table class="min-w-full text-left border-collapse">
                        <thead class="text-white bg-blue-900">
                            <tr>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">Nama</th>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">Tipe</th>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">Tanggal</th>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">Waktu Masuk</th>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">Waktu Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($limitedTransactionJoinStudents)): ?>
                                <?php foreach ($limitedTransactionJoinStudents as $limitedStudent): ?>
                                    <tr class="border-t hover:bg-gray-100">
                                        <td class="px-6 py-4 text-sm font-poppins"><?= $limitedStudent['full_name'] ?></td>
                                        <td class="px-6 py-4 text-sm font-poppins">

                                            <?php if ($limitedStudent['type_transaction'] == 'transportation'): ?>
                                                Transportasi
                                            <?php elseif ($limitedStudent['type_transaction'] == 'gate'): ?>
                                                Gerbang
                                            <?php elseif ($limitedStudent['type_transaction'] == 'class'): ?>
                                                Kelas
                                            <?php endif ?>

                                        </td>
                                        <td class="px-6 py-4 text-sm font-poppins"><?= $limitedStudent['date'] ?></td>
                                        <td class="px-6 py-4 text-sm font-poppins"><?= $limitedStudent['check_in'] ?></td>
                                        <td class="px-6 py-4 text-sm font-poppins"><?= $limitedStudent['check_out'] ?></td>
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
            </section>
        </div>
        <div class="col-span-1">
            <section id="data-siswa">
                <div class="flex items-center justify-between">
                    <h2 class="mb-4 text-xl font-semibold text-blue-900 font-poppins">Log Aktivitas</h2>
                    <a href="/logs" class="mr-4 text-sm text-blue-900 font-poppins hover:font-semibold">Lihat Selengkapnya ></a>
                </div>
                <div class="overflow-hidden bg-white border rounded-md shadow">
                    <table class="min-w-full text-left border-collapse">
                        <thead class="text-white bg-blue-900">
                            <tr>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">UID</th>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">Waktu Dibuat</th>
                                <th class="px-6 py-4 text-sm font-medium font-poppins">Waktu Diperbaruhi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($limitedLogs)): ?>
                                <?php foreach ($limitedLogs as $limitedLog): ?>
                                    <tr class="border-t hover:bg-gray-100">
                                        <td class="px-6 py-4 text-sm font-poppins"><?= $limitedLog['uid'] ?></td>
                                        <td class="px-6 py-4 text-sm font-poppins"><?= $limitedLog['created_at'] ?></td>
                                        <td class="px-6 py-4 text-sm font-poppins"><?= $limitedLog['updated_at'] ?></td>

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
            </section>
        </div>
    </div>

</main>