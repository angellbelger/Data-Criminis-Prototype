<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
<div>
    <a href="index.php"><button class="click">Sair</button></a>
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
        <form enctype="multipart/form-data" action="" method="post">
            <?php
                if (count($_POST) > 1){
                    include("connection.php");
                    if (isset($_POST["data_bo"])){
                        $data_bo = $_POST["data_bo"];    
                    }
                    
                    if (isset($_POST["hora_inicial"])){
                        $hora_inicial = $_POST["hora_inicial"];    
                    }
                    
                    if (isset($_POST["hora_final"])){
                        $hora_final = $_POST["hora_final"];    
                    }
                    
                    if (isset($_POST["endereco"])){
                        $endereco = strtolower(trim($_POST["endereco"]));    
                    }
                    
                    if (isset($_POST["numero"])){
                        $numero = trim($_POST["numero"]);    
                    }
                    
                    if (isset($_POST["bairro"])){
                        $bairro = strtolower(trim($_POST["bairro"]));    
                    }
                    
                    if (isset($_POST["complemento_bo"])){
                        $complemento_bo = strtolower(trim($_POST["complemento_bo"]));    
                    }
                    
                    if (isset($_POST["fk_municipio_bo"])){
                        $fk_municipio_bo = $_POST["fk_municipio_bo"];    
                    }
                    
                    if (isset($_POST["fk_uf_bo"])){
                        $fk_uf_bo = $_POST["fk_uf_bo"];    
                    }

                    if (isset($_POST["atendimento_bo_desc"])){
                        $atendimento_bo_desc = trim(ucwords(($_POST["atendimento_bo_desc"])));
                    }
                    
                    if (isset($_POST["atendimento_bo"]) && strlen($_POST["atendimento_bo"]) > 0){
                        $atendimento_bo = trim(ucwords(($_POST["atendimento_bo"])));    
                    }else {
                        $atendimento_bo = $atendimento_bo_desc; 
                    }

                    if (isset($_POST["material_apreendido"])){
                        $material_apreendido = trim($_POST["material_apreendido"]);    
                    }
                    
                    if (isset($_POST["algema"])){
                        $algema = trim($_POST["algema"]);    
                    }
                    
                    if (isset($_POST["justificar_algema"])){
                        $justificar_algema = trim($_POST["justificar_algema"]);    
                    }
                    
                    if (isset($_POST["historico_bo"])){
                        $historico_bo = trim($_POST["historico_bo"]);    
                    }
                    
                    if (isset($_POST["integridade_fisica"])){
                        $integridade_fisica = trim($_POST["integridade_fisica"]);    
                    }
                    if (isset($_POST["descricao_integridade_fisica"])){
                        $descricao_integridade_fisica = trim($_POST["descricao_integridade_fisica"]);    
                    }
                    
                    if (isset($_POST["fk_relator_bo"])){
                        $fk_relator_bo = trim($_POST["fk_relator_bo"]);    
                    }
                    
                    if (isset($_POST["autoridade_policial"])){
                        $autoridade_policial = strtolower(trim($_POST["autoridade_policial"]));
                    }
                    if (isset($_POST["funcao_autoridade_policial"])){
                        $funcao_autoridade_policial = strtolower(trim($_POST["funcao_autoridade_policial"]));
                    }
                    
                    if (isset($_POST["matricula_autoridade_policial"])){    
                        $matricula_autoridade_policial = trim($_POST["matricula_autoridade_policial"]);    
                    }

                    $error = false;
                    if(empty($data_bo)){
                        $error = "<p class=\"false\">Selecione a data da ocorrência.<p>";
                    }
                    if(empty($hora_inicial)){
                        $error = "<p class=\"false\">Selecione a hora inicial da ocorrência.<p>";
                    }
                    if(empty($hora_final)){
                        $error = "<p class=\"false\">Selecione a hora final da ocorrência.<p>";
                    }
                    if(empty($fk_municipio_bo)){
                        $error = "<p class=\"false\">Especifique o município da ocorrência.<p>";
                    }
                    if(empty($fk_uf_bo)){
                        $error = "<p class=\"false\">Especifique a Unidade Federativa da Ocorrência.<p>";
                    }
                    if (empty($_POST["atendimento_bo"]) && empty($_POST["atendimento_bo_desc"])){
                        $error = "<p class=\"false\">Especifique o tipo de atendimento.<p>";
                    }

                    if(empty($algema)){
                        $error = "<p class=\"false\">Especifique se houve o uso da algema e justifique caso tenha usado.<p>";
                    }
                    if(isset($_POST["algema"]) && $_POST["algema"] == "Sim" && empty($justificar_algema)){
                        $error = "<p class=\"false\">justifique a utilização da algema.<p>";
                    }
                    if(empty($historico_bo)){
                        $error = "<p class=\"false\">Descreva a ocorrência no histórico.<p>";
                    }
                    if(empty($integridade_fisica)){
                        $error = "<p class=\"false\">Preencha o campo sobre a integridade física.<p>";
                    }
                    if(empty($fk_relator_bo)){
                        $error = "<p class=\"false\">Especifique o nome do relator.<p>";
                    }
                    if(empty($autoridade_policial)){
                        $autoridade_policial = NULL;

                    }
                    if(empty($funcao_autoridade_policial)){
                        $funcao_autoridade_policial = NULL;

                    }
                    if ($error){
                        echo "<p class=\"false\">$error</p>";
                    }else{

                        $mysqli->begin_transaction();
                        try {
                            if($_FILES["dossie_bo"]["size"] > 0){
                                $file = $_FILES["dossie_bo"];

                                if ($file["error"]){
                                    $erro = "Falha ao Enviar arquivo";
                                }

                                if ($file["size"] > 100097152)
                                    $error = "Arquivo muito grande. Selecione algo menor que 100MB.";

                                $folder = "files_bo/";
                                $nameFile = $file["name"];
                                $newNameFile = uniqid();
                                $extensionFile = strtolower(pathinfo($nameFile, PATHINFO_EXTENSION));

                                if ($extensionFile != "pdf" && $extensionFile != "jpg" && $extensionFile != "png" && $extensionFile != "jpeg"){
                                    $error = "Extensão: $extensionFile. Tipo de arquivo não aceito.";
                                    $ok = false;
                                }else{
                                    $path = $folder . $newNameFile . "." . $extensionFile;
                                    $ok = move_uploaded_file($file["tmp_name"], $path);
                                }

                                if ($ok){
                                    echo "<p class=\"true\">Arquivo anexado com sucesso, para vê-lo. <a href=\"files_bo/$newNameFile.$extensionFile\" target=\"_blank\">Click Aqui.</a></p>";
                                }else{
                                    $error = "Falha ao enviar arquivo.";
                                }
                            }
                            if ($error){
                                echo "<p class=\"false\"><strong>$error</strong></p>";
                            }else{
                                $owner = $_SESSION["name"];
                                if (!isset($path)){
                                    $path = NULL;
                                }

                                $sqlCode = "INSERT INTO bo 
                                (data_bo, hora_inicial, hora_final, endereco, numero, bairro, complemento_bo, fk_municipio_bo, fk_uf_bo, atendimento_bo, material_apreendido, algema, justificar_algema, historico_bo, integridade_fisica, descricao_integridade_fisica, fk_relator_bo, autoridade_policial, funcao_autoridade_policial, matricula_autoridade_policial, dossie_bo) 
                                VALUES
                                ('$data_bo', '$hora_inicial', '$hora_final', '$endereco', '$numero', '$bairro', '$complemento_bo', '$fk_municipio_bo', '$fk_uf_bo', '$atendimento_bo', '$material_apreendido', '$algema', '$justificar_algema', '$historico_bo', '$integridade_fisica', '$descricao_integridade_fisica', '$fk_relator_bo', '$autoridade_policial', '$funcao_autoridade_policial', '$matricula_autoridade_policial', '$path') ";

                                $addData = $mysqli->query($sqlCode) or die($mysqli->error);

                                $fk_bo = $mysqli->insert_id;
                                
                                echo "<p class=\"true\"><strong>Boletim de Ocorrência PRO registrado, com assinatura digital do(a) agente ".ucwords($owner)." realizado com sucesso.<br>Número de Protocolo: $fk_bo</strong></p>";
                                echo "<a href=\"process_bo.php\"><button class=\"click\" type=\"button\">Click aqui para adicionar envolvidos:</button></a>";
                                $_SESSION["fk_bo"] = $fk_bo;
                                ?>
                                <script>
                                    function redirecionar() {
                                        // Altere a URL abaixo para a página que você deseja redirecionar
                                        var novaPagina = "process_bo.php";

                                        // Redirecionar para a nova página
                                        window.location.href = novaPagina;
                                    }
                                </script>
                                <?php
                            }
                            $mysqli->commit();
                            include("connection2.php");
                            $fk_user = $_SESSION["user"];
                            $act = "Registrou um Boletim de Ocorrência PRO com número de protocolo $fk_bo";
                            $sqlCodeAct = "INSERT INTO activities (fk_user, act, data) VALUES ('$fk_user','$act', NOW())";
                            $addAct = $mysqli->query($sqlCodeAct) or die($mysqli->error);
                            header("Location: process_bo.php");
                            die();

                        } catch (Exception $e){
                            $mysqli->rollback();

                            echo "<p class=\"false\">Ocorreu um erro: ". $e->getMessage() ."</p>";
                        }
                    }
                }

            ?>
            <fieldset>
                <legend>Data-Criminis - B.O.P</legend>
                <h2>Boletim de Ocorrência - PRO</h2>
                <?php 
                    if(isset($_SESSION["fk_bo"])){
                        echo "<div class=\"centre\"><p class=\"false\">Boletim de Ocorrência PRO já registrado, vá para a página \"Finalizar\" e finalize o processo.  </p></div>";
                        die();
                    }
                ?>
                <p class="bo">
                    <div class="form">
                        <label for="data_bo"><strong>Data:</strong></label>
                        <input type="date" name="data_bo" id="data_bo" value= "<?php if (isset($_POST['data_bo'])) echo date('Y-m-d', strtotime($_POST['data_bo'])) ?>"><span class="false"> * </span>
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="hora_inicial"><strong>Hora Início:</strong></label>
                        <input type="time" name="hora_inicial" id="hora_inicial" value="<?php if (isset($_POST["hora_inicial"])) echo $_POST["hora_inicial"] ?>"><span class="false"> * </span>
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="hora_final"><strong>Horário Término:</strong></label>
                        <input type="time" name="hora_final" id="hora_final" value="<?php if (isset($_POST["hora_final"])) echo $_POST["hora_final"] ?>"><span class="false"> * </span>
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="endereco"><strong>Endereço:</strong></label>
                        <input type="text" placeholder="Rua Itatiaia" name="endereco" id="endereco" value="<?php if (isset($_POST["endereco"])) echo $_POST["endereco"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="numero" ><strong>Nº:</strong></label>
                        <input type="text" placeholder="Ex: 221b" name="numero" id="numero" value="<?php if (isset($_POST["numero"])) echo $_POST["numero"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="bairro"><strong>Bairro:</strong></label>
                        <input type="text" placeholder="Ex: Água Verde" name="bairro" id="bairro" value="<?php if (isset($_POST["bairro"])) echo $_POST["bairro"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                        <label for="complemento_bo"><strong>Complemento:</strong></label>
                        <input type="text" placeholder="Ex: Em frente..." name="complemento_bo" id="complemento_bo" value="<?php if (isset($_POST["complemento_bo"])) echo $_POST["complemento_bo"] ?>">
                    </div>
                </p>
                <p class="bo">
                    <div class="form">
                    <label for="fk_municipio_bo" require><strong>Município:</strong> </label>
                        <select name="fk_municipio_bo" id="fk_municipio_bo">
                            <option value="">
                            </option>
                            <?php
                                include("connection.php");
                                if (isset($_POST["fk_municipio_bo"])){
                                    echo "<option>-</option>";
                                }
                                $sqlCode = "SELECT cidades.id_cidade, cidades.nome_cidade, cidades.fk_estado, estados.id_estado, estados.nome_estado, estados.uf FROM cidades, estados WHERE cidades.fk_estado = estados.id_estado ORDER BY nome_cidade ASC";
                                $search = $mysqli->query($sqlCode) or die($mysqli->error);
                                while($cidade = $search->fetch_assoc()){
                                    ?>
                                        <option value="<?php echo $cidade["id_cidade"]?>" <?php if (isset($_POST["fk_municipio_bo"]) && $cidade["id_cidade"] == $_POST["fk_municipio_bo"]) echo "selected"?>><?php echo $cidade["nome_cidade"]; echo " - ". $cidade["uf"] ."";?></option>
                                    <?php
                                }
                            ?>
                        </select><span class="false"> * </span>
                    </div>
                </p>
                <P class="bo">
                    <label for="fk_uf_bo"><strong>UF:</strong> </label>
                        <select name="fk_uf_bo" id="fk_uf_bo">
                            <option value="">
                            </option>
                            <?php include("connection.php");
                                
                                $sqlCode = "SELECT * FROM estados ORDER BY nome_estado ASC";
                                $search = $mysqli->query($sqlCode) or die();

                                while ($estado = $search->fetch_assoc()){
                                    ?>
                                        <option value="<?php echo $estado["id_estado"]?>" <?php if (isset($_POST["fk_uf_bo"]) && $estado["id_estado"] == $_POST["fk_uf_bo"]) echo "selected"?>><?php echo "".$estado["uf"]." - ".$estado["nome_estado"].""?></option>
                                    <?php
                                }
                            
                            ?>
                        </select><span class="false"> * </span>
                </P>

                <hr>
                
                <h3>Natureza da Ocorrência <span class="false"> * </span></h3>
                <div class="check_bo">
                    <div class="services">
                        <input type="radio" name="atendimento_bo" value="Agressão" id="box1" <?php if (isset($_POST["atendimento_bo"]) && $_POST["atendimento_bo"] == "Agressão") echo "checked"?>>
                        <label for="box1">Agressão</label><br>
                    </div>
                    <div class="services">
                        <input type="radio" name="atendimento_bo" value="Ameaça" id="box2" <?php if (isset($_POST["atendimento_bo"]) && $_POST["atendimento_bo"] == "Ameaça") echo "checked"?>>
                        <label for="box2">Ameaça</label><br>
                    </div>
                    <div class="services">
                        <input type="radio" name="atendimento_bo" value="Desacato" id="box3" <?php if (isset($_POST["atendimento_bo"]) && $_POST["atendimento_bo"] == "Desacato") echo "checked"?>>
                        <label for="box3">Desacato</label><br>
                    </div>
                    <div class="services">
                        <input type="radio" name="atendimento_bo" value="Desordem" id="box4" <?php if (isset($_POST["atendimento_bo"]) && $_POST["atendimento_bo"] == "Desordem") echo "checked"?>>
                        <label for="box4">Desordem</label><br>
                    </div>
                    <div class="services">
                        <input type="radio" name="atendimento_bo" value="Furto" id="box5" <?php if (isset($_POST["atendimento_bo"]) && $_POST["atendimento_bo"] == "Furto") echo "checked"?>>
                        <label for="box5">Furto</label><br>
                    </div>
                    <div class="services">
                        <input type="radio" name="atendimento_bo" value="Roubo" id="box6" <?php if (isset($_POST["atendimento_bo"]) && $_POST["atendimento_bo"] == "Roubo") echo "checked"?>>
                        <label for="box6">Roubo</label><br>
                    </div>
                </div>
                <div class="check_bo">
                    <div class="services">
                        <input type="radio" name="atendimento_bo" value="Homicídio" id="box7" <?php if (isset($_POST["atendimento_bo"]) && $_POST["atendimento_bo"] == "Homicídio") echo "checked"?>>
                        <label for="box7">Homicídio</label><br>
                    </div>
                    <div class="services">
                        <input type="radio" name="atendimento_bo" value="Lesão Corporal" id="box8" <?php if (isset($_POST["atendimento_bo"]) && $_POST["atendimento_bo"] == "Lesão Corporal") echo "checked"?>>
                        <label for="box8">Lesão Corporal</label><br>
                    </div>
                    <div class="services">
                        <input type="radio" name="atendimento_bo" value="Arma de Fogo" id="box9" <?php if (isset($_POST["atendimento_bo"]) && $_POST["atendimento_bo"] == "Arma de Fogo") echo "checked"?>>
                        <label for="box9">Arma de Fogo</label><br>
                    </div>
                    <div class="services">
                        <input type="radio" name="atendimento_bo" value="Drogas" id="box10" <?php if (isset($_POST["atendimento_bo"]) && $_POST["atendimento_bo"] == "Drogas") echo "checked"?>>
                        <label for="box10">Drogas</label><br>
                    </div>
                    <div class="services">
                        <input type="radio" name="atendimento_bo" value="Poluição Sonora" id="box11" <?php if (isset($_POST["atendimento_bo"]) && $_POST["atendimento_bo"] == "Poluição Sonora") echo "checked"?>>
                        <label for="box11">Poluição Sonora</label><br>
                    </div>
                    
                    <div class="services">
                        <input type="radio" name="atendimento_bo" value="Vandalismo" id="box12" <?php if (isset($_POST["atendimento_bo"]) && $_POST["atendimento_bo"] == "Vandalismo") echo "checked"?>>
                        <label for="box12">Vandalismo</label><br>
                    </div>
                </div>
                <p class="form">
                    <input type="radio" name="atendimento_bo" value="<?php if(isset($_POST["atendimento_bo_desc"])) echo $_POST["atendimento_bo_desc"]?>" id="box13" <?php if (!isset($_POST["atendimento_bo"])) echo "checked"?>>
                    <label for="box13">Outros:</label>
                    <input type="text" name="atendimento_bo_desc" value="<?php if(isset($_POST["atendimento_bo_desc"])) echo $_POST["atendimento_bo_desc"] ?>" id="">
                </p>
                <h3>Descrição de Materiais ou Armas Apreendidos (Recolhidos)</h3>
                <div class="area">
                    <textarea name="material_apreendido" id="bo" rows="5" placeholder="Relato dos materiais e armas apreendidos"><?php if (isset($_POST["material_apreendido"])) echo $_POST["material_apreendido"] ?></textarea>
                </div>
                <h3>Utilização de Algemas <span class="false"> * </span></h3>
                <p class="form">
                    <div class="form">
                        <input type="radio" name="algema" id="algsim" value="Sim" <?php if (isset($_POST["algema"]) && $_POST["algema"] == "Sim") echo "checked"?>>
                        <label for="algsim" style="font-size: 26px;">Sim</label>
                    </div>
                    <div class="form">
                        <input type="radio" name="algema" id="algnao" value="Não" <?php if (isset($_POST["algema"]) && $_POST["algema"] == "Não") echo "checked"?>>
                        <label for="algnao" style="font-size: 26px;">Não</label>
                    </div>
                </p>
                <p class="form">
                    <h3>Justificar:</h3>
                    <div class="area">
                        <textarea name="justificar_algema" id="bo" rows="5" placeholder="Súmula Vinculante 11"><?php if (isset($_POST["justificar_algema"])) echo $_POST["justificar_algema"] ?></textarea>
                    </div>
                </p>
                <h3>Histórico da Ocorrência <span class="false"> * </span></h3>
                <p class="form">
                    <div class="area">
                        <textarea name="historico_bo" id="bo" rows="10" placeholder="Relato da ocorrência..."><?php if (isset($_POST["historico_bo"])) echo $_POST["historico_bo"] ?></textarea>
                    </div>
                </p>
                <h3>Integridade Física do Apresentado <span class="false"> * </span></h3>
                <p class="form">
                    <div class="form">
                        <input type="radio" name="integridade_fisica" id="semlesao" value="Sem lesão" <?php if (isset($_POST["integridade_fisica"]) && $_POST["integridade_fisica"] == "Sem lesão") echo "checked"?>>
                        <label for="semlesao" style="font-size: 26px;">Sem Lesão</label>
                    </div>
                    <div class="form">
                        <input type="radio" name="integridade_fisica" id="comlesao" value="Com lesão" <?php if (isset($_POST["integridade_fisica"]) && $_POST["integridade_fisica"] == "Com lesão") echo "checked"?>>
                        <label for="comlesao" style="font-size: 26px;">Com Lesão</label>
                    </div>
                </p>
                <p class="form">
                    <div class="area">
                        <textarea name="descricao_integridade_fisica" id="bo" rows="5" placeholder="Descrição ou observação sobre a integridade física do apresentado."><?php if (isset($_POST["descricao_integridade_fisica"])) echo $_POST["descricao_integridade_fisica"] ?></textarea>
                    </div>
                </p>
                <h3>Dados do Relator <span class="false"> * </span></h3>
                <p class="form">
                    <div class="form">
                        <select name="fk_relator_bo" id="">
                            <option value="">
                            </option>
                            <?php include("connection.php");

                                $sqlCode = "SELECT id, ranking, nome, mat, cargo
                                FROM agentes ORDER BY nome";

                                $search = $mysqli->query($sqlCode) or die();

                                while ($relator = $search->fetch_assoc()){
                                    ?>

                                        <option value="<?php echo $relator["id"] ?>" <?php if (isset($_POST["fk_relator_bo"]) && $relator["id"] == $_POST["fk_relator_bo"]) echo "selected"?>><?php echo ucwords($relator["nome"])?></option>

                                    <?php
                                }
                            
                            ?>
                        </select>
                    </div>
                </p>
                <h3>Dados da Autoridade Policial <span class="false"> * </span></h3>
                <p class="form">
                    <div class="form">
                        <label for="autoridade_policial"><strong>Nome:</strong></label>
                        <input type="text" placeholder="" name="autoridade_policial" id="autoridade_policial" value="<?php if (isset($_POST["autoridade_policial"])) echo ucwords($_POST["autoridade_policial"]) ?>"><span class="false"> * </span>
                    </div>
                </p>
                <p class="form">
                    <div class="form">
                        <label for="funcao_autoridade"><strong>Função:</strong></label>
                        <input type="text" placeholder="" name="funcao_autoridade_policial" id="funcao_autoridade" value="<?php if (isset($_POST["funcao_autoridade_policial"])) echo $_POST["funcao_autoridade_policial"] ?>"><span class="false"> * </span>
                    </div>
                </p>
                <p class="form">
                    <div class="form">
                        <label for="matricula_autoridade"><strong>Matrícula:</strong></label>
                        <input type="text" placeholder="" name="matricula_autoridade_policial" id="matricula_autoridade_policial" value="<?php if (isset($_POST["matricula_autoridade_policial"])) echo $_POST["matricula_autoridade_policial"] ?>">
                    </div>
                </p>
                <h3>Dossiê</h3>
                <p class="form">
                    <div class="form">
                        <label for="dossie_bo"><strong>Adicionar anexo ao documento:</strong></label><br>
                        <input type="file" name="dossie_bo" id="dossie_bo">
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