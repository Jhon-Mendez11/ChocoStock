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
        <table class="tabla-productos">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio (S/)</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr class="<?= ($p['cantidad'] < $p['cantidad_min']) ? 'alerta' : '' ?>">
                        <td><?= htmlspecialchars($p['nombre']) ?></td>
                        <td><?= $p['cantidad'] ?></td>
                        <td><?= $p['precio'] ?></td>
                        <td><?= date("d/m/Y H:i", strtotime($p['fecha'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>