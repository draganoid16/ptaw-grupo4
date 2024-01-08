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

<body>
  <!-- Header -->
  <nav class="navbar navbar-expand-lg bg-black">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="navbar-brand logo h1 align-self-center text-blue" href="index.php">LICITAME</a>

      <button class="navbar-toggler navbar-dark border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="align-self-center collapse navbar-collapse flex-fill d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
        <div class="flex-fill">
          <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
            <li class="nav-item">
              <a class="nav-link text-blue" id="home-link" href="index.php">Página Inicial</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link text-white" href="licitacoes.php">Licitações
              </a>
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
            <i class="fa fa-fw fa-search text-white mr-2"></i>
          </a>
          <?php
          if (!isset($_SESSION['user_email'])) {
            echo '
            <a class="nav-icon position-relative text-decoration-none" href="login.html">
            <i class="fa fa-fw fa-user text-white mr-1"></i>
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

  <!-- Profile Modal -->
  <div class="modal fade" id="userProfileModal" tabindex="-1" aria-labelledby="userProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-body">
          <!-- Content will be loaded here -->
        </div>
      </div>
    </div>
  </div>

  <!-- Start Banner Hero -->
  <div id="template-mo-zay-hero-carousel" class="carousel slide" daqsta-bs-ride="carousel">
    <ol class="carousel-indicators">
      <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
      <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
      <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="container">
          <div class="row p-5">
            <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
              <img class="img-fluid" src="./assets/img/slide1.jpg" alt="" />
            </div>
            <div class="col-lg-6 mb-0 d-flex align-items-center">
              <div class="text-align-left align-self-center">
                <h1 class="h1 text-blue"><b>LICITAME</b> Leilões</h1>
                <h3 class="h2">Tranquilidade e Segurança</h3>
                <p>
                  A <bold>LICITAME</bold> apresenta a revolucionária
                  plataforma de leilões online para colecionadores de arte,
                  garantindo segurança e confiabilidade em todas as
                  transações. Desfrute da tranquilidade de saber que cada item
                  leiloado passa por um rigoroso processo de autenticação. A
                  nossa parceria com especialistas no mercado de arte assegura
                  que todos os itens listados são genuínos e de grande valor.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="container">
          <div class="row p-5">
            <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
              <img class="img-fluid" src="./assets/img/slide2.jpg" alt="" />
            </div>
            <div class="col-lg-6 mb-0 d-flex align-items-center">
              <div class="text-align-left">
                <h1 class="h1 text-blue">Fascinação pela <b>Arte</b></h1>
                <h3 class="h2">Intuitivo e Moderno</h3>
                <p>
                  Mergulhe no fascinante mundo da arte com a nossa plataforma.
                  Com uma interface intuitiva e recursos avançados,
                  proporcionamos uma experiência de leilão online excepcional
                  para entusiastas e colecionadores de arte. Partilhe a sua
                  paixão com outros membros da nossa comunidade e explore a
                  diversidade de obras-primas disponíveis.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="container">
          <div class="row p-5">
            <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
              <img class="img-fluid" src="./assets/img/slide3.jpg" alt="" />
            </div>
            <div class="col-lg-6 mb-0 d-flex align-items-center">
              <div class="text-align-left">
                <h1 class="h1 text-blue">Arte sem <b>Fronteiras</b></h1>
                <h3 class="h2">Juntos na diversificidade</h3>
                <p>
                  Queremos ir além das fronteiras geográficas, aproximando
                  colecionadores de arte e entusiastas em todo o mundo. Na
                  nossa plataforma, poderá encontrar e adquirir peças únicas
                  que refletem diferentes culturas e períodos da história da
                  arte. Junte-se a nós e amplie os seus horizontes,
                  descobrindo novas perspectivas e possibilidades neste
                  mercado tão rico e variado.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
      <i class="fas fa-chevron-left"></i>
    </a>
    <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
      <i class="fas fa-chevron-right"></i>
    </a>
  </div>
  <!-- End Banner Hero -->

  <!-- GET STARTED -->
  <section class="bg-white">
    <div class="container py-5">
      <div class="row text-center py-3">
        <div class="col-lg-6 m-auto">
          <h1 class="h1"><b>Como Começar?</b></h1>
          <p class="lead">
            Siga os passos abaixo para iniciar a sua jornada no mundo dos
            leilões de arte.
          </p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 text-center">
          <i class="fas fa-user-plus fa-3x mb-3"></i>
          <h3>Crie a sua conta</h3>
          <p>
            Registe-se na plataforma para começar a explorar e participar nos
            leilões de arte disponíveis.
          </p>
        </div>
        <div class="col-md-4 text-center">
          <i class="fas fa-gavel fa-3x mb-3"></i>
          <h3>Liste e licite</h3>
          <p>
            Liste os seus itens para leilão e licite nas obras de arte que
            despertam o seu interesse.
          </p>
        </div>
        <div class="col-md-4 text-center">
          <i class="fas fa-shield-alt fa-3x mb-3"></i>
          <h3>Transações seguras</h3>
          <p>
            Gira as suas transações financeiras com confiança, sabendo que
            a plataforma garante segurança e autenticidade.
          </p>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-12 text-center">
          <a href="sign_up.html" class="btn btn-primary btn-lg">Registe-se agora</a>
          <a href="#" class="btn btn-secondary btn-lg">Saiba mais</a>
        </div>
      </div>
    </div>
  </section>
  <!-- End GET STARTED-->

  <!-- Start Featured Product -->
  <section class="bg-white">
    <div class="container_maior py-5">
      <div class="row text-center py-3">
        <div class="col-lg-6 m-auto">
          <h1 class="h1"><b>Leilões Mais Recentes</b></h1>
        </div>
      </div>
      <div class="container_maior py-5">
        <div class="row d-flex justify-content-center" id="inserir"></div>
      </div>
    </div>
  </section>
  <!-- End Featured Product -->

  <div id="gerar-footer"></div>
  <!-- End Footer -->

  <!-- Start Script -->
  <script src="assets/js/jquery-1.11.0.min.js"></script>
  <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/templatemo.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="assets/js/gerar-box-index.js"></script>
  <script src="assets/js/gerar-footer.js"></script>
  <script src="src/js/user.js"></script>
  <!-- End Script -->
</body>

</html>