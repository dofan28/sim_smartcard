<?php
if (!isset($_SESSION['login'])) {
    header("Location: /login");
    exit;
}

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



?>

<!-- Main Content -->
<main class="container px-6 py-8 mx-auto">
    <section class="mb-12">
        <div class="p-6 bg-white rounded-md shadow">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="p-4 bg-blue-900 rounded-md shadow">
                    <h3 class="text-lg font-semibold text-white font-poppins">Total Siswa</h3>
                    <p class="mt-2 text-2xl font-bold text-amber-400"><?= getTotalStudents($db); ?></p>
                </div>
                <div class="p-4 bg-blue-900 rounded-md shadow">
                    <h3 class="text-lg font-semibold text-white font-poppins">Total Kehadiran Siswa</h3>
                    <p class="mt-2 text-2xl font-bold text-amber-400"><?= getTotalTransactions($db); ?></p>
                </div>
                <div class="p-4 bg-blue-900 rounded-md shadow">
                    <h3 class="text-lg font-semibold text-white font-poppins">Total Log Aktivitas</h3>
                    <p class="mt-2 text-2xl font-bold text-amber-400"><?= getTotalLogs($db); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Scan Kartu Section -->
    <section id="scan-kartu" class="mb-12">
        <h2 class="mb-4 text-2xl font-bold text-blue-900">Scan Kartu</h2>
        <div class="p-6 bg-white rounded-md shadow">
            <p class="mb-4 text-gray-700">Silakan tempelkan kartu Anda pada scanner untuk melanjutkan.</p>
            <button class="px-4 py-2 text-white rounded-md bg-amber-400 hover:bg-amber-500">Scan Kartu</button>
        </div>
    </section>

    <!-- Data Siswa Section -->
    <section id="data-siswa" class="mb-12">
        <h2 class="mb-4 text-2xl font-bold text-blue-900">Data Siswa</h2>
        <div class="overflow-hidden bg-white rounded-md shadow">
            <table class="min-w-full border border-collapse border-gray-200">
                <thead class="text-white bg-blue-900">
                    <tr>
                        <th class="px-4 py-2 border border-gray-200">No</th>
                        <th class="px-4 py-2 border border-gray-200">Nama</th>
                        <th class="px-4 py-2 border border-gray-200">Kelas</th>
                        <th class="px-4 py-2 border border-gray-200">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-2 border border-gray-200">1</td>
                        <td class="px-4 py-2 border border-gray-200">Ali Ahmad</td>
                        <td class="px-4 py-2 border border-gray-200">5A</td>
                        <td class="px-4 py-2 border border-gray-200">Aktif</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border border-gray-200">2</td>
                        <td class="px-4 py-2 border border-gray-200">Siti Nurhaliza</td>
                        <td class="px-4 py-2 border border-gray-200">6B</td>
                        <td class="px-4 py-2 border border-gray-200">Aktif</td>
                    </tr>
                    <!-- Data lainnya -->
                </tbody>
            </table>
        </div>
    </section>
</main>