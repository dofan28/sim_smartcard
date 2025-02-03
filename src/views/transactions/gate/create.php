<?php
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



    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: /transaction/gates/create");
        exit;
    }

    $addTransaction = storeTransactionGates($db, $student_id, $date, $check_in, $check_out);

    if ($addTransaction) {
        echo "
        <script>
            alert('Data berhasil ditambahkan');
            document.location.href = '/transaction/gates';
        </script>
        ";
    } else {
        echo "
            <script>
            alert('Data gagal ditambahkan');
            document.location.href = '/transaction/gates/create';
        </script>";
    }
}
?>

<main class="container px-6 py-12 mx-auto">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-3xl font-semibold tracking-wide text-blue-900 font-poppins">Buat Log Akses Gerbang</h1>
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

        <div class="mb-4 custom-select-container">
            <label for="student_search" class="block text-sm font-medium text-gray-800 font-poppins">Mahasiswa</label>
            <div class="relative">
                <input type="text" id="student_search"
                    class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                    placeholder="Cari mahasiswa..." autocomplete="off">
                <input type="hidden" id="student_id" name="student_id" required
                    value="<?= isset($_SESSION['old_data']['student_id']) ? $_SESSION['old_data']['student_id'] : '' ?>">
                <div id="student_list" class="absolute z-10 hidden w-full mt-1 overflow-y-auto bg-white border border-gray-300 rounded-md shadow-lg max-h-60">
                    <?php foreach ($students as $student): ?>
                        <div class="px-4 py-2 text-sm cursor-pointer student-item hover:bg-gray-100 font-poppins"
                            data-id="<?= $student['id'] ?>"
                            data-name="<?= htmlspecialchars($student['full_name']) ?>">
                            <?= htmlspecialchars($student['full_name']) ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-800 font-poppins">Tanggal</label>
            <input type="date" id="date" name="date"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan tanggal" required value="<?= isset($_SESSION['old_data']['date']) ? $_SESSION['old_data']['date'] : '' ?>">
        </div>
        <div class="mb-4">
            <label for="check_in" class="block text-sm font-medium text-gray-800 font-poppins">Waktu Masuk</label>
            <input type="time" id="check_in" name="check_in"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan nama lengkap" required value="<?= isset($_SESSION['old_data']['check_in']) ? $_SESSION['old_data']['check_in'] : '' ?>">
        </div>
        <div class="mb-4">
            <label for="check_out" class="block text-sm font-medium text-gray-800 font-poppins">Waktu Pulang</label>
            <input type="time" id="check_out" name="check_out"
                class="w-full px-4 py-2 mt-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 font-poppins"
                placeholder="Masukkan nama lengkap" required value="<?= isset($_SESSION['old_data']['check_out']) ? $_SESSION['old_data']['check_out'] : '' ?>">
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
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('student_search');
        const studentList = document.getElementById('student_list');
        const hiddenInput = document.getElementById('student_id');
        const studentItems = document.querySelectorAll('.student-item');

        // Set initial value if exists
        if (hiddenInput.value) {
            const selectedItem = document.querySelector(`.student-item[data-id="${hiddenInput.value}"]`);
            if (selectedItem) {
                searchInput.value = selectedItem.textContent.trim();
            }
        }

        // Search functionality
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            let hasResults = false;

            studentItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.classList.remove('hidden');
                    hasResults = true;
                } else {
                    item.classList.add('hidden');
                }
            });

            studentList.style.display = 'block';

            if (!hasResults && searchTerm) {
                studentList.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500">Tidak ada hasil yang ditemukan</div>';
            }
        });

        // Handle item selection
        studentList.addEventListener('click', function(e) {
            const item = e.target.closest('.student-item');
            if (item) {
                const id = item.dataset.id;
                const name = item.dataset.name;

                searchInput.value = name;
                hiddenInput.value = id;
                studentList.style.display = 'none';

                // Remove selection from other items
                studentItems.forEach(i => i.classList.remove('selected'));
                item.classList.add('selected');
            }
        });

        // Show/hide dropdown
        searchInput.addEventListener('focus', () => {
            studentList.style.display = 'block';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-select-container')) {
                studentList.style.display = 'none';
            }
        });

        // Keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            const visibleItems = [...studentItems].filter(item => !item.classList.contains('hidden'));
            const currentIndex = visibleItems.findIndex(item => item.classList.contains('selected'));

            switch (e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    if (currentIndex < visibleItems.length - 1) {
                        visibleItems[currentIndex]?.classList.remove('selected');
                        visibleItems[currentIndex + 1]?.classList.add('selected');
                        visibleItems[currentIndex + 1]?.scrollIntoView({
                            block: 'nearest'
                        });
                    }
                    break;

                case 'ArrowUp':
                    e.preventDefault();
                    if (currentIndex > 0) {
                        visibleItems[currentIndex]?.classList.remove('selected');
                        visibleItems[currentIndex - 1]?.classList.add('selected');
                        visibleItems[currentIndex - 1]?.scrollIntoView({
                            block: 'nearest'
                        });
                    }
                    break;

                case 'Enter':
                    e.preventDefault();
                    const selectedItem = visibleItems[currentIndex];
                    if (selectedItem) {
                        searchInput.value = selectedItem.dataset.name;
                        hiddenInput.value = selectedItem.dataset.id;
                        studentList.style.display = 'none';
                    }
                    break;

                case 'Escape':
                    studentList.style.display = 'none';
                    break;
            }
        });
    });
</script>