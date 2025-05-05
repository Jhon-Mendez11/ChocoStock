<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>ChocoStock web</title>
  <link rel="stylesheet" href="css/login.css" />
</head>

<body>
  <div class="contenedor">
    <form action="server/user/login.php" method="POST">
      <div class="login-container">
        <h1>Choco Stock</h1>
        <p>Ingresa tu clave para acceder</p>
        <input type="password" name="clave" placeholder="Clave" required />
        <button type="submit">Ingresar</button>
        <br><br>
        <label>
          <a href="Pnl_register.php" class="btn-reg">registrar clave</a>
        </label>
        <?php if (isset($_GET['error'])): ?>
          <p class="error">Credenciales incorrectas</p>
        <?php endif; ?>
      </div>
    </form>
  </div>
</body>

</html>