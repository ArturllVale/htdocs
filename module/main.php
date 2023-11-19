<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lumen Flux</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/estilo.css">
</head>

<body>
  <div class="container">
    <div class="row index-box">
      <?php include('menu.php'); ?>
      <div class="col-md-12 index-direita-main">
        <h2>Bem vindo <?php echo $_SESSION["usuario"]; ?>!</h2>
        <ul>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Integer semper dui diam, eu euismod augue iaculis et.
            Nullam ante justo, faucibus eget fringilla a, maximus ut orci.
            Nulla justo lacus, tincidunt sed tempus ac, interdum at purus.
            Proin accumsan dictum tellus eu rutrum. Pellentesque sed dapibus nisi.
            Suspendisse tristique sodales ultrices. Donec nec ultrices lorem.</p>
        </ul>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>