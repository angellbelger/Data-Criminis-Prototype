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

                        if (isset($_POST["nome_suspeito"])){
                            $nome_suspeito = strtolower(trim($_POST["nome_suspeito"]));

                        }

                        if (isset($_POST["nascimento_suspeito"])){
                            $nascimento_suspeito = strtolower(trim($_POST["nascimento_suspeito"]));

                        }

                        if (isset($_POST["cpf_suspeito"])){
                            $cpf_suspeito = str_replace(array(".", "-"), "", trim($_POST["cpf_suspeito"]));

                        }

                        if (isset($_POST["endereco_suspeito"])){
                            $endereco_suspeito = strtolower(trim($_POST["endereco_suspeito"]));

                        }

                        if (isset($_POST["numero_suspeito"])){
                            $numero_suspeito = strtolower(trim($_POST["numero_suspeito"]));

                        }

                        if (isset($_POST["bairro_suspeito"])){
                            $bairro_suspeito = strtolower(trim($_POST["bairro_suspeito"]));

                        }

                        if (isset($_POST["phone_suspeito"])){
                            $phone_suspeito = strtolower(trim($_POST["phone_suspeito"]));

                        }

                        if (isset($_POST["pai_suspeito"])){
                            $pai_suspeito = strtolower(trim($_POST["pai_suspeito"]));

                        }

                        if (isset($_POST["mae_suspeito"])){
                            $mae_suspeito = strtolower(trim($_POST["mae_suspeito"]));

                        }

                        $error = false;
                        if(empty($nome_suspeito)){
                            $error = "<p class=\"false\">Digite o nome do suspeito.<p>";
            
                        }
                        
                        if (empty($cpf_suspeito)){
                            $cpf_suspeito = NULL;

                        }else{
                                    
                            $sqlCode = "SELECT id_suspeito, cpf_suspeito FROM suspeitos ORDER by id_suspeito ASC";

                            $search = $mysqli->query($sqlCode) or die($mysqli->error);
                            
                            while($sus = $search->fetch_assoc()){
                                if ($sus["cpf_suspeito"] == $cpf_suspeito){
                                    if (isset($sus["cpf_suspeito"]) && strlen($sus["cpf_suspeito"]) == 11){
                                        $cpf_suspeito = substr_replace($sus["cpf_suspeito"], '.', 3, 0);
                                        $cpf_suspeito = substr_replace($cpf_suspeito, '.', 7, 0);
                                        $cpf_suspeito = substr_replace($cpf_suspeito, '-', 11, 0);
                                    }
                                    $error = "Suspeito com o número de documento ". $cpf_suspeito ." já registrado no banco de dados. Ele já pode ser vinculado a qualquer outro Boletim de Ocorrência sem registro prévio.";
                                    break;
                                }
                            }
                        }

                        if ($error){
                            echo "<p class=\"false\">$error</p>";

                        }else{
                            $sqlCode = "INSERT INTO suspeitos 
                            (nome_suspeito, nascimento_suspeito, cpf_suspeito, endereco_suspeito, numero_suspeito, bairro_suspeito, phone_suspeito, pai_suspeito, mae_suspeito) 
                            VALUES 
                            ('$nome_suspeito', '$nascimento_suspeito', '$cpf_suspeito', '$endereco_suspeito', '$numero_suspeito', '$bairro_suspeito', '$phone_suspeito', '$pai_suspeito', '$mae_suspeito')";

                            $addData = $mysqli->query($sqlCode) or die($mysqli->error);
                            if ($addData){
                                
                                echo "<p class=\"true\"><strong>Suspeito registrado no banco de dados: ". ucwords($nome_suspeito). ".</strong></p>";
                                echo "<p>Click aqui para adicionar outro <a href=\"#\"><button class=\"click\">Adicionar outro</button></a></p>";

                                die();
                            }
                        }

                    }
            ?>
            <fieldset>
                <legend>Data-Criminis - B.O</legend>
                <h2>Registrar Suspeitos</h2>
                <p class="bo">
                    <div class="form">
                        <label for="nome_suspeito"><strong>Nome:</strong></label>
                        <input type="text" placeholder="" name="nome_suspeito" id="nome_suspeito" value="<?php if (isset($_POST["nome_suspeito"])) echo $_POST["nome_suspeito"]?>"><span class="false"> * </span>
                    </div>
                <p class="bo">
                    <div class="form">
                        <label for="nascimento_suspeito"><strong>Data de nascimento:</strong></label>
                        <input type="date" name="nascimento_suspeito" id="nascimento_suspeito" value="<?php if (isset($_POST["nascimento_suspeito"])) echo $_POST["nascimento_suspeito"]?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="cpf_suspeito"><strong>CPF/RG:</strong></label>
                        <input type="text" name="cpf_suspeito" id="cpf_suspeito" value="<?php if (isset($_POST["cpf_suspeito"])) echo $_POST["cpf_suspeito"]?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="endereco_suspeito"><strong>Endereço:</strong></label>
                        <input type="text" placeholder="" name="endereco_suspeito" id="endereco_suspeito" value="<?php if (isset($_POST["endereco_suspeito"])) echo $_POST["endereco_suspeito"]?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="numero_suspeito"><strong>Nº:</strong></label>
                        <input type="text" placeholder="221b" name="numero_suspeito" id="numero_suspeito" size="5" value="<?php if (isset($_POST["numero_suspeito"])) echo $_POST["numero_suspeito"]?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="bairro_suspeito"><strong>Bairro:</strong></label>
                        <input type="text" placeholder="Ex: Água Verde" name="bairro_suspeito" id="bairro_suspeito" value="<?php if (isset($_POST["bairro_suspeito"])) echo $_POST["bairro_suspeito"]?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="phone_suspeito"><strong>Phone:</strong></label>
                        <input type="text" placeholder="(41) 99xxx-xxxx" name="phone_suspeito" id="phone_suspeito" value="<?php if (isset($_POST["phone_suspeito"])) echo $_POST["phone_suspeito"]?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="pai_suspeito"><strong>Pai:</strong></label>
                        <input type="text" name="pai_suspeito" id="pai_suspeito" value="<?php if (isset($_POST["pai_suspeito"])) echo $_POST["pai_suspeito"]?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="mae_suspeito"><strong>Mãe:</strong></label>
                        <input type="text" name="mae_suspeito" id="mae_suspeito" value="<?php if (isset($_POST["mae_suspeito"])) echo $_POST["mae_suspeito"]?>">
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