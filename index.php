<table?php session_start(); ?>
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
      <div>
        <h1>Bienvenid@ a Choco Stock</h1>
        <h2>Inventario</h2>
        <table class="tabla-productos" id="list-products"></table>
        <br>
      </div>
      <form action="pages/products.php" method="post">
        <button type="summit">Agregar producto</button>
      </form>
    </main>

  </body>

  </html>