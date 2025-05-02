<?php
session_start();
require '../commons/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clave = $_POST['clave'];

    try {
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE clave = :clave LIMIT 1");
        $stmt->bindParam(':clave', $clave);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['autenticado'] = true;
            header("Location: /ChocoStock/index.html");
            exit();
        } else {
            header('Location: /ChocoStock/Pnl_login.php?error=1');
        }

    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
        exit();
    }
}
?>