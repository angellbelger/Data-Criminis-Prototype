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

                        if (isset($_POST["nome_vitima"])){
                            $nome_vitima = $_POST["nome_vitima"];

                        }

                        if (isset($_POST["nascimento_vitima"])){
                            $nascimento_vitima = $_POST["nascimento_vitima"];

                        }

                        if (isset($_POST["cpf_vitima"])){
                            $cpf_vitima = str_replace(array(".", "-"), "", trim($_POST["cpf_vitima"]));

                        }

                        if (isset($_POST["endereco_vitima"])){
                            $endereco_vitima = $_POST["endereco_vitima"];

                        }

                        if (isset($_POST["numero_vitima"])){
                            $numero_vitima = $_POST["numero_vitima"];

                        }

                        if (isset($_POST["bairro_vitima"])){
                            $bairro_vitima = $_POST["bairro_vitima"];

                        }

                        if (isset($_POST["phone_vitima"])){
                            $phone_vitima = $_POST["phone_vitima"];

                        }

                        if (isset($_POST["pai_vitima"])){
                            $pai_vitima = $_POST["pai_vitima"];

                        }

                        if (isset($_POST["mae_vitima"])){
                            $mae_vitima = $_POST["mae_vitima"];

                        }

                        $error = false;
                        if(empty($nome_vitima)){
                            $error = "<p class=\"false\">Digite o nome da vitima.<p>";

                        }

                        if (empty($cpf_vitima)){
                            $cpf_vitima = NULL;

                        }else{
                                    
                            $sqlCode = "SELECT id_vitima, cpf_vitima FROM vitimas ORDER by id_vitima ASC";

                            $search = $mysqli->query($sqlCode) or die($mysqli->error);
                            
                            while($vit = $search->fetch_assoc()){
                                if ($vit["cpf_vitima"] == $cpf_vitima){
                                    if (isset($vit["cpf_testemunha"]) && strlen($vit["cpf_vitima"]) == 11){
                                        $cpf_vitima = substr_replace($vit["cpf_vitima"], '.', 3, 0);
                                        $cpf_vitima = substr_replace($cpf_vitima, '.', 7, 0);
                                        $cpf_vitima = substr_replace($cpf_vitima, '-', 11, 0);
                                    }
                                    $error = "Vítima com o número de documento ". $cpf_vitima ." já registrado no banco de dados. Ele já pode ser vinculado a qualquer outro Boletim de Ocorrência sem registro prévio.";
                                    break;
                                }
                            }
                        }
                        
                        if ($error){
                            echo "<p class=\"false\">$error</p>";

                        }else{
                            $sqlCode = "INSERT INTO vitimas 
                            (nome_vitima, nascimento_vitima, cpf_vitima, endereco_vitima, numero_vitima, bairro_vitima, phone_vitima, pai_vitima, mae_vitima) 
                            VALUES 
                            ('$nome_vitima', '$nascimento_vitima', '$cpf_vitima', '$endereco_vitima', '$numero_vitima', '$bairro_vitima', '$phone_vitima', '$pai_vitima', '$mae_vitima')";

                            $addData = $mysqli->query($sqlCode) or die($mysqli->error);
                            if ($addData){
                                
                                echo "<p class=\"true\"><strong>Vitima registrada no banco de dados: ". ucwords($nome_vitima). ".</strong></p>";
                                echo "<p>Click aqui para adicionar outro <a href=\"#\"><button class=\"click\">Adicionar outro</button></a></p>";

                                die();
                            }
                        }

                    }
            ?>
            <fieldset>
                <legend>Data-Criminis - B.O.P</legend>
                <h2>Registrar Vítimas</h2>
                <p class="bo">
                    <div class="form">
                        <label for="nome_vitima"><strong>Nome:</strong></label>
                        <input type="text" placeholder="" name="nome_vitima" id="nome_vitima" value="<?php if (isset($_POST["nome_vitima"])) echo $_POST["nome_vitima"] ?>"><span class="false"> * </span>
                    </div>
                <p class="bo">
                    <div class="form">
                        <label for="nascimento_vitima"><strong>Data de nascimento:</strong></label>
                        <input type="date" name="nascimento_vitima" id="nascimento_vitima" value="<?php if (isset($_POST["nascimento_vitima"])) echo $_POST["nascimento_vitima"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="cpf_vitima"><strong>CPF/RG:</strong></label>
                        <input type="text" name="cpf_vitima" id="cpf_vitima" value="<?php if (isset($_POST["cpf_vitima"])) echo $_POST["cpf_vitima"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="endereco_vitima"><strong>Endereço:</strong></label>
                        <input type="text" placeholder="" name="endereco_vitima" id="endereco_vitima" value="<?php if (isset($_POST["endereco_vitima"])) echo $_POST["endereco_vitima"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="numero_vitima"><strong>Nº:</strong></label>
                        <input type="text" placeholder="221b" name="numero_vitima" id="numero_vitima" size="5" value="<?php if (isset($_POST["numero_vitima"])) echo $_POST["numero_vitima"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="bairro_vitima"><strong>Bairro:</strong></label>
                        <input type="text" placeholder="Ex: Água Verde" name="bairro_vitima" id="bairro_vitima" value="<?php if (isset($_POST["bairro_vitima"])) echo $_POST["bairro_vitima"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="phone_vitima"><strong>Phone:</strong></label>
                        <input type="text" placeholder="(41) 99xxx-xxxx" name="phone_vitima" id="phone_vitima" value="<?php if (isset($_POST["phone_vitima"])) echo $_POST["phone_vitima"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="pai_vitima"><strong>Pai:</strong></label>
                        <input type="text" name="pai_vitima" id="pai_vitima" value="<?php if (isset($_POST["pai_vitima"])) echo $_POST["pai_vitima"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="mae_vitima"><strong>Mãe:</strong></label>
                        <input type="text" name="mae_vitima" id="mae_vitima" value="<?php if (isset($_POST["mae_vitima"])) echo $_POST["mae_vitima"] ?>">
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