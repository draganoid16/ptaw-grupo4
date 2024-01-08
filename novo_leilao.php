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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">


    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap" />
    <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .main-container {
            width: 60%;
            margin: 0 auto;
        }
    </style>

    <script type="text/javascript">
        let id = '<?php echo $_SESSION['id']; ?>';
    </script>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg bg-black">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand logo h1 align-self-center text-blue" href="index.php">LICITAME</a>

            <button class="navbar-toggler  navbar-dark border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                        echo '<a class="nav-icon position-relative text-decoration-none" href="login.html">
                        <i class="fa fa-fw fa-user text-white mr-3"></i>
                        </a>
                        ';
                    } else {
                        echo '
                        <a class="nav-icon position-relative text-decoration-none" href="novo_leilao.php">
                        <i class="fa fa-fw fa-plus-circle text-white mr-1"></i>
                        </a>
                        
                        <a class="nav-icon position-relative text-decoration-none" href="perfilutilizador.php">
                        <i class="fa fa-fw fa-user text-white mr-3"></i>
                        </a>

                        <a class="nav-icon position-relative text-decoration-none" id="logout">
                        <i class="fa fa-fw fa-user-slash text-white mr-3"></i>
                        </a>
                        ';
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>
    <!-- Close Header -->

    <main class="container mt-5 ">
        <div class="main-container ">
            <h1 class="text-center mb-4">Crie um novo leilão</h1>
            <div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label id="ltitle" for="title" class="form-label">Titulo da obra</label>
                        <input type="text" class="form-control" id="title" placeholder="Introduza o titulo.">
                        <small class="form-text text-muted">Introduza o seu titulo. Este deve obrigatoriamente ter o nome da obra.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label id="limages" for="formFileMultiple" class="form-label">Imagens</label>
                        <input class="form-control" name="images[]" type="file" placeholder="Nenhuma imagem selecionada" id="images" multiple>
                        <small class="form-text text-muted">Introduza fotografias. Certifique-se que as imagens encontram-se nos seguintes formatos: PNG, JPG e JPEG.</small>
                    </div>

                    <div class="mb-3">
                        <label id="ldescription" for="description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="description" rows="3" placeholder="Introduza uma descrição."></textarea>
                        <small class="form-text text-muted">Introduza uma descrição que melhor descreva a arte.</small>
                    </div>

                    <div class="mb-3">
                        <label id="lauthDocuments" for="authDocuments" class="form-label">Documentos de Autenticação</label>
                        <input type="file" class="form-control" name="files[]" id="authDocuments" multiple>
                        <small class="form-text text-muted">Faça upload dos documentos necessários para autenticação da sua obra de arte. Apenas ficheiros do formato PDF são permitidos.</small>
                    </div>

                    <div class="mb-3">
                        <label id="lcategoria" for="authDocuments" class="form-label">Categoria</label>
                        <select class="form-select mb-3" id="categorias">
                            <option value="1">Belas Artes</option>
                            <option value="2">Artes Visuais</option>
                            <option value="3">Arte Contemporânea</option>
                        </select>
                        <small class="form-text text-muted">Escolha a categoria a que o seu item pertence.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label id="lstart_bid" for="start_bid" class="form-label">Licitação Inicial</label>
                            <input type="number" class="form-control" id="start_bid" placeholder="Introduza o valor inicial">
                            <small class="form-text text-muted">Introduza o valor pelo qual o leilão ira começar.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label id="lbuy_now_price" for="buy_now_price" class="form-label">Preço de Venda Imediata</label>
                            <input type="number" class="form-control" id="buy_now_price" placeholder="Introduza o valor de compra.">
                            <small class="form-text text-muted">Introduza o valor pelo qual a obra de arte sera imediatamente vendida.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label id="lstart_time" for="start_time" class="form-label">Data de Começo da Leilão</label>
                            <input type="datetime-local" class="form-control" id="start_time">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label id="lend_time" for="end_time" class="form-label">Data de Fim de Leilão</label>
                            <input type="datetime-local" class="form-control" id="end_time">
                        </div>
                    </div>

                    <div class="m-b-18">
                        <p id="mensagem" style="color: red"></p>
                    </div>

                    <div class="text-center mb-3">
                        <button id="submit-item" type="submit" class="btn btn-primary btn-lg">Submeter</button>
                    </div>
                </div>
            </div>
    </main>

    <!-- Start Footer -->
    <div id="gerar-footer"></div>
    <!-- End Footer -->


    <script src="assets/js/gerar-footer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs"></script>
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="src/js/user.js"></script>
    <script src="src/js/itens.js"></script>
    <!-- End Script -->
</body>

</html>