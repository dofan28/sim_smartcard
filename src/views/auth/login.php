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
                <div class="flex justify-center items-center">
                    <span class="bg-red-100 py-2 px-3 text-red-600 font-semibold ">Email dan kata sandi salah</span>
                </div>
            </div>
        <?php endif; ?>
        <h2 class="mb-4 text-2xl font-bold text-center text-blue-900 font-poppins">Masuk</h2>
        <form method="POST" class="space-y-4">
            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-poppins font-medium text-gray-800">Alamat Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email"
                    class="w-full p-3 mt-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-400 focus:outline-none" required>
            </div>
            <!-- Password Input -->
            <div>
                <label for="password" class="block text-sm font-poppins font-medium text-gray-800">Kata Sandi</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password"
                    class="w-full p-3 mt-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-amber-400 focus:outline-none" required>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full py-3 mt-4 text-white rounded-md bg-amber-400 hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2" name="login">
                    Masuk
                </button>
            </div>
        </form>

    </div>
</section>