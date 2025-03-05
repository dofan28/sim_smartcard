<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verifyJWT() {
    global $secret_key;
    
    $headers = apache_request_headers();
    
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["message" => "Token tidak ditemukan"]);
        exit;
    }

    $authHeader = $headers['Authorization'];
    list($token) = sscanf($authHeader, 'Bearer %s');

    try {
        $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
        return $decoded;
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["message" => "Token tidak valid"]);
        exit;
    }
}
?>
