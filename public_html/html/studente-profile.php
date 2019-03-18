<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php include_once 'conf.php'; ?>
<?php include_once 'injector.php'; ?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Il tuo profilo</title>
<link rel="shortcut icon" type="image/png" href="../images/favicon.png" />
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
<?php injectNavbar('Area privata') ?>

<div class="parallax-img2"></div>
<div id="global-container">
    <?php
        if(isset($_SESSION['ID']) and isset($_REQUEST['sid']))
            build_area_privata_studente_profile_vetrina();
    ?>
</div>
<?php 
injectFooter();
?>
<script type="text/javascript" src="../js/functions.js"></script>
</body>
</html>
