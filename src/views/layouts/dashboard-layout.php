<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /login");
    exit;
}

$current_uri = htmlspecialchars(trim($_SERVER['REQUEST_URI'], '/'), ENT_QUOTES, 'UTF-8');
function isActive($path)
{
    $current_uri = trim($_SERVER['REQUEST_URI'], '/');
    return strpos($current_uri, $path) === 0 ? 'bg-yellow-400' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' | ' : '' ?> SIM - Smart Card</title>
    <link rel="stylesheet" href="/css/style.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        .custom-select-container .student-item {
            transition: background-color 0.2s;
        }

        .custom-select-container .student-item.selected {
            background-color: #EBF5FF;
        }

        .custom-select-container .student-item.hidden {
            display: none;
        }

        #student_list:empty:after {
            content: "Tidak ada hasil yang ditemukan";
            display: block;
            padding: 0.5rem 1rem;
            color: #6B7280;
            font-size: 0.875rem;
        }

        /* Custom scrollbar untuk browser yang mendukung */
        #student_list {
            scrollbar-width: thin;
            scrollbar-color: #CBD5E1 #F1F5F9;
        }

        #student_list::-webkit-scrollbar {
            width: 6px;
        }

        #student_list::-webkit-scrollbar-track {
            background: #F1F5F9;
        }

        #student_list::-webkit-scrollbar-thumb {
            background-color: #CBD5E1;
            border-radius: 3px;
        }
    </style>

</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="text-white bg-blue-900 border-b-2 shadow-sm border-amber-400">
        <div class="container flex items-center justify-between px-6 py-4 mx-auto">
            <h1 class="text-2xl font-semibold text-amber-400">
                <a href="/" class="font-poppins">SIM - Smart Card</a>
            </h1>
            <nav class="space-x-4">
                <a href="/logout" class="px-3 py-2 text-sm font-medium text-white rounded-md font-poppins hover:bg-amber-600 hover:font-semibold bg-amber-400">Logout</a>
            </nav>
        </div>
    </header>
    <nav class="container px-6 py-6 mx-auto ">
        <div class="bg-blue-900 border-2 rounded-md border-amber-400">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Navigation Links -->
                    <div class="hidden sm:flex sm:items-center">
                        <div class="flex space-x-4">
                            <a href="/dashboard"
                                class="text-white hover:bg-amber-400 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 font-poppins <?= isActive('dashboard') ?>">
                                Dashboard
                            </a>
                            <!--          <a href="/scanners"
                                class="text-white hover:bg-amber-400 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 font-poppins <?= isActive('scanners') ?>">
                                Scan Kartu
                            </a>
                            -->
                            <a href="/students"
                                class="text-white hover:bg-amber-400 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 font-poppins <?= isActive('students') ?>">
                                Data Siswa
                            </a>
                            <a href="/transactions"
                                class="text-white hover:bg-amber-400 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 font-poppins <?= isActive('transactions') ?>">
                                Rekap Kehadiran
                            </a>
                            <a href="/logs"
                                class="text-white hover:bg-amber-400 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 font-poppins <?= isActive('logs') ?>">
                                Log Aktivitas
                            </a>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center sm:hidden">
                        <button type="button"
                            class="inline-flex items-center justify-center p-2 text-white rounded-md hover:bg-blue-800 focus:outline-none"
                            aria-controls="mobile-menu"
                            aria-expanded="false">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="sm:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="/scanners"
                        class="text-white hover:bg-amber-400 block px-3 py-2 rounded-md text-base font-medium font-poppins <?= isActive('scanners') ?>">
                        Scan Kartu
                    </a>
                    <a href="/students"
                        class="text-white hover:bg-amber-400 block px-3 py-2 rounded-md text-base font-medium font-poppins <?= isActive('students') ?>">
                        Data Siswa
                    </a>
                    <a href="/transactions"
                        class="text-white hover:bg-amber-400 block px-3 py-2 rounded-md text-base font-medium font-poppins <?= isActive('transactions') ?>">
                        Rekap Kehadiran
                    </a>
                    <a href="/logs"
                        class="text-white hover:bg-amber-400 block px-3 py-2 rounded-md text-base font-medium font-poppins <?= isActive('logs') ?>">
                        Log Aktivitas
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <?php include $content; ?>
    </main>

    <!-- Footer -->
    <footer class="py-6 text-gray-300 bg-blue-900 border-t-2 shadow-sm border-amber-400">
        <div class="container mx-auto text-center">
            <p class="text-sm leading-relaxed font-poppins">
                &copy; 2025
                <span class="text-amber-400 font-poppins">Smart Card </span>.
                All Rights Reserved.
            </p>
        </div>
    </footer>
    <script>
        const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            const expanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !expanded);
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>