<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php include_once 'conf.php'; ?>
<?php include_once 'injector.php';?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Esegui il login a TutorMeister con le tue credenziali per accedere alla tua area privata.">
    <meta name="author" content="Gianmarco Santi">
    <meta name="author" content="Nicolò Tartaggia">
    <meta name="author" content="Andrea Trevisin">
    <meta name="author" content="Ciprian Voinea">

    <title>Accedi a TutorMeister</title>
    <link rel="shortcut icon" type="image/png" href="../images/favicon.png" />
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="../css/print_style.css" rel="stylesheet" type="text/css" media="print">

</head>
    
<body>
<?php injectNavbar("login");?>

    <div class="maincontainer">
        <form id="Login-form" method="post" action="login-server.php" autocomplete="off">
            <h1>BENVENUTO!</h1>
            <h2>Registrati per avere accesso al mondo di TutorMeister</h2>
            <div class="Login-field">
                <label class = "hidden" aria-label = "e-mail" for="input-username">E-mail</label>
                <input id="input-username" class="QSInput" name="mail" type="text" required/> 
                <span class= "fake-label">E-mail</span>
            </div> 
            <div class="Login-field">
                <label class = "hidden" aria-label = "password" for="input-password">Password</label>
                <input id="input-password" class="QSInput" name="password" type="password" required/>
                <span class= "fake-label">Password</span>
            </div> 
            <button type="submit" aria-label="accedi" class="Login-button">Accedi</button>
            <span>oppure</span>
            <a class="" href="sign-up.php">Sei nuovo? Registrati!</a>
        </form>
    </div>
<?php
    injectFooter();
    if(isset($_SESSION['error'])){
        if($_SESSION['error'] == "password"){
            echo "<script>alert('Password errata!'); </script>";
            $_SESSION['error'] = 'none';
        }else if($_SESSION['error'] == "mail"){
            echo "<script>alert('Email errata!'); </script>";
            $_SESSION['error'] = 'none';
        }
    }
?>

    <script type = "text/javascript" src="../js/functions.js"></script> 
</body>
