<?php
error_reporting(0);
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>LICITAME</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico" />

  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/templatemo.css" />
  <link rel="stylesheet" href="assets/css/custom.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap" />
  <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./ass"></script>
</head>

<body>
  <!-- Header -->
  <nav class="navbar navbar-expand-lg navbar-light shadow bg-black">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="navbar-brand logo h1 align-self-center text-blue" href="index.php">LICITAME</a>

      <button class="navbar-toggler navbar-dark border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="align-self-center collapse navbar-collapse flex-fill d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
        <div class="flex-fill">
          <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
            <li class="nav-item">
              <a class="nav-link text-white" id="home-link" href="index.php">Página Inicial</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-blue" id="licitacoes-link" href="licitacoes.php">Licitações</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" id="sugestoes-link" href="sugestoes.php">Sugestões</a>
            </li>
          </ul>
        </div>
        <div class="navbar align-self-center d-flex">
          <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
            <div class="input-group">
              <input type="text" class="form-control" id="inputMobileSearch" placeholder="Search ..." />
              <div class="input-group-text">
                <i class="fa fa-fw fa-search"></i>
              </div>
            </div>
          </div>
          <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal" data-bs-target="#templatemo_search">
            <i class="fa fa-fw fa-search text-dark mr-2 text-white"></i>
          </a>
          <?php
          if (!isset($_SESSION['user_email'])) {
            echo $_SESSION['user_email'];
            echo '
            <a class="nav-icon position-relative text-decoration-none" href="login.html">
            <i class="fa fa-fw fa-user text-white mr-3"></i>
            </a>
            ';
          } else {
            if ($_SESSION['tipo_utilizador'] == "avaliador") {
              echo '            
              <a class="nav-icon position-relative text-decoration-none" href="perfilavaliador.php">
              <i class="fa fa-fw fa-check text-white mr-1"></i>
              </a>';
            }else{
              echo '            
              <a class="nav-icon position-relative text-decoration-none" href="novo_leilao.php">
              <i class="fa fa-fw fa-plus-circle text-white mr-1"></i>
              </a>';
            }
            echo '
              
            <a class="nav-icon position-relative text-decoration-none" href="perfilutilizador.php">
            <i class="fa fa-fw fa-user text-white mr-1"></i>
            </a>

            <a class="nav-icon position-relative text-decoration-none" id="logout">
            <i class="fa fa-fw fa-user-slash text-white mr-1"></i>
            </a>
            ';
          }
          ?>
        </div>
      </div>
    </div>
  </nav>
  <!-- Close Header -->

  <!-- Modal -->
  <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="w-100 pt-1 mb-5 text-right">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="get" class="modal-content modal-body border-0 p-0">
        <div class="input-group mb-2">
          <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ..." />
          <button type="submit" class="input-group-text btn-blue text-light">
            <i class="fa fa-fw fa-search text-white"></i>
          </button>
        </div>
      </form>
    </div>
  </div>

  <div class="container-fluid bg-light py-5">
    <div class="col-md-6 m-auto text-center">
      <h1 class="h1">Leilões Ativos</h1>
    </div>
  </div>

  <!-- Content -->
  <div class="container_maior py-5 w-80">
    <div class="row">
      <div id="menu" class="col-md-3 menu-categoria">
        <h4>Categorias</h4>
        <div class="list-group">
          <option onclick="catClick(this)" value="1" class="cat list-group-item list-group-item-action">Belas Artes</option>
          <option onclick="catClick(this)" value="2" class="cat list-group-item list-group-item-action">Artes Visuais</option>
          <option onclick="catClick(this)" value="3" class="cat list-group-item list-group-item-action">Arte Contemporânea</option>
        </div>

        <h4 class="mt-4">Filtro de Preço de Compra</h4>
        <div>
          <div class="mb-3">
            <label for="min-price" class="form-label">Preço Minimo</label>
            <input type="number" class="form-control" id="min-price" placeholder="..." />
          </div>
          <div class="mb-3">
            <label for="max-price" class="form-label">Preço Maximo</label>
            <input type="number" class="form-control" id="max-price" placeholder="..." />
          </div>
          <button id="filter" class="w-100 btn btn-blue">Aplicar Filtro</button>
          <div class="m-b-18">
            <p id="mensagem" style="color: red"></p>
          </div>
        </div>
        <br>
      </div>

      <div class="col-lg-9">

        <div class="row" id="inserir"></div>

      </div>

    </div>
  </div>

  <!-- Content -->

  <!-- Footer -->
  <div id="gerar-footer"></div>
  <!-- Footer -->

  <!-- Script -->
  <script src="assets/js/gerar-footer.js"></script>
  <script src="assets/js/jquery-1.11.0.min.js"></script>
  <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/templatemo.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="assets/js/gerar.js"></script>
  <script src="src/js/user.js"></script>

  <script>
    $(window).on('resize', function() {
      var win = $(this);
      if (win.width() < 1200) {
        $('.cartao').addClass('col-md-5');
        $('.cartao').removeClass('col-md-4');
      } else {
        $('.cartao').addClass('col-md-4');
        $('.cartao').removeClass('col-md-5');
      }

      if (win.width() <= 991) {
        $('#menu').addClass('w-100');
        $('#menu').removeClass('col-md-3');

        $('.cartao').addClass('col-md-4');
        $('.cartao').removeClass('col-md-5');
      } else {
        $('#menu').addClass('col-md-3');
        $('#menu').removeClass('w-100');
      }

      if (win.width() > 2000) {
        $('.cartao').addClass('col-md-3');
        $('.cartao').removeClass('col-md-4');
      } else {
        $('.cartao').addClass('col-md-4');
        $('.cartao').removeClass('col-md-3');
      }

    });
  </script>

  <script src="src/js/actions.js"></script>
  <!-- Script -->
</body>

</html>