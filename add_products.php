<?php
//require 'server/commons/db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/ChocoStock/server/commons/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $cantidad = isset($_POST['cantidad']) ? (int) $_POST['cantidad'] : 0;
    $precio = isset($_POST['precio']) ? (int) $_POST['precio'] : 0;
    $cantidad_min = isset($_POST['cantidad_min']) ? (int) $_POST['cantidad_min'] : 0;

    // Validación simple
    if ($precio < 0 || $cantidad < 0 || $cantidad_min < 0) {
        die("❌ Error: Los valores no pueden ser negativos.");
    }

    $query = "INSERT INTO productos (nombre, cantidad, precio, cantidad_min, fecha)
              VALUES (:nombre, :cantidad, :precio, :cantidad_min, NOW())";

    $stmt = $db->prepare($query);
    $stmt->execute([
        ':nombre' => $nombre,
        ':cantidad' => $cantidad,
        ':precio' => $precio,
        ':cantidad_min' => $cantidad_min
    ]);

    header('Location: products.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="contenedor">
        <h1>Agregar Producto</h1>
        <form method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>

            <label>Cantidad:</label>
            <input type="number" name="cantidad" min="0" required>

            <label>Precio (S/):</label>
            <input type="number" step="00.01" name="precio" min="0" required>

            <label>Cantidad mínima:</label>
            <input type="number" name="cantidad_min" min="0" required>

            <button type="submit">Guardar</button>
            <a href="products.php">Cancelar</a>
        </form>
    </div>
</body>

</html>