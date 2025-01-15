<?php

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['uid'])) {
    $uid = $data['uid'];
    
    storeLog($db, $uid);

    echo "LOG_SAVED";
} else {
    echo "INVALID_REQUEST";
}
