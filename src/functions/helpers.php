<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

function sendResponse($status, $message, $data = null, $student = null)
{
    http_response_code($status);
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data,
        'student' => $student
    ]);
    exit;
}

function smtp_mail($to, $subject, $message, $from_name, $from, $cc, $bcc, $debug = false)
{
    $mail = new PHPMailer;
    $mail->SMTPDebug = $debug; // Ubah menjadi true jika ingin menampilkan sistem debug SMTP Mailer
    $mail->isSMTP();

    // Hapus Semua Tujuan, CC dan BCC
    $mail->ClearAddresses();
    $mail->ClearCCs();
    $mail->ClearBCCs();

    /* -------------------------- Konfigurasi Dasar SMTP ---------------------------------- */

    $mail->SMTPAuth     = true;
    $mail->Host           = 'smartcard.taibacreative.co.id';  // Masukkan Server SMTP
    $mail->Port           = 587;                                      // Masukkan Port SMTP
    $mail->SMTPSecure = 'tls';                                    // Masukkan Pilihan Enkripsi ( `tls` atau `ssl` )
    $mail->Username     = 'system_smartcard@taibacreative.co.id';                // Masukkan Email yang digunakan selama proses pengiriman email via SMTP
    $mail->Password     = 'Bismillah@99';                                          // Masukkan Password dari Email tsb
    $default_email_from       = 'system_smartcard@taibacreative.co.id';        // Masukkan default from pada email
    $default_email_from_name  = 'Smart Card: Taiba Creative';           // Masukkan default nama dari from pada email

    /* -------------------------- Konfigurasi Dasar SMTP ---------------------------------- */

    if (empty($from)) $mail->From = $default_email_from;
    else $mail->From = $from;

    if (empty($from_name)) $mail->FromName = $default_email_from_name;
    else $mail->FromName = $from_name;

    // Set penerima email
    if (is_array($to)) {
        foreach ($to as $k => $v) {
            $mail->addAddress($v);
        }
    } else {
        $mail->addAddress($to);
    }

    // Set email CC ( optional )
    if (!empty($cc)) {
        if (is_array($cc)) {
            foreach ($cc as $k => $v) {
                $mail->addCC($v);
            }
        } else {
            $mail->addCC($cc);
        }
    }

    // Set email BCC ( optional )
    if (!empty($bcc)) {
        if (is_array($bcc)) {
            foreach ($bcc as $k => $v) {
                $mail->addBCC($v);
            }
        } else {
            $mail->addBCC($bcc);
        }
    }

    // Set isi dari email
    $mail->isHTML(true);
    $mail->Subject     = $subject;
    $mail->Body       = $message;
    $mail->AltBody    = $message;
    if (!$mail->send()) {
        return 1;
    } else {
        return 0;
    }
}
