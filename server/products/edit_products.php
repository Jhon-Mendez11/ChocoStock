<?php
require_once __DIR__ . '/../commons/db.php';

if (!isset($_GET['id'])) {
    die("ID de producto no proporcionado.");
}

$id = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $cantidad = (int) $_POST['cantidad'];
    $precio = intval($_POST['precio']);
    $cantidad_min = (int) $_POST['cantidad_min'];

    $query = "UPDATE productos 
              SET nombre = :nombre, cantidad = :cantidad, precio = :precio, cantidad_min = :cantidad_min 
              WHERE p_id = :id";

    $stmt = $db->prepare($query);
    $stmt->execute([
        ':nombre' => $nombre,
        ':cantidad' => $cantidad,
        ':precio' => $precio,
        ':cantidad_min' => $cantidad_min,
        ':id' => $id
    ]);

    header("Location: /ChocoStock/index.php");
    exit();
}

// Obtener datos del producto
$query = "SELECT * FROM productos WHERE p_id = :id";
$stmt = $db->prepare($query);
$stmt->execute([':id' => $id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    die("Producto no encontrado.");
}
?>