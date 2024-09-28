<?php 

function sendFile($error, $size, $name, $tmp_name){

    if ($error){
        die("Falha ao enviar arquivo");
    }

    if ($size > 2097152){
        die("Arquivo muito grande. Máximo permitido: 2 MB");
    }

    $folder = "photos/";
    $fileName = $name;
    $newFilmeName = uniqid();
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    if ($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
        die("Tipo de arquivo não aceito, tente arquivos do tipo JPG ou PNG");

    }

    $path = $folder . $newFilmeName . "." . $extension;
    $ok = move_uploaded_file($tmp_name, $path);

    if ($ok){
        return $path;

    }else {
        return false;
    }
}

function sendDoc($error, $size, $name, $tmp_name){

    if ($error){
        die("Falha ao enviar arquivo");
    }

    if ($size > 2097152){
        die("Arquivo muito grande. Máximo permitido: 2 MB");
    }

    $folder = "photos/";
    $fileName = $name;
    $newFilmeName = uniqid();
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    if ($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
        die("Tipo de arquivo não aceito, tente arquivos do tipo JPG ou PNG");

    }

    $path = $folder . $newFilmeName . "." . $extension;
    $ok = move_uploaded_file($tmp_name, $path);

    if ($ok){
        return $path;

    }else {
        return false;
    }
}

?>