<?php
require('../../libs/fpdf.php');
require '../commons/db.php';

header('Content-Type: application/json');

// Orden
$order = $_GET['order'] ?? 'desc';
$allowedOrders = ['asc', 'desc'];
$order = in_array(strtolower($order), $allowedOrders) ? $order : 'desc';

// Consulta
$query = "SELECT id_ventas, cantidad, precio_venta, fecha FROM ventas ORDER BY fecha $order";
$stmt = $db->query($query);
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si se requiere PDF
if (isset($_GET['view_pdf']) || isset($_GET['download_pdf'])) {
    generarPDF($ventas, isset($_GET['download_pdf']) ? 'D' : 'I');
}

echo json_encode($ventas);
exit();

// Función PDF
function generarPDF($ventas, $modo = 'I') {
    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'ChocoStock - Reporte de Ventas', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Reporte realizado el: ' . date('d/m/Y'), 0, 1, 'L');
    $pdf->Cell(0, 10, 'Empresa: ChocoStock', 0, 1, 'L');
    $pdf->Ln(10);

    $pdf->Cell(30, 10, 'Cantidad', 1);
    $pdf->Cell(40, 10, 'Precio (S/)', 1);
    $pdf->Cell(40, 10, 'Fecha', 1);
    $pdf->Ln();

    foreach ($ventas as $v) {
        $pdf->Cell(30, 10, $v['cantidad'], 1);
        $pdf->Cell(40, 10, number_format($v['precio_venta'], 2), 1);
        $pdf->Cell(40, 10, date('d/m/Y', strtotime($v['fecha'])), 1);
        $pdf->Ln();
    }

    $pdf->Output($modo, 'reporte_ventas.pdf');
    exit();
}
