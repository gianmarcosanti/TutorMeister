<?php
	
require_once 'conf.php';

$mail = register('mail');
$pass = register('password');

$query_user = "select * from utente where email_utente = '".$mail."'
";

$isPresent = select($query_user);
var_dump($isPresent);
echo $mail;
echo $pass;

if(count($isPresent)>0){
    if(password_verify($pass, $isPresent[0]['password'])){
        $_SESSION['ID'] = $mail;
        if ($isPresent[0]['is_tutor'] == 1) {
            $_SESSION['TYPE'] = "tutor";
            $_SESSION['error']= "none";
        }else{
            $_SESSION['TYPE'] = "studente";
            $_SESSION['error']= "none";
        }
    }else{
        $_SESSION['error']= "password";
        redirect('login.php');
    }
}else{
    $_SESSION['error'] = "mail";
    redirect('login.php');
}

if($_SESSION['TYPE'] == "tutor"){
    redirect('personal-area-tutor-settings.php');
}else if($_SESSION['TYPE'] == "studente") {
    redirect('personal-area-studente-settings.php');
}
?>