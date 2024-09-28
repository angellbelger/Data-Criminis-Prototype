<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div>
    <a href="start.php?p=begin"><button class="click">Sair</button></a>
    <div class="centre">
        <a href="start.php?p=add_suspect">
            <button class="click">Suspeito</button>
        </a>
        <a href="start.php?p=add_victim">
            <button class="click">Vítima</button>
        </a>
        <a href="start.php?p=add_witness">
            <button class="click">Testemunha</button>
        </a>
        <a href="start.php?p=add_bo">
            <button class="click">Boletim de Ocorrência</button>
        </a>
        <a href="process_bo.php">
            <button class="click">Finalizar</button>
        </a>
    </div>
    <section class="main">
        <form action="" method="post">
            <?php
                    if (count($_POST) > 1){
                        include("connection.php");

                        if (isset($_POST["nome_testemunha"])){
                            $nome_testemunha = $_POST["nome_testemunha"];

                        }

                        if (isset($_POST["nascimento_testemunha"])){
                            $nascimento_testemunha = $_POST["nascimento_testemunha"];

                        }

                        if (isset($_POST["cpf_testemunha"])){
                            $cpf_testemunha = str_replace(array(".", "-"), "", trim($_POST["cpf_testemunha"]));

                        }

                        if (isset($_POST["endereco_testemunha"])){
                            $endereco_testemunha = $_POST["endereco_testemunha"];

                        }

                        if (isset($_POST["numero_testemunha"])){
                            $numero_testemunha = $_POST["numero_testemunha"];

                        }

                        if (isset($_POST["bairro_testemunha"])){
                            $bairro_testemunha = $_POST["bairro_testemunha"];

                        }

                        if (isset($_POST["phone_testemunha"])){
                            $phone_testemunha = $_POST["phone_testemunha"];

                        }

                        if (isset($_POST["pai_testemunha"])){
                            $pai_testemunha = $_POST["pai_testemunha"];

                        }

                        if (isset($_POST["mae_testemunha"])){
                            $mae_testemunha = $_POST["mae_testemunha"];

                        }

                        $error = false;
                        if(empty($nome_testemunha)){
                            $error = "<p class=\"false\">Digite o nome da testemunha.<p>";
                        }

                        if (empty($cpf_testemunha)){
                            $cpf_testemunha = NULL;

                        }else{
                                    
                            $sqlCode = "SELECT id_testemunha, cpf_testemunha FROM testemunhas ORDER by id_testemunha ASC";

                            $search = $mysqli->query($sqlCode) or die($mysqli->error);
                            
                            while($test = $search->fetch_assoc()){
                                
                                if ($test["cpf_testemunha"] == $cpf_testemunha){
                                    if (isset($test["cpf_testemunha"]) && strlen($test["cpf_testemunha"]) == 11){
                                        $cpf_testemunha = substr_replace($test["cpf_testemunha"], '.', 3, 0);
                                        $cpf_testemunha = substr_replace($cpf_testemunha, '.', 7, 0);
                                        $cpf_testemunha = substr_replace($cpf_testemunha, '-', 11, 0);
                                    }
                                    $error = "Testemunha com o número de documento ". $cpf_testemunha ." já registrado no banco de dados. Ele já pode ser vinculado a qualquer outro Boletim de Ocorrência sem registro prévio.";
                                    break;
                                }
                            }
                        }

                        if ($error){
                            echo "<p class=\"false\">$error</p>";

                        }else{
                            $sqlCode = "INSERT INTO testemunhas 
                            (nome_testemunha, nascimento_testemunha, cpf_testemunha, endereco_testemunha, numero_testemunha, bairro_testemunha, phone_testemunha, pai_testemunha, mae_testemunha) 
                            VALUES 
                            ('$nome_testemunha', '$nascimento_testemunha', '$cpf_testemunha', '$endereco_testemunha', '$numero_testemunha', '$bairro_testemunha', '$phone_testemunha', '$pai_testemunha', '$mae_testemunha')";

                            $addData = $mysqli->query($sqlCode) or die($mysqli->error);
                            if ($addData){
                                
                                echo "<p class=\"true\"><strong>Testemunha registrada no banco de dados: ". ucwords($nome_testemunha). ".</strong></p>";
                                echo "<p>Click aqui para adicionar outro <a href=\"#\"><button class=\"click\">Adicionar outro</button></a></p>";

                                die();
                            }
                        }

                    }
            ?>
            <fieldset>
                <legend>Data-Criminis - B.O.P</legend>
                <h2>Registrar Testemunhas</h2>
                <p class="bo">
                    <div class="form">
                        <label for="nome_testemunha"><strong>Nome:</strong></label>
                        <input type="text" placeholder="" name="nome_testemunha" id="nome_testemunha" value="<?php if (isset($_POST["nome_testemunha"])) echo $_POST["nome_testemunha"] ?>"><span class="false"> * </span>
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="nascimento_testemunha"><strong>Data de nascimento:</strong></label>
                        <input type="date" name="nascimento_testemunha" id="nascimento_testemunha" value="<?php if (isset($_POST["nascimento_testemunha"])) echo $_POST["nascimento_testemunha"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="cpf_testemunha"><strong>CPF/RG:</strong></label>
                        <input type="text" name="cpf_testemunha" id="cpf_testemunha" value="<?php if (isset($_POST["cpf_testemunha"])) echo $_POST["cpf_testemunha"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="endereco_testemunha"><strong>Endereço:</strong></label>
                        <input type="text" placeholder="" name="endereco_testemunha" id="endereco_testemunha" value="<?php if (isset($_POST["endereco_testemunha"])) echo $_POST["endereco_testemunha"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="numero_testemunha"><strong>Nº:</strong></label>
                        <input type="text" placeholder="221b" name="numero_testemunha" id="numero_testemunha" size="5" value="<?php if (isset($_POST["numero_testemunha"])) echo $_POST["numero_testemunha"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="bairro_testemunha"><strong>Bairro:</strong></label>
                        <input type="text" placeholder="Ex: Água Verde" name="bairro_testemunha" id="bairro_testemunha" value="<?php if (isset($_POST["bairro_testemunha"])) echo $_POST["bairro_testemunha"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="phone_testemunha"><strong>Phone:</strong></label>
                        <input type="text" placeholder="(41) 99xxx-xxxx" name="phone_testemunha" id="phone_testemunha" value="<?php if (isset($_POST["phone_testemunha"])) echo $_POST["phone_testemunha"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="pai_testemunha"><strong>Pai:</strong></label>
                        <input type="text" name="pai_testemunha" id="pai_testemunha" value="<?php if (isset($_POST["pai_testemunha"])) echo $_POST["pai_testemunha"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="mae_testemunha"><strong>Mãe:</strong></label>
                        <input type="text" name="mae_testemunha" id="mae_testemunha" value="<?php if (isset($_POST["mae_testemunha"])) echo $_POST["mae_testemunha"] ?>">
                    </div>
                </p>
                <div class="centre">
                <div class="button"><input type="submit" value="Registrar" class="sub"></div>
                    <div class="button"><input type="reset" value="Limpar" class="sub"></div>
                </div>
            </fieldset>
        </form>
    </section>
</div>               
</div>