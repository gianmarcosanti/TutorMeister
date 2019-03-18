<?php
    include_once 'conf.php';
    if(isset($_REQUEST['tid'])){
        query("delete from allievo where email_studente='".$_SESSION['ID']."' and email_tutor = '".$_REQUEST['tid']."'");
    }

    redirect($_SERVER['HTTP_REFERER']);
?>