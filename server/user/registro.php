<?php
require '../commons/db.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clave = $_POST['clave'];
    $name_user = $_POST['name_user'];

    try {
        // Verificar si ya existe esa clave
        $stmt = $db->prepare("SELECT * FROM usuario WHERE clave = :clave");
        $stmt->bindParam(':clave', $clave);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Esta clave ya está registrada'); window.location.href = '/cacao_app/login.php';</script>";
            exit();
        }

        // Insertar nueva clave
        $stmt = $db->prepare("INSERT INTO usuario (clave, name_user) VALUES (:clave, :name_user)");
        $stmt->bindParam(':clave', $clave);
        $stmt->bindParam(':name_user', $name_user);
        $stmt->execute();

        header("Location: /cacao_app/login.php");
    } catch (PDOException $e) {
        echo "Error en el registro: " . $e->getMessage();
        exit();
    }
}
?>
