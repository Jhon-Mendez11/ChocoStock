<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ChocoStock web</title>
  <link rel="stylesheet" href="css/login.css" />
</head>

<body>
  <div class="login-container">
    <h1>Choco Stock</h1>
    <p>Ingresa tu clave para acceder</p>
    <form action="server/user/login.php" method="POST">
      <input type="password" name="clave" placeholder="Clave" required />
      <button type="submit">Ingresar</button>
      <br><br>
      <label>
        <a href="pnl-registro.php" class="btn-reg">registrar clave</a>
      </label>
    </form>
    <?php if (isset($_GET['error'])): ?>
      <p class="error">Credenciales incorrectas</p>
    <?php endif; ?>
  </div>
</body>

</html>