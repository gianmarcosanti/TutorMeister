<?php
include_once 'conf.php';

var_dump($_POST);
var_dump($_FILES);


$visita = register('gruppo-visita');
if($visita == "si"){
    $visita = 1;
}else{
    $visita = 0;
}
$ospita = register('gruppo-ospita');
if($ospita == "si"){
    $ospita = 1;
}else{
    $ospita = 0;
}
$webcam = register('gruppo-webcam');
if($webcam == "si"){
    $webcam = 1;
}else{
    $webcam = 0;
}
$concordato = register('gruppo-concordato');
if($concordato == "si"){
    $concordato = 1;
}else{
    $concordato = 0;
}
$privato = register('gruppo-privato');
if($privato == "si"){
    $privato = 1;
}else{
    $privato = 0;
}
$gruppo = register('gruppo-gruppo');
if($gruppo == "si"){
    $gruppo = 1;
}else{
    $gruppo = 0;
}
$short_bio = register('short_bio');
$tel = register('modifica_telefono');
$mail = register('mail');
$info = register('textarea-info');
$metodo = register('textarea-metodo');

// SEZIONE IMMAGINE PROFILO
if($_FILES["upload-immagine-profilo"]['name']!="") {
    $target_dir = "../uploads/users/" . $_SESSION['ID'] . "/profile-pic/";
    $target_file = $target_dir . basename($_FILES["upload-immagine-profilo"]["name"]);
//echo $target_file;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    if (isset($_POST["settings-submit"])) {
        $check = getimagesize($_FILES["upload-immagine-profilo"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG & PNG files are allowed.";
        $uploadOk = 0;
    }
    if (file_exists($target_dir)) {
        echo "esiste";
    } else {
        echo "Costruisco la directory";
        if(!mkdir($target_dir, 0777, true)){
            $error = error_get_last();
            echo $error['message'];
        }
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["upload-immagine-profilo"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["upload-immagine-profilo"]["name"]) . " has been uploaded.";
            echo $target_dir;
            echo $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$query = "
   UPDATE utente
    SET  telefono = '".$tel."'";
if(isset($target_file))
    $query.=", path_immagine = '".$target_file."'";

$query.=",
    short_bio = '".$short_bio."'
    WHERE utente.email_utente ='".$_SESSION['ID']."';
";
echo $query;
query($query);

$query = "
   UPDATE tutor
    SET visita = ".$visita.",
        ospita = ".$ospita.",
        remoto = ".$webcam.",
        luogo_concordato = ".$concordato.",
        insegnante_privato = ".$privato.",
        lezioni_gruppo = ".$gruppo.",
        descrizione = '".$info."',
        metodo = '".$metodo."'
    WHERE tutor.email_tutor_utente ='".$_SESSION['ID']."';
";

query($query);
redirect("personal-area-tutor-profile.php");

