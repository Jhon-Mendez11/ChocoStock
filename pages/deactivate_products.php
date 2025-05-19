<?php
require_once __DIR__ . '/../commons/db.php';

if (!isset($_GET['id'])) {
    die("ID no recibido");
}

$id = (int) $_GET['id'];

$query = "UPDATE productos SET activo = FALSE WHERE p_id = :id";
$stmt = $db->prepare($query);
$stmt->execute([':id' => $id]);

header("Location: /ChocoStock/index.php?eliminado=exitoso");
exit();
