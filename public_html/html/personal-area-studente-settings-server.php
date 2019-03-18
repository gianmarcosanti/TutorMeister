<?php

include_once 'conf.php';

$short_bio = register('short_bio');
$tel = register('modifica_telefono');
$mail = register('mail');
$info = register('textarea-info');


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
        mkdir($target_dir, 0777, true);
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

query($query);

$query = "
   UPDATE studente
    SET descrizione = '".$info."'
    WHERE studente.email_studente_utente ='".$_SESSION['ID']."'; 
";
echo  $query;

query($query);
redirect("personal-area-studente-profile.php");

