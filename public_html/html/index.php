<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php include_once 'conf.php'; ?>
<?php include_once 'injector.php'; ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Pagina principale di TutorMeister. Diventa un nostro alunno e trova i tutor migliori,
    oppure diventa tutor abbonandoti ad uno dei nostri piani tariffari.">
    <meta name="author" content="Gianmarco Santi">
    <meta name="author" content="Nicolò Tartaggia">
    <meta name="author" content="Andrea Trevisin">
    <meta name="author" content="Ciprian Voinea">

    <title>TutorMeister</title>
    <link rel="shortcut icon" type="image/png" href="../images/favicon.png" />
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="../css/print_style.css" rel="stylesheet" type="text/css" media="print">
</head>

<body>

<?php injectNavbar('index') ?>

<div id="bgimg-1">
    <div class="caption">
        <form id="Quick-search-form" action="ricerca_avanzata.php" method="post" autocomplete="off">
            <h1>Trova subito un tutor.</h1>
            <div class="research-field">
                <label for="input-ASSubject" class = "hidden" aria-label="materia">Materia</label>
                <input id="input-ASSubject" class="QSInput" name="ASSubject" type="text" onkeyup="showHintLogin(this.value, this.name)" required/>
                <span class = "fake-label">Materia</span>
                <span id="esempio">Esempio: "Tecnologie web - Informatica", "Matematica"</span>
            </div>
            <div id="research-outputs-ASSubject" class="">
            </div>
            <div class="research-field">
                <label for="input-ASCity" class = "hidden" aria-label="città">Citt&agrave;</label>
                <input id="input-ASCity" class="QSInput" name="ASCity" type="text" onkeyup="showHintLogin(this.value, this.name)" required/>
                <span class = "fake-label">Citt&agrave;</span>
            </div>
            <div id="research-outputs-ASCity" class="research-outputs">
            </div>
            <button aria-label="trova" name="trova-quick-search" class="find-button">Trova</button>
            <span>oppure</span>
            <a href="ricerca_avanzata.php">Esegui ricerca avanzata</a>
        </form>
    </div>


    <div class="text-container">
        <div class="big-phrase"><span>Trova il tutor perfetto, è gratis!</span></div>
    </div>
    <div id="oppure"><span>oppure</span></div>
    <div class="text-container">
        <div class="big-phrase"><span>Unisciti a noi e inizia a guadagnare!</span></div>
    </div>

    <div id="account-options" tabindex="0">
        <div class="subscription-type">
            <span>Abbonamento mensile</span>
            <span class="price">10€</span>
        </div>
        <div class="subscription-type center">
            <span>Abbonamento semestrale</span>
            <span class="price">50€</span>
        </div>
        <div class="subscription-type">
            <span>Abbonamento annuale</span>
            <span class="price">90€</span>
        </div>
    </div>
</div>     

<?php injectFooter() ?>
<script type="text/javascript" src="../js/functions.js"></script>
</body>
</html>