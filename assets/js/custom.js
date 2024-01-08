function typeWriter(elemento) {
  const textoarray = elemento?.innerHTML.split('');
  elemento?.innerHTML = "";
  textoarray.forEach((letra, i) => {
    setTimeout(() =>
      elemento?.innerHTML += letra, 100 * i);
  });
}

typeWriter(document.querySelector('.pisca'));

function updateHeaderFontColor() {
  // Get URL pagina atual
  const currentPage = window.location.pathname.split('/').pop();

  // Define paginas para link mapping
  const pageToLinkId = {
    'index.html': 'home-link',
    'licitacoes.html': 'licitacoes-link',
    'sugestoes.html': 'sugestoes-link'
  };

  // Get pagina atual
  const activeLinkId = pageToLinkId[currentPage];

  // se encontrar, muda a cor
  if (activeLinkId) {
    const activeLink = document.getElementById(activeLinkId);
    activeLink.classList.add('text-blue');
  }
}


// onLoad chama a função
document.addEventListener('DOMContentLoaded', updateHeaderFontColor, imagens_item_unico);
