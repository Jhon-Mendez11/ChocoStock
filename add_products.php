<?php
require 'server/commons/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $cantidad = $_POST['cantidad'] ?? 0;
    $precio = $_POST['precio'] ?? 0;
    $cantidad_min = $_POST['cantidad_min'] ?? 0;

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
            <input type="number" step="0.01" name="precio" min="0" required>

            <label>Cantidad mínima:</label>
            <input type="number" name="cantidad_min" min="0" required>

            <button type="submit">Guardar</button>
            <a href="products.php">Cancelar</a>
        </form>
    </div>
</body>

</html>