<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$transactionGates = getAllTransactionGateJoinStudents($db);

$mpdf = new \Mpdf\Mpdf();

$html = '<h2 style="text-align: start;">SmartEducard Bukittinggi</h2>';
$html .= '<h3 style="text-align: center; margin-top: 10px;">Log Akses Gerbang</h3>';
$html .= '<table style="width: 100%; border-collapse: collapse;" border="1">';
$html .= '<thead>
<tr style="background-color: #003366; color: #FFFFFF ;">
        <th style="padding: 8px; color: #FFFFFF">Nama</th>
        <th style="padding: 8px; color: #FFFFFF">Tanggal</th>
        <th style="padding: 8px; color: #FFFFFF">Waktu Masuk</th>
        <th style="padding: 8px; color: #FFFFFF">Waktu Pulang</th>
    </tr>
</thead>
<tbody>';

if (!empty($transactionGates)) {
    foreach ($transactionGates as $transactionGate) {
        $html .= '<tr>
            <td style="padding: 8px;">' . htmlspecialchars($transactionGate['full_name']) . '</td>
            <td style="padding: 8px;">' . htmlspecialchars($transactionGate['date']) . '</td>
            <td style="padding: 8px;">' . htmlspecialchars($transactionGate['check_in']) . '</td>
            <td style="padding: 8px;">' . htmlspecialchars($transactionGate['check_out']) . '</td>
        </tr>';
    }
} else {
    $html .= '<tr>
        <td colspan="4" style="text-align: center; padding: 8px; color: red;">Tidak ada data.</td>
    </tr>';
}

$html .= '</tbody></table>';

$mpdf->WriteHTML($html);
$mpdf->Output('Laporan_Log_Akses_Gerbang.pdf', 'D');
