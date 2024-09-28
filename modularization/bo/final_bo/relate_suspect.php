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
                if (isset($_POST["fk_suspeito"])){
                    $fk_suspeito = $_POST["fk_suspeito"];
                }

                if (isset($fk_suspeito) && empty($fk_suspeito)){
                    $error = "Escolha o Suspeito";
                }

                if (empty($fk_suspeito)){
                    $fk_suspeito = NULL;

                }else{
                            
                    $sqlCode = "SELECT id_bs, fk_suspeito, fk_bo FROM boletim_suspeito ORDER by id_bs ASC";

                    $search = $mysqli->query($sqlCode) or die($mysqli->error);
                    
                    while($bs = $search->fetch_assoc()){
                        if ($bs["fk_suspeito"] == $fk_suspeito && $bs["fk_bo"] == $_SESSION["fk_bo"]) {

                            $error = "Suspeito selecionada já relacionado com esse B.O";
                            break;
                        }
                    }
                }

                if ($error){
                    echo "<p class=\"false\">Atenção $error</p>";
                }else {
                    $fk_bo = $_SESSION["fk_bo"];
                    $sqlCodeSus = "INSERT INTO 
                    boletim_suspeito
                    (fk_bo, fk_suspeito)
                    VALUES
                    ('$fk_bo', '$fk_suspeito')";

                    $addSus = $mysqli->query($sqlCodeSus) or die($mysqli->error);
                    if ($addSus){
                        $mysqli->begin_transaction();
                        try{
                            $sqlCodeActor = "SELECT id_suspeito, nome_suspeito FROM suspeitos WHERE id_suspeito = $fk_suspeito";
                            $search = $mysqli->query($sqlCodeActor) or die();
                            $actor = $search->fetch_assoc();
                        } catch (Exception $e){
                            echo "<p class=\"false\">Ocorreu um erro: ". $e->getMessage() ."</p>";
                            $mysqli->rollback();
                            die();
                        }
                        echo "<p class=\"true\">Suspeito: ". ucwords($actor["nome_suspeito"]) ." relacionado com o Boletim $fk_bo</p>";
                    }
                }
            }

            ?>
            <?php echo "B.O PRO de Protocolo: ". $_SESSION["fk_bo"]?>
            <fieldset>
                <legend>Suspeito</legend>
                <p class="bo" id="form_suspeito">
                    <div class="form">
                        <select name="fk_suspeito" id="">
                            <option value="">
                            </option>
                            <?php include("connection.php");

                                $sqlCode = "SELECT id_suspeito, nome_suspeito, cpf_suspeito 
                                FROM suspeitos ORDER BY nome_suspeito";

                                $search = $mysqli->query($sqlCode) or die();

                                while ($suspeito = $search->fetch_assoc()){
                                    ?>

                                        <option value="<?php echo $suspeito["id_suspeito"] ?>" <?php if (isset($_POST["fk_suspeito"]) && $suspeito["id_suspeito"] == $_POST["fk_suspeito"]) echo "selected"?>><?php echo ucwords($suspeito["nome_suspeito"])?></option>
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
