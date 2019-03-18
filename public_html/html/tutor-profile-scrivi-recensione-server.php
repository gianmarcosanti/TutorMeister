<?php
include_once 'conf.php';

$SRValutazione = register('star');
$SRTesto = register('textarea-rec');
$tutor =  $_REQUEST['tid'];
$query_inserimento ="
    insert into recensione(valutazione, motivazione, email_studente, email_tutor) values (".$SRValutazione.",'".$SRTesto."','".$_SESSION['ID']."','".$tutor."')
";
echo $query_inserimento;

query($query_inserimento);

redirect('tutor-profile.php?tid='.$tutor);


