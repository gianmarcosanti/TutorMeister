<?php
require_once 'conf.php';
var_dump($_REQUEST);

$mail_= register('mail1');
$mail2 = register('mail2');
$password_= password_hash(register('password1'),PASSWORD_DEFAULT);
$nome_= register('nome');
$cognome_= register('cognome');
$dataNas_= date("Y-m-d", strtotime('data-nascita'));
$telefono_= register('telefono');
$via_ = register('via');
$comune_ = register('ASCity');
$cap_ = register('cap');
$uni_ = register('ACUni');
$corso_ = register('ACCorso_di_laurea');
$annoIsc_ = register('annoisc');
$matricola_ = register('matricola');

//cotrollo se l'utente e' gia registrato
$sql= "select * from utente where utente.email_utente = '".$mail_."'";
$res = select($sql);
if(count($res)>0){
	$_SESSION['error'] = 'mail';
	redirect('sign-up-alunno.php');
}


preg_match('/(.*)-/', $corso_, $corso_);
$corso_= trim($corso_[1]);

$query_comune = "select comune.id_comune from comune where  comune.nome = '".$comune_."'";
$res_comune = select($query_comune);
$comune_ = $res_comune[0]['id_comune'];


$query = "
        INSERT INTO utente (email_utente, password, nome, cognome, data_nascita, telefono, fk_comune , cap, via, is_tutor) 
        VALUES ('" . $mail_ . "', '" . $password_ . "', '" . $nome_ . "', '" . $cognome_ . "',' " . $dataNas_ . "', " . $telefono_ . ", '" . $comune_ . "', " . $cap_ . ", '" . $via_ . "', 0); 
    ";

query($query);

$query = "
    INSERT INTO studente (email_studente_utente, anno_iscrizione, matricola, fk_corso_laurea) 
    VALUES ('" . $mail_ . "', " . $annoIsc_ . ", " . $matricola_ . ", '" . $corso_ . "');
";

query($query);

$_SESSION['ID']= $mail_;
$_SESSION['TYPE']= 'studente';

redirect('index.php');
?>
