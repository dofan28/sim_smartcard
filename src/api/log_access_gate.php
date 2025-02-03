<?php

$uid = $matches[1];

if ($uid) {
    // Cari siswa berdasarkan UID
    $student = getStudentByUID($db, $uid);
    if (!$student) {
        sendResponse(404, 'Invalid card');
    }

    $studentId = $student['id'];
    $transactionGate = handleTransactionGate($db, $studentId);

    if ($transactionGate) {
        if (!$transactionGate['check_out']) {
            $checkInTime = strtotime($transactionGate['check_in']);
            $currentTime = time();
            $timeDifference = ($currentTime - $checkInTime) / 60;

            if ($timeDifference >= 10) {
                updateCheckout($db, $transactionGate['id']);
                sendResponse(200, 'Checkout successful');
            } else {
                sendResponse(400, 'Checkout too early');
            }
        } else {
            sendResponse(200, 'Already checked out');
        }
    } else {
        createTransactionGate($db, $studentId);
        sendResponse(201, 'Check-in successful');
    }
} else {
    sendResponse(405, 'Method not allowed');
}
