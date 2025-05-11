<?php
session_start();
require '../commons/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad = $_POST['cantidad'] ?? 0;
    $precio_venta = $_POST['precio_venta'] ?? 0;
    $p_id = $_POST['id_producto'] ?? '';
    $u_id = $_SESSION['u_id'] ?? null;

    if ($p_id !== null && $u_id !== null) {
        $query = "INSERT INTO ventas (id_producto, cantidad, precio_venta, fecha, u_id)
        VALUES (:p_id, :cantidad, :precio_venta, NOW(), :u_id)";

        $stmt = $db->prepare($query);
        $stmt->execute([
            ':p_id' => $p_id,
            ':cantidad' => $cantidad,
            ':precio_venta' => $precio_venta,
            ':u_id' => $u_id
        ]);

        $update = "UPDATE productos SET cantidad = cantidad - :cantidad WHERE p_id = :p_id";
        $stmt = $db->prepare($update);
        $stmt->execute([
            ':cantidad' => $cantidad,
            ':p_id' => $p_id
        ]);
    }

    header('Location: /ChocoStock/index.php');
    exit;
}

?>