<?php 
require_once __DIR__ . '/../classes/Database.php';

$conn = Database::getConnection(); 

// se o formulário de contato foi enviado, salva no banco
if (isset($_POST['action']) || isset($_GET['action'])) {
    $action = $_POST['action'] ?? $_GET['action'];

    if ($action == 'contato') {
        $stmt = $conn->prepare("INSERT INTO mensagens_contato (nome, email, telefone, mensagem, data) 
                                VALUES (:nome, :email, :telefone, :mensagem, :data)");
        $stmt->execute([
            ':nome'     => $_POST['nome'],
            ':email'    => $_POST['email'],
            ':telefone' => $_POST['telefone'],
            ':mensagem' => $_POST['mensagem'],
            ':data'     => date('Y-m-d H:i:s'),
        ]);

        // redireciona de volta pra página após salvar
        header("Location: index.php");
        exit;
    }
}

//busca as preferências cadastradas no cms (pega a primeira linha)
$stmt = $conn->prepare('SELECT * FROM preferencias LIMIT 1');
$stmt->execute();
$pref = $stmt->fetch(PDO::FETCH_ASSOC);

//busca todas as caracteristicas da seção home
$stmt2 = $conn->prepare('SELECT * FROM caracteristicas_home');
$stmt2 ->execute();
$caracteristicas= $stmt2->fetchAll(PDO::FETCH_ASSOC);

//busca todos os testemunhos
$stmt3 = $conn->prepare('SELECT * FROM testemunhos');
$stmt3 ->execute();
$testemunhos = $stmt3->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <!--titulo dinamico-->
    <title><?php echo $pref['titulo_landing_page']; ?></title>    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<meta  http-equiv="Content-Security-Policy"  content="upgrade-insecure-requests" />	
	
    <meta name="description" content="Landing Page Treinamento.">
    <meta name="keywords" content="">
    <meta name="author" content="Treinamento">
    <meta name="title" content="Landing Page Treinamento.">
   
    

    <link rel="shortcut icon" href="images/favicon.png">

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" id="bootstrap-style">

    <!-- Material Icon Css -->
    <link rel="stylesheet" href="css/materialdesignicons.min.css" type="text/css">

    <!-- Swiper Css -->
    <link rel="stylesheet" href="css/tiny-slider.css" type="text/css">
    <link rel="stylesheet" href="css/swiper.min.css" type="text/css">

    <!-- Custom Css -->
    <link rel="stylesheet" href="css/style.min.css" type="text/css">

    <!-- colors -->
    <link href="css/colors/default.css" rel="stylesheet" type="text/css" id="color-opt">
    
		

</head>

<body data-bs-spy="scroll" data-bs-target="#navbarCollapse">


    <!-- START  NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-light" id="navbar">
        <div class="container-fluid">

            <!-- LOGO -->
            <a class="navbar-brand logo text-uppercase" href="../landpage">
                <!--logo dinamica-->
                <img src="<?php echo $pref['logo_cabecalho']; ?>" class="logo-dark" alt="" height="30">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="mdi mdi-menu"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto" id="navbar-navlist">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cta">Obter APP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonial">Depoimentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contato</a>
                    </li>
                </ul>
                <div class=" d-flex align-items-center" style="margin-left: 20px!important;">
                    <!--link do facebook dinamico-->
                     <a href="<?php echo $pref['link_facebook']; ?>" target="_blank"
							class="me-2 avatar-sm text-center" data-bs-toggle="tooltip" data-bs-placement="top"
							data-bs-title="Facebook" title="Facebook">
							<i class="mdi mdi-facebook f-24 align-middle text-primary"></i>
                     </a>
                     <!-- link do insta dinamico-->
                     <a href="<?php echo $pref['link_instagram']; ?>" target="_blank"
							class="mx-2 avatar-sm text-center" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Instagran" title="Instagram">
                            <i class="mdi mdi-instagram f-24 align-middle text-primary"></i>
					</a>
                </div>				
                <div class="ms-auto">
                    <a href="#" class="btn bg-gradiant" style="display: flex; align-items: center;"><i class="mdi mdi-account f-20 me-2"></i>Conecte-se</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->



    <!-- home section -->
    <section class="home bg-light" id="home" Style="background-color: #bde7fd !important;">
        <!-- start container -->
        <div class="container">
            <!-- start row -->
            <div class="row align-items-center">
                <div class="col-lg-6">
                </div>
                <!-- start features -->
                <div class="section features" id="features">
                    <!-- start container -->
                    <div class="container">


                        <div class="row justify-content-center">

                            <div class="col-lg-6">
                                <div class="title text-center mb-5">
                                    <div class="d-flex align-items-center mt-5">
                                        <div class="flex-shrink-0">
                                        </div>
                                          <div class="flex-grow-1 ms-3">
                                            <!--titulo da seção home dinamico-->
                                            <h6 class="mb-0"><?php echo $pref['titulo_secao_home']; ?></h6>
                                            <p class="fw-semibold mb-0 text-muted"><?php echo $pref['subtitulo_secao_home']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">

                                <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                                    <li class="nav-item mb-3" role="presentation">
                                        <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false">Plataforma</button>
                                    </li>
                                    <li class="nav-item mb-3" role="presentation">
                                        <button class="nav-link" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-home" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true">Aplicativo</button>
                                    </li>

                                </ul>
                                <div class="tab-content mt-5" id="pills-tabContent">

                                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                                        <div class="row align-items-center">
                                            <div class="col-lg-6">
                                                <img src="images/features/home-1.png" alt="" class="img-fluid"
                                                    style="animation: ani-bg 3s infinite;">
                                            </div>

                                            <div class="col-lg-6">
                                                <h2 class="mb-4"><i style="font-size: 40px;" class="mdi mdi-tablet-cellphone f-20 me-2"></i>Na palma da sua mão</h2>

                                                <div class="row">
                                                    <?php foreach ($caracteristicas as $c): ?>
                                                        <div class="col-lg-6">
                                                            <div class="features-box mt-4">
                                                                <div class="d-flex">
                                                                    <div class="heading" style="height: 255px;">
                                                                        <h6 class="d-flex align-items-center mt-1">
                                                                            <?php echo $c['titulo']; ?>
                                                                        </h6>
                                                                        <p class="text-muted"><?php echo $c['descricao']; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>

        </div>
    </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4 order-2 order-lg-first">
                                                <div class="features-item text-start text-lg-end">
                                                    <div class="icon avatar-sm text-center ms-lg-auto rounded-circle">
                                                        <i class="mdi mdi-tools f-24"></i>
                                                    </div>
                                                    <div class="content mt-3">
                                                        <h5>Gestão de Ativos</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                    </div>
                                                </div>

                                                <div class="features-item text-start text-lg-end mt-5">
                                                    <div class="icon avatar-sm text-center ms-lg-auto rounded-circle">
                                                        <i class="mdi mdi-school f-24"></i>
                                                    </div>
                                                    <div class="content mt-3">
                                                        <h5>Treinamentos</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                    </div>
                                                </div>

                                                <div class="features-item text-start text-lg-end mt-5 mb-5">
                                                    <div class="icon avatar-sm text-center ms-lg-auto rounded-circle">
                                                        <i class="mdi mdi-cogs f-24"></i>
                                                    </div>
                                                    <div class="content mt-3">
                                                        <h5>Execução</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <img src="images/features/phone.png" alt="" class="img-fluid"
                                                    style="animation: ani-bg 3s infinite;">
                                            </div>
                                            <div class="col-lg-4 order-last">
                                                <div class="features-item">
                                                    <div class="icon avatar-sm text-center rounded-circle">
                                                        <i class="mdi mdi-checkbox-marked f-24"></i>
                                                    </div>
                                                    <div class="content mt-3">
                                                        <h5>Check</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                    </div>
                                                </div>

                                                <div class="features-item mt-5">
                                                    <div class="icon avatar-sm text-center rounded-circle">
                                                        <i class="mdi mdi-dropbox f-24"></i>
                                                    </div>
                                                    <div class="content mt-3">
                                                        <h5>Ação</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                    </div>
                                                </div>

                                                <div class="features-item mt-5">
                                                    <div class="icon avatar-sm text-center rounded-circle">
                                                        <i class="mdi mdi-flask f-24"></i>
                                                    </div>
                                                    <div class="content mt-3">
                                                        <h5>API de integração</h5>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- end container -->
                </div>
                <!-- end features -->
            </div>
        </div>
        <!-- end row -->
		
		
        </div>
        <!-- end container -->

        <div class="background-line"></div>
    </section>
    <!-- end home section -->






    <!-- start testimonial -->
    <section class="section bg-light testimonial" id="testimonial">
        <!-- start container -->
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="title">
                        <p class=" text-primary fw-bold mb-0">Depoimento dos clientes <i
                                class="mdi mdi-chat-processing"></i>
                        </p>
                        <h3>O que eles pensam de nós!</h3>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="testi-slider" id="testi-slider">
                        <?php foreach ($testemunhos as $t): ?>
                            <div class="item">
                                <div class="testi-box position-relative overflow-hidden">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <img src="<?php echo $t['imagem_fundo']; ?>" alt="" class="img-fluid">
                                        </div>
                                        <div class="col-md-7">
                                            <div class="p-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar">
                                                            <img src="<?php echo $t['foto']; ?>" alt="" class="img-fluid rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <p class="f-14 mb-0 text-dark fw-bold"><?php echo $t['nome']; ?></p>
                                                        <p class="text-muted mb-0 f-14"><?php echo $t['funcao']; ?></p>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <h5 class="fw-bold"><?php echo $t['titulo']; ?></h5>
                                                    <p class="text-muted f-14"><?php echo $t['descricao']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    

                </div>
            </div>
        </div>
        </div>
        <!-- end container -->
    </section>
    <!-- end testimonial -->







    <!-- app store section -->
    <section class="section cta" id="cta">
        <div class="bg-overlay-gradiant"></div>
        <!-- start container -->
        <div class="container position-relative">
            <div class="row">
                <div class="col-lg-6">
                    <div class="py-5">
                        <!--loja do app dinamica-->
                        <h1 class="display-4 text-white"><?php echo $pref['titulo_secao_loja_apps']; ?></h1>
                        <p class="text-white-50 mt-3 f-18"><?php echo $pref['subtitulo_secao_loja_apps']; ?></p><br><br><br><br>
                        <div class="d-flex mt-4 ">
                            <div class="app-store">
                                <a target="_blank" href="<?php echo $pref['imagem_appstore']; ?>">
                                    <img src="images/img-appstore.png" alt="" class="img-fluid">
                                </a>
                            </div>
                            <div class="googleplay">
                                <a target="_blank" href="<?php echo $pref['imagem_playstore']; ?>">
                                    <img src="images/img-googleplay.png" alt="" class="img-fluid ms-3">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="cta-phone-image">
                        <img src="images/home-5.png" alt="" style="height:600px;" class=" img-fluid">
                    </div>
                </div>
            </div>
        </div>
        <!-- end container -->
    </section>
    <!-- end section -->


    <!-- contact section -->
    <section class="section contact overflow-hidden" id="contact">
        <!-- start container -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="title text-center mb-5">
                        <h6 class="mb-0 fw-bold text-primary">Contate-nos</h6>
                        <h2 class="f-40">Entre em Contato</h2>
                    </div>
                </div>
            </div>

            <div class="row row justify-content-center">
                <div class="col-lg-5">
                    <div class="contact-box">
                        <div class="mb-4">
                            <h4 class=" fw-semibold mb-1">Tem alguma dúvida?</h4>
                            <p class="text-muted">ou deseja um orçamento? Contate-nos.</p>
                        </div>

                        <div class="custom-form mt-4 ">
                            <form method="post" action="index.php?action=contato">
                                <p id="error-msg" style="opacity: 1;">
									<p class='alert alert-success' id='msg_alert'> <strong>Obrigado !</strong> Sua Mensagem foi entregue.</p>									
                                </p>

                                <div id="simple-msg"></div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input name="nome" id="nome" type="text" class="form-control contact-form"
                                                placeholder="Nome" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input name="email" id="email" type="email" value=""
                                                class="form-control contact-form" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mt-2">
                                            <input name="telefone" type="text" class="form-control contact-form" id="telefone" value=""
                                                placeholder="(82)99999-9999">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mt-2">
                                            <textarea name="mensagem" id="mensagem" rows="4" 
                                                class="form-control contact-form h-auto"
                                                placeholder="Mensagem"> </textarea>
                                        </div>
                                    </div>
                                </div>
                               
								<div class="row">
                                <div class="row my-2">
                                    <div class="col-lg-12 d-grid">
                                        <input type="submit" id="submit" name="send"
                                            class="submitBnt btn btn-rounded btn-primary" value="Enviar mensagem">
                                    </div>
                                </div>
								</div>                                
                            </form>
                        </div>
                    </div>


                </div>
            </div>


            <div class="row mt-4 row justify-content-center">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mt-4 mt-lg-0">
                        <div class="flex-shrink-0">
                            <i class="mdi mdi-phone f-50 text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1">Telefone</h5>
                            <p class="f-14 mb-0 text-muted"><?php echo $pref['telefone_contato']; ?></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- end container -->
    </section>
    <!-- end section -->



    <!-- footer section -->
    <section class=" section footer bg-dark overflow-hidden">
        <div class="">

        </div>
        <!-- container -->
        <div class="container ">
            <div class="row justify-content-center ">
                <div class="col-lg-4">
                    <a class="navbar-brand logo text-uppercase" href="#">
                        <img src="<?php echo $pref['logo_rodape']; ?>" class="logo-light" alt="" height="30">
                    </a>
                    <p class="text-white-50 mt-2 mb-0"><?php echo $pref['mensagem_copyright']; ?></p>
                    <a href="<?php echo $pref['url_rodape']; ?>" target="_blank">
                        <p><?php echo $pref['url_rodape']; ?></p>
                    </a>
                    <div class="footer-icon mt-4">
                        <div class=" d-flex align-items-center">
                            <a href="<?php echo $pref['link_facebook']; ?>" target="_blank"
                                class="me-2 avatar-sm text-center" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Facebook" title="Facebook">
                                <i class="mdi mdi-facebook f-24 align-middle text-primary"></i>
                            </a>
                            <a href="<?php echo $pref['link_instagram']; ?>" target="_blank"
                                class="mx-2 avatar-sm text-center" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Instagram" title="Instagram">
                                <i class="mdi mdi-instagram f-24 align-middle text-primary"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="text-start mt-4 mt-lg-0">
                        <h5 class="text-white fw-bold">Produto</h5>
                        <ul class="footer-item list-unstyled footer-link mt-3">
                            <li><a href="#cta">Obter APP</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 ">
                    <div class="text-start">
                        <h5 class="text-white fw-bold">Politicas</h5>
                        <ul class="footer-item list-unstyled footer-link mt-3">
                            <li><a href="#">Politica de privacidade</a></li>
                            <li><a href="#">Termos de uso</a></li>
                        </ul>
                    </div>
                </div>


            </div>
        </div>
        <!-- end container -->
    </section>

    <section class="bottom-footer py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <p class="mb-0 text-center text-muted"><?php echo $pref['mensagem_powered']; ?></p>
                </div>
            </div>
        </div>
    </section>
    <!-- end footer -->

    <!--Bootstrap Js-->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Slider Js -->
    <script src="js/tiny-slider.js"></script>
    <script src="js/swiper.min.js"></script>
    
	<!-- jQuery 1.8+ -->
	<script src="plugin/components/jQuery/jquery-1.11.3.min.js"></script>
	
    <!-- App Js -->
    <script src="js/app.js"></script> 

    <style>
	


</body>

</html>