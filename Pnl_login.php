<?php
// Solo para detectar mensajes de error o éxito
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ChocoStock web</title>
  <link rel="stylesheet" href="css/login.css" />
</head>

<body>
  <div class="contenedor">
    <form action="server/user/login.php" method="POST">
      <div class="login-container">
        <div class="titulo-login">
          <h1>Choco Stock</h1>
          <img src="img/CS.png" alt="Logo Choco Stock" />
        </div>

        <p>Ingresa tu clave y nombre para acceder</p>
        <input type="text" name="name_u" placeholder="Nombre de usuario" required />
        <input type="password" name="clave" placeholder="Clave" required />
        <button type="submit">Ingresar</button>
        <br /><br />
        <label>
          <a href="Pnl_register.php" class="btn-reg">registrar clave</a>
        </label>

        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
          <div id="registroMensaje" class="mensaje mensaje-exito">
            ✅ Registro exitoso. Puedes iniciar sesión.
          </div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'credenciales'): ?>
          <div id="loginMensaje" class="mensaje mensaje-error">
            Usuario o contraseña incorrectos.
          </div>
        <?php endif; ?>

        <script>
          setTimeout(() => {
            const loginMsg = document.getElementById('loginMensaje');
            const regMsg = document.getElementById('registroMensaje');
            if (loginMsg) loginMsg.style.display = 'none';
            if (regMsg) regMsg.style.display = 'none';
          }, 4000);
        </script>
      </div>
    </form>
  </div>
</body>

</html>
