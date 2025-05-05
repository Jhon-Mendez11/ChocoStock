<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inventario - ChocoStock</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="contenedor">
        <h1>Inventario Doña Juana</h1>
        <a href="add_product.php" class="btn-agregar">➕ Agregar producto</a>
        <table class="tabla-productos">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio (S/)</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $p): ?>
                        <tr class="<?= ($p['cantidad'] < $p['cantidad_min']) ? 'alerta' : '' ?>">
                            <td><?= htmlspecialchars($p['nombre']) ?></td>
                            <td><?= $p['cantidad'] ?></td>
                            <td><?= $p['precio'] ?></td>
                            <td><?= date("d/m/Y H:i", strtotime($p['fecha'])) ?></td>
                            <td>
                                <a href="edit_product.php?id=<?= $p['p_id'] ?>">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No hay productos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>