<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php include_once 'conf.php';?>
<?php include_once 'injector.php';?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Esegui una ricerca avanzata per trovare il tutor più adatto alle tue esigenze.">
    <meta name="author" content="Gianmarco Santi">
    <meta name="author" content="Nicolò Tartaggia">
    <meta name="author" content="Andrea Trevisin">
    <meta name="author" content="Ciprian Voinea">

    <title>Ricerca avanzata</title>
    <link rel="shortcut icon" type="image/png" href="../images/favicon.png" />
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="../css/print_style.css" rel="stylesheet" type="text/css" media="print">

    <!-- STELLINE RATING -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
</head>

    <body class="text-center" >
    <?php injectNavbar("ricerca");?>
    <main>
        <div class="maincontainer">
            <div id="main-container">
                <div id="AS-form" class="filter-form">
                    <form id="Advanced-search-form" class="" method="post" autocomplete="off">
                        <h1>Trova subito un tutor</h1>
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
    
                        <div id="AS-price-range">
                            <p><label for="max-price" aria-label="tariffa orario massima">Tariffa oraria massima: <span id= "tariffa"> 50 € l'ora</span></label></p>
                            <input type="range" min="0" max="100" value="50" class="slider" name="price-range" id="max-price" oninput="showPrice(this.value)">
                        </div>
                        <br/>
                        <div class = "centered-wrapper">
                        <div id="rating-container">
                            <span id="star-rating" aria-label="Valutazione" tabindex="0">Valutazione:</span>
                            <div class="rating">
                                    <input type="radio" name="star" id="star-5" value="5" onclick="minRatingChoosed(this.id)"/>
                                    <label for="star-5" title="Fantastico, il migliore" aria-label="Fantastico, il migliore" onclick="minRatingChoosed('star-5')" onkeypress="this.click()" tabindex=0>Fantastico, il migliore</label>
                                    <input type="radio" name="star" id="star-4" value="4" onclick="minRatingChoosed(this.id)" />
                                    <label for="star-4" title="Ottimo tutor" aria-label="Ottimo tutor" onclick="minRatingChoosed('star-4')" onkeypress="this.click()" tabindex=0>Ottimo tutor</label>
                                    <input type="radio" name="star" id="star-3" value="3" onclick="minRatingChoosed(this.id)" />
                                    <label for="star-3" title="Livello buono" aria-label="Livello buono" onclick="minRatingChoosed('star-3')" onkeypress="this.click()" tabindex=0>Livello buono</label>
                                    <input type="radio" name="star" id="star-2" value="2" onclick="minRatingChoosed(this.id)" />
                                    <label for="star-2" title="Non il migliore" aria-label="Non il migliore" onclick="minRatingChoosed('star-2')" onkeypress="this.click()" tabindex=0>Non il migliore</label>
                                    <input type="radio" name="star" id="star-1" value="1" onclick="minRatingChoosed(this.id)" />
                                    <label for="star-1" title="Pessimo" aria-label="Pessimo" onclick="minRatingChoosed('star-1')" onkeypress="this.click()" tabindex=0>Pessimo</label>
                            </div>
                        </div>
                        </div>
                        <br/>
                        <div class="AS-type-fields">
                            <label class="checkbox-container" for="inputTipoACT" aria-label="lezioni a casa tua">Lezioni a casa tua
                                <input id="inputTipoACT" class="QSInput" name="ASAct" type="checkbox" />
                                <span class="checkmark"></span>
                            </label>
                            <label class="checkbox-container" for="inputTipoACS" aria-label="Lezione a casa sua">Lezione a casa sua
                                <input id="inputTipoACS" class="QSInput" name="ASAcs" type="checkbox" />
                                <span class="checkmark"></span>
                            </label>
                            <label class="checkbox-container" for="inputTipoWC" aria-label="Lezione via webcam">Lezione via webcam
                                <input id="inputTipoWC" class="QSInput" name="ASWc" type="checkbox" />
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <button class="find-button" type="submit" name="trova" aria-label="trova">Trova</button>
                    </form>
                </div>
                <div id="AS-results" class="results-list">
                    <div class="result-allfather">
                        <!--Cut&paste from AS_prova_form-->
                        <?php
                        if (isset($_POST['trova'])) {
                            getResults();
                        }
                        if (isset($_POST['trova-quick-search'])) {
                            getResultsFromQuickSearch();
                        }
                        ?>
                    </div>
               </div>
            </div>
        </div>
    </main>
    <?php injectFooter();?>
    <script type = "text/javascript" src="../js/functions.js"></script>
    </body>
</html>
