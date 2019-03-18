<?php
	require_once 'conf.php';

	$mail_= register('mail1');
    $mail2 = register('mail2');
    $password_= password_hash(register('password1'),PASSWORD_DEFAULT);
	$nome_= register('nome');
	$cognome_= register('cognome');
	$dataNas_= date("Y-m-d", strtotime(register('data-nascita')));
	$telefono_= register('telefono');
	$via_= register('via');
	$comune_= register('ASCity');
	$cap_= register('cap');
	$laurea_= register('ACCorso_di_laurea');
	$ACUni= register('ACUni');
	$abbonamento_= register('sel-abbonamento');


	//cotrollo se l'utente e' gia registrato
	$sql= "select * from utente where utente.email_utente = '".$mail_."'";
	$res = select($sql);
	if(count($res)>0){
		$_SESSION['error'] = 'mail';
		redirect('sign-up-tutor.php');
	}
	
	preg_match('/(.*)-/', $laurea_, $laurea_);
	$laurea_= trim($laurea_[1]);

	$query_comune = "select comune.id_comune from comune where  comune.nome = '".$comune_."'";
	$res_comune = select($query_comune);
	$comune_ = $res_comune[0]['id_comune'];

	$query = "
		INSERT INTO utente (email_utente, password, nome, cognome, data_nascita, telefono, fk_comune , cap, via, is_tutor) 
		VALUES ('" . $mail_ . "', '" . $password_ . "', '" . $nome_ . "', '" . $cognome_ . "', '" . $dataNas_ . "', '" . $telefono_ . "', '" . $comune_ . "', '" . $cap_ . "', '" . $via_ . "', 1);
	";

	query($query);

	$query = "
		INSERT INTO tutor (email_tutor_utente, fk_corso_laurea, fk_abbonamento)
		VALUES ('" . $mail_ . "','" . $laurea_ . "', '" . $abbonamento_ . "'); 
	";

	query($query);

    $_SESSION['ID']= $mail_;
	$_SESSION['TYPE']= 'tutor';

	redirect('index.php');

?>

