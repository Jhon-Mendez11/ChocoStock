<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar producto</title>
</head>

<body>
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

        <button type="submit">Guardar cambios</button>
    </form>
</body>

</html>