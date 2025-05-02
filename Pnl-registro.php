<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de clave</title>
    <link rel="stylesheet" href="css/login.css" />
</head>

<body>
    <div class="login-container">
        <h2>Registrar nueva usuario </h2>
        <form action="server/user/registro.php" method="POST" autocomplete="off">
            <br>
            <label>
                <span>Nombre del usuario</span>
                <input type="text" id="name_user" name="name_user" placeholder="Nombre">
            </label>
            <label>
                <span>Registre su clave</span>
                <input type="password" id="clave" name="clave" placeholder="clave" required />
            </label>
            <button type="submit">Registrar</button>
            <br><br>
            <label>
                <a href="login.php" class="btn-reg">Volver al login</a>
            </label>
        </form>
    </div>
</body>

</html>