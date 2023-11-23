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

  // Quando a página é carregada
document.addEventListener('DOMContentLoaded', function() {
  window.onscroll = function() {
      scrollFunction();
  };
});

// Mostra ou oculta o botão com base no scroll
function scrollFunction() {
  var topBtn = document.getElementById("topBtn");
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      topBtn.style.display = "block";
  } else {
      topBtn.style.display = "none";
  }
};

// Retorna ao topo quando o botão é clicado
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
};