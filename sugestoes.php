<?php
error_reporting(0);
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>LICITAME</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">

    <!-- Load map styles -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let nomeD = '<?php echo $_SESSION['nome'] ?>';
        let emailD = '<?php echo $_SESSION['user_email'] ?>';
    </script>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow bg-black">
        <div class="container d-flex justify-content-between align-items-center">

            <a class="navbar-brand logo h1 align-self-center text-blue" href="index.php">LICITAME</a>

            <button class="navbar-toggler navbar-dark border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
                <div class="flex-fill ">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" id="home-link" href="index.php">Página Inicial</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" id="licitacoes-link" href="licitacoes.php">Licitações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-blue" id="sugestoes-link" href="sugestoes.php">Sugestões</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar align-self-center d-flex">
                    <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="inputMobileSearch" placeholder="Search ...">
                            <div class="input-group-text">
                                <i class="fa fa-fw fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <a class="nav-icon d-none d-lg-inline" href="" data-bs-toggle="modal" data-bs-target="#templatemo_search">
                        <i class="fa fa-fw fa-search text-dark mr-2 text-white"></i>
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
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-blue text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Start Content Page -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">Escreva a sua sugestão</h1>
        </div>
    </div>

    <!-- Start Sugestões -->
    <div class="container py-5">
        <div class="row py-5">
            <div class="col-md-9 m-auto">

                <?php
                if (!isset($_SESSION['user_email'])) {
                    echo '                
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="inputname">Nome</label>
                                <input type="text" class="form-control mt-1" id="nome" name="name" placeholder="Nome">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="inputemail">Email</label>
                                <input type="email" class="form-control mt-1" id="email" name="email" placeholder="Email">
                            </div>
                        </div>';
                }
                ?>

                <div class="mb-3">
                    <label for="inputsubject">Assunto</label>
                    <input type="text" class="form-control mt-1" id="assunto" name="subject" placeholder="Assunto">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">Mensagem</label>
                    <textarea class="form-control mt-1" id="message" name="mensagem" placeholder="Mensagem" rows="8"></textarea>
                </div>
                <div class="m-b-18">
                    <p id="mensagem" style="color: red"></p>
                </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button id="enviar" class="btn btn-blue">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Sugestões -->
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
    <script src="src/js/user.js"></script>
    <script src="src/js/actions.js"></script>
    <!-- End Script -->
</body>

</html>