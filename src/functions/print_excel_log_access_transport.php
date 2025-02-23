<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$transactionTransports = getAllTransactionTransportJoinStudents($db);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header
$sheet->setCellValue('A1', 'Nama');
$sheet->setCellValue('B1', 'Tanggal');
$sheet->setCellValue('C1', 'Waktu Masuk');
$sheet->setCellValue('D1', 'Waktu Pulang');

// Apply styling to header
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '003366']],
    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
];
$sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

// Fill data
$row = 2;
if (!empty($transactionTransports)) {
    foreach ($transactionTransports as $transactionTransport) {
        $sheet->setCellValue('A' . $row, $transactionTransport['full_name']);
        $sheet->setCellValue('B' . $row, $transactionTransport['date']);
        $sheet->setCellValue('C' . $row, $transactionTransport['check_in']);
        $sheet->setCellValue('D' . $row, $transactionTransport['check_out']);
        $row++;
    }
} else {
    $sheet->setCellValue('A2', 'Tidak ada data.')->mergeCells('A2:D2');
    $sheet->getStyle('A2')->getFont()->getColor()->setRGB('FF0000');
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
}

// Auto size columns
foreach (range('A', 'D') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Export file
$writer = new Xlsx($spreadsheet);
$filename = 'Laporan_Log_Akses_Transportasi.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
