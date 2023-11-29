<?php
// Verifica se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: index.php");
    exit();
}
?>
<h2>MVPs Vivos</h2>
<div class="row">
    <?php
    $dados = buscarDadosMvpStatus();
    for ($i = 0; $i < count($dados); $i += 4) {
        echo '<div class="row">';
        for ($j = $i; $j < $i + 4; $j++) {
            echo '<div class="col">';
            echo '<div class="card" style="width: 18rem;">';
            echo '<img src="data/' . strtolower($dados[$j]['mvpName']) . '.png" class="card-img-top ' . ($dados[$j]['status'] === 'MORTO' ? 'grayscale' : '') . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $dados[$j]['mvpName'] . '</h5>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
    ?>
</div>
<script>
    setInterval(function() {
    $.ajax({
      url: '../module/buscar_dados.php', // Substitua pelo caminho do seu arquivo PHP
      type: 'GET',
      success: function(data) {
        // Limpa a tabela
        $('.row').empty();
  
        // Preenche a tabela com os novos dados
        for(let i = 0; i < data.length; i+=4) {
          let row = $('<div class="row"></div>');
          for(let j = i; j < i + 4; j++) {
            let col = $(
              '<div class="col">' +
                '<div class="card" style="width: 18rem;">' +
                  '<img src="../data/' + data[j].mvpName.toLowerCase() + '.png" class="card-img-top ' + (data[j].status === 'MORTO' ? 'grayscale' : '') + '">' +
                  '<div class="card-body">' +
                    '<h5 class="card-title">' + data[j].mvpName + '</h5>' +
                  '</div>' +
                '</div>' +
              '</div>'
            );
            row.append(col);
          }
          $('.row').append(row);
        }
      }
    });
  }, 10000);  
</script>