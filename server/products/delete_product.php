<?php
header('Content-Type: application/json');
require '../commons/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['p_id'])) {
        try {
            $id = $data['p_id'];
            $stmt = $db->prepare("DELETE FROM productos WHERE p_id = :p_id");
            $stmt->execute(['p_id' => $id]);

            echo json_encode(["success" => true]);
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Missing ID"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
