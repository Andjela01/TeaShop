<?php
require_once '../../vendor/autoload.php';


require_once '../../config/connection.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Izveštaj o Porudžbinama');


$stmt = $pdo->query("SELECT o.id, o.user_id, o.total_amount, o.order_date FROM orders o");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'ID Korisnika');
$sheet->setCellValue('C1', 'Ukupan Iznos');
$sheet->setCellValue('D1', 'Datum Porudžbine');

$row = 2;
foreach ($orders as $order) {
      $sheet->setCellValue('A' . $row, $order['id']);
      $sheet->setCellValue('B' . $row, $order['user_id']);
      $sheet->setCellValue('C' . $row, $order['total_amount']);
      $sheet->setCellValue('D' . $row, $order['order_date']);
      $row++;
}


$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="izvestaj_porudzbina.xlsx"');
$writer->save('php://output');
exit;
