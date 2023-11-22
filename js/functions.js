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

    // Oculta todos os conteúdos
    var allContents = document.getElementsByClassName('content');
    for (var i = 0; i < allContents.length; i++) {
      allContents[i].style.display = 'none';
    }

    // Mostra ou oculta o conteúdo clicado
    if (content.style.display === 'none') {
      content.style.display = 'block';
    } else {
      content.style.display = 'none';
    }
  }