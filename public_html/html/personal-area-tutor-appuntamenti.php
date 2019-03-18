<?php
include_once 'conf.php';
include_once 'injector.php';

if($_SESSION['TYPE']!='tutor'){
    redirect('access_denied.html');
}
?>
<!doctype html>
<html lang="it">
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
    <div class="profile-container">
        <?php
            if(isset($_SESSION['ID']))
                build_area_privata_tutor_appuntamenti();
        ?>
    </div>
</div>
<?php injectFooter() ?>
<script type="text/javascript" src="../js/functions.js"></script>
</body>
</html>
