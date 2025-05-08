<?php
require('../libs/fpdf.php'); // Asegúrate de que esta ruta sea correcta
require '../server/commons/db.php';

$order = $_GET['order'] ?? 'desc';
$allowedOrders = ['asc', 'desc'];
$order = in_array(strtolower($order), $allowedOrders) ? $order : 'desc';

// CONSULTA A LA TABLA DE VENTAS
$query = "SELECT id_ventas, cantidad, precio_venta, fecha FROM ventas ORDER BY fecha $order";
$stmt = $db->query($query);
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// FUNCION PARA GENERAR EL PDF (reutilizada para ver o descargar)
function generarPDF($ventas, $modo = 'I') {
    $pdf = new FPDF();
    $pdf->AddPage();

    // Configurar la imagen como marca de agua (ajusta la ruta de la imagen y el tamaño)
    $imagePath = '../img/CS.png'; // Ruta de la imagen de marca de agua
    $pdf->Image($imagePath, 15, 15, 160, 269, 'PNG', '', 'C', false, 300, 'C', false, false);

    // TÍTULO
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'ChocoStock - Reporte de Ventas', 0, 1, 'C');
    $pdf->Ln(10);

    // INFORMACIÓN DEL REPORTE
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Reporte realizado el: ' . date('d/m/Y'), 0, 1, 'L');
    $pdf->Cell(0, 10, 'Empresa: ChocoStock', 0, 1, 'L');
    $pdf->Ln(10);

    // CABECERA
    $pdf->Cell(30, 10, 'Cantidad', 1);
    $pdf->Cell(40, 10, 'Precio (S/)', 1);
    $pdf->Cell(40, 10, 'Fecha', 1);
    $pdf->Ln();

    // FILAS
    foreach ($ventas as $v) {
        $pdf->Cell(30, 10, $v['cantidad'], 1);
        $pdf->Cell(40, 10, number_format($v['precio_venta'], 2), 1);
        $pdf->Cell(40, 10, date('d/m/Y', strtotime($v['fecha'])), 1);
        $pdf->Ln();
    }

    // Mostrar o descargar
    $pdf->Output($modo, 'reporte_ventas.pdf');
    exit();
}

// Si se solicita ver o descargar el PDF
if (isset($_GET['view_pdf'])) {
    generarPDF($ventas, 'I'); // Mostrar en navegador
}

if (isset($_GET['download_pdf'])) {
    generarPDF($ventas, 'D'); // Descargar
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="p_contenedor">
        <h2>Reporte de Ventas</h2>

        <!-- Formulario para ordenar -->
        <div class="ordenar">
            <form method="get">
                <label for="order">Ordenar por fecha:</label>
                <select name="order" id="order" onchange="this.form.submit()">
                    <option value="desc" <?= $order == 'desc' ? 'selected' : '' ?>>Más reciente</option>
                    <option value="asc" <?= $order == 'asc' ? 'selected' : '' ?>>Más antiguo</option>
                </select>
            </form>
        </div>

        <!-- Tabla de ventas -->
        <table class="tabla-productos">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Precio Venta (S/)</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($ventas)): ?>
                    <tr><td colspan="4">No hay registros de ventas.</td></tr>
                <?php else: ?>
                    <?php foreach ($ventas as $v): ?>
                        <tr>
                            <td><?= $v['cantidad'] ?></td>
                            <td><?= number_format($v['precio_venta'], 2) ?></td>
                            <td><?= date('d/m/Y', strtotime($v['fecha'])) ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Botones globales para PDF -->
        <div style="margin-top: 20px; text-align: center;">
            <a class="btn-pdf" href="?view_pdf=true&order=<?= $order ?>" target="_blank">Ver PDF</a>
            <a class="btn-pdf" href="?download_pdf=true&order=<?= $order ?>">Descargar PDF</a>
        </div>

        <!-- Botón volver -->
        <div style="margin-top: 20px; text-align: center;">
            <a class="btn-volver" href="../index.php">Volver</a>
        </div>
    </div>
</body>
</html>
