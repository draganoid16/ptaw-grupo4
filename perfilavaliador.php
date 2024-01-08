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

  <link rel="apple-touch-icon" href="assets/img/apple-icon.png" />
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico" />

  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/templatemo.css" />
  <link rel="stylesheet" href="assets/css/custom.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />

  <!-- Load fonts style after rendering the layout styles -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap" />
  <link rel="stylesheet" href="assets/css/fontawesome.min.css" />

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
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
              <a class="nav-link text-white" id="licitacoes-link" href="licitacoes.php">Licitações</a>
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
            } else {
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
          </a>
        </div>
      </div>
    </div>
  </nav>
  <!-- Close Header -->

  <section class="my-3">
    <div class="container py-5">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col">
          <div class="card">
            <div class="rounded-top bg-dark text-white d-flex flex-row" style="height: 200px">
              <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px">
                <img src="assets\img\place.png" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1" />
              </div>
              <div class="ms-3" style="margin-top: 130px">
                <h5>
                  <?php
                  if (isset($_SESSION['user_email'])) {
                    echo $_SESSION['nome'];
                  }
                  ?>
                </h5>
                <p>Avaliador</p>
              </div>
            </div>
            <div class="p-4 text-black" style="background-color: #f8f9fa">
              <!--Para ser dinamico com a BD Queue-->
            </div>
            <div class="card-body p-4 text-black">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="lead fw-normal mb-0">Artigos a Avaliar</p>
              </div>
              <ul class="list-group" id="inserir">

              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Start Footer -->
  <div id="gerar-footer"></div>
  <!-- End Footer -->

  <script src="assets/js/gerar-footer.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-S1CTryJMVz/FFb5YQ0Mz2tsA2z+BAYbe/8g8F0G+dhGeTQJ4TTiW0o8yNn1f4Vp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-rbsAued9C0b/m68RugAbXtlR2JogrVMiZVT1kCvTgTbj8zD0XfMwjg+Q4g4ZKj8Z" crossorigin="anonymous"></script>

  <script src="src/js/aprovar.js"></script>
  <script src="src/js/user.js"></script>
</body>

</html>