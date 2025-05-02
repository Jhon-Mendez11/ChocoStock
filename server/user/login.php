<?php
session_start();
require '../commons/db.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clave = $_POST['clave'];

    try {
        $stmt = $db->prepare("SELECT * FROM usuario WHERE clave = :clave LIMIT 1");
        $stmt->bindParam(':clave', $clave);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['autenticado'] = true;
            header("Location: /cacao_app/index.html");
            exit();
        } else {
            header('Location: /cacao_app/login.php?error=1');
        }

    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
        exit();
    }
}
?>
