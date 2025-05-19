<?php
require '../commons/db.php';
header('Content-Type: application/json');

if (!isset($_GET['u_id'])) {
    echo json_encode(['error' => 'Falta el parámetro u_id']);
    exit;
}

$u_id = $_GET['u_id'];

try {
    $stmt = $db->prepare("SELECT * FROM productos WHERE u_id = :u_id AND activo = TRUE ORDER BY fecha DESC");//linea cambiada 
    $stmt->execute([
        'u_id' => $u_id
    ]);

    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($productos as &$producto) {
        $producto['editar'] = '<a href=/ChocoStock/pages/edit_p.php?id=' . $producto['p_id'] . '\ class=\"btn-editar\">Editar</a>';
    }
    echo json_encode($productos);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener productos: ' . $e->getMessage()]);
}
?>