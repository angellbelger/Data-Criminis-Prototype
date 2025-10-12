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

include("connection.php");
$id_bo = intval($_GET["id_bo"]);

$sqlCode = "SELECT
id_bo,
data_bo,
hora_inicial,
hora_final,
endereco,
numero,
bairro,
complemento_bo,
fk_municipio_bo,
fk_uf_bo,
atendimento_bo,
material_apreendido,
algema,
justificar_algema,
historico_bo,
integridade_fisica,
descricao_integridade_fisica,
fk_relator_bo,
autoridade_policial,
funcao_autoridade_policial,
matricula_autoridade_policial,
data_assinatura,
dossie_bo
FROM
bo
WHERE bo.id_bo = '$id_bo'";

/*
$sqlCode = "SELECT * FROM agentes WHERE id = $id";
*/

$search = $mysqli->query($sqlCode) or die($mysqli->error);
$bo = $search->fetch_assoc();

if (!empty($bo["data_bo"])){
    $dataFormat = implode('/', array_reverse(explode('-', $bo["data_bo"])));
}

if (!empty($bo["data_assinatura"])){
    $dataFormatAssinatura = implode('/', array_reverse(explode('-', $bo["data_assinatura"])));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Data Criminis</title>

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
                        <table id="header">
                            <tr>
                                <td colspan="16"><img src="../../images/logos/header-print.png" alt="header-doc" class="h"> </td>
                                <td colspan="4" style="text-align: center;"><strong style="text-decoration: underline;">Protocolo:</strong> <?php echo $bo["id_bo"]?></td>
                            </tr>
                        </table>                     
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div>
                            <div class="centre"><a href="list_bo.php"><button class="click">Voltar</button></a> </div>
                            <?php 
                                if (isset($_SESSION["level"]) && $_SESSION["level"] == 1){
                                    echo "<p class=\"false\">Acesso negado, o usuário não tem permissão para acessar essa área.</p>";
                                    die();
                                }
                            ?>  
                            <section class="main">
                                <h2 class="main">Boletim de Ocorrência PRO</h2>
                                <?php include('connection.php'); ?>
                                <form action="" method="post">
                                    <fieldset>
                                        <legend><strong>Dados Referentes à Ocorrência</strong></legend>
                                        <?php 
                                            $sqlCodeCity = "SELECT
                                            id_cidade,
                                            nome_cidade,
                                            id_estado,
                                            fk_estado,
                                            uf,
                                            id_bo,
                                            fk_municipio_bo
                                            FROM
                                            bo 
                                            JOIN cidades ON bo.fk_municipio_bo = cidades.id_cidade
                                            JOIN estados ON fk_estado = id_estado
                                            WHERE id_cidade = fk_municipio_bo
                                            ";

                                            $searchCity = $mysqli->query($sqlCodeCity) or die($mysqli->error);
                                            $city = $searchCity->fetch_assoc();
                                        ?>
                                        <p id="pt">
                                            <strong>Protocolo: </strong> </label><?php echo $bo["id_bo"] ?>
                                        </p>
                                        <p>
                                            <strong>Data: </strong></label><?php echo $dataFormat ?>
                                        </p>
                                        <p>
                                            <strong>Início: </strong></label><?php echo ucwords($bo["hora_inicial"]) ?><strong> Fim: </strong></label><?php echo $bo["hora_final"] ?>
                                        </P>
                                        <p>
                                            <strong>Endereço: </strong></label><?php echo ucwords($bo["endereco"]) ?>
                                        </p>
                                        <p>
                                            <strong>Número: </strong></label><?php echo $bo["numero"] ?>
                                        </p>
                                        <p>
                                            <strong>Bairro: </strong></label><?php echo $bo["bairro"] ?>
                                        </p>
                                        <p>
                                            <strong>Complemento: </strong> <?php echo $bo["complemento_bo"] ?></label>
                                        </p>
                                        <p>
                                            <strong>Município: </strong> <?php echo "".$city["nome_cidade"]." - ".$city["uf"]."" ?>
                                        </p>
                                    </fieldset>

                                    <fieldset>
                                        <legend><strong>Dados Referentes aos Suspeitos</strong></legend>
                                        <?php 
                                            $sqlCodeSus = "SELECT
                                            id_suspeito,
                                            nome_suspeito,
                                            nascimento_suspeito,
                                            cpf_suspeito,
                                            endereco_suspeito,
                                            numero_suspeito,
                                            bairro_suspeito,
                                            phone_suspeito,
                                            pai_suspeito,
                                            mae_suspeito,
                                            id_bs,
                                            fk_bo,
                                            fk_suspeito
                                            FROM
                                            suspeitos 
                                            JOIN boletim_suspeito ON id_suspeito = fk_suspeito
                                            WHERE fk_bo = '$id_bo' AND id_suspeito = fk_suspeito
                                            ";

                                            $searchSus = $mysqli->query($sqlCodeSus) or die($mysqli->error);

                                            while($suspeito = $searchSus->fetch_assoc()){
                                                if (!empty($suspeito["nascimento_suspeito"])){
                                                    $dataFormatSuspeito = implode('/', array_reverse(explode('-', $suspeito["nascimento_suspeito"])));
                                                }else{
                                                    $dataFormatSuspeito = "";
                                                }

                                                if (isset($suspeito["cpf_suspeito"]) && strlen($suspeito["cpf_suspeito"]) == 11){
                                                    $cpf_split_suspeito = substr_replace($suspeito["cpf_suspeito"], '.', 3, 0);
                                                    $cpf_split_suspeito = substr_replace($cpf_split_suspeito, '.', 7, 0);
                                                    $cpf_split_suspeito = substr_replace($cpf_split_suspeito, '-', 11, 0);
                                                }else{
                                                    $cpf_split_suspeito = $suspeito["cpf_suspeito"];
                                                }

                                                ?>
                                                    <div style="display: <?php if ($suspeito["id_suspeito"] == 0) echo "none"; else echo "block"?>">
                                                        <p><strong>Nome:</strong> <?php echo ucwords($suspeito["nome_suspeito"])?></p>
                                                        <p><strong>Data de Nascimnento:</strong> <?php echo $dataFormatSuspeito?></p>
                                                        <p><strong>CPF/RG:</strong> <?php echo $cpf_split_suspeito?></p>
                                                        <p><strong>Endereço:</strong> <?php echo $suspeito["endereco_suspeito"]?></p>
                                                        <p><strong>Número:</strong> <?php echo $suspeito["numero_suspeito"]?></p>
                                                        <p><strong>Bairro:</strong> <?php echo $suspeito["bairro_suspeito"]?></p>
                                                        <p><strong>Celular:</strong> <?php echo $suspeito["phone_suspeito"]?></p>
                                                        <p><strong>Pai:</strong> <?php echo ucwords($suspeito["pai_suspeito"])?></p>
                                                        <p><strong>Mãe:</strong> <?php echo ucwords($suspeito["mae_suspeito"])?></p>
                                                        <hr>
                                                    </div>

                                                <?php
                                            }
                                        ?>
                                    </fieldset>

                                    <fieldset>
                                        <legend><strong>Dados Referentes às Vítimas</strong></legend>
                                        <?php 
                                            $sqlCodeVit = "SELECT
                                            id_vitima,
                                            nome_vitima,
                                            nascimento_vitima,
                                            cpf_vitima,
                                            endereco_vitima,
                                            numero_vitima,
                                            bairro_vitima,
                                            phone_vitima,
                                            pai_vitima,
                                            mae_vitima,
                                            id_bv,
                                            fk_bo,
                                            fk_vitima
                                            FROM
                                            vitimas 
                                            JOIN boletim_vitima ON id_vitima = fk_vitima
                                            WHERE fk_bo = '$id_bo' AND id_vitima = fk_vitima
                                            ";

                                            $searchVit = $mysqli->query($sqlCodeVit) or die($mysqli->error);

                                            while($vitima = $searchVit->fetch_assoc()){
                                                if (!empty($vitima["nascimento_vitima"])){
                                                    $dataFormatVitima = implode('/', array_reverse(explode('-', $vitima["nascimento_vitima"])));
                                                }else{
                                                    $dataFormatVitima = "";
                                                }

                                                if (!empty($vitima["cpf_vitima"]) && strlen($vitima["cpf_vitima"]) == 11){
                                                    $cpf_split_vitima = substr_replace($vitima["cpf_vitima"], '.', 3, 0);
                                                    $cpf_split_vitima = substr_replace($cpf_split_vitima, '.', 7, 0);
                                                    $cpf_split_vitima = substr_replace($cpf_split_vitima, '-', 11, 0);
                                                }else{
                                                    $cpf_split_vitima = $vitima["cpf_vitima"];
                                                }

                                                ?>
                                                    <div style="display: <?php if ($vitima["id_vitima"] == 0) echo "none"; else echo "block"?>">
                                                        <p><strong>Nome:</strong> <?php echo ucwords($vitima["nome_vitima"])?></p>
                                                        <p><strong>Data de Nascimnento:</strong> <?php echo $dataFormatVitima?></p>
                                                        <p><strong>CPF/RG:</strong> <?php echo $cpf_split_vitima?></p>
                                                        <p><strong>Endereço:</strong> <?php echo $vitima["endereco_vitima"]?></p>
                                                        <p><strong>Número:</strong> <?php echo $vitima["numero_vitima"]?></p>
                                                        <p><strong>Bairro:</strong> <?php echo $vitima["bairro_vitima"]?></p>
                                                        <p><strong>Celular:</strong> <?php echo $vitima["phone_vitima"]?></p>
                                                        <p><strong>Pai:</strong> <?php echo ucwords($vitima["pai_vitima"])?></p>
                                                        <p><strong>Mãe:</strong> <?php echo ucwords($vitima["mae_vitima"])?></p>
                                                        <hr>
                                                    </div>

                                                <?php
                                            }
                                        ?>
                                    </fieldset>

                                    <fieldset>
                                        <legend><strong>Dados Referentes às Testemunhas</strong></legend>
                                        <?php 
                                            $sqlCodeTest = "SELECT
                                            id_testemunha,
                                            nome_testemunha,
                                            nascimento_testemunha,
                                            cpf_testemunha,
                                            endereco_testemunha,
                                            numero_testemunha,
                                            bairro_testemunha,
                                            phone_testemunha,
                                            pai_testemunha,
                                            mae_testemunha,
                                            id_bt,
                                            fk_bo,
                                            fk_testemunha
                                            FROM
                                            testemunhas 
                                            JOIN boletim_testemunha ON id_testemunha = fk_testemunha
                                            WHERE fk_bo = '$id_bo' AND id_testemunha = fk_testemunha
                                            ";

                                            $searchTest = $mysqli->query($sqlCodeTest) or die($mysqli->error);

                                            while($testemunha = $searchTest->fetch_assoc()){
                                                if (!empty($testemunha["nascimento_testemunha"])){
                                                    $dataFormatTestemunha = implode('/', array_reverse(explode('-', $testemunha["nascimento_testemunha"])));

                                                }else{
                                                    $dataFormatTestemunha = "";
                                                }

                                                if (!empty($testemunha["cpf_testemunha"]) && strlen($testemunha["cpf_testemunha"]) == 11){
                                                    $cpf_split_testemunha = substr_replace($testemunha["cpf_testemunha"], '.', 3, 0);
                                                    $cpf_split_testemunha = substr_replace($cpf_split_testemunha, '.', 7, 0);
                                                    $cpf_split_testemunha = substr_replace($cpf_split_testemunha, '-', 11, 0);
                                                }else{
                                                    $cpf_split_testemunha = $testemunha["cpf_testemunha"];
                                                }

                                                ?>
                                                    <div style="display: <?php if ($testemunha["id_testemunha"] == 0) echo "none"; else echo "block"?>">
                                                        <p><strong>Nome:</strong> <?php echo ucwords($testemunha["nome_testemunha"])?></p>
                                                        <p><strong>Data de Nascimnento:</strong> <?php echo $dataFormatTestemunha?></p>
                                                        <p><strong>CPF/RG:</strong> <?php echo $cpf_split_testemunha?></p>
                                                        <p><strong>Endereço:</strong> <?php echo $testemunha["endereco_testemunha"]?></p>
                                                        <p><strong>Número:</strong> <?php echo $testemunha["numero_testemunha"]?></p>
                                                        <p><strong>Bairro:</strong> <?php echo $testemunha["bairro_testemunha"]?></p>
                                                        <p><strong>Celular:</strong> <?php echo $testemunha["phone_testemunha"]?></p>
                                                        <p><strong>Pai:</strong> <?php echo ucwords($testemunha["pai_testemunha"])?></p>
                                                        <p><strong>Mãe:</strong> <?php echo ucwords($testemunha["mae_testemunha"])?></p>
                                                        <hr>
                                                    </div>

                                                <?php
                                            }
                                        ?>
                                    </fieldset>

                                    <fieldset>
                                        <legend><strong>Detalhes da Ocorrência</strong></legend>
                                        <p>
                                            <strong>Natureza da Ocorrência: </strong> <?php echo $bo["atendimento_bo"] ?></label>
                                        </p>
                                        <p>
                                            <strong>Material Apreendido: </strong> <?php echo $bo["material_apreendido"] ?></label>
                                        </p>
                                    </fieldset>
                                    <h3></h3>
                                    <fieldset>
                                        <legend><strong>Utilização da Algema</strong></legend>
                                        <p>
                                            <strong>Houve a utilização da algema: </strong> <?php echo ucwords($bo["algema"]) ?></label>
                                        </p>
                                        <p>
                                            <strong>Justificativa: </strong> <?php echo $bo["justificar_algema"] ?></label>
                                        </p>
                                    </fieldset>

                                    <fieldset>
                                        <legend><strong>Histórico da Ocorrência</strong></legend>
                                        <div class="area">
                                            <textarea  rows="17" readonly id="bo" rows="10"><?php echo $bo["historico_bo"] ?>
                                            </textarea>
                                        </div>
                                    </fieldset>

                                    <fieldset>
                                        <legend><strong>Integridade Física do Apresentado</strong></legend>
                                        <p>
                                            <strong>Lesão: </strong></label><?php echo $bo["integridade_fisica"] ?>
                                        </p>
                                        <p>
                                            <strong>Descrição da Integridade Física: </strong></label><?php echo $bo["descricao_integridade_fisica"] ?>
                                        <p>
                                    </fieldset>

                                    <fieldset>
                                        <legend><strong>Relator</strong></legend>
                                        <?php 
                                        $sqlCodeRelator = "SELECT
                                        id,
                                        nome,
                                        mat,
                                        fk_relator_bo
                                        FROM agentes
                                        JOIN bo ON agentes.id = fk_relator_bo
                                        WHERE bo.id_bo = '$id_bo' AND agentes.id = fk_relator_bo";

                                        $searchRelator = $mysqli->query($sqlCodeRelator) or die($mysqli->error);

                                        $searchRelator = $mysqli->query($sqlCodeRelator) or die($mysqli->error);
                                        $relator = $searchRelator->fetch_assoc();
                                        
                                        ?>
                                        <p>
                                            <strong>Nome: </strong></label><?php echo ucwords($relator["nome"]) ?>
                                        <p>
                                        <p>
                                            <strong>Matrícula: </strong></label><?php echo ucwords($relator["mat"]) ?>
                                        <p>
                                    </fieldset>

                                    <fieldset>
                                        <legend><strong>Autoridade Policial</strong></legend>
                                        <p>
                                            <strong>Nome: </strong></label><?php echo ucwords($bo["autoridade_policial"]) ?>
                                        <p>
                                        <p>
                                            <strong>Função: </strong></label><?php echo ucwords($bo["funcao_autoridade_policial"]) ?>
                                        <p>
                                        <p>
                                            <strong>Matrícula: </strong></label><?php echo $bo["matricula_autoridade_policial"] ?>
                                        <p>
                                        <p>
                                            <strong>Data da Assinatura: </strong></label><?php echo $dataFormatAssinatura ?>
                                        </p>
                                    </fieldset>

                                    <fieldset>
                                        <legend><strong>Dossiê</strong></legend>
                                        <p>
                                            <strong>Documento em anexo: </strong> <a target="_blank" href="<?php if (strlen($bo["dossie_bo"]) >= 1) echo $bo["dossie_bo"]?>"><?php if (strlen($bo["dossie_bo"]) >= 1) echo "Click aqui para ver" ?></a>
                                        </p>
                                    </fieldset>
                                </form>
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