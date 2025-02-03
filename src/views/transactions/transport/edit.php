<?php



$transactionId = $matches[1];

if ($transactionId) {
    // Ambil data transaksi berdasarkan ID
    $transaction_id = $transactionId;

    $transaction = getTransactionTransportById($db, $transaction_id);

    // Pastikan transaksi ditemukan
    if (!$transaction) {
        echo "Transaksi tidak ditemukan.";
        exit;
    }
} else {
    header("Location: /transaction/transports");
    exit;
}

$students = getAllStudents($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = !empty($_POST["student_id"]) ? htmlspecialchars($_POST["student_id"]) : null;
    $date = !empty($_POST["date"]) ? htmlspecialchars($_POST["date"]) : null;
    $check_in = !empty($_POST["check_in"]) ? htmlspecialchars($_POST["check_in"]) : null;
    $check_out = !empty($_POST["check_out"]) ? htmlspecialchars($_POST["check_out"]) : null;

    $errors = [];

    // Validasi UID (minimal 5 karakter)
    if (empty($student_id)) {
        $errors[] = "ID Siswa harus diisi.";
    }

    // Validasi NIS (hanya angka, minimal 5 karakter)
    if (empty($date)) {
        $errors[] = "Tanggal harus diisi.";
    }

    // Validasi Nama Lengkap (minimal 3 karakter)
    if (empty($check_in)) {
        $errors[] = "Waktu masuk harus diisi.";
    }

    // Validasi Kelas (hanya huruf dan angka)
    if (empty($check_out)) {
        $errors[] = "Waktu pulang harus diisi.";
    }


    // Jika ada kesalahan
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: /transaction/transports/{$transaction_id}/edit");
        exit;
    }

    $addTransaction = updateTransactionTransports($db, $transaction_id, $student_id, $date, $check_in, $check_out);

    if ($addTransaction) {
        echo "
        <script>
            alert('Data berhasil diperbaruhi.');
            document.location.href = '/transaction/transports';
        </script>
        ";
    } else {
        echo "
            <script>
            alert('Data gagal diperbaruhi.');
            document.location.href = '/students/{$transaction_id}/edit';
        </script>";
    }
}
?>
<main class="container px-6 py-12 mx-auto">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-3xl font-semibold tracking-wide text-blue-900 font-poppins">Edit Log Akses Transportasi</h1>
    </header>
    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
            <ul class="px-4 list-disc">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li class="text-sm font-poppins"><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form Edit Data -->
    <form method="POST" class="p-6 bg-white rounded-md shadow-md">
        <div class="mb-4">
            <label for="student_id" class="block text-sm font-medium text-gray-800 font-poppins">Mahasiswa</label>
            <input type="text" id="student_id" name="student_id"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                required value="<?= isset($_SESSION['old_data']['student_id']) ? $_SESSION['old_data']['student_id'] : $transaction['full_name'] ?>" disabled>
        </div>
        <input type="text" id="student_id" name="student_id"
            class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
            required value="<?= isset($_SESSION['old_data']['student_id']) ? $_SESSION['old_data']['student_id'] : $transaction['student_id'] ?>" hidden>
        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-800 font-poppins">Tanggal</label>
            <input type="date" id="date" name="date"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                required value="<?= isset($_SESSION['old_data']['date']) ? $_SESSION['old_data']['date'] : $transaction['date'] ?>">
        </div>
        <div class="mb-4">
            <label for="check_in" class="block text-sm font-medium text-gray-800 font-poppins">Waktu Masuk</label>
            <input type="time" id="check_in" name="check_in"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                required value="<?= isset($_SESSION['old_data']['check_in']) ? $_SESSION['old_data']['check_in'] : $transaction['check_in'] ?>">
        </div>
        <div class="mb-4">
            <label for="check_out" class="block text-sm font-medium text-gray-800 font-poppins">Waktu Pulang</label>
            <input type="time" id="check_out" name="check_out"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                required value="<?= isset($_SESSION['old_data']['check_out']) ? $_SESSION['old_data']['check_out'] : $transaction['check_out'] ?>">
        </div>
        <div class="flex justify-between">
            <button type="reset"
                class="px-6 py-2 text-sm text-gray-800 bg-gray-300 rounded-md font-poppins hover:bg-gray-400">
                Reset
            </button>
            <button type="submit"
                class="px-6 py-2 text-sm text-white bg-blue-800 rounded-md font-poppins hover:bg-blue-900">
                Perbarui
            </button>
        </div>
    </form>
</main>

<?php
unset($_SESSION['errors']);
unset($_SESSION['old_data']);
?>