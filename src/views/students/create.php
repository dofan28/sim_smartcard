<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = !empty($_POST["uid"]) ? htmlspecialchars($_POST["uid"]) : null;
    $nis = !empty($_POST["nis"]) ? htmlspecialchars($_POST["nis"]) : null;
    $email = !empty($_POST["email"]) ? htmlspecialchars($_POST["email"]) : null;
    $full_name = !empty($_POST["full_name"]) ? htmlspecialchars($_POST["full_name"]) : null;
    $class = !empty($_POST["class"]) ? htmlspecialchars($_POST["class"]) : null;
    $address = !empty($_POST["address"]) ? htmlspecialchars($_POST["address"]) : null;
    $phone = !empty($_POST["phone"]) ? htmlspecialchars($_POST["phone"]) : null;
    $status = !empty($_POST["status"]) ? htmlspecialchars($_POST["status"]) : null;

    $errors = [];

    function isUnique($db, $column, $value)
    {
        $stmt = $db->prepare("SELECT COUNT(*) FROM students WHERE $column = :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetchColumn() == 0;
    }

    // Validasi UID (minimal 5 karakter)
    if (empty($uid) || strlen($uid) < 5) {
        $errors[] = "UID harus diisi dengan minimal 5 karakter.";
    } elseif (!isUnique($db, 'uid', $uid)) {
        $errors[] = "UID sudah digunakan, silakan gunakan UID lain.";
    }

    // Validasi NIS (hanya angka, minimal 5 karakter)
    if (empty($nis) || !ctype_digit($nis) || strlen($nis) < 5) {
        $errors[] = "NIS harus berupa angka dan minimal 5 karakter.";
    } elseif (!isUnique($db, 'nis', $nis)) {
        $errors[] = "NIS sudah terdaftar, silakan gunakan NIS lain.";
    }

    // Validasi Email (harus diisi dan format email yang valid)
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email harus diisi dengan format yang valid.";
    } elseif (!isUnique($db, 'email', $email)) {
        $errors[] = "Email sudah digunakan, silakan gunakan email lain.";
    }


    // Validasi Nama Lengkap (minimal 3 karakter)
    if (empty($full_name) || strlen($full_name) < 3) {
        $errors[] = "Nama lengkap harus diisi dengan minimal 3 karakter.";
    }

    // Validasi Kelas (hanya huruf dan angka)
    if (empty($class) || !preg_match('/^[a-zA-Z0-9\s]+$/', $class)) {
        $errors[] = "Kelas hanya boleh mengandung huruf, angka, dan spasi.";
    }

    // Validasi Alamat (tidak boleh kosong)
    if (empty($address)) {
        $errors[] = "Alamat tidak boleh kosong.";
    }

    // Validasi Nomor HP (hanya angka, minimal 10 karakter, maksimal 15 karakter)
    if (empty($phone) || !ctype_digit($phone) || strlen($phone) < 10 || strlen($phone) > 15) {
        $errors[] = "Nomor HP harus berupa angka dan memiliki panjang antara 10 hingga 15 karakter.";
    }

    // Validasi Status (aktif atau tidak aktif)
    if (empty($status) || !in_array($status, ['active', 'inactive'])) {
        $errors[] = "Status harus dipilih antara 'Aktif' atau 'Tidak Aktif'.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: /students/create");
        exit;
    }

    $addStudent = storeStudent($db, $uid, $nis, $email, $full_name, $class, $address, $phone, $status);

    if ($addStudent) {
        echo "
        <script>
            alert('Data berhasil ditambahkan');
            document.location.href = '/students';
        </script>
        ";
    } else {
        echo "
            <script>
            alert('Data gagal ditambahkan');
            document.location.href = '/students/create';
        </script>";
    }
}
?>

<!-- Main Content -->
<main class="container px-6 py-12 mx-auto">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-3xl font-semibold tracking-wide text-blue-900 font-poppins">Buat Data Siswa</h1>
        <p class="mt-2 text-sm text-gray-800 font-poppins">Isi formulir di bawah ini untuk menambahkan data Siswa baru. Pastikan Anda memiliki kartu fisik (Card) untuk membaca UID yang akan digunakan dalam formulir ini.</p>
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
    <!-- Form Tambah Data -->
    <form method="POST" class="p-6 bg-white rounded-md shadow-md">
        <div class="p-2 rounded-md bg-amber-100">
            <span class="mb-2 text-xs font-medium text-gray-600 font-poppins"> <span class="text-xs text-red-400">*</span>
                <span class="font-semibold text-gray-800">Perhatian:</span><br> Pengisian data UID dapat memilih secara manual ataupun otomatis, jika secara manual anda harus mengetahui UID dari kartu fisik anda dengan demikian dapat mengisi kolom masukkan UID yang telah disediakan, jika secara otomatis syaratnya pada saat ini kartu fisik (Card) ada ditangan anda, lalu tempelkan kartu fisik ke alat pembaca (Reader) yang nantinya masukkan UID secara otomatis diisi pada kolom masukkan UID yang tersedia.
            </span>
        </div>
        <div class="mt-4 mb-4">
            <label for="uid" class="block text-sm font-medium text-gray-800 font-poppins">Pilih metode untuk memasukkan UID</label>
            <div class="mt-2 space-x-2">
                <button type="button" id="manual-button"
                    class="py-1.5 rounded-md px-3 bg-amber-400 text-sm text-white font-poppins hover:bg-amber-600">
                    Manual
                </button>
                <button type="button" id="auto-button"
                    class="py-1.5 rounded-md px-3 bg-amber-400 text-sm text-white font-poppins hover:bg-amber-600">
                    Otomatis
                </button>
            </div>

            <!-- Input UID Manual -->
            <div id="manual-input-container" class="mt-4" hidden>
                <label for="uid-manual" class="block text-sm font-medium text-gray-800 font-poppins">UID</label>
                <input type="text" id="uid-manual" name="uid"
                    class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                    placeholder="Masukkan UID secara manual">
            </div>

            <!-- Input UID Otomatis -->
            <div id="auto-input-container" class="mt-4" hidden>
                <label class="block text-sm font-medium text-gray-800 font-poppins">UID</label>
                <input type="text" id="uid-auto" name="uid" placeholder="Masukkan UID secara otomatis"
                    class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins">
                <small class="block mt-1 text-xs text-gray-600 font-poppins">Data UID diambil dari kartu fisik (Card) yang terakhir ditempelkan pada alat pembaca (Reader). Jika ingin memasukkan data UID terbaru atau milik anda silakan tempelkan ke alat pembaca (Reader) lagi.</small>
            </div>
        </div>
        <div class="mb-4">
            <label for="nis" class="block text-sm font-medium text-gray-800 font-poppins">Nomor Induk Siswa (NIS)</label>
            <input type="text" id="nis" name="nis"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan nomor induk siswa (NIS)" required value="<?= isset($_SESSION['old_data']['nis']) ? $_SESSION['old_data']['nis'] : '' ?>">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-800 font-poppins">Email</label>
            <input type="text" id="email" name="email"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan email" required value="<?= isset($_SESSION['old_data']['email']) ? $_SESSION['old_data']['email'] : '' ?>">
        </div>
        <div class="mb-4">
            <label for="full_name" class="block text-sm font-medium text-gray-800 font-poppins">Nama Lengkap</label>
            <input type="text" id="full_name" name="full_name"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan nama lengkap" required value="<?= isset($_SESSION['old_data']['full_name']) ? $_SESSION['old_data']['full_name'] : '' ?>">
        </div>
        <div class="mb-4">
            <label for="class" class="block text-sm font-medium text-gray-800 font-poppins">Kelas</label>
            <input type="text" id="class" name="class"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan kelas" required value="<?= isset($_SESSION['old_data']['class']) ? $_SESSION['old_data']['class'] : '' ?>">
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-800 font-poppins">Nomor HP (Disarankan nomor HP orang tua jika ada)</label>
            <input type="text" id="phone" name="phone"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan nomor HP" required value="<?= isset($_SESSION['old_data']['phone']) ? $_SESSION['old_data']['phone'] : '' ?>">
        </div>
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-800 font-poppins">Alamat</label>
            <input type="text" id="address" name="address"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan alamat" required value="<?= isset($_SESSION['old_data']['address']) ? $_SESSION['old_data']['address'] : '' ?>">
        </div>
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-800 font-poppins">Status</label>
            <select id="status" name="status"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                required>
                <option value="" disabled selected>Pilih Status</option>
                <option value="active" <?= (isset($_SESSION['old_data']['status']) && $_SESSION['old_data']['status'] === 'active') ? 'selected' : '' ?>>Aktif</option>
                <option value="inactive" <?= (isset($_SESSION['old_data']['status']) && $_SESSION['old_data']['status'] === 'inactive') ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </div>

        <div class="flex justify-between">
            <button type="reset"
                class="px-6 py-2 text-sm text-gray-800 bg-gray-300 rounded-md font-poppins hover:bg-gray-400">
                Reset
            </button>
            <button type="submit"
                class="px-6 py-2 text-sm text-white bg-blue-800 rounded-md font-poppins hover:bg-blue-900">
                Simpan
            </button>
        </div>
    </form>
</main>
<?php
unset($_SESSION['errors']);
unset($_SESSION['old_data']);
?>

<script>
    const manualButton = document.getElementById('manual-button');
    const autoButton = document.getElementById('auto-button');
    const manualInputContainer = document.getElementById('manual-input-container');
    const autoInputContainer = document.getElementById('auto-input-container');
    const autoInput = document.getElementById('uid-auto');
    const manualInput = document.getElementById('uid-manual');

    // Reset semua input saat halaman dimuat
    window.onload = () => {
        manualInputContainer.hidden = true;
        autoInputContainer.hidden = true;
        autoInput.disabled = true;
        manualInput.disabled = true;
    };

    // Tampilkan input manual
    manualButton.addEventListener('click', () => {
        manualInputContainer.hidden = false;
        autoInputContainer.hidden = true;
        manualInput.disabled = false;
    });

    // Tampilkan input otomatis
    autoButton.addEventListener('click', () => {
        manualInputContainer.hidden = true;
        autoInputContainer.hidden = false;
        autoInput.disabled = false;

        // Mulai polling untuk memperbarui UID secara otomatis
        startPollingForUID();

    });

    // Fungsi untuk memulai polling
    function startPollingForUID() {
        const interval = 1000; // Polling setiap 1 detik (1000 ms)

        // Fungsi untuk memanggil API secara berkala
        const polling = setInterval(() => {
            fetch('/api/logs/latest') // Ganti URL dengan endpoint API yang valid
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200 && data.data) {
                        // Perbarui inputan UID dengan data terbaru
                        autoInput.value = data.data; // Asumsikan data.data adalah UID terbaru
                    } else {
                        autoInput.value = 'UID tidak tersedia'; // Pesan jika UID tidak ditemukan
                    }
                })
                .catch(error => {
                    console.error('Error fetching UID:', error);
                    autoInput.value = 'Error mengambil UID';
                });
        }, interval);
    }
</script>