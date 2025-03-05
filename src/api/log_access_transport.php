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
    case 'GET':
        break;
    case 'POST':
        if ($input['uid']) {

            $student = getStudentByUID($db, $input['uid']);

            if (!$student) {
                sendResponse(200, 'Invalid card');
            }

            $studentId = $student['id'];
            $transactionTransport = handleTransactionTransport($db, $studentId);

            if ($transactionTransport) {
                if (!$transactionTransport['check_out']) {
                    $checkInTime = strtotime($transactionTransport['check_in']);
                    $currentTime = time();
                    $timeDifference = ($currentTime - $checkInTime) / 60;

                    if ($timeDifference >= 10) {
                        $data = updateCheckout($db, $transactionTransport['id']);

                        $nis = $student['nis'] ?? 'N/A';
                        $full_name = $student['full_name'] ?? 'N/A';
                        $class = $student['class'] ?? 'N/A';

                        $type_transaction = $data['type_transaction'] ?? 'N/A';
                        $date = $data['date'] ?? 'N/A';
                        $check_in = $data['check_in'] ?? 'N/A';
                        $check_out = $data['check_out'] ?? '-';

                        $to       = $student['email'] ?? 'N/A';
                        $subject  = 'Report Jam Pulang: Akses Transportasi';

                        $message = "
                <html>
                <head>
                    <title>Report Jam Pulang: Akses Transportasi</title>
                    <style>
                        body {
                            color: #000000; /* Warna hitam untuk seluruh teks */
                            font-family: Arial, Helvetica, sans-serif;
                        }
                        p, h3, b {
                            color: #000000; /* Memastikan teks paragraf, heading, dan bold tetap hitam */
                        }
                    </style>
                </head>
                <body>
                    <p style=\"color: #000000;\">Halo <b style=\"color: #000000;\">$full_name</b>,</p>
                    <p style=\"color: #000000;\">Berikut adalah laporan jam pulang Anda:</p>
            
                    <h3 style=\"color: #000000;\">📌 Detail Siswa:</h3>
                    <p style=\"color: #000000;\"><b style=\"color: #000000;\">NIS:</b> <span style=\"color: #000000;\">$nis</span><br>
                    <b style=\"color: #000000;\">Nama:</b> <span style=\"color: #000000;\">$full_name</span><br>
                    <b style=\"color: #000000;\">Kelas:</b> <span style=\"color: #000000;\">$class</span></p>
            
                    <h3 style=\"color: #000000;\">📅 Detail Transaksi:</h3>
                    <p style=\"color: #000000;\"><b style=\"color: #000000;\">Jenis Transaksi:</b> <span style=\"color: #000000;\">Transportasi</span><br>
                    <b style=\"color: #000000;\">Tanggal:</b> <span style=\"color: #000000;\">$date</span><br>
                    <b style=\"color: #000000;\">Jam Masuk:</b> <span style=\"color: #000000;\">$check_in</span><br>
                    <b style=\"color: #000000;\">Jam Pulang:</b> <span style=\"color: #000000;\">$check_out</span></p>
            
                    <p style=\"color: #000000;\">Terima kasih telah menggunakan layanan transportasi sekolah.</p>
            
                </body>
                </html>";

                        smtp_mail($to, $subject, $message, '', '', 0, 0, false);

                        sendResponse(200, 'Checkout successful');
                    } else {
                        sendResponse(200, 'Checkout too early');
                    }
                } else {
                    sendResponse(200, 'Already checked out');
                }
            } else {
                $data = createTransactionTransport($db, $studentId);

                $nis = $student['nis'] ?? 'N/A';
                $full_name = $student['full_name'] ?? 'N/A';
                $class = $student['class'] ?? 'N/A';

                $type_transaction = $data['type_transaction'] ?? 'N/A';
                $date = $data['date'] ?? 'N/A';
                $check_in = $data['check_in'] ?? 'N/A';
                $check_out = $data['check_out'] ?? '-';

                $to       = $student['email'] ?? 'N/A';
                $subject  = 'Report Jam Masuk: Akses Transportasi';

                $message = "
        <html>
        <head>
            <title>Report Jam Masuk: Akses Transportasi</title>
            <style>
                body {
                    color: #000000; /* Warna hitam untuk seluruh teks */
                    font-family: Arial, Helvetica, sans-serif;
                }
                p, h3, b {
                    color: #000000; /* Memastikan teks paragraf, heading, dan bold tetap hitam */
                }
            </style>
        </head>
        <body>
            <p style=\"color: #000000;\">Halo <b style=\"color: #000000;\">$full_name</b>,</p>
            <p style=\"color: #000000;\">Berikut adalah laporan jam masuk Anda:</p>
    
            <h3 style=\"color: #000000;\">📌 Detail Siswa:</h3>
            <p style=\"color: #000000;\"><b style=\"color: #000000;\">NIS:</b> <span style=\"color: #000000;\">$nis</span><br>
            <b style=\"color: #000000;\">Nama:</b> <span style=\"color: #000000;\">$full_name</span><br>
            <b style=\"color: #000000;\">Kelas:</b> <span style=\"color: #000000;\">$class</span></p>
    
            <h3 style=\"color: #000000;\">📅 Detail Transaksi:</h3>
            <p style=\"color: #000000;\"><b style=\"color: #000000;\">Jenis Transaksi:</b> <span style=\"color: #000000;\">Transportasi</span><br>
            <b style=\"color: #000000;\">Tanggal:</b> <span style=\"color: #000000;\">$date</span><br>
            <b style=\"color: #000000;\">Jam Masuk:</b> <span style=\"color: #000000;\">$check_in</span><br>
            <b style=\"color: #000000;\">Jam Pulang:</b> <span style=\"color: #000000;\">$check_out</span></p>
    
            <p style=\"color: #000000;\">Terima kasih telah menggunakan layanan transportasi sekolah.</p>
    
        </body>
        </html>";
                smtp_mail($to, $subject, $message, '', '', 0, 0, false);

                sendResponse(200, 'Check-in successful');
            }
        } else {
            sendResponse(405, 'Method not allowed');
        }

        break;
    case 'PUT':
        break;
    case 'DELETE':
        break;
    default:
        echo json_encode(['message' => 'Invalid request method']);
        break;
}
