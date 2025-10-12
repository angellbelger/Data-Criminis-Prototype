<?php 
if(!isset($_SESSION)){
    session_start();

    if (isset($_SESSION["name"])){
        $name = ucfirst($_SESSION["name"]);
    }
}

if(!isset($_SESSION["user"]) || $_SESSION["situation"] == "inativo"){
    header("Location: ../../../door.php");
    die("Você não possui permissão.");
}

/*
$lastInsertId = $mysqli->insert_id;
*/
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data Criminis</title>
<!--

Template 2097 Pop

https://www.tooplate.com/view/2097-pop

-->
    <!-- load CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300">  <!-- Google web font "Open Sans" -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">                                  <!-- https://getbootstrap.com/ -->
    <link rel="stylesheet" href="../../fontawesome/css/fontawesome-all.min.css">                <!-- https://fontawesome.com/ -->
    <link rel="stylesheet" type="text/css" href="../../slick/slick.css"/>                       <!-- http://kenwheeler.github.io/slick/ -->
    <link rel="stylesheet" type="text/css" href="../../slick/slick-theme.css"/>
    <link rel="stylesheet" href="../../css/tooplate-style.css">                               <!-- Templatemo style -->
    <!-- nova biblioteca -->
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <!-- nova biblioteca -->
    
    <script>document.documentElement.className="js";var supportsCssVars=function(){var e,t=document.createElement("style");return t.innerHTML="root: { --tmp-var: bold; }",document.head.appendChild(t),e=!!(window.CSS&&window.CSS.supports&&window.CSS.supports("font-weight","var(--tmp-var)")),t.parentNode.removeChild(t),e};supportsCssVars()||alert("Please view this in a modern browser such as latest version of Chrome or Microsoft Edge.");</script>

</head>

<body>
    <div id="tm-bg"></div>
    <div id="tm-wrap">
        <div class="tm-main-content">
            <div class="container tm-site-header-container">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-md-col-xl-6 mb-md-0 mb-sm-4 mb-4 tm-site-header-col">
                        <div class="tm-site-header">
                            <h1 class="mb-4">Data Criminis</h1>
                            <img src="../../images/logos/underline.png" class="img-fluid mb-4">     
                        </div>                        
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="content">
                            <div class="grid">
                                <div class="grid__item" id="home-link">
                                    <a href="index.html">
                                        <a href="../../index.php">
                                            <div class="product">
                                                <div class="tm-nav-link">
                                                    <i class="fas fa-arrow-left fa-3x tm-nav-icon" class="ion-aperture"></i>
                                                    <span class="tm-nav-text">Voltar</span>
                                                    <div class="product__bg"></div>
                                                </div>
                                            
                                            </div>
                                        </a>
                                    </a>
                                    
                                </div>
                                
                                <div class="grid__item" id="home-link">
                                    <a href="list_bo.php">
                                        <div class="product">
                                            <div class="tm-nav-link">
                                                <i class="fa fa-search fa-3x" aria-hidden="true"></i>
                                                <span class="tm-nav-text">Listar B.O.P</span>
                                                <div class="product__bg"></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>  

                                <div class="grid__item" id="team-link">
                                    <a href="start.php">
                                        <div class="product">
                                            <div class="tm-nav-link">
                                                <i class="fa fa-file fa-3x" aria-hidden="true"></i>
                                                <span class="tm-nav-text">Adicionar B.O.P</span>
                                                <div class="product__bg"></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="grid__item">
                                    <a href="intrinsic_bo.php">
                                        <div class="product">
                                            <div class="tm-nav-link">
                                                <i class="fa fa-user-secret fa-3x" aria-hidden="true"></i>
                                                <span class="tm-nav-text">Busca Intríseca</span>
                                                <div class="product__bg"></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div> 
                        </div>                       
                    </div>
                </div>                
            </div>
            <footer>
                <p class="small tm-copyright-text">Copyright &copy; <span class="tm-current-year">2020</span> Bëlger - DIT. 
            </footer>
        </div> <!-- .tm-main-content -->  
    </div>
    <!-- load JS -->
    <script src="../../js/jquery-3.2.1.slim.min.js"></script>         <!-- https://jquery.com/ -->    
    <script src="../../slick/slick.min.js"></script>                  <!-- http://kenwheeler.github.io/slick/ -->  
    <script src="../../js/anime.min.js"></script>                     <!-- http://animejs.com/ -->
    <script src="../../js/main.js"></script>  
    <script>      

        function setupFooter() {
            var pageHeight = $('.tm-site-header-container').height() + $('footer').height() + 100;

            var main = $('.tm-main-content');

            if($(window).height() < pageHeight) {
                main.addClass('tm-footer-relative');
            }
            else {
                main.removeClass('tm-footer-relative');   
            }
        }

        /* DOM is ready
        ------------------------------------------------*/
        $(function(){

            setupFooter();

            $(window).resize(function(){
                setupFooter();
            });

            $('.tm-current-year').text(new Date().getFullYear());  // Update year in copyright           
        });

    </script>             

</body>
</html>