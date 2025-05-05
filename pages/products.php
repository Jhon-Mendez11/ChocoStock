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
        <form action="../server/products/add_products.php" method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>

            <label>Cantidad:</label>
            <input type="number" name="cantidad" min="0" required>

            <label>Precio (S/):</label>
            <input type="number" step="00.01" name="precio" min="0" required>

            <label>Cantidad mínima:</label>
            <input type="number" name="cantidad_min" min="0" required>

            <button type="submit">Guardar</button>
            <a href="../index.php">Cancelar</a>
        </form>
        <a href="../index.php">volver</a>
    </div>
</body>

</html>