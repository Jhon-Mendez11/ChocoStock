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
    <div class="p_contenedor">
        <h1>Editar producto</h1>
        <form method="POST">
            <label>Nombre:
                <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
            </label><br>

            <label>Cantidad:
                <input type="number" name="cantidad" value="<?= $producto['cantidad'] ?>" required>
            </label><br>

            <label>Precio:
                <input type="number" step="1" name="precio" value="<?= $producto['precio'] ?>" required>
            </label><br>

            <label>Cantidad mínima:
                <input type="number" name="cantidad_min" value="<?= $producto['cantidad_min'] ?>" required>
            </label><br>

            <div class="form-buttons">
                <button type="submit">Guardar cambios</button>
                <a href="../index.php" class="cancel-btn">Cancelar</a>
            </div>

        </form>
    </div>
</body>

</html>