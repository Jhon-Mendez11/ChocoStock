<?php
require '../commons/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $clave = $_POST['clave'];

    try {
        // Verificar si ya existe esa clave
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE clave = :clave");
        $stmt->bindParam(':clave', $clave);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Esta clave ya está registrada'); window.location.href = '/ChocoStock/Pnl_login.php';</script>";
            exit();
        }

        // Insertar nueva clave
        try {
            $q = "INSERT INTO usuarios (clave, name_u, correo) VALUES (:clave, :name_u, :correo)";
            $stmt = $db->prepare($q);
            $stmt->execute([
                "clave" => $_POST["clave"],
                "name_u" => $_POST["name_u"],
                "correo" => $_POST["correo"],
            ]);
        } catch (PDOException $e) {
            echo 'Error en la conexión ' . $e->getMessage();
            exit();
        }

        header("Location: /ChocoStock/Pnl_login.php");
    } catch (PDOException $e) {
        echo "Error en el registro: " . $e->getMessage();
        exit();
    }
}
?>