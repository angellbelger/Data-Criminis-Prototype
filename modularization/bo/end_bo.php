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

$page = "begin.php";

if (isset($_GET["p"])){
    $page = $_GET["p"] . ".php";   
}

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
    <!-- Style Form -->
    <link rel="stylesheet" href="../../css/form/style.css">
    <!-- Print -->
    <link rel="stylesheet" href="../../css/form/print.css" media="print">
    
    <script>document.documentElement.className="js";var supportsCssVars=function(){var e,t=document.createElement("style");return t.innerHTML="root: { --tmp-var: bold; }",document.head.appendChild(t),e=!!(window.CSS&&window.CSS.supports&&window.CSS.supports("font-weight","var(--tmp-var)")),t.parentNode.removeChild(t),e};supportsCssVars()||alert("Please view this in a modern browser such as latest version of Chrome or Microsoft Edge.");</script>

</head>

<body>
    <div id="tm-bg"></div>
    <div id="tm-wrap">
        <div class="tm-main-content">
            <div class="container tm-site-header-container">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-md-col-xl-6 mb-md-0 mb-sm-4 mb-4 tm-site-header-col">
                        <div class="tm-site-header">
                        </div>                        
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <a href="index.php"><button class="click">Sair</button></a>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <?php 
                        if (!isset($_SESSION["fk_bo"])){
                            echo "<div class=\"centre\"><p class=\"false\">Registre o B.O primeiro</p></div>";
                            die();
                        }else{
                            include("connection.php");
                            echo "<section class=\"main\"><p class=\"true\">Boletim de Ocorrência PRO com o protocolo ". $_SESSION["fk_bo"] ." finalizado com sucesso.</p></session>";
                            $mysqli->close();
                            unset($_SESSION["fk_bo"]);
                            die();
                        }
                        
                    ?>
                    </div>
                </div>                
            </div>
            <footer>    
            </footer>
        </div> <!-- .tm-main-content -->  
    </div>
    <!-- load JS -->
    <script src="../../js/jquery-3.2.1.slim.min.js"></script>         <!-- https://jquery.com/ -->    
    <script src="../../slick/slick.min.js"></script>                  <!-- http://kenwheeler.github.io/slick/ -->  
    <script src="../../js/anime.min.js"></script>                     <!-- http://animejs.com/ -->
    <script src="../../js/main.js"></script>
    <script src="../../js/bo.js"></script>  
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
