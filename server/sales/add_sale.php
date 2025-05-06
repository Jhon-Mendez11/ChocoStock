<?php
session_start();
require '../commons/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad = $_POST['cantidad'] ?? 0;
    $precio_venta = $_POST['precio_venta'] ?? 0;
    $cantidad_min = $_POST['cantidad_min'] ?? 0;
    $p_id = $_SESSION['p_id'] ?? '';

    $query = "INSERT INTO ventas (id_producto, cantidad, precio_venta, fecha)
              VALUES (:p_id, :cantidad, :precio_venta, NOW())";

    $stmt = $db->prepare($query);
    $stmt->execute([
        ':p_id' => $id_producto,
        ':cantidad' => $cantidad,
        ':precio_venta' => $precio_venta
    ]);

    header('Location: /ChocoStock/index.php');
    exit;
}

?>