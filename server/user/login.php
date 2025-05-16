<?php
session_start();
session_unset(); 
session_destroy();
session_start();
require '../commons/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clave = $_POST['clave'];

    $stmt = $db->prepare("SELECT * FROM usuarios WHERE clave = :clave LIMIT 1;");
    $stmt->execute([
        'clave' => $clave
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($user)) {
        $_SESSION['u_id'] = $user['u_id'];
        $_SESSION['name_u'] = $user['name_u'];
        header('Location: /ChocoStock/index.php');
        exit;
    } else {
        header('Location: Pnl_login.php?error=credenciales');
        exit;
    }
}
?>