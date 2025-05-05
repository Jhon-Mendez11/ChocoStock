<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['u_id'])) {
    echo json_encode([
        'u_id' => $_SESSION['u_id'],
        'name_u' => $_SESSION['name_u']
    ]);
} else {
    echo json_encode(['error' => 'No hay sesión activa']);
}
