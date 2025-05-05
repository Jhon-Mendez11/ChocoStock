<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/styles.css" />
  <title>Choco Stock</title>
  <script src='js/app.js'></script>
</head>

<body>

  <main>
    <nav class="menu">
      <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="pages/products.php">Agregar producto</a></li>
        <li><a href="#">Reportes</a></li>
      </ul>
    </nav>
    <div>
      <h1>Bienvenid@ a Choco Stock</h1>
      <h2>Inventario de <?php echo $_SESSION['name_u']; ?></h2>
      <table class="tabla-productos">
        <thead>
          <tr>
            <th>Tipo de producto</th>
            <th>Cantidad</th>
            <th>precio</th>
            <th>fecha</th>
          </tr>
        </thead>
        <tbody id="list-products">
          <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $p): ?>
              <tr class="<?= ($p['cantidad'] < $p['cantidad_min']) ? 'alerta' : '' ?>">
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><?= $p['cantidad'] ?></td>
                <td><?= $p['precio'] ?></td>
                <td><?= date("d/m/Y H:i", strtotime($p['fecha'])) ?></td>
                <td>
                  <a href="edit_product.php?id=<?= $p['p_id'] ?>">Editar</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No hay productos registrados.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
      <br>
    </div>
  
  </main>

</body>

</html>