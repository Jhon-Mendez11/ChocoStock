<?php
session_start();
session_unset();
session_destroy();
session_start();
require '../commons/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name_u = trim($_POST['name_u'] ?? '');

    // Validar que nombre no esté vacío y clave sea numérica
    if ($name_u === '' || !isset($_POST['clave']) || !is_numeric($_POST['clave'])) {
        header('Location: /ChocoStock/Pnl_login.php?error=credenciales');
        exit;
    }

    $clave = intval($_POST['clave']);

    $stmt = $db->prepare("SELECT * FROM usuarios WHERE name_u = :name_u AND clave = :clave LIMIT 1;");
    $stmt->execute([
        'name_u' => $name_u,
        'clave' => $clave
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['u_id'] = $user['u_id'];
        $_SESSION['name_u'] = $user['name_u'];
        header('Location: /ChocoStock/index.php');
        exit;
    } else {
        header('Location: /ChocoStock/Pnl_login.php?error=credenciales');
        exit;
    }
}
