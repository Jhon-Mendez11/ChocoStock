<!DOCTYPE html>
<?php require '../server/products/edit_products.php'; ?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="form-container">
        <h1>Editar producto</h1>
        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" step="1" name="precio" id="precio" value="<?= $producto['precio'] ?>" required>
            </div>

            <div class="form-buttons">
                <button type="submit">Guardar cambios</button>
                <a href="../index.php" class="cancel-btn">Cancelar</a>
            </div>
        </form>
    </div>
</body>

</html>