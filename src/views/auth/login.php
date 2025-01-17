<?php

if (isset($_SESSION['login'])) {
    header("Location: /");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = true;
        header("Location: dashboard");
        exit;
    } else {
        $error = true;
    }
}
?>

<!-- Login Section -->
<section class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-sm p-6 bg-white rounded-md shadow-lg">
        <?php if (isset($error)) : ?>
            <div class="my-6">
                <div class="flex items-center justify-center">
                    <span class="px-3 py-2 text-sm text-red-600 bg-red-100 font-poppins">Email atau kata sandi salah.</span>
                </div>
            </div>
        <?php endif; ?>
        <h2 class="mb-4 text-2xl font-bold text-center text-blue-900 font-poppins">Masuk</h2>
        <form method="POST" class="space-y-4">
            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-800 font-poppins">Alamat Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email"
                    class="w-full p-3 mt-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-400 focus:outline-none font-poppins" required>
            </div>
            <!-- Password Input -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-800 font-poppins">Kata Sandi</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password"
                    class="w-full p-3 mt-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-400 focus:outline-none font-poppins" required>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full py-3 mt-4 text-sm font-semibold text-white rounded-md bg-amber-400 hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 font-poppins" name="login">
                    Masuk
                </button>
            </div>
        </form>

    </div>
</section>