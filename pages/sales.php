<?php
session_start();
require '../server/commons/db.php'; // tu archivo de conexión
$u_id = $_SESSION['u_id'];

$query = "SELECT p_id, nombre FROM productos where u_id = :u_id";
$stmt = $db->prepare($query);
$stmt->execute([':u_id' => $u_id]);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de venta</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="p_contenedor">
        <h2>Registrar venta</h2>
        <form action="../server/sales/add_sale.php" method="post">
            <div class="form-group">
                <label>Nombre:</label>
                <select name="id_producto" id="id_producto" required>
                    <option value="">Seleccione un producto</option>
                    <?php foreach ($productos as $p): ?>
                        <option value="<?= $p['p_id'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Cantidad:</label>
                <input type="number" name="cantidad" min="0" required>
            </div>
            <div class="form-group">
                <label>Precio (S/):</label>
                <input type="number" step="0.01" name="precio_venta" min="0" required>
            </div>

            <div class="form-buttons">
                <button type="submit">Guardar</button>
                <a href="../index.php" class="cancel-btn">Cancelar</a>
            </div>
        </form>
    </div>
</body>

</html>