<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="p_contenedor">
        <h1>Agregar Producto</h1>
        <form action="../server/products/add_products.php" method="POST" class="form-grid">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="form-group">
                <label>Cantidad en Kg:</label>
                <input type="number" name="cantidad" min="0" required>
            </div>
            <div class="form-group">
                <label>Precio inicial:</label>
                <input type="number" step="0.01" name="precio" min="0" required>
            </div>

            <div class="form-buttons">
                <button type="submit">Guardar</button>
                <a href="../index.php" class="cancel-btn">Cancelar</a>
            </div>
        </form>
    </div>

</body>

</html>