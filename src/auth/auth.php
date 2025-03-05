<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$input = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';

    // Cek pengguna dalam database
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $payload = [
            "iss" => $server_name,
            "aud" => $server_name,
            "iat" => time(),
            "user_id" => $user['id']
        ];
        
        $jwt = JWT::encode($payload, $secret_key, 'HS256');
        echo json_encode(["status" => "success", "token" => $jwt]);
    } else {
        echo json_encode(["status" => "error", "message" => "Email atau password salah"]);
    }
}
?>
