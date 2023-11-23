<?php
  include "header.php";
?>

<body>
  <?php
  if (isset($_SESSION["logado"]) && $_SESSION["logado"]) {
    include "module/main.php";
  } else {
    include "module/login.php";
  }
  ?>

  <div id="cookieConsentPopup" class="fixed-bottom p-3 bg-light" style="display: none;">
    <div class="container text-center">
      <p class="mb-0">Este site usa cookies para garantir que você obtenha a melhor experiência em nosso site. <button
          id="acceptCookiesButton" class="btn btn-primary btn-sm">Aceitar</button></p>
    </div>
  </div>
  <?php
  include "footer.php";
  ?>
  <script src="js/cookies.js"></script>