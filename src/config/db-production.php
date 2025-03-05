<?php
$secret_key = "taiba@lmg";
$server_name = "SmartEduCard Bukittinggi";

$host = 'localhost';
$dbname = 'taibacre_smartcard_app';
$username = 'taibacre_smartcard_app';
$password = 'Bismillah@99';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
