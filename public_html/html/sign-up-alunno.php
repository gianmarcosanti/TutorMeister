<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php include_once 'conf.php'; ?>
<?php include_once 'injector.php';?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Diventa uno studente e trova il tutor che fa per te">
    <meta name="author" content="Gianmarco Santi">
    <meta name="author" content="Nicolò Tartaggia">
    <meta name="author" content="Andrea Trevisin">
    <meta name="author" content="Ciprian Voinea">

    <title>Registrati come alunno</title>
<link rel="shortcut icon" type="image/png" href="../images/favicon.png" />
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <link href="../css/print_style.css" rel="stylesheet" type="text/css" media="print">
    <script type = "text/javascript" src="../js/functions.js"></script> 
</head>
    
<body>

<?php injectNavbar("signup");?>

    <div id="container-sign-up">
        <form id="Signup-form" action="sign-up-alunno-server.php" method="post" autocomplete="off">
            <h1>BENVENUTO!</h1>
            <h2>Registrati per avere accesso al mondo di TutorMeister</h2>
            <div id="credential-form-container">
                <div id="progress-bar-container">
                    <ol class = "progress-bar" role="progressbar" tabindex="0" aria-valuemin="1" aria-valuemax="4" aria-valuenow="1">
                        <li class = "active-step">Account</li>
                        <li>Generalità</li>
                        <li>Recapito</li>
                        <li>Corso di studi</li>
                    </ol>
                </div>
                <div id = "info-container">
                    <fieldset class="form-page">
                        <legend class="signup-group-legend">Credenziali</legend>
                        <div id= "info-profilo" class="form-group  active-group">
                            <div class="Signup-field">
                                <label for="input-mail-1" class = "hidden" aria-label="indirizzo e-mail">Indirizzo e-mail</label>
                                <input id="input-mail-1" class="QSInput" name="mail1" type="email" onblur="stayUp(this)" required/>
                                <span class = "fake-label">Indirizzo e-mail</span>
                            </div>
                            <div class="Signup-field">
                                <label for="input-mail-2" class = "hidden" aria-label="conferma e-mail">Conferma e-mail</label>
                                <input id="input-mail-2" class="QSInput" name="mail2" type="email" onblur="stayUp(this); checkMail(this);" required/>
                                <span class = "fake-label">Conferma e-mail</span>
                            </div>
                            <div class="Signup-field">
                                <label for="input-password" class = "hidden" aria-label="password">Password</label>
                                <input id="input-password" class="QSInput" name="password1" type="password" onblur="stayUp(this)" aria-describedby="pwd-exp" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" required/>
                                <span class = "fake-label">Password</span>
                                <span id="pwd-exp">La password deve essere composta da almeno 1 lettera maiuscola, 1 lettera minuscola e 1 numero</span>
                            </div>
                            <div class="CBInput">
                                <label for="show-password" class="CBLabel" aria-label="mostra password"><span>Mostra password:</span><input id="show-password" name="password2" type="checkbox" onclick="showPsw()" tabindex="0"/></label>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-page">
                        <legend  class="signup-group-legend">Generalità</legend>
                        <div id= "info-personali" class="form-group">
                            <div class="Signup-field">
                                <label for="input-nome" class = "hidden" aria-label="nome">Nome</label>
                                <input id="input-nome" class="QSInput" name="nome" type="text" onblur="stayUp(this)" required/>
                                <span class = "fake-label">Nome</span>
                            </div>

                            <div class="Signup-field">
                                <label for="input-cognome" class = "hidden" aria-label="cognome">Cognome</label>
                                <input id="input-cognome" class="QSInput" name="cognome" type="text" onblur="stayUp(this)" required/>
                                <span class = "fake-label">Cognome</span>
                            </div>

                            <div class="Signup-field">
                                <label for="input-data-nascita" class = "hidden" aria-label="data di nascita">Data di nascita</label>
                                <input id="input-data-nascita" class="QSInput" name="data-nascita" onblur="stayUp(this)" type="text"
                                       pattern="\d{1,2}/\d{1,2}/\d{4}" aria-describedby = "birthdate-exp" required/>
                                <span class = "fake-label">Data di nascita</span>
                                <span id="birthdate-exp">Formato richiesto: gg/mm/aaaa</span>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-page">
                        <legend  class="signup-group-legend">Recapito</legend>
                        <div id="info-recapito" class="form-group">
                            <div class="Signup-field">
                                <label for="input-telefono" class = "hidden" aria-label="telefono">Telefono</label>
                                <input id="input-telefono" class="QSInput" name="telefono" onblur="stayUp(this)" type="tel"
                                       pattern="[0-9]{10}" required/>
                                 <span class = "fake-label">Telefono</span>
                            </div>
                            <div class="Signup-field">
                                <label for="input-ASCity" class = "hidden" aria-label="città">Citt&agrave;</label>
                                <input id="input-ASCity" class="QSInput" name="ASCity" type="text" onkeyup="showHintLogin(this.value, this.name)" required/>
                                <span class = "fake-label">Citt&agrave;</span>
                            </div>
                            <div id="research-outputs-ASCity" class="research-outputs"></div>
                            <div class="Signup-field">
                                <label for="input-cap" class = "hidden" aria-label="codice avviamento postale">CAP</label>
                                <input id="input-cap" class="QSInput" name="cap" type="text" onblur="stayUp(this)" pattern="[0-9]{5}" required/>
                                <span class = "fake-label">CAP</span>
                            </div>

                            <div class="Signup-field">
                                <label for="input-via" class = "hidden" aria-label="via">Via</label>
                                <input id="input-via" class="QSInput" name="via" type="text"  onblur="stayUp(this)" required/>
                                <span class = "fake-label">Via</span>
                                <span id="esempio">e.g. Via Savonarola, 80</span>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-page">
                        <legend  class="signup-group-legend">Corso di studi</legend>
                        <div id="info-alunno" class="form-group">
                            <div class="Signup-field"> 
                                <label for="input-ACUni" class = "hidden" aria-label="universita">Universit&agrave;</label> 
                                <input id="input-ACUni" class="QSInput" name="ACUni"  onblur="stayUp(this)" type="text" onkeyup="showHintLogin(this.value, this.name)" required/>
                                <span class = "fake-label">Universit&agrave;</span>
                            </div>
                            <div id="research-outputs-ACUni" class=""></div>
                            <div class="Signup-field"> 
                                <label for="input-ACCorso_di_laurea" class = "hidden" aria-label="corso di laurea">Corso di laurea</label>
                                <input id="input-ACCorso_di_laurea" class="QSInput" name="ACCorso_di_laurea" onblur="stayUp(this)"  type="text" onkeyup="showHintCompetenza(this.value, this.name,'input-ACUni')" required/> 
                                <span class = "fake-label">Corso di laurea</span>
                            </div>
                            <div id="research-outputs-ACCorso_di_laurea" class=""></div>
                            <div class="Signup-field"> 
                                <label for = "input-anno-iscrizione" class = "hidden" aria-label = "anno di iscrizione">Anno di iscrizione</label>
                                <input id="input-anno-iscrizione" class="QSInput" name="annoisc" type="number" onblur="stayUp(this)" min="1900" max="2099" step="1" required/>
                                <span class = "fake-label">Anno di iscrizione</span>
                            </div>
                            <div class="Signup-field"> 
                                <label for = "input-matricola" class = "hidden" aria-label = "matricola">Matricola</label> 
                                <input id="input-matricola" class="QSInput" name="matricola" type="number" onblur="stayUp(this)" required/> 
                                <span class = "fake-label">Matricola</span>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <button type = "button" class = "form-button" id="go-back" onclick="moveForm(-1)">Indietro</button>
            <button type = "button" class = "form-button" id="go-fwd" onclick="moveForm(1)">Avanti</button>
            <button type = "submit" class = "form-button" id="go-sub">Conferma</button>
        </form> 
    </div>
<?php 
injectFooter();
    if(isset($_SESSION['error'])){
        if($_SESSION['error'] == "mail"){
            echo "<script>alert('Utente gia' registrato!'); </script>";
            $_SESSION['error'] = 'none';
        }
    }
?>

</body>
