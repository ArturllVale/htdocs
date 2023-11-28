// Oculta todos os conteúdos inicialmente
window.onload = function() {
    var allContents = document.getElementsByClassName('content');
    for (var i = 0; i < allContents.length; i++) {
      allContents[i].style.display = 'none';
    }
  };

  function toggleCollapse(btnNumber) {
    var contentId = 'content' + btnNumber;
    var content = document.getElementById(contentId);

    // Mostra ou oculta o conteúdo clicado
    if (content.style.display === 'block') {
      content.style.display = 'none';
    } else {
      // Oculta todos os conteúdos antes de mostrar o atual
      var allContents = document.getElementsByClassName('content');
      for (var i = 0; i < allContents.length; i++) {
        allContents[i].style.display = 'none';
      }

      content.style.display = 'block';
    }
  };

document.addEventListener('DOMContentLoaded', function() {
    window.onscroll = function() {
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
        setTimeout(function() {
            topBtn.style.display = "none";
        }, 300); // Tempo correspondente à transição CSS
    }
};

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
};

// Lista de URLs das imagens
var imagens = [
  'url("../data/bgbox.png")',
  'url("../data/bgbox2.jpg")',
  'url("../data/bgbox3.jpg")'
];

// Função para escolher uma imagem aleatória
function escolherImagemAleatoria() {
  return imagens[Math.floor(Math.random() * imagens.length)];
}

// Aplicar a imagem aleatória ao elemento index
document.querySelector('.index-esquerda::before').style.backgroundImage = escolherImagemAleatoria();