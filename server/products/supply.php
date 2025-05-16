<?php
session_start();

require '../commons/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p_id = $_POST['id_producto'] ?? '';
    $cantidad = $_POST['cantidad'] ?? 0;
    $u_id = $_SESSION['u_id'];
    $precio = $_POST['precio_venta'] ?? '';

    if ($p_id && $cantidad > 0) {
        // 1. Sumar la cantidad al inventario
        $update = "UPDATE productos SET cantidad = cantidad + :cantidad WHERE p_id = :p_id";
        $stmt = $db->prepare($update);
        $stmt->execute([
            ':cantidad' => $cantidad,
            ':p_id' => $p_id
        ]);
    }

    $mov = "INSERT INTO movimientos (tipo_mov, cantidad, producto_id, u_id, precio)
    VALUES ('entrada', :cantidad, :p_id, :u_id, :precio_venta)";
    $stmt_mov = $db->prepare($mov);
    $stmt_mov->execute([
        ':cantidad' => $cantidad,
        ':p_id' => $p_id,
        ':u_id' => $_SESSION['u_id'],
        ':precio_venta' => $precio
    ]);

    header('Location: /ChocoStock/index.php?supply=exitoso');
    exit;
}
?>