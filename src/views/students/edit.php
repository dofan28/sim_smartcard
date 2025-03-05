<?php


$studentId = $matches[1];

$query = "SELECT * FROM students WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $studentId, PDO::PARAM_INT);
$stmt->execute();
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    echo "Siswa tidak ditemukan.";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = htmlspecialchars($_POST['id']);
    $uid = !empty($_POST["uid"]) ? htmlspecialchars($_POST["uid"]) : null;
    $nis = !empty($_POST["nis"]) ? htmlspecialchars($_POST["nis"]) : null;
    $email = !empty($_POST["email"]) ? htmlspecialchars($_POST["email"]) : null;
    $full_name = !empty($_POST["full_name"]) ? htmlspecialchars($_POST["full_name"]) : null;
    $class = !empty($_POST["class"]) ? htmlspecialchars($_POST["class"]) : null;
    $phone = !empty($_POST["phone"]) ? htmlspecialchars($_POST["phone"]) : null;
    $address = !empty($_POST["address"]) ? htmlspecialchars($_POST["address"]) : null;
    $status = !empty($_POST["status"]) ? htmlspecialchars($_POST["status"]) : null;

    $errors = [];

    function isUniqueForUpdate($db, $column, $value, $id)
    {
        $stmt = $db->prepare("SELECT COUNT(*) FROM students WHERE $column = :value AND id != :id");
        $stmt->execute(['value' => $value, 'id' => $id]);
        return $stmt->fetchColumn() == 0; // Jika 0 berarti unik atau milik sendiri
    }

    // Validasi UID (minimal 5 karakter)
    if (empty($uid) || strlen($uid) < 5) {
        $errors[] = "UID harus diisi dengan minimal 5 karakter.";
    } elseif (!isUniqueForUpdate($db, 'uid', $uid, $id)) {
        $errors[] = "UID sudah digunakan oleh pengguna lain.";
    }

    // Validasi NIS (hanya angka, minimal 5 karakter)
    if (empty($nis) || !ctype_digit($nis) || strlen($nis) < 5) {
        $errors[] = "NIS harus berupa angka dan minimal 5 karakter.";
    } elseif (!isUniqueForUpdate($db, 'nis', $nis, $id)) {
        $errors[] = "NIS sudah terdaftar oleh pengguna lain.";
    }

    // Validasi Email (format benar & unik untuk update)
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email harus diisi dengan format yang valid.";
    } elseif (!isUniqueForUpdate($db, 'email', $email, $id)) {
        $errors[] = "Email sudah digunakan oleh pengguna lain.";
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

    // Validasi Status (aktif atau tidak aktif)
    if (empty($status) || !in_array($status, ['active', 'inactive'])) {
        $errors[] = "Status harus dipilih antara 'Aktif' atau 'Tidak Aktif'.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: /students/{$id}/edit");
        exit;
    }

    $updateStudent = updateStudent($db, $id, $uid, $nis, $email, $full_name, $class, $address, $phone, $status);

    if ($updateStudent) {
        echo "<script>
                alert('Data berhasil diperbarui');
                document.location.href = '/students';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal diperbarui');
                document.location.href = '/students/{$id}/edit';
              </script>";
    }
}
?>

<!-- Main Content -->
<main class="container px-6 py-12 mx-auto">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-3xl font-semibold tracking-wide text-blue-900 font-poppins">Edit Data Siswa</h1>
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
    <!-- Form Update Data -->
    <form method="POST" class="p-6 bg-white rounded-md shadow">
        <input type="hidden" name="id" value="<?= htmlspecialchars($student['id']); ?>">
        <div class="mb-4">
            <label for="uid" class="block text-sm font-medium text-gray-800">UID</label>
            <input type="text" id="uid" name="uid" value="<?= htmlspecialchars($student['uid']); ?>"
                class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" readonly>
        </div>
        <div class="mb-4">
            <label for="nis" class="block text-sm font-medium text-gray-800 font-poppins">Nomor Induk Siswa (NIS)</label>
            <input type="text" id="nis" name="nis"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan nomor induk siswa (NIS)" required value="<?= htmlspecialchars($student['nis']); ?>">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-800 font-poppins">Email</label>
            <input type="text" id="email" name="email"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan email" required value="<?= htmlspecialchars($student['email']); ?>">
        </div>
        <div class="mb-4">
            <label for="full_name" class="block text-sm font-medium text-gray-800 font-poppins">Nama Lengkap</label>
            <input type="text" id="full_name" name="full_name"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan nama lengkap" required value="<?= htmlspecialchars($student['full_name']); ?>">
        </div>

        <div class="mb-4">
            <label for="class" class="block text-sm font-medium text-gray-800 font-poppins">Kelas</label>
            <input type="text" id="class" name="class"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan kelas" required value="<?= htmlspecialchars($student['class']); ?>">
        </div>

        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-800 font-poppins">Alamat</label>
            <input type="text" id="address" name="address"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan alamat" required value="<?= htmlspecialchars($student['address']); ?>">
        </div>


        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-800 font-poppins">Status</label>
            <select id="status" name="status"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                required>
                <option value="active" <?= ($student['status'] == 'active') ? 'selected' : ''; ?>>Aktif</option>
                <option value="inactive" <?= ($student['status'] == 'inactive') ? 'selected' : ''; ?>>Tidak Aktif</option>
            </select>
        </div>

        <div class="flex justify-between">
            <button type="reset"
                class="px-6 py-2 text-sm text-gray-800 bg-gray-300 rounded-md font-poppins hover:bg-gray-400">
                Reset
            </button>
            <button type="submit"
                class="px-6 py-2 text-sm text-white bg-blue-800 rounded-md font-poppins hover:bg-blue-900">
                Simpan Perubahan
            </button>
        </div>
    </form>
</main>
<?php
unset($_SESSION['errors']);
unset($_SESSION['old_data']);
?>