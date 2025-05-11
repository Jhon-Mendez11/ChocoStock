<?php
require '../commons/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p_id = $_POST['id_producto'] ?? '';
    $cantidad = $_POST['cantidad'] ?? 0;
    $u_id = $_SESSION['u_id'];
    if ($p_id && $cantidad > 0) {
        // 1. Sumar la cantidad al inventario
        $update = "UPDATE productos SET cantidad = cantidad + :cantidad WHERE p_id = :p_id";
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
