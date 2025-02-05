<?php
session_start();


require_once '../../vendor/autoload.php';
require_once '../../config/connection.php';

$stmt = $pdo->prepare("SELECT id, username, email FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 20);
$pdf->Cell(0, 10, 'Izveštaj o korisnicima', 0, 1, 'C');


$pdf->SetFont('Helvetica', '', 12);
foreach ($users as $user) {
      $pdf->Cell(0, 10, 'ID: ' . $user['id'] . ', Username: ' . $user['username'] . ', Email: ' . $user['email'], 0, 1);
}


$pdf->Output('izvestaj_korisnika.pdf', 'D');
