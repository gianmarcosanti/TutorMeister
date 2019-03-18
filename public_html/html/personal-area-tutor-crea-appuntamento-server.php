<?php
include_once 'conf.php';

$CAStudente = register('CAStudente');
$CAMateria = register('CAMateria');
$CAData = date("Y-m-d", strtotime(register('CAData')));
$CAInizio = register('CAInizio');
$CADurata= register('CADurata');
$gruppo_luogo = register('gruppo-luogo');
$gruppo_metodo = register('gruppo-metodo');

$id_corso  = explode('-', $CAMateria)[0]; //TROVARE COMPETENZA CORSO NON ID CORSO DC
preg_match('/\((.*)\)/', $CAStudente, $id_studente)[1];

$select_competenza ="
    select id_competenza_corso 
    from tutor, competenza_corso, corso_studio
    where fk_corso_studio = id_corso_studio
    and tutor.email_tutor_utente = '".$_SESSION['ID']."'
    and id_corso_studio = '".$id_corso."'
";

echo $select_competenza;
$res = select($select_competenza);

$query_inserimento ="
    insert into appuntamento(email_tutor, email_studente, fk_competenza_corso ,data,ora_inizio,durata,tipo,location) 
    values ('".$_SESSION['ID']."','".$id_studente[1]."','".$res[0]['id_competenza_corso']."','".$CAData."','".$CAInizio."','".$CADurata."','".$gruppo_metodo."','".$gruppo_luogo."')
";

echo $query_inserimento;

query($query_inserimento);

redirect("personal-area-tutor-appuntamenti.php");


