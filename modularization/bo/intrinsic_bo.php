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
                    <div class="col-sm-6 col-md-6 col-lg-6 col-md-col-xl-6 mb-md-0 mb-sm-4 mb-4 tm-site-header-col">
                        <div class="tm-site-header">
                            <h1 class="mb-4">Data Criminis</h1>
                            <img src="../../images/logos/underline.png" class="img-fluid mb-4">     
                        </div>                        
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div>
                            <a href="index.php"><button class="click">Voltar</button></a>
                            <?php 
                                if (isset($_SESSION["level"]) && $_SESSION["level"] == 1){
                                    echo "<p class=\"false\">Acesso negado, o usuário não tem permissão para acessar essa área.</p>";
                                    die();
                                }
                            ?>
                            <section>  
                                <h2>Lista B.O.P - Busca Intrísica</h2>
                                <form action="" method="post">
                                    <p class="form">
                                        <label for="">Buscar por: </label>
                                        <select name="intrinsic" id="intrinsic">
                                            <option value="data_bo" <?php if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "data_bo") echo "selected"?>>Ano</option>

                                            <option value="nome" <?php if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "nome") echo "selected"?>>Relator</option>

                                            <option value="autoridade_policial" <?php if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "autoridade_policial") echo "selected"?>>Autoridade Policial</option>

                                            <option value="historico_bo" <?php if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "historico_bo") echo "selected"?>>Histórico</option>

                                            <option value="nome_suspeito" <?php if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "nome_suspeito") echo "selected"?>>Suspeito</option>

                                            <option value="nome_vitima" <?php if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "nome_vitima") echo "selected"?>>Vítima</option>

                                            <option value="nome_testemunha" <?php if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "nome_testemunha") echo "selected"?>>Testemunha</option>   

                                        </select>
                                        <input type="text" placeholder="Palavra-chave" name="key" value="<?php if (isset($_POST["key"])) echo $_POST["key"]; ?>">
                                    </p>
                                    <p class="form">
                                        <button type="submit" class="click">Pesquisar</button>
                                    </p>
                                </form>

                                <?php include("connection.php");

                                    if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "nome"){
                                        $element = $_POST["intrinsic"];
                                        $key = strtolower(trim($_POST["key"]));
                                        $sqlCode = "SELECT
                                        id_bo, data_bo, algema, fk_relator_bo, nome, autoridade_policial, id
                                        FROM bo
                                        JOIN
                                        agentes ON bo.fk_relator_bo = agentes.id
                                        WHERE $element like '%$key%' ORDER BY data_bo DESC";

                                        $search = $mysqli->query($sqlCode) or die($mysqli->error);
                                        $numberBO = $search->num_rows;
                                    }

                                    else if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "data_bo"){
                                        $element = $_POST["intrinsic"];
                                        $key = strtolower(trim($_POST["key"]));
                                        $sqlCode = "SELECT
                                        id_bo, data_bo, algema, fk_relator_bo, nome, autoridade_policial, id
                                        FROM bo
                                        JOIN
                                        agentes ON bo.fk_relator_bo = agentes.id
                                        WHERE $element like '%$key%' ORDER BY data_bo DESC";

                                        $search = $mysqli->query($sqlCode) or die($mysqli->error);
                                        $numberBO = $search->num_rows;
                                    }

                                    else if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "autoridade_policial"){
                                        $element = $_POST["intrinsic"];
                                        $key = strtolower(trim($_POST["key"]));
                                        $sqlCode = "SELECT
                                        id_bo, data_bo, algema, fk_relator_bo, nome, autoridade_policial, id
                                        FROM bo
                                        JOIN
                                        agentes ON bo.fk_relator_bo = agentes.id
                                        WHERE $element like '%$key%' ORDER BY data_bo DESC";

                                        $search = $mysqli->query($sqlCode) or die($mysqli->error);
                                        $numberBO = $search->num_rows;
                                    }

                                    else if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "historico_bo"){
                                        $element = $_POST["intrinsic"];
                                        $key = strtolower(trim($_POST["key"]));
                                        $sqlCode = "SELECT
                                        id_bo, data_bo, algema, fk_relator_bo, nome, autoridade_policial, id, historico_bo
                                        FROM bo
                                        JOIN
                                        agentes ON bo.fk_relator_bo = agentes.id
                                        WHERE $element like '%$key%' ORDER BY data_bo DESC";

                                        $search = $mysqli->query($sqlCode) or die($mysqli->error);
                                        $numberBO = $search->num_rows;
                                    }

                                    else if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "nome_suspeito"){
                                        $element = $_POST["intrinsic"];
                                        $key = strtolower(trim($_POST["key"]));
                                        $sqlCode = "SELECT
                                        id_bo, data_bo, algema, autoridade_policial, id_bs, fk_suspeito, nome_suspeito, nome
                                        FROM bo
                                        JOIN
                                        boletim_suspeito ON bo.id_bo = boletim_suspeito.fk_bo
                                        JOIN
                                        suspeitos ON suspeitos.id_suspeito = boletim_suspeito.fk_suspeito
                                        JOIN
                                        agentes ON id = fk_relator_bo
                                        WHERE $element like '%$key%' ORDER BY data_bo DESC";

                                        $search = $mysqli->query($sqlCode) or die($mysqli->error);
                                        $numberBO = $search->num_rows;
                                    }

                                    else if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "nome_vitima"){
                                        $element = $_POST["intrinsic"];
                                        $key = strtolower(trim($_POST["key"]));
                                        $sqlCode = "SELECT
                                        id_bo, data_bo, algema, autoridade_policial, id_bv, fk_vitima, nome_vitima, nome
                                        FROM bo
                                        JOIN
                                        boletim_vitima ON bo.id_bo = boletim_vitima.fk_bo
                                        JOIN
                                        vitimas ON vitimas.id_vitima = boletim_vitima.fk_vitima
                                        JOIN
                                        agentes ON id = fk_relator_bo
                                        WHERE $element like '%$key%' ORDER BY data_bo DESC";

                                        $search = $mysqli->query($sqlCode) or die($mysqli->error);
                                        $numberBO = $search->num_rows;
                                    }

                                    else if (isset($_POST["intrinsic"]) && $_POST["intrinsic"] == "nome_testemunha"){
                                        $element = $_POST["intrinsic"];
                                        $key = strtolower(trim($_POST["key"]));
                                        $sqlCode = "SELECT
                                        id_bo, data_bo, algema, autoridade_policial, id_bt, fk_testemunha, nome_testemunha, nome
                                        FROM bo
                                        JOIN
                                        boletim_testemunha ON bo.id_bo = boletim_testemunha.fk_bo
                                        JOIN
                                        testemunhas ON testemunhas.id_testemunha = boletim_testemunha.fk_testemunha
                                        JOIN
                                        agentes ON id = fk_relator_bo
                                        WHERE $element like '%$key%' ORDER BY data_bo DESC";

                                        $search = $mysqli->query($sqlCode) or die($mysqli->error);
                                        $numberBO = $search->num_rows;
                                    }
                                    
                                    else{
                                        die();
                                    }
                 
                                ?>
                                <div class="contain">
                                    <table id="bos">
                                        <thead>
                                            <th>Data da Ocorrência</th>
                                            <th>Relator</th>
                                            <th>Autoridade Policial</th>
                                            <th>Mais Detalhes</th>
                                        </thead>
                                        <tbody>
                                            <?php if($numberBO == 0) { ?>
                                                <tr>
                                                    <td colspan="30" style="text-align: center;">No Data</td>
                                                </tr>
                                    
                                            <?php 
                                            } else {
                                                while($bo = $search->fetch_assoc()){
                                                    if (!empty($bo["data_bo"])){
                                                        $dataFormat = implode('/', array_reverse(explode('-', $bo["data_bo"])));
                                                    }else{
                                                        $dataFormat = "";
                                                    }
                                                ?>
                                                <tr>
                                                    <td><?php echo $dataFormat?></td>
                                                    <td><?php echo ucwords($bo["nome"])?></td>
                                                    <td><?php echo ucwords($bo["autoridade_policial"])?></td>
                                                    <td>
                                                        <a href="review_bo.php?id_bo=<?php echo $bo["id_bo"]?>">Inspecionar</a>
                                                    </td>
                                                </tr>
                                                <?php 
                                                }
                                            } ?>
                                        </tbody>
                                        <tfoot>
                                            
                                        </tfoot>
                                    </table>    
                                </div>
                                <p>Total: <?php echo $numberBO?></p> 
                            </section>
                        </div>                      
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