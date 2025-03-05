<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' | ' : '' ?> SIM - Smart Card</title>
    <link rel="stylesheet" href="css/style.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="text-white bg-blue-900 border-b-2 shadow-sm border-amber-400">
        <div class="container flex items-center justify-between px-6 py-4 mx-auto">
            <h1 class="text-2xl font-semibold text-amber-400">
                <a href="/" class="font-poppins">SmartEduCard Bukittinggi</a>
            </h1>
            <nav class="space-x-4">
                <?php if (isset($_SESSION['login'])): ?>
                    <a href="/dashboard" class="px-3 py-2 text-sm font-medium text-white rounded-md font-poppins hover:bg-amber-600 hover:font-semibold bg-amber-400">Dashboard</a>
                <?php else: ?>
                    <a href="/login" class="px-3 py-2 text-sm font-medium text-white rounded-md font-poppins hover:bg-amber-600 hover:font-semibold bg-amber-400">Masuk</a>
                <?php endif ?>
            </nav>
        </div>
    </header>

    <main>
        <?php include $content; ?>
    </main>
    <!-- Footer -->
    <footer class="py-6 text-gray-300 bg-blue-900 border-t-2 shadow-sm border-amber-400">
        <div class="container mx-auto text-center">
            <p class="text-sm leading-relaxed font-poppins">
                &copy; 2025
                <span class="text-amber-400 font-poppins">SmartEduCard Buktitinggi</span>.
                All Rights Reserved.
            </p>
        </div>
    </footer>
</body>

</html>