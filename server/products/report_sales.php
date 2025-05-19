<?php
require('../../libs/fpdf.php');
require '../commons/db.php';

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['u_id'])) {
    echo json_encode(['error' => 'No hay sesión activa']);
    exit;
}

$u_id = $_SESSION['u_id'];

// Orden
$order = $_GET['order'] ?? 'desc';
$allowedOrders = ['asc', 'desc'];
$order = in_array(strtolower($order), $allowedOrders) ? $order : 'desc';

// Límite
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 8;
$limit = ($limit > 0 && $limit <= 100) ? $limit : 8;

// Consulta modificada para incluir el nombre del producto
$query = "SELECT v.id_ventas, v.cantidad, v.precio_venta, v.fecha, p.nombre 
FROM ventas v 
JOIN productos p ON v.id_producto = p.p_id 
WHERE v.u_id = :u_id 
ORDER BY v.fecha $order 
LIMIT :limit";

$stmt = $db->prepare($query);
$stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();

$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generar PDF si se solicita
if (isset($_GET['view_pdf']) || isset($_GET['download_pdf'])) {
    generarPDF($ventas, isset($_GET['download_pdf']) ? 'D' : 'I');
    exit;
}

// Devolver JSON
echo json_encode($ventas);
exit();

// Función para PDF
function generarPDF($ventas, $modo = 'I')
{
    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'ChocoStock - Reporte de Ventas', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Reporte realizado el: ' . date('d/m/Y'), 0, 1, 'L');
    $pdf->Cell(0, 10, 'Empresa: ChocoStock', 0, 1, 'L');
    $pdf->Ln(10);

    // Encabezado de tabla
    $pdf->Cell(30, 10, 'Cantidad', 1);
    $pdf->Cell(50, 10, 'Producto', 1);
    $pdf->Cell(40, 10, 'Precio (S/)', 1);
    $pdf->Cell(40, 10, 'Fecha', 1);
    $pdf->Ln();

    foreach ($ventas as $v) {
        $pdf->Cell(30, 10, $v['cantidad'], 1);
        $pdf->Cell(50, 10, $v['nombre'], 1);
        $pdf->Cell(40, 10, number_format($v['precio_venta'], 2), 1);
        $pdf->Cell(40, 10, date('d/m/Y', strtotime($v['fecha'])), 1);
        $pdf->Ln();
    }

    $pdf->Output($modo, 'reporte_ventas.pdf');
}
?>