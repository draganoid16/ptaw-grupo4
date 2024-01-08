<?php
error_reporting(0);
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Projecto Web</title>
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

      <button class="navbar-toggler  navbar-darkborder-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
            <i class="fa fa-fw fa-search text-white mr-2"></i>
          </a>
          <?php
          if (!isset($_SESSION['user_email'])) {
            echo $_SESSION['user_email'];
            echo '<a class="nav-icon position-relative text-decoration-none" href="login.html">
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
  <div class="container my-3">
    <a href="licitacoes.php" class="btn btn-outline-secondary">
      <i class="fa fa-arrow-left"></i> Voltar para Lista de Leilões
    </a>
  </div>
  <!-- Main content -->
  <main class="container my-5">
    <div class="row">
      <!-- Image gallery -->
      <div class="col-md-6">
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

      <?php
      include 'api/config/database.php';

      $itemId = $_GET['Leilão'];
      $tempoRestante =  $_GET['TempoRestante'];
      $db = new Database();

      $conn = $db->connectTest();
      $stmt = $conn->prepare("SELECT * FROM items where id = :id LIMIT 100");

      $stmt->bindParam(':id', $itemId);
      $stmt->execute();

      $item = $stmt->fetch(PDO::FETCH_ASSOC);
      ?>
      <script>
        let item = '<?php echo json_encode($item) ?>';
        let id = '<?php echo $_SESSION['id']; ?>';
      </script>

      <!-- Bidding section -->
      <div class="col-md-6">
        <h2><?php echo $item['titulo']; ?></h2>
        <a href="perfilVendedor.html" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#userProfileModal">
          <h2 class="text-blue" id="vendedorNome" style="cursor: pointer; transition: 0.3s;">
            Vendedor X
            <style>
              #vendedorNome:hover {
                text-decoration: underline;
              }
            </style>
          </h2>

        </a>
        <hr />
        <div class="mb-3">
          <strong>Licitação Atual:</strong> <span><?php echo $item['licitacao_corrente'];
                                                  echo '€'; ?></span>
        </div>
        <div class="mb-3">
          <strong>Licitação Inicial:</strong> <span><?php echo $item['primeira_licitacao'];
                                                  echo '€'; ?></span>
        </div>
        <div class="mb-3">
          <strong>Comprar Agora:</strong> <span><?php echo $item['comprar_agora_preco'];
                                                echo '€'; ?></span>
        </div>
        <div class="mb-3">
        <strong>Tempo Restante:</strong> <span id="tempo_restante"><?php echo $tempoRestante; ?></span>
        </div>
        <div class="mb-3"><strong>Licitações:</strong> <span><?php echo $item['num_licitacoes']; ?></span></div>
        <hr />
          <?php
          if (!isset($_SESSION['user_email'])) {
            echo ' 
            <form action="login.html">       
            <button type="submit" class="btn btn-primary">
              Inicie sessão para licitar ou comprar 
            </button>
            </form>';
          } else {
            echo ' 
            <div class="mb-3">
            <label for="bidAmount" class="form-label">A sua Licitação:</label>
            <input type="number" class="form-control" id="bidAmount" placeholder="Introduza o valor da sua licitação" />
          </div>   
          <p id="textoErro"></p>    
          <button type="submit" class="btn btn-primary" id="submeter">
            Confirmar Licitação
          </button>
          <button type="submit" class="btn btn-secondary" id="comprar_agora">
            Comprar Agora
          </button>';
          }
          ?>
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

    <!-- Description section -->
    <div class="row mt-5">
      <div class="col-12">
        <h3>Descrição</h3>
        <p style="word-wrap: break-word;">
          <?php echo $item['descricao']; ?>
        </p>
      </div>
    </div>
  </main>

  <!-- Start Footer -->
  <div id="gerar-footer"></div>
  <!-- End Footer -->

  <!-- Start Script -->
  <script src="assets/js/gerar-footer.js"></script>
  <script src="assets/js/jquery-1.11.0.min.js"></script>
  <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/templatemo.js"></script>
  <script src="assets/js/custom.js"></script>
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
        $(".modal-body").load("perfilvendedor.html");
      });
    });
  </script>
  <!-- End Slider Script -->
  <!-- Start Script -->
  <script src="assets/js/jquery-1.11.0.min.js"></script>
  <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/templatemo.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="src/js/user.js"></script>
  <script src="src/js/dom.js"></script>
  <script src="src/js/actions.js"></script>
  <script src="src/js/gerar.js"></script>
  <!-- End Script -->
</body>

</html>