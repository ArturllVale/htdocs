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
  document.body.classList.add('loaded');
});