<?php
error_reporting(0);
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Avaliação</title>
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
  <nav class="navbar navbar-expand-lg bg-black">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="navbar-brand logo h1 align-self-center text-blue" href="index.php">LICITAME</a>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="align-self-center collapse navbar-collapse flex-fill d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
        <div class="flex-fill">
          <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
            <li class="nav-item">
              <a class="nav-link text-white" href="index.php">Página Inicial</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="licitacoes.php">Licitações</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="sugestoes.php">Sugestões</a>
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
          <!--Onclick user hover menu-->
          </a>
        </div>
      </div>
    </div>
  </nav>
  <!-- Close Header -->
  <section class="bg-light">
    <div class="container pb-5">
      <div class="row">
        <div class="col-lg-5 mt-5">

          <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div id="carroca" class="carousel-inner"></div>

            <button class="carousel-control-prev bg-transparent border-transparent" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
              <span class="carousel-control-prev-icon icon-black" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>

            <button class="carousel-control-next bg-transparent border-transparent" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
              <span class="carousel-control-next-icon icon-black" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>

        </div>
        <!-- col end -->
        <div class="col-lg-7 mt-5">
          <div class="card">
            <div class="card-body">
              <h1 id="titulo" class="h2"></h1>
              <p id="compra" class="h3 py-2"></p>
              <ul class="list-inline">
                <li class="list-inline-item">
                  <h6>Autor:</h6>
                </li>
                <li class="list-inline-item">
                  <p class="text-muted"><strong id="autor"></strong></p>
                </li>
              </ul>

              <h6>Descrição:</h6>
              <p id="desc"></p>
              <ul class="list-inline">
                <li class="list-inline-item">
                  <h6>Data de Submissão :</h6>
                </li>
                <li class="list-inline-item">
                  <p class="text-muted"><strong id="data_sub"></strong></p>
                </li>
              </ul>


              <div class="card">
                <div class="card-body">
                  <h1 class="h2">Documentos de avaliação</h1>
                  <ul id="inserir" class="list-group">
                  </ul>
                </div>
              </div>
              <br />

              <?php
              if (isset($_SESSION['user_email'])) {
                echo '
                <section>
                  <input type="hidden" name="product-title" value="Activewear">
                  <div class="row pb-3">
                    <div class="col d-grid">
                      <button id="aceitar" class="btn btn-success btn-lg" name="submit" value="buy">Validar Obra</button>
                    </div>
                    <div class="col d-grid">
                      <button id="rejeitar" class="btn btn-danger btn-lg" name="submit" value="addtocard">Rejeitar Obra</button>
                    </div>
                  </div>
                </section>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  </main>

  <!-- Start Footer -->
  <div id="gerar-footer"></div>

  <!-- End Footer -->

  <!-- Start Script -->
  <script src="assets/js/jquery-1.11.0.min.js"></script>
  <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/templatemo.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="assets/js/gerar-footer.js"></script>

  <!-- End Script -->

  <!-- Start Slider Script -->
  <script src="assets/js/slick.min.js"></script>
  <script>
    $("#carousel-related-product").slick({
      infinite: true,
      arrows: false,
      slidesToShow: 4,
      slidesToScroll: 3,
      dots: true,
      responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          },
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 3,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 3,
          },
        },
      ],
    });
  </script>

  <script>
    $(document).ready(function() {
      $("#userProfileModal").on("show.bs.modal", function() {
        $(".modal-body").load("perfil.php");
      });
    });
  </script>
  <script src="src/js/avaliar.js"></script>

  <script src="src/js/user.js"></script>
  <!-- End Slider Script -->
</body>

</html>