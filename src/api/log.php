<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

$decodedToken = verifyJWT();

switch ($method) {
    case 'POST':
        if (!isset($input['uid'])) {
            sendResponse(400, 'UID is required');
        }
        storeLog($db, $input['uid']);
        sendResponse(200, 'Log created successfully');
        break;
    default:
        sendResponse(405, 'Invalid request method');
        break;
}
