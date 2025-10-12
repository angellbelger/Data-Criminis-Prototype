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
                if (isset($_POST["fk_testemunha"])){
                    $fk_testemunha = $_POST["fk_testemunha"];
                }

                if (isset($fk_testemunha) && empty($fk_testemunha)){
                    $error = "Escolha o Vítima";
                }

                if (empty($fk_testemunha)){
                    $fk_testemunha = NULL;

                }else{
                            
                    $sqlCode = "SELECT id_bt, fk_testemunha, fk_bo FROM boletim_testemunha ORDER by id_bt ASC";

                    $search = $mysqli->query($sqlCode) or die($mysqli->error);
                    
                    while($bs = $search->fetch_assoc()){
                        if ($bs["fk_testemunha"] == $fk_testemunha && $bs["fk_bo"] == $_SESSION["fk_bo"]) {

                            $error = "Testemunha já relacionada com esse B.O";
                            break;
                        }
                    }
                }

                if ($error){
                    echo "<p class=\"false\">Atenção $error</p>";
                }else {
                    $fk_bo = $_SESSION["fk_bo"];
                    $sqlCodeTest = "INSERT INTO 
                    boletim_testemunha
                    (fk_bo, fk_testemunha)
                    VALUES
                    ('$fk_bo', '$fk_testemunha')";

                    $addTest = $mysqli->query($sqlCodeTest) or die($mysqli->error);
                    if ($addTest){
                        $mysqli->begin_transaction();
                        try{
                            $sqlCodeActor = "SELECT id_testemunha, nome_testemunha FROM testemunhas WHERE id_testemunha = $fk_testemunha";
                            $search = $mysqli->query($sqlCodeActor) or die();
                            $actor = $search->fetch_assoc();
                        } catch (Exception $e){
                            echo "<p class=\"false\">Ocorreu um erro: ". $e->getMessage() ."</p>";
                            $mysqli->rollback();
                            die();
                        }
                        echo "<p class=\"true\">Testemunha: ". ucwords($actor["nome_testemunha"]) ." relacionado com o Boletim $fk_bo</p>";
                    }
                }
            }

            ?>
            <?php echo "B.O PRO de Protocolo: ". $_SESSION["fk_bo"]?>
            <fieldset>
                <legend>Testemunha</legend>
                <p class="bo" id="form_testemunha">
                    <div class="form">
                        <select name="fk_testemunha" id="">
                            <option value="">
                            </option>
                            <?php include("connection.php");

                                $sqlCode = "SELECT id_testemunha, nome_testemunha, cpf_testemunha 
                                FROM testemunhas ORDER BY nome_testemunha";

                                $search = $mysqli->query($sqlCode) or die();

                                while ($testemunha = $search->fetch_assoc()){
                                    ?>

                                        <option value="<?php echo $testemunha["id_testemunha"] ?>" <?php if (isset($_POST["fk_testemunha"]) && $testemunha["id_testemunha"] == $_POST["fk_testemunha"]) echo "selected"?>><?php echo ucwords($testemunha["nome_testemunha"])?></option>
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
