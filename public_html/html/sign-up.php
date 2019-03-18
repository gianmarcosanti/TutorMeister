<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
    <?php
        include_once 'conf.php';
        include_once 'injector.php';

        if(isset($_SESSION['TYPE'])){
            if($_SESSION['TYPE']== 'tutor')
                redirect('personal-area-tutor-profile.php');
            else
                redirect('personal-area-studente-profile.php');
        }
    ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Registrati a TutorMeister come alunno o come tutor.">
    <meta name="author" content="Gianmarco Santi">
    <meta name="author" content="Nicolò Tartaggia">
    <meta name="author" content="Andrea Trevisin">
    <meta name="author" content="Ciprian Voinea">

    <title>Registrati a TutorMeister</title>
<link rel="shortcut icon" type="image/png" href="../images/favicon.png" />
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="../css/print_style.css" rel="stylesheet" type="text/css" media="print">
    <script type = "text/javascript" src="../js/functions.js"></script> 
</head>
    
<body>

<?php injectNavbar("signup");?>
    <div class = "signup-btn-container">
        <a id="signup-btn-alunno" href="sign-up-alunno.php">
            <div>
                <div id="alunno-icon"></div>
                <h1>REGISTRATI COME ALUNNO</h1>
                <p>Trova un tutor che ti aiuti a superare gli esami pi&ugrave; difficili!</p>          
            </div>
        </a>
        <a id="signup-btn-tutor" href="sign-up-tutor.php">
            <div>
                <div id = "tutor-icon"></div>
                <h1>REGISTRATI COME TUTOR</h1>
                <p>Guadagna dando lezioni e costruisciti una reputazione!</p>
            </div>
        </a>
    </div>
<?php injectFooter();?>

</body>