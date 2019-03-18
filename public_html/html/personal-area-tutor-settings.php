<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php
    include_once 'conf.php';
    include_once 'injector.php';

    if($_SESSION['TYPE']!='tutor'){
        redirect('access_denied.html');
    }
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Gestisci le tue informazioni per farti conoscere al mondo di TutorMeister">
    <meta name="author" content="Gianmarco Santi">
    <meta name="author" content="Nicolò Tartaggia">
    <meta name="author" content="Andrea Trevisin">
    <meta name="author" content="Ciprian Voinea">

    <title>Impostazioni di profilo</title>
<link rel="shortcut icon" type="image/png" href="../images/favicon.png" />
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="../css/print_style.css" rel="stylesheet" type="text/css" media="print">
</head>

<body>
<?php injectNavbar('area p') ?>

<div class="parallax-img2"></div>
<div id="global-container">
    <div class="profile-container">
        <?php
        if(isset($_SESSION['ID']))
            build_area_privata_tutor_settings();
        ?>
    </div>
</div>
<?php injectFooter() ?>
<script type="text/javascript" src="../js/functions.js"></script>
</body>
</html>