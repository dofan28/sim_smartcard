<?php

$uid = $matches[1];

if ($uid) {
    // Cari siswa berdasarkan UID
    $student = getStudentByUID($db, $uid);
    if (!$student) {
        sendResponse(404, 'Invalid card');
    }

    $studentId = $student['id'];
    $transactionClass = handleTransactionClass($db, $studentId);

    if ($transactionClass) {
        if (!$transactionClass['check_out']) {
            $checkInTime = strtotime($transactionClass['check_in']);
            $currentTime = time();
            $timeDifference = ($currentTime - $checkInTime) / 60;

            if ($timeDifference >= 10) {
                updateCheckout($db, $transactionClass['id']);
                sendResponse(200, 'Checkout successful');
            } else {
                sendResponse(400, 'Checkout too early');
            }
        } else {
            sendResponse(200, 'Already checked out');
        }
    } else {
        createTransactionClass($db, $studentId);
        sendResponse(201, 'Check-in successful');
    }
} else {
    sendResponse(405, 'Method not allowed');
}
