<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div>
    <a href="start.php?p=add_bo"><button class="click">Voltar para o B.O</button></a>
    <div class="centre">
        <a href="process_bo.php?p=relate_suspect">
            <button class="click">Relacionar Suspeito</button>
        </a>
        <a href="process_bo.php?p=relate_victim">
            <button class="click">Relacionar Vítima</button>
        </a>
        <a href="process_bo.php?p=relate_witness">
            <button class="click">Relacionar Testemunha</button>
        </a>
    </div>
    <?php 
    if (!isset($_SESSION["fk_bo"])){
        echo "<div class=\"centre\"><p class=\"false\">Registre o B.O primeiro</p></div>";
        die();
    }
    
    ?>
    <section class="main">
        <form action="" method="post">
            <?php
            if (count($_POST) > 0){ 
                include("connection.php");

                $error = false;
                if (isset($_POST["fk_vitima"])){
                    $fk_vitima = $_POST["fk_vitima"];
                }

                if (isset($fk_vitima) && empty($fk_vitima)){
                    $error = "Escolha a Vítima";
                }

                if (empty($fk_vitima)){
                    $fk_vitima = NULL;

                }else{
                            
                    $sqlCode = "SELECT id_bv, fk_vitima, fk_bo FROM boletim_vitima ORDER by id_bv ASC";

                    $search = $mysqli->query($sqlCode) or die($mysqli->error);
                    
                    while($bs = $search->fetch_assoc()){
                        if ($bs["fk_vitima"] == $fk_vitima && $bs["fk_bo"] == $_SESSION["fk_bo"]) {

                            $error = "Vítima selecionada já relacionada com esse B.O";
                            break;
                        }
                    }
                }

                if ($error){
                    echo "<p class=\"false\">Atenção $error</p>";
                }else {
                    $fk_bo = $_SESSION["fk_bo"];
                    $sqlCodeVit = "INSERT INTO 
                    boletim_vitima
                    (fk_bo, fk_vitima)
                    VALUES
                    ('$fk_bo', '$fk_vitima')";

                    $addVit = $mysqli->query($sqlCodeVit) or die($mysqli->error);
                    if ($addVit){
                        $mysqli->begin_transaction();
                        try{
                            $sqlCodeActor = "SELECT id_vitima, nome_vitima FROM vitimas WHERE id_vitima = $fk_vitima";
                            $search = $mysqli->query($sqlCodeActor) or die();
                            $actor = $search->fetch_assoc();
                        } catch (Exception $e){
                            echo "<p class=\"false\">Ocorreu um erro: ". $e->getMessage() ."</p>";
                            $mysqli->rollback();
                            die();
                        }
                        echo "<p class=\"true\">Vítima: ". ucwords($actor["nome_vitima"]) ." relacionado com o Boletim $fk_bo</p>";
                    }
                }
            }

            ?>
            <?php echo "B.O PRO de Protocolo: ". $_SESSION["fk_bo"]?>
            <fieldset>
                <legend>Vítima</legend>
                <p class="bo" id="form_vitima">
                    <div class="form">
                        <select name="fk_vitima" id="">
                            <option value="">
                            </option>
                            <?php include("connection.php");

                                $sqlCode = "SELECT id_vitima, nome_vitima, cpf_vitima 
                                FROM vitimas ORDER BY nome_vitima";

                                $search = $mysqli->query($sqlCode) or die();

                                while ($vitima = $search->fetch_assoc()){
                                    ?>

                                        <option value="<?php echo $vitima["id_vitima"] ?>" <?php if (isset($_POST["fk_vitima"]) && $vitima["id_vitima"] == $_POST["fk_vitima"]) echo "selected"?>><?php echo ucwords($vitima["nome_vitima"])?></option>
                                        <hr>

                                    <?php
                                }
                            
                            ?>
                        </select>
                    </div>
                </p>
                <div class="centre">
                    <div class="button"><input type="submit" value="Relacionar" class="sub"></div>
                </div>
            </fieldset>
        </form>
    </section>
</div>               
</div>
