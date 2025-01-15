<?php
$uid = getLogLastUID($db);

if ($uid) {
    sendResponse(200, 'Success', $uid);
} else {
    sendResponse(404, 'Hayolohhh!', 'Hayo Mau Cari Apa?');
}
