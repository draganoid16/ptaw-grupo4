document.addEventListener('DOMContentLoaded', function () {
    const footerHTML = `
    <footer class="bg-dark" id="tempaltemo_footer">
    <div class="container">
      <div class="row">
        <div class="col-md-4 pt-5">
          <h2 class="h2 text-blue border-bottom pb-3 border-light logo">
            LICITAME
          </h2>
          <ul class="list-unstyled text-light footer-link-list">
            <li>
              <i class="fas fa-map-marker-alt fa-fw"></i>
              R. Cmte. Pinho e Freitas 28, 3750-127 Águeda
            </li>
            <li>
              <i class="fa fa-phone fa-fw"></i>
              <a class="text-decoration-none" href="tel:234-611-500"
                >234 611 500</a
              >
            </li>
            <li>
              <i class="fa fa-envelope fa-fw"></i>
              <a class="text-decoration-none" href="mail:estga.geral@ua.pt"
                >estga.geral@ua.pt</a
              >
            </li>
          </ul>
        </div>
      </div>

      <div class="row text-light mb-4">
        <div class="col-12 mb-3">
          <div class="w-100 my-3 border-top border-light"></div>
        </div>
        <div class="col-auto me-auto">
          <ul class="list-inline text-left footer-icons">
            <li
              class="list-inline-item border border-light rounded-circle text-center"
            >
              <a
                class="text-light text-decoration-none"
                target="_blank"
                href="http://facebook.com/"
                ><i class="fab fa-facebook-f fa-lg fa-fw"></i
              ></a>
            </li>
            <li
              class="list-inline-item border border-light rounded-circle text-center"
            >
              <a
                class="text-light text-decoration-none"
                target="_blank"
                href="https://www.instagram.com/"
                ><i class="fab fa-instagram fa-lg fa-fw"></i
              ></a>
            </li>
            <li
              class="list-inline-item border border-light rounded-circle text-center"
            >
              <a
                class="text-light text-decoration-none"
                target="_blank"
                href="https://twitter.com/"
                ><i class="fab fa-twitter fa-lg fa-fw"></i
              ></a>
            </li>
            <li
              class="list-inline-item border border-light rounded-circle text-center"
            >
              <a
                class="text-light text-decoration-none"
                target="_blank"
                href="https://www.linkedin.com/"
                ><i class="fab fa-linkedin fa-lg fa-fw"></i
              ></a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="w-100 bg-dark py-3">
      <div class="container">
        <div class="row pt-2">
          <div class="col-12">
            <p class="text-left text-light">
              Copyright &copy; 2023 | Criado por João Coelho, Gonçalo Dias,
              Tomás Rosa, Gonçalo Gonçalves<a
                rel="sponsored"
                target="_blank"
              ></a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>
    `;
  
    const footerDiv = document.getElementById('gerar-footer');
    if (footerDiv) {
      footerDiv.innerHTML = footerHTML;
    }
  });