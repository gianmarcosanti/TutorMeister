<?php
include_once 'conf.php';

$cid = register('cid');

$sql= "
    delete from competenza_corso where id_competenza_corso = '".$cid."'
";

query($sql);

redirect($_SERVER['HTTP_REFERER']);

