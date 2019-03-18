<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php include_once 'conf.php'; ?>
<?php include_once 'injector.php'; ?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Scrivi una recensione per fare sapere ciò che pensi di questo tutor">
    <meta name="author" content="Gianmarco Santi">
    <meta name="author" content="Nicolò Tartaggia">
    <meta name="author" content="Andrea Trevisin">
    <meta name="author" content="Ciprian Voinea">

    <title>Scrivi una recensione</title>
<link rel="shortcut icon" type="image/png" href="../images/favicon.png" />
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="../css/print_style.css" rel="stylesheet" type="text/css" media="print">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
<?php injectNavbar('Area privata') ?>

<div class="parallax-img2"></div>
<div id="global-container">
    <div class="profile-container">
        <?php
            if(isset($_SESSION['ID']) and isset($_REQUEST['tid']))
                build_studente_scrivi_recensione($_REQUEST['tid']);
        ?>
    </div>
</div>
<?php injectFooter() ?>
<script type="text/javascript" src="../js/functions.js"></script> 
</body>
</html>