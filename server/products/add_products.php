<?php
session_start();
require '../commons/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $cantidad = $_POST['cantidad'] ?? 0;
    $precio = $_POST['precio'] ?? 0;
    $cantidad_min = $_POST['cantidad_min'] ?? 0;
    $u_id = $_SESSION['u_id'] ?? '';

    $query = "INSERT INTO productos (nombre, cantidad, precio, fecha, u_id)
              VALUES (:nombre, :cantidad, :precio, NOW(), :u_id)";

    $stmt = $db->prepare($query);
    $stmt->execute([
        ':nombre' => $nombre,
        ':cantidad' => $cantidad,
        ':precio' => $precio,
        ':u_id' => $u_id
    ]);

    header('Location: /ChocoStock/index.php?registro=exitoso');
    exit;
}
?>