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
        <li><a href="pages/sales.php">Salida</a></li>
        <li><a href="pages/supply.php">Entrada</a></li>
        <li class="submenu"><a href="#">Reportes</a>
          <ul class="dropdown">
            <li><a href="pages/report_mov">Movimientos</a></li>
            <li><a href="pages/report.php">Reporte de Ventas</a></li>
          </ul>
        </li>
        <li><a href="server/user/logout.php" method="get" class="logout-link left-align">cerrar sesión</a></li>
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
            <th>Acciones</th>
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
                  <?= $p['eliminar'] = '<a href= /ChocoStock/product/delete_product.php?id=' . $p['p_id'] . ' class="btn-eliminar">Eliminar</a>' ?>;
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
      <form action="pages/products.php" method="get">
        <button type="submit" class="delete-btn btn">Registrar nuevo producto</button>
        <br>
        <div id="eliminacionMensaje" class="mensaje mensaje-exito" style="display: none;"></div>
        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
          <div id="registroProduct" class="mensaje mensaje-exito">
            ✅ Registro de nuevo producto exitoso.
          </div>
        <?php endif; ?>

        <?php if (isset($_GET['supply']) && $_GET['supply'] === 'exitoso'): ?>
          <div id="registroSupply" class="mensaje mensaje-exito">
            ✅ Se agrego producto al Inventario.
          </div>
        <?php endif; ?>
        <?php if (isset($_GET['sale']) && $_GET['sale'] === 'exitoso'): ?>
          <div id="registroSale" class="mensaje mensaje-exito">
            ✅ Venta Exitosa.
          </div>
        <?php endif; ?>
        <script>
          setTimeout(() => {
            const regSal = document.getElementById('registroSale');
            const regSup = document.getElementById('registroSupply');
            const regMsg = document.getElementById('registroProduct');
            if (regSal) regSal.style.display = 'none';
            if (regSup) regSup.style.display = 'none';
            if (regMsg) regMsg.style.display = 'none';
          }, 4000);
        </script>

      </form>
    </div>

  </main>

</body>

</html>