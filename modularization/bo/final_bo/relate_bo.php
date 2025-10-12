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
        <p>Relaciona os Autores com a ocorrência, assim que todos forem vinculados, click no botão abaixo "Finalizar B.O"</p>
    </section>
</div>               
</div>
