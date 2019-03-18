<?php

include_once 'conf.php';
var_dump($_POST);
$ACCorso_di_studio = register('ACCorso_di_studio');
$ACTariffa = register('ACTariffa');
$ACDescrizione = register('ACDescrizione');

$id_corso = $parts = explode('-', $ACCorso_di_studio);

$query_inserimento = "
    insert into  competenza_corso(tariffa, descrizione, email_tutor, fk_corso_studio) 
    values ('".$ACTariffa."','".$ACDescrizione."','".$_SESSION['ID']."','".$id_corso[0]."')
";

echo $query_inserimento;
query($query_inserimento);

redirect('personal-area-tutor-profile.php');