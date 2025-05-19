<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/report.js" defer></script>
</head>

<body>
    <div class="p_contenedor">
        <h2>Reporte de Ventas</h2>

        <div class="ordenar">
            <form id="ordenForm">
                <label for="order">Ordenar por fecha:</label>
                <select name="order" id="order">
                    <option value="desc">Más reciente</option>
                    <option value="asc">Más antiguo</option>
                </select>
            </form>
        </div>

        <table class="tabla-productos">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Producto</th>
                    <th>Precio Venta (S/)</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody id="ventas-body">
                <!-- Aquí se insertarán los datos vía JS -->
            </tbody>
        </table>
        <div style="margin-top: 20px; text-align: center;">
            <a class="btn-pdf" id="verPdfBtn" href="#" target="_blank">Ver PDF</a>
            <a class="btn-pdf" id="descargarPdfBtn" href="#">Descargar PDF</a>
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <a class="btn-volver" href="../index.php">Volver</a>
        </div>
    </div>
</body>

</html>