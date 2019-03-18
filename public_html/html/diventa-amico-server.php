<?php
include_once 'conf.php';
if(isset($_REQUEST['tid'])){
    query("Insert into allievo(email_studente, email_tutor) VALUES ('".$_SESSION['ID']."','".$_REQUEST['tid']."')");
}

redirect($_SERVER['HTTP_REFERER']);