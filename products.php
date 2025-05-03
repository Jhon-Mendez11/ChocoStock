<?php
require 'server/commons/db.php';

// Obtener productos de la base de datos
$query = "SELECT * FROM productos ORDER BY fecha DESC";
$stmt = $db->query($query);

// Obtener todos los productos como arreglo asociativo
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cargar la plantilla
include 'templates/products_list.php';
?>