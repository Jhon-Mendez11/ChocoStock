<?php
session_start();
require '../commons/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad = $_POST['cantidad'] ?? 0;
    $precio_venta = $_POST['precio_venta'] ?? 0;
    $p_id = $_POST['id_producto'] ?? '';
    $u_id = $_SESSION['u_id'] ?? null;

    if ($p_id === '' || $u_id === null) {
        echo json_encode([
            'success' => false,
            'text' => 'Datos incompletos.'
        ]);
        exit;
    }

    try {
        // Verificar stock actual
        $stmt = $db->prepare("SELECT cantidad FROM productos WHERE p_id = :p_id");
        $stmt->execute([':p_id' => $p_id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$producto) {
            echo json_encode([
                'success' => false,
                'text' => 'Producto no encontrado.'
            ]);
            exit;
        }

        $stock_actual = (int) $producto['cantidad'];
        $cantidad_venta = (int) $cantidad;

        if ($cantidad_venta <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Cantidad inválida.'
            ]);
            exit;
        }

        if ($cantidad_venta > $stock_actual) {
            echo json_encode([
                'success' => false,
                'message' => 'No hay suficiente stock para realizar la venta.'
            ]);
            exit;
        }
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
    
        $mov = "INSERT INTO movimientos (tipo_mov, cantidad, producto_id, u_id, precio)
        VALUES ('salida', :cantidad, :p_id, :u_id, :precio_venta)";
        $stmt_mov = $db->prepare($mov);
        $stmt_mov->execute([
            ':cantidad' => $cantidad,
            ':p_id' => $p_id,
            ':u_id' => $_SESSION['u_id'],
            ':precio_venta' => $precio
        ]);
    }

    catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error en la base de datos.'
        ]);
    }
    header('Location: /ChocoStock/index.php?sale=exitoso');
    exit;
}

?>