// Oculta todos os conteúdos inicialmente
window.onload = function () {
    var allContents = document.getElementsByClassName("content");
    for (var i = 0; i < allContents.length; i++) {
        allContents[i].style.display = "none";
    }
};

function toggleCollapse(btnNumber) {
    var contentId = "content" + btnNumber;
    var content = document.getElementById(contentId);

    // Mostra ou oculta o conteúdo clicado
    if (content.style.display === "block") {
        content.style.display = "none";
    } else {
        // Oculta todos os conteúdos antes de mostrar o atual
        var allContents = document.getElementsByClassName("content");
        for (var i = 0; i < allContents.length; i++) {
            allContents[i].style.display = "none";
        }

        content.style.display = "block";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    window.onscroll = function () {
        scrollFunction();
    };
});

function scrollFunction() {
    var topBtn = document.getElementById("topBtn");
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        topBtn.style.opacity = "1";
        topBtn.style.display = "block";
    } else {
        topBtn.style.opacity = "0";
        setTimeout(function () {
            topBtn.style.display = "none";
        }, 400); // Tempo correspondente à transição CSS
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

// Lista de classes
var classes = ["bg1", "bg2", "bg3"];

// Função para escolher uma classe aleatória
function escolherClasseAleatoria() {
    return classes[Math.floor(Math.random() * classes.length)];
}

// Obter o elemento
var elemento = document.querySelector(".index-esquerda");

// Remover classes existentes
elemento.classList.remove(...classes);

// Adicionar a classe aleatória
elemento.classList.add(escolherClasseAleatoria());

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
                  '<img src="../data/' + data[j].mvpName.toLowerCase() + '.jpg" class="card-img-top ' + (data[j].status === 'MORTO' ? 'grayscale' : '') + '">' +
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