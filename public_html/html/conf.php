<?php

session_start();

header('Content-type: text/html; charset=utf-8');
define('redirect', true);

$servername = "localhost";
$username = "gisanti";
$password = "eith0Nainiejeing";
$dbname = "gisanti";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn)
	// Redirect to error page
    die("Connection failed: " . mysqli_connect_error());
//else
//	echo "connected!!";

//VERIAILI TEMPORANEE
$loremIpsum = "Lorem ipsum dolor sit amet, eam postea diceret eu. An reque eirmod democritum sed, meis electram maluisset no sed. Ne causae maiestatis sit. In vix dictas hendrerit, eu ius brute idque aperiri. Et magna nominavi persequeris nam, quo novum utroque voluptua in, eos id integre molestie. Vim ne repudiare aliquando, cu his appareat electram. Veniam audire eu nec, aeque theophrastus sit ex. Ad ius epicuri percipitur instructior. Solet causae ea est. Eam libris euismod id, ad causae iriure nec. Ad pro wisi errem, te vim modus doctus recteque. Pri id error saepe elaboraret, et quo postea euismod elaboraret. Illud laboramus nec te. In cum choro interesset, paulo accusamus ut has, consequat neglegentur mel et. Mel blandit scaevola ei. Ei vel melius insolens, ex eos assum nonumes iudicabit, quidam perfecto sit ut. Per malorum tincidunt et, ex persecuti deseruisse cum. Usu utroque facilisi scriptorem ei. Sed fastidii vulputate te, accumsan forensibus adipiscing quo ei. Te commodo adolescens omittantur usu. Appetere reprehendunt an per, discere legimus lobortis quo ne, cu unum solum oportere quo. Tincidunt maiestatis mei ex. Eum ea audiam diceret. Diam interesset no mel, elit antiopam ex usu. Ne labores argumentum cotidieque usu, vix utamur tibique ex, choro decore ponderum sit ne.";

// REGISTRAZIONE VARIABILI DA FORM
// registra una variabile nella pagina che richiama questa funzione, la variabile arriva da una form
// se non è registrata la imposta a vuota
function register($varname)
{
//    global $$varname;
    if (isset($_REQUEST[$varname])) {
        return addslashes(stripslashes($_REQUEST[$varname])); // previene SQL injection
    } else {
//        $$varname = null;
    	return null;
    }
}

//FUNZIONE SELECT, esegue una query di selezione e restituisce i risultati sotto forma di array
function select($sql)
{
    $res = query($sql);
    $table = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $table[] = $row;
    }
    return $table;
}

//FUNZIONE DI ESECUZIONE QUERY GENERICA
function query($sql)
{
    global $conn;
    if ($conn != null) {
        $res = mysqli_query($conn, $sql);
    }
    //Esegue la query sul db.
    if (!$res) {
        echo "Query fallita: ";
        echo mysqli_error($conn);
        die();
    }
    return $res;
}

//REINDIRIZZAMENTO
function redirect($url)
{
    if (redirect) {
        header('location: ' . $url);
    } else {
        echo "<a href='".$url."'> should go to ".$url." </a>";
    }
}

//REPERISCO INFORMAZIONI PER CREARE I BADGE
function getBadges($tid){
    $query_vip = "select count(email_studente) as tot
                    from allievo
                    where email_tutor= '".$tid."'";
    $res = select($query_vip);
    $badges = '';
    if($res[0]['tot']>10)
        $badges .='<img src="../images/profile_images/badges/091-star-18.svg" alt = "badge vip, tutor con più di 10 alunni">';
    else
        $badges .='<img class="inactive-badge" src="../images/profile_images/badges/091-star-18.svg" alt = "badge vip inattivo">';

    $query_hot = "
        select avg(recensione.valutazione) as media
        from recensione
        where email_tutor = '".$tid."'";

    $res = select($query_hot);
    if($res[0]['tot']>10)
        $badges .='<img src="../images/profile_images/badges/052-hot.svg" alt = "badge hot, tutor con ottime recensioni">';
    else
        $badges .='<img class="inactive-badge" src="../images/profile_images/badges/052-hot.svg" alt = "badge hot inattivo">';


    $query_new = "
        select utente.data_registrazione 
        from utente
        where email_utente = '".$tid."'";

    $res = select($query_new);

    $now = time();
    $your_date = strtotime($res[0]['data_registrazione']);
    $datediff = $now - $your_date;

    $diff = round($datediff / (60 * 60 * 24));
    if($diff <30)
        $badges .='<img src="../images/profile_images/badges/066-new.png" alt = "badge new, tutor iscritto da meno di 10 giorni">';
    else
        $badges .='<img class="inactive-badge" src="../images/profile_images/badges/066-new.png" alt = "badge new inattivo">';


    return $badges;
}

//CREAZIONE PAGINE PERSONALI STUDENTE
function build_area_privata_studente_profile(){

    $query = "
        SELECT *
        FROM studente, utente
        WHERE utente.email_utente = studente.email_studente_utente 
            AND utente.email_utente = '" . $_SESSION['ID'] . "';
    ";
    
    $res = select($query);

    $nome = $res[0]['nome']. " ".$res[0]['cognome'];
    $titolo = $res[0]['short_bio'];
    $informazioni = $res[0]['descrizione'];
    $telefono = $res[0]['telefono'];
    $path_immagine = $res[0]['path_immagine'];
    $mail = $_SESSION['ID'];
    

    echo ' 
   <div class="profile-container">
        <div class="profile-header">
            <div class="profile-picture">
                <div class="frame">
                    <img src="'.$path_immagine.'" alt = "Immagine profilo">
                </div>
            </div>
            <div class="info-container">
                <h1>'.$nome.'</h1>
                <h2><i>'.$titolo.'</i></h2>
            </div>
        </div>
        <div class="profile-body">
';
    injectStudentMenuPersonalArea('profilo');
    echo '
            <div class="info-container">
                <div id="other-info-container">
                    <div class="profile-additions">
                        <div class="single-add-container">
                            <div class="profile-additions-header">
                                <h1>Informazioni su '.$nome.'</h1>
                            </div>
                            <div class="profile-additions-body">
                                <p>'.$informazioni.'</p>
                            </div>
                        </div>
                        <div class="single-add-container">
                                <div class="profile-additions-header">
                                    <h1>Contatti</h1>
                                </div>
                                <div class="profile-additions-body">
                                    <ul>
                                        <li><label for="mail"> Mail: </label name= "mail"><span>'.$mail.'</span></li>
                                        <li><label for="tel"> Cellulare: </label name= "tel"><span>'.$telefono.'</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
';
}

function build_area_privata_studente_appuntamenti(){

    $query_base = "
    SELECT utente.nome,
    utente.cognome,
    utente.path_immagine
    FROM studente, utente
    WHERE utente.email_utente = studente.email_studente_utente
        AND utente.email_utente = '" . $_SESSION['ID'] . "'
";

    $res = select($query_base);

    $nome = $res[0]['nome']. " ".$res[0]['cognome'];
    $titolo = $res[0]['short_bio'];
    $path_immagine = $res[0]['path_immagine'];


    $query = "
            select utente.nome,
               utente.cognome,
               corso_studio.nome as corso,
               appuntamento.data,
               appuntamento.durata,
               competenza_corso.tariffa,
               appuntamento.tipo,
               appuntamento.location
        from appuntamento, competenza_corso, corso_studio, tutor, utente
        where appuntamento.email_studente = '".$_SESSION['ID']."'
        and appuntamento.email_tutor = utente.email_utente
        and appuntamento.fk_competenza_corso = competenza_corso.id_competenza_corso
        and competenza_corso.fk_corso_studio = corso_studio.id_corso_studio
    ";

    echo '
        <div class="profile-header">
            <div class="profile-picture">
                <div class="frame">
                    <img src="'.$path_immagine.'" alt="Immagine di profilo">
                </div>
            </div>
            <div class="info-container">
                <h1>'.$nome.'</h1>
                <h2><i>'.$titolo.'</i></h2>
            </div>
        </div>
        <div class="profile-body">
    ';
    injectStudentMenuPersonalArea('agenda');
    echo '
            <div class="appointment-container">
                <ul class="appointments-list">
    ';
    $lista_app = select($query);

    for($i =0 ; $i< count($lista_app); $i++){
        $nome_tutor = $lista_app[$i]['nome']." ".$lista_app[$i]['cognome'];
        $insegnamento = $lista_app[$i]['corso'];
        $dataApp= $lista_app[$i]['data'];
        $durata= $lista_app[$i]['durata'];
        $compenso= $lista_app[$i]['tariffa'];
        $location= $lista_app[$i]['location'];
        $metodo= $lista_app[$i]['tipo'];
        echo' 
                    <li class="appointment">
                        <div class="appointment-head">
                            <img src="../images/boss.png" alt="immagine profilo">
                            <h1>'.$nome_tutor.'</h1>
                        </div>
                        <div class="appointment-body">
                            <dl>
                                 <dt>Insegnamento</dt>
                                <dd>'.$insegnamento.'</dd>
                            </dl>
                            <dl>
                                <dt>Data</dt>
                                <dd>'.$dataApp.'</dd>
                            </dl>
                            <dl>
                                <dt>Durata</dt>
                                <dd>'.$durata.'</dd>
                            </dl>
                            <dl>
                                <dt>Compenso orario</dt>
                                <dd>'.$compenso.'</dd>
                            </dl>
                            <dl>
                                <dt>Location</dt>
                                <dd>'.$location.'</dd>
                            </dl>
                            <dl>
                                <dt>Metodo</dt>
                                <dd>'.$metodo.'</dd>
                            </dl>
                        </div>
                    </li>
        ';
    }
    echo '
                </ul>
            </div>
        </div>
    ';
}

function build_area_privata_studente_settings(){

    $query_base = "
    SELECT *
    FROM studente, utente
    WHERE utente.email_utente = studente.email_studente_utente
        AND utente.email_utente = '" . $_SESSION['ID'] . "'
";

    $res = select($query_base);

    $nome = $res[0]['nome']. " ".$res[0]['cognome'];
    $textarea_info = $res[0]['descrizione'];
    $shortBio =  $res[0]['short_bio'];
    $modifica_telefono = $res[0]['telefono'];
    $path_immagine = $res[0]['path_immagine'];


    echo '
        <div class="profile-header">
            <div class="profile-picture">
                <div class="frame">
                    <img src="'.$path_immagine.'" alt="immagine profilo">
                </div>
            </div>
            <div class="info-container">
                <h1>'.$nome.'</h1>
                <h2><i>'.$shortBio.'</i></h2>
            </div>
        </div>
        <div class="profile-body">
    ';

    injectStudentMenuPersonalArea('settings');

    echo '
            <div class="info-container">
                <form id="tutor-settings" action= "personal-area-studente-settings-server.php" method="post" enctype="multipart/form-data">
                    <div id="other-info-container">
                        <div id="other-info">
                            <dl class="float-left">
                                <dt id="immagine-profilo">
                                    <h1>Immagine profilo</h1>
                                </dt>
                                <dd>
                                    <input type="file" name="upload-immagine-profilo" accept="image/*" />
                                </dd>
                                <dt id="short-bio">
                                    <h1>Short bio</h1>
                                </dt>
                                <dd>
                                    <input type="text" id = "in-bio" name="short_bio" value ="'.$shortBio.'" />
                                </dd>
                            </dl>
                            <dl class="float-left">
                                <dt>
                                    <h1>Contatti</h1>
                                </dt>
                                <dd>
                                    <ul id="contatti">
                                        <li>
                                            <label for="tel"> Telefono: </label>
                                            <input type="text" id="tel" name="modifica_telefono" pattern="[0-9]{10}" placeholder="0123456789" value="'.$modifica_telefono.'" />
                                        </li>
                                    </ul>
                                </dd>
                            </dl>
                        </div>
                        <div class="profile-additions">
                            <div class="single-add-container">
                                <div class="profile-additions-header">
                                    <h1>Informazioni su '.$nome.'</h1>
                                </div>
                                <div class="profile-additions-body">
                                    <textarea maxlength="1225" form= "tutor-settings" id="textarea-info" name="textarea-info">'.$textarea_info.'</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id = "settings-submit" type="submit"> Finito </button>
                </form>
            </div>
        </div>
    ';
}

function build_studente_scrivi_recensione($tutor){
    $query_base = "
    SELECT *
    FROM studente, utente
    WHERE utente.email_utente = studente.email_studente_utente
        AND utente.email_utente = '" . $_SESSION['ID'] . "'
";

    $res = select($query_base);

    $nome = $res[0]['nome']. " ".$res[0]['cognome'];
    $shortBio =  $res[0]['short_bio'];
    $path_immagine = $res[0]['path_immagine'];


    echo '
        <div class="profile-header">
            <div class="profile-picture">
                <div class="frame">
                    <img src="'.$path_immagine.'" alt="immagine profilo">
                </div>
            </div>
            <div class="info-container">
                <h1>'.$nome.'</h1>
                <h2><i>'.$shortBio.'</i></h2>
            </div>
        </div>
        <div class="profile-body">
    ';
    
    $res = select("select * from utente where email_utente ='".$tutor."'");
    $nome = $res[0]['nome']. " ".$res[0]['cognome'];

    echo '
            <div class="app-creation-container">
                <div id="back-section" class="get-lower">
                    <a href="tutor-profile.php"><img src="../images/icons/left.svg" alt="indietro"/></a>
                </div>
                <form id="Quick-search-form" action="tutor-profile-scrivi-recensione-server.php?tid='.$tutor.'" method="post">
                    <h1>Scrivi una recensione per '.$nome.'</h1>
                    <div class = "centered-wrapper">
                        <div id="rating-container">
                            <label id="star-rating" for= "minRatingChoise">Valutazione:</label>
                            <div class="rating">
                                <input type="radio" name="star" value = "5"  id="star-5" onclick="minRatingChoosed(this.id)" />
                                <label for="star-5" onclick="minRatingChoosed(\'star-5\')" onkeypress="this.click()" tabindex=0></label>
                                <input type="radio" name="star" value = "4"  id="star-4" onclick="minRatingChoosed(this.id)" />
                                <label for="star-4" onclick="minRatingChoosed(\'star-4\')" onkeypress="this.click()" tabindex=0></label>
                                <input type="radio" name="star" value = "3"  id="star-3" onclick="minRatingChoosed(this.id)" />
                                <label for="star-3" onclick="minRatingChoosed(\'star-3\')" onkeypress="this.click()" tabindex=0></label>
                                <input type="radio" name="star" value = "2"  id="star-2" onclick="minRatingChoosed(this.id)" />
                                <label for="star-2" onclick="minRatingChoosed(\'star-2\')" onkeypress="this.click()" tabindex=0></label>
                                <input type="radio" name="star" value = "1"  id="star-1" onclick="minRatingChoosed(this.id)" />
                                <label for="star-1" onclick="minRatingChoosed(\'star-1\')" onkeypress="this.click()" tabindex=0></label>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <textarea maxlength="500" form= "Quick-search-form" id="textarea-rec" name="textarea-rec" placeholder = "Scrivi la tua recensione..." aria-label = "Scrivi la tua recensione"></textarea>
                    <button type="submit" class="find-button">Pubblica</button>
                </form>
            </div>
        </div>
    ';
}

//CREAZIONE PAGINE PERSONALI TUTOR
function build_area_privata_tutor_profile(){

    //REPERISCO INFORMAZIONI BASE
    $query = "
    SELECT *
    FROM tutor, utente
    WHERE utente.email_utente = tutor.email_tutor_utente
        AND utente.email_utente = '" . $_SESSION['ID'] . "'
";

    $res = select($query);

    //var_dump($res);

    $nome = $res[0]['nome']. " ".$res[0]['cognome'];
    $titolo = $res[0]['short_bio'];
    $informazioni = $res[0]['descrizione'];
    $telefono = $res[0]['telefono'];
    $path_immagine = $res[0]['path_immagine'];
    $mail = $_SESSION['ID'];

    $contatti =
   '<li><label for="tel"> Telefono: </label><span id= "tel"> '.$telefono.' </span></li>
    <li><label for="mail"> Mail: </label><span id= "mail"> '.$mail.' </span></li>
';
    $lezioni = "";
    if($res[0]['insegnante_privato'] == "1"){
        $lezioni .= "<li>Insegnante privato</li>";
    }
    if($res[0]['lezioni_gruppo'] == "1") {
        $lezioni .= "<li>In gruppo</li>";
    }


    $servizio = "";

    if($res[0]['remoto'] == "1"){
        $servizio .= "<li>Via webcam</li>";
    }
    if($res[0]['ospita'] == "1") {
        $servizio .= "<li>A casa mia</li>";
    }
    if($res[0]['visita'] == "1"){
        $servizio .= "<li>A domicilio</li>";
    }
    if($res[0]['luogo_concordato'] == "1"){
        $servizio .= "<li>Luogo concordato</li>";
    }
    $metodo = $res[0]['metodo'];

    //REPERISCO INFORMAZIONI PER CREARE I BADGE
    $badges = getBadges($_SESSION['ID']);

    //REPERISCO INFORMAZIONI SULLE COMPETENZE

    $query_competenza = "
        select tariffa, nome
        from competenza_corso, corso_studio
        where competenza_corso.email_tutor = '".$_SESSION['ID']."'
        and competenza_corso.fk_corso_studio = corso_studio.id_corso_studio;
    ";

    $res = select($query_competenza);
    $materie = "";

    for ($i = 0; $i < count($res); $i++){
       $materie .= "
            <li>".$res[$i]['nome'].", ".$res[$i]['tariffa']."€/h
       ";
    }

    echo '
        <div class="profile-header">
            <div class="profile-picture">
                <div class="frame">
                    <img src="'.$path_immagine.'" alt = "immagine profilo">
                </div>
            </div>
            <div class="info-container">
                <h1>'.$nome.'</h1>
                <h2><i>'.$titolo.'</i></h2>
            </div>
            <div class="badge-container">
            '.$badges.'
            </div>
        </div>
        <div class="profile-body">
    ';
    injectMenuPersonalArea('profilo');
    echo '
    <div class="info-container">
        <div id="other-info-container">
            <div id="other-info">
                <dl class="float-left">
                    <dt id="servizi">
                        <h1>Servizio</h1>
                    </dt>
                    <dd>
                        <ul>'.$servizio.'
                        </ul>
                    </dd>
                </dl>
                <dl class="float-left">
                    <dt>
                        <h1>Contatti</h1>
                    </dt>
                    <dd>
                        <ul>'.$contatti.'</ul>
                    </dd>
                </dl>
                <dl> 
                    <dt id="lezioni">
                        <h1>Lezioni</h1>
                    </dt>
                    <dd>
                        <ul>'.$lezioni.'
                        </ul>
                    </dd>
                </dl>
            </div>
            <div class="profile-additions">
                <div class="single-add-container">
                    <div class="profile-additions-header">
                        <h1>Informazioni su '.$nome.'</h1>
                    </div>
                    <div class="profile-additions-body">
                        <p>'.$informazioni.'</p>
                    </div>
                </div>
                <div class="single-add-container">
                    <div class="profile-additions-header">
                        <h1>Metodologia</h1>
                    </div>
                    <div class="profile-additions-body">
                        <p>'.$metodo.'</p>
                    </div>
                </div>
                <div class="single-add-container">
                    <div class="profile-additions-header">
                        <h1>Competenze</h1>
                    </div>
                    <div class="profile-additions-body">
                        <ul>
                            '.$materie.'
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="opinions">
            <h1>Recensioni su '.$nome.'</h1>';

    printRecensioni($_SESSION['ID']);

    echo'
        </div>
    </div>
';
}

function build_area_privata_tutor_studenti(){

    //REPERISCO INFORMAZIONI BASE

    $query = "
    SELECT *
    FROM tutor, utente
    WHERE utente.email_utente = tutor.email_tutor_utente
        AND utente.email_utente = '" . $_SESSION['ID'] . "'";

    $res = select($query);

    $nome = $res[0]['nome']. " ".$res[0]['cognome'];
    $path_immagine = $res[0]['path_immagine'];
    $titolo = $res[0]['short_bio'];


    //REPERISCO INFORMAZIONI PER CREARE I BADGE
    $badges = getBadges($_SESSION['ID']);


    $query_studenti = "
        select utente.nome, utente.cognome, utente.email_utente
        from allievo, studente, utente
        where allievo.email_tutor = '".$_SESSION['ID']."'
        and allievo.email_studente = studente.email_studente_utente
        and studente.email_studente_utente = utente.email_utente
    ";

    $lista_stud = select($query_studenti);

    echo '
        <div class="profile-header">
            <div class="profile-picture">
                <div class="frame">
                    <img src="'.$path_immagine.'" alt="immagine profilo">
                </div>
            </div>
            <div class="info-container">
                <h1>'.$nome.'</h1>
                <h2><i>'.$titolo.'</i></h2>
            </div>
            <div class="badge-container">
            '.$badges.'
            </div>
        </div>
        <div class="profile-body">
    ';
    injectMenuPersonalArea('alunni');
    echo '
        <div class="students-list-container">
            <div class="student-list-caption">
                Lista studenti di '.$nome.'
            </div>
            <ul class="student-list">
    ';

    for($i =0 ; $i< count($lista_stud); $i++){
        $nome_stud = $lista_stud[$i]['nome']." ".$lista_stud[0]['cognome'];
        echo' 
                <li class="student-list-item">
                    <div class="profile-pic float-left">
                        <img src="../images/boss.png" alt="immagine profilo di '.$nome_stud.'" href=""/>
                    </div>
                    <span><a href="studente-profile.php?sid='.$lista_stud[$i]['email_utente'].'">'.$nome_stud.'</a></span>
                </li>
        ';
    }
    echo '
            </ul>
        </div>
    </div>

    ';
}

function build_area_privata_tutor_appuntamenti(){

    //REPERISCO INFORMAZIONI BASE

    $query_base = "
    SELECT utente.nome,
    utente.cognome,
    utente.path_immagine,
    utente.short_bio
    FROM tutor, utente
    WHERE utente.email_utente = tutor.email_tutor_utente
        AND utente.email_utente = '" . $_SESSION['ID'] . "'
";
    
     $res = select($query_base);

    $nome = $res[0]['nome']. " ".$res[0]['cognome'];
    $path_immagine = $res[0]['path_immagine'];
    $titolo = $res[0]['short_bio'];

    //REPERISCO INFORMAZIONI PER CREARE I BADGE
    $badges = getBadges($_SESSION['ID']);

//    $lista_app = select($query);
    $query_appuntamenti ="
        select appuntamento.*, 
        utente.nome as nome,
        utente.cognome as cognome,
        corso_studio.nome as corso,
        competenza_corso.tariffa  
        from utente, appuntamento, studente, competenza_corso, corso_studio
        where appuntamento.email_tutor = '".$_SESSION['ID']."'
        and utente.email_utente = studente.email_studente_utente
        and email_studente = studente.email_studente_utente
        and appuntamento.fk_competenza_corso = competenza_corso.id_competenza_corso
        and competenza_corso.fk_corso_studio = corso_studio.id_corso_studio
    ";

    echo '
        <div class="profile-header">
            <div class="profile-picture">
                <div class="frame">
                    <img src="'.$path_immagine.'" alt="immagine profilo">
                </div>
            </div>
            <div class="info-container">
                <h1>'.$nome.'</h1>
                <h2><i>'.$titolo.'</i></h2>
            </div>
            <div class="badge-container">
            '.$badges.'
            </div>
        </div>
        <div class="profile-body">
    ';

    injectMenuPersonalArea('agenda');

    echo '
            <div class="new-appointment-container">
                <a  href="personal-area-tutor-crea-appuntamento.php" id = "create-app"><div>Crea nuovo appuntamento</div></a>
            </div>
            <div class="appointment-container">
                <ul class="appointments-list">
    ';

    $lista_app = select($query_appuntamenti);

    for($i =0 ; $i< count($lista_app); $i++){
        echo' 
                    <li class="appointment">
                        <div class="appointment-head">
                            <img src="../images/boss.png" alt="immagine profilo">
                            <h1>'.$lista_app[$i]["nome"].'</h1>
                        </div>
                        <div class="appointment-body">
                            <dl>
                                 <dt>Insegnamento</dt>
                                <dd>'.$lista_app[$i]["corso"].'</dd>
                            </dl>
                            <dl>
                                <dt>Data</dt>
                                <dd>'.$lista_app[$i]["data"].'</dd>
                            </dl>
                            <dl>
                                <dt>Durata</dt>
                                <dd>'.$lista_app[$i]["durata"].'</dd>
                            </dl>
                            <dl>
                                <dt>Compenso orario</dt>
                                <dd>'.$lista_app[$i]["tariffa"].'</dd>
                            </dl>
                            <dl>
                                <dt>Location</dt>
                                <dd>'.$lista_app[$i]["location"].'</dd>
                            </dl>
                            <dl>
                                <dt>Metodo</dt>
                                <dd>'.$lista_app[$i]["tipo"].'</dd>
                            </dl>
                        </div>
                    </li>
        ';
    }

    echo '
                </ul>
            </div>
        </div>
    ';

}

function build_area_privata_tutor_crea_appuntamento(){

    //REPERISCO INFORMAZIONI BASE

    $query_base = "
    SELECT utente.nome,
    utente.cognome,
    utente.path_immagine,
    utente.short_bio
    FROM tutor, utente
    WHERE utente.email_utente = tutor.email_tutor_utente
        AND utente.email_utente = '" . $_SESSION['ID'] . "'
";

    $res = select($query_base);

    $nome = $res[0]['nome']. " ".$res[0]['cognome'];
    $path_immagine = $res[0]['path_immagine'];
    $titolo = $res[0]['short_bio'];

    //REPERISCO INFORMAZIONI PER CREARE I BADGE
    $badges = getBadges($_SESSION['ID']);

    echo '
        <div class="profile-header">
            <div class="profile-picture">
                <div class="frame">
                    <img src="'.$path_immagine.'" alt="immagine profilo">
                </div>
            </div>
            <div class="info-container">
                <h1>'.$nome.'</h1>
                <h2><i>'.$titolo.'</i></h2>
            </div>
            <div class="badge-container">
            '.$badges.'
            </div>
        </div>
        <div class="profile-body">
    ';
    injectMenuPersonalArea('agenda');
    echo '
            <div class="app-creation-container">
                <div id="back-section">
                    <a href="personal-area-tutor-appuntamenti.php"><img src="../images/icons/left.svg" alt="indietro"/></a>
                </div>
                <form id="Quick-search-form" action="personal-area-tutor-crea-appuntamento-server.php" method="post">
                    <h1>Crea un appuntamento</h1>
                    <div class="research-field">
                        <label aria-label = "studente" class = "hidden" for="input-CAStudente">Studente</label>
                        <input class="QSInput" name="CAStudente" id="input-CAStudente" type="text"  onblur="stayUp(this)" onkeyup="showHintLogin(this.value, this.name)" required/>
                        <span class = "fake-label">Studente</span>
                    </div>
                    <div id="research-outputs-CAStudente" class="">
                    </div>
                    <div class="research-field">
                        <label class = "hidden" aria-label = "insegnamento" for="input-CAMateria">Insegnamento</label> 
                        <input class="QSInput" name="CAMateria" id="input-CAMateria" type="text" onblur="stayUp(this)" onkeyup="showHintLogin(this.value, this.name)" required/>
                        <span class = "fake-label">Insegnamento</span>
                    </div>
                    <div id="research-outputs-CAMateria" class="">
                    </div>
                    <div class="research-field">
                        <label class = "hidden" aria-label = "data" for="input-CAData">Data</label>
                        <input class="QSInput" name="CAData" id="input-CAData" onblur="stayUp(this)" type="text" pattern="\d{1,2}/\d{1,2}/\d{4}" required/>
                        <span class = "fake-label">Data</span>
                        <span id="esempio-data">Formato richiesto: gg/mm/aaaa</span>
                    </div>
                    <div class="research-field">
                        <label class = "hidden" aria-label = "inizio" for="input-CAInizio">Inizio</label>
                        <input class="QSInput" name="CAInizio" id="input-CAInizio" onblur="stayUp(this)" type="text" pattern="\d{2}:\d{2}" required/>
                        <span class = "fake-label">Inizio</span>
                        <span id="esempio-inizio">Formato richiesto: hh:mm</span>
                    </div>
                    <div class="research-field">
                        <label class = "hidden" aria-label = "durata in ore" for="input-CADurata">Durata in ore</label>
                        <input class="QSInput" name="CADurata" type="text" onblur="stayUp(this)" id="input-CADurata" required/>
                        <span class = "fake-label">Durata in ore</span>
                    </div>
                    <div>
                        <fieldset id="gruppo-luogo" name="gruppo-luogo">
                        <legend class="hidden-legend">Luogo dell&apos;appuntamento</legend>
                            <input type="radio" id="radio_ospita" name="gruppo-luogo" value="ospita" />
                            <label for="radio_ospita">A casa tua</label>
                            <input type="radio" id="radio_visita" name="gruppo-luogo" value="visita" />
                            <label for="radio_visita">A casa dello studente</label>
                            <input type="radio" id="radio_concordato" name="gruppo-luogo" value="concordato" />
                            <label for="radio_concordato">In un luogo concordato</label>
                        </fieldset>
                    </div>
                    <div>
                        <fieldset id="gruppo-metodo" name="gruppo-metodo" >
                        <legend class="hidden-legend">Metodo di lezione</legend>
                            <input type="radio" id="radio_frontale" name="gruppo-metodo" value="frontale" />
                            <label for="radio_frontale">Lezione frontale</label>
                            <input type="radio" id="radio_gruppo" name="gruppo-metodo" value="gruppo" />
                            <label for="radio_gruppo">Lezione in gruppo</label>
                            <input type="radio" id="radio_web" name="gruppo-metodo" value="webcam" />
                            <label for="radio_web">Lezione via webcam</label>
                        </fieldset>
                    </div>
                    <button class="find-button">Crea</button>
                </form>
            </div>
        </div>
    ';
}

function build_area_privata_tutor_settings(){

    //REPERISCO INFORMAZIONI BASE

    $query_base = "
        select * 
        FROM tutor, utente
        where tutor.email_tutor_utente = '" . $_SESSION['ID'] . "'
        and utente.email_utente = tutor.email_tutor_utente
";

    $res = select($query_base);

    $nome = $res[0]['nome']. " ".$res[0]['cognome'];
    $shortBio = $res[0]['short_bio'];

    $gruppo_visita =  $res[0]['visita'];
    $gruppo_visita_si = "";
    $gruppo_visita_no ="";
    if($gruppo_visita == 1)
        $gruppo_visita_si = "checked";
    else
        $gruppo_visita_no = "checked";

    $gruppo_ospita = $res[0]['ospita'];
    $gruppo_ospita_si = "";
    $gruppo_ospita_no = "";
    if($gruppo_ospita == 1)
        $gruppo_ospita_si = "checked";
    else
        $gruppo_ospita_no = "checked";

    $gruppo_webcam = $res[0]['remoto'];
    $gruppo_webcam_si = "";
    $gruppo_webcam_no = "";
    if($gruppo_webcam == 1)
        $gruppo_webcam_si = "checked";
    else
        $gruppo_webcam_no = "checked";

    $luogo_concordato = $res[0]['luogo_concordato'];
    $luogo_concordato_si = "";
    $luogo_concordato_no = "";
    if($luogo_concordato == 1)
        $luogo_concordato_si = "checked";
    else
        $luogo_concordato_no = "checked";

    $modifica_telefono = $res[0]['telefono'];
    $mail = $_SESSION['ID'];

    $gruppo_privato = $res[0]['insegnante_privato'];
    $gruppo_privato_si = "";
    $gruppo_privato_no = "";
    if($gruppo_privato == 1)
        $gruppo_privato_si = "checked";
    else
        $gruppo_privato_no = "checked";

    $gruppo_gruppo = $res[0]['lezioni_gruppo'];
    $gruppo_gruppo_si = "";
    $gruppo_gruppo_no = "";
    if($gruppo_gruppo == 1)
        $gruppo_gruppo_si = "checked";
    else
        $gruppo_gruppo_no = "checked";

    $textarea_info = $res[0]['descrizione'];
    $textarea_metodo = $res[0]['metodo'];
    $path_immagine = $res[0]['path_immagine'];

    //REPERISCO INFORMAZIONI PER CREARE I BADGE
    $badges = getBadges($_SESSION['ID']);


    echo '
        <div class="profile-header">
            <div class="profile-picture">
                <div class="frame">
                    <img src="'.$path_immagine.'" alt="immagine profilo">
                </div>
            </div>
            <div class="info-container">
                <h1>'.$nome.'</h1>
                <h2><i>'.$shortBio.'</i></h2>
            </div>
            <div class="badge-container">
            '.$badges.'
            </div>
        </div>
        <div class="profile-body">
    ';

    injectMenuPersonalArea('settings');

    echo '
            <div class="info-container">
                <form id="tutor-settings" action= "personal-area-tutor-settings-server.php" method="post" enctype="multipart/form-data">
                    <div id="other-info-container">
                        <div id="other-info">
                            <dl class="float-left">
                                <dt id="immagine-profilo">
                                    <h1>Immagine profilo</h1>
                                </dt>
                                <dd>
                                    <label for = "pro-pic" class = "hidden" aria-label = "carica una immagine di profilo">carica una immagine di profilo</label>
                                    <input id="pro-pic" type="file" name="upload-immagine-profilo" accept="image/*"/>
                                </dd>
                                <dt id="short-bio">
                                    <h1>Short bio</h1>
                                </dt>
                                <dd>
                                    <label for = "input-bio" class = "hidden" aria-label = "inserisci una breve bio">inserisci una breve bio</label>
                                    <input id = "input-bio" type="text" name="short_bio" placeholder="Dottore in ...  @ universit&agrave; di ... ."value ="'.$shortBio.'" />
                                </dd>
                            </dl>
                            <dl class="float-left">
                                <dt id="servizi">
                                    <h1>Servizio</h1>
                                </dt>
                                <dd>
                                    <ul>
                                        <li>A domicilio:
                                            <fieldset class="float-right" id="gruppo-visita"><legend class = "hidden-legend">Servizio a domicilio</legend>
                                                <label for="ACRsi">si</label>
                                                <input type="radio" id="ACRsi" name="gruppo-visita" value="si" '.$gruppo_visita_si.'/>
                                                <label for="ACRno">no</label>
                                                <input type="radio" id="ACRno" name="gruppo-visita" value="no" '.$gruppo_visita_no.'/>
                                            </fieldset>
                                        </li>
                                        <li>A casa mia:
                                            <fieldset id="gruppo-ospita" class="float-right">
                                            <legend class="hidden-legend">Servizio a casa mia</legend>
                                                <label for="ACTsi">si</label>
                                                <input type="radio" id="ACTsi" name="gruppo-ospita" value="si" '.$gruppo_ospita_si.'/>
                                                <label for="ACTno">no</label>
                                                <input type="radio" id="ACTno" name="gruppo-ospita" value="no" '.$gruppo_ospita_no.'/>
                                            </fieldset>
                                            </li>
                                        <li>Via webcam:
                                            <fieldset id="gruppo-webcam" class="float-right">
                                            <legend class="hidden-legend">Servizio via webcam</legend>
                                                <label for="WBsi">si</label>
                                                <input type="radio" id="WBsi" name="gruppo-webcam" value="si" '.$gruppo_webcam_si.'/>
                                                <label for="WBno">no</label>
                                                <input type="radio" id="WBno" name="gruppo-webcam" value="no" '.$gruppo_webcam_no.'/>
                                            </fieldset>
                                        </li>
                                        <li>Luogo concordato:
                                            <fieldset id="gruppo-concordato" class="float-right">
                                            <legend class="hidden-legend">Servizio in un luogo concordato</legend>
                                                <label for="CONCsi">si</label>
                                                <input type="radio" id="CONCsi" name="gruppo-concordato" value="si" '.$luogo_concordato_si.'/>
                                                <label for="CONCno">no</label>
                                                <input type="radio" id="CONCno" name="gruppo-concordato" value="no" '.$luogo_concordato_no.'/>
                                            </fieldset>
                                        </li>
                                    </ul>
                                </dd>
                            </dl>
                            <dl class="float-left">
                                <dt>
                                    <h1>Contatti</h1>
                                </dt>
                                <dd>
                                    <ul id="contatti">
                                        <li>
                                            <label for="tel"> Telefono: </label>
                                            <input type="text" id="tel" name="modifica_telefono" pattern="[0-9]{10}" placeholder="0123456789" value="'.$modifica_telefono.'" />
                                        </li>
                                        <li>
                                            <label for="mail"> Mail: </label>
                                            <input type="text" id="mail" name= "modifica_mail" placeholder="tm@gmail.com" value="'.$mail.'" />
                                        </li>
                                    </ul>
                                </dd>
                            </dl>
                            <dl> 
                                <dt id="lezioni">
                                    <h1>Lezioni</h1>
                                </dt>
                                <dd>
                                    <ul>                
                                        <li>Insegnante privato:
                                            <fieldset name="gruppo-privato" class="float-right">
                                            <legend class = "hidden-legend">Servizio via webcam</legend>
                                                <label for="privato_si">si</label>
                                                <input type="radio" id="privato_si" name="gruppo-privato" value="si" '.$gruppo_privato_si.'/>
                                                <label for="privato_no">no</label>
                                                <input type="radio" id="privato_no" name="gruppo-privato" value="no" '.$gruppo_privato_no.'/>
                                            </fieldset>
                                        </li>

                                        <li>In gruppo:
                                            <fieldset name="gruppo-gruppo" class="float-right">
                                            <legend class = "hidden-legend">Servizio via webcam</legend>
                                                <label for="gruppo_si">si</label>
                                                <input type="radio" id="gruppo_si" name="gruppo-gruppo" value="si" '.$gruppo_gruppo_si.'/>
                                                <label for="gruppo_no">no</label>
                                                <input type="radio" id="gruppo_no" name="gruppo-gruppo" value="no" '.$gruppo_gruppo_no.'/>
                                            </fieldset>
                                        </li>
                                    </ul>
                                </dd>
                            </dl>
                        </div>
                        <div class="profile-additions">
                            <div class="single-add-container">
                                <div class="profile-additions-header">
                                    <h1>Informazioni su '.$nome.'</h1>
                                </div>
                                <div class="profile-additions-body">
                                    <textarea maxlength="1225" aria-label = "informazioni generali" form= "tutor-settings" id="textarea-info" name="textarea-info">'.$textarea_info.'</textarea>
                                </div>
                            </div>
                            <div class="single-add-container">
                                <div class="profile-additions-header">
                                    <h1>Metodologia</h1>
                                </div>
                                <div class="profile-additions-body">
                                    <textarea maxlength="1225" form= "tutor-settings" id="textarea-metodo" name="textarea-metodo" aria-label="metodo di insegnamento">'.$textarea_metodo.'</textarea>
                                </div>
                            </div>
                            <div class="single-add-container" id = "comp-list">
                                <div class="profile-additions-header">
                                    <h1>Competenze</h1>
                                </div>
                                <div class="profile-additions-body padded">
                                    <ul id = "lista-comp">                
                                        ';

                                $query_competenze = "select competenza_corso.id_competenza_corso as cid, corso_studio.nome as corso
                                                    from tutor, competenza_corso, corso_studio
                                                    where tutor.email_tutor_utente = competenza_corso.email_tutor
                                                    and competenza_corso.fk_corso_studio = corso_studio.id_corso_studio
                                                    and tutor.email_tutor_utente = '" . $_SESSION['ID'] . "'";

                                $competenze = select($query_competenze);

                                for ($i=0; $i < count($competenze) ; $i++) { 
                                    echo '
                                        <li>'.$competenze[$i]['corso'].'
                                            <a href="personal-area-tutor-cancella-competenza-server.php?cid='.$competenze[$i]['cid'].'" name="elimina_competenza" id = "delete-comp">&#x2716;</a>
                                        </li>
                                    ';
                                }

    echo '
                                    </ul>
                                    <a href="personal-area-tutor-aggiungi-materia.php" id="add-comp">Aggiungi competenza</a>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <button id = "settings-submit" type="submit"> Salva </button>
                </form>
            </div>
    ';
}

function build_area_privata_tutor_aggiungi_competenza(){

    //REPERISCO INFORMAZIONI BASE

    $query_base = "
    SELECT utente.nome,
    utente.cognome,
    utente.path_immagine
    FROM tutor, utente
    WHERE utente.email_utente = tutor.email_tutor_utente
        AND utente.email_utente = '" . $_SESSION['ID'] . "'
";

    $res = select($query_base);

    $nome = $res[0]['nome']. " ".$res[0]['cognome'];
    $titolo = "Dottore in scienze delle merendine @UniPd";

    //REPERISCO INFORMAZIONI PER CREARE I BADGE
    $badges = getBadges($_SESSION['ID']);

    echo '
        <div class="profile-header">
            <div class="profile-picture">
                <div class="frame">
                    <img src="../images/profile_images/boss.png" alt="immagine profilo">
                </div>
            </div>
            <div class="info-container">
                <h1>'.$nome.'</h1>
                <h2><i>'.$titolo.'</i></h2>
            </div>
            <div class="badge-container">
            '.$badges.'
            </div>
        </div>
        <div class="profile-body">
    ';
    injectMenuPersonalArea('agenda');
    echo '
        <div class="app-creation-container">
            <div id="back-section">
                <a href="personal-area-tutor-settings.php"><img src="../images/icons/left.svg" alt="indietro"/></a>
            </div>
            <form id="Quick-search-form" action="personal-area-tutor-aggiungi-materia-server.php" method="post">
                <h1>Aggiungi una competenza</h1>
                <div class="research-field">
                    <label class = "hidden" aria-label = "università" for="input-ACUni">Universit&agrave;</label>
                    <input class="ACUni" name="ACUni" id="input-ACUni" type="text" onblur="stayUp(this)" onkeyup="showHintLogin(this.value, this.name)" required/>
                    <span class = "fake-label">Università</span>
                </div>
                <div id="research-outputs-ACUni" class="">
                </div>
                <div class="research-field">
                    <label class = "hidden" aria-label = "corso di laurea" for="input-ACCorso_di_laurea">Corso di laurea</label>
                    <input class="QSInput" name="ACCorso_di_laurea" id="input-ACCorso_di_laurea" type="text" onblur="stayUp(this)" onkeyup="showHintCompetenza(this.value, this.name,\'input-ACUni\')" required/>
                    <span class = "fake-label">Corso di laurea</span>
                </div>
                <div id="research-outputs-ACCorso_di_laurea" class="">
                </div>
                <div class="research-field">
                    <label class = "hidden" aria-label = "corso di laurea" for="input-ACCorso_di_studio">Corso di studio</label>
                    <input class="QSInput" name="ACCorso_di_studio" id="input-ACCorso_di_studio" type="text" onblur="stayUp(this)" onkeyup="showHintCompetenza(this.value, this.name, \'input-ACCorso_di_laurea\' )" required/>
                    <span class = "fake-label">Corso di studio</span>
                </div>
                <div id="research-outputs-ACCorso_di_studio" class="">
                </div>
                <div class="research-field">
                    <label class = "hidden" aria-label = "tariffa" for="input-ACTariffa">Tariffa oraria</label>
                    <input type="number" class="QSInput" name="ACTariffa" id = "input-ACTariffa" onblur="stayUp(this)" type="text" required/>
                    <span class = "fake-label">Tariffa</span>
                </div>
                <div class="research-field">
                    <label class = "hidden" aria-label = "motivaziones" for="input-ACDescrizione">Motivazioni</label>
                    <input class="QSInput" name="ACDescrizione" id="input-ACDescrizione" onblur="stayUp(this)" type="text" required/>
                    <span class = "fake-label">Motivazione</span>
                </div>
                <button type="submit" class="find-button">Aggiungi</button>
            </form>
        </div>
    ';
}

function printRecensioni($tutor){

    $query_recensioni ="
        select utente.nome, utente.cognome, recensione.*
        from recensione, utente 
        where email_studente = utente.email_utente
        and recensione.email_tutor = '".$tutor."'
    ";

    $recensioni = select($query_recensioni);


    for ($i = 0; $i<count($recensioni);$i++) {
        $nome = $recensioni[$i]['nome']. " ".$recensioni[$i]['cognome'];
        echo "
                        <div class = 'review-container'>
                            <div class = 'review-module'>
                                <div class = 'review-header'>
                                    <div class = 'review-name'>
                                        <span class = 'r-name'>".$nome."</span>
                                    </div>
                                    <div class='review-rating'>";

        for($j=0; $j< $recensioni[$i]['valutazione']; $j++){
            echo "<span class='r-star'></span>";
        }
        for($j;$j <5;$j++){
            echo "<span class='r-star r-inactive'></span>";
        }
        echo "
                                    </div>
                                </div>
                                <div class = 'review-body'>
                                    ".$recensioni[$i]['motivazione']."
                                </div>
                            </div>
                        </div>
        ";
    }
}

//CREAZIONE PROFILI VETRINA

function build_area_privata_tutor_profile_vetrina($code){
    $tutor_id = $_REQUEST['tid'];


    $query = "
    SELECT *
    FROM tutor, utente
    WHERE utente.email_utente = tutor.email_tutor_utente
        AND utente.email_utente = '" . $tutor_id . "'
";

    $res = select($query);

    $nome = $res[0]['nome']. " ".$res[0]['cognome'];
    $titolo = $res[0]['short_bio'];
    $informazioni = $res[0]['descrizione'];
    $telefono = $res[0]['telefono'];
    $path_immagine = $res[0]['path_immagine'];
    $mail = $res[0]['email_utente'];
    $badges = getBadges($tutor_id);
    $contatti =
        '<li><label for="tel"> Telefono: </label><span name= "tel" id="tel"> '.$telefono.' </span></li>
    <li><label for="mail"> Mail: </label><span name= "mail" id="mail"> '.$mail.' </span></li>
';
    $lezioni = "";
    if($res[0]['insegnante_privato'] == "1"){
        $lezioni .= "<li>Insegnante privato</li>";
    }
    if($res[0]['lezioni_gruppo'] == "1") {
        $lezioni .= "<li>In gruppo</li>";
    }


    $servizio = "";

    if($res[0]['remoto'] == "1"){
        $servizio .= "<li>Via webcam</li>";
    }
    if($res[0]['ospita'] == "1") {
        $servizio .= "<li>A casa mia</li>";
    }
    if($res[0]['visita'] == "1"){
        $servizio .= "<li>A domicilio</li>";
    }
    if($res[0]['luogo_concordato'] == "1"){
        $servizio .= "<li>Luogo concordato</li>";
    }
    $metodo = $res[0]['metodo'];

    $query_competenza = "
        select tariffa, nome
        from competenza_corso, corso_studio
        where competenza_corso.email_tutor = '".$tutor_id."'
        and competenza_corso.fk_corso_studio = corso_studio.id_corso_studio;
    ";

    $res = select($query_competenza);
    $materie = "";

    for ($i = 0; $i < count($res); $i++){
        $materie .= "
            <li>".$res[$i]['nome'].", ".$res[$i]['tariffa']."€/h
       ";
    }

    echo '
        <div class="profile-header">
            <div class="profile-picture">
                <div class="frame">
                    <img src="'.$path_immagine.'" alt = "immagine profilo">
                </div>
            </div>
            <div class="info-container">
                <h1>'.$nome.'</h1>
                <h2><i>'.$titolo.'</i></h2>
            </div>
            <div class="badge-container">
            '.$badges.'
            </div>
        </div>
        <div class="profile-body">
            <div class="info-container">';
    if($_SESSION['TYPE'] != 'tutor') {
        if ($code == "ospite") {
            echo '<a href="login.php" id = "become-alumn">Iscriviti e diventa suo alunno!</a>';
        } else {
            $query_amico = select("select * from allievo where email_studente = '" . $_SESSION['ID'] . "' and email_tutor = '" . $tutor_id . "'");
            if (count($query_amico) > 0) {
                echo '<a href="rimuovi-amico-server.php?tid=' . $tutor_id . '" id = "become-alumn">Rimuoviti dalla lista alunni</a>';
            } else {
                echo '<a href="diventa-amico-server.php?tid=' . $tutor_id . '" id = "become-alumn">Diventa suo alunno!</a>';
            }
        }
    }

    echo'       <div id="other-info-container">
                    <div id="other-info">
                        <dl class="float-left">
                            <dt id="servizi">
                                <h1>Servizio</h1>
                            </dt>
                            <dd>
                                <ul>'.$servizio.'
                                </ul>
                            </dd>
                        </dl>';
    if(isset($_SESSIO['ID'])) {
        echo '
                            <dl class="float-left">
                                <dt>
                                    <h1>Contatti</h1>
                                </dt>
                                <dd>
                                    <ul>' . $contatti . '</ul>
                                </dd>
                            </dl>';
    }

    echo'
                        <dl> 
                            <dt id="lezioni">
                                <h1>Lezioni</h1>
                            </dt>
                            <dd>
                                <ul>'.$lezioni.'
                                </ul>
                            </dd>
                        </dl>
                    </div>
                    <div class="profile-additions">
                        <div class="single-add-container">
                            <div class="profile-additions-header">
                                <h1>Informazioni su '.$nome.'</h1>
                            </div>
                            <div class="profile-additions-body">
                                <p>'.$informazioni.'</p>
                            </div>
                        </div>
                        <div class="single-add-container">
                            <div class="profile-additions-header">
                                <h1>Metodologia</h1>
                            </div>
                            <div class="profile-additions-body">
                                <p>'.$metodo.'</p>
                            </div>
                        </div>
                        <div class="single-add-container">
                            <div class="profile-additions-header">
                                <h1>Competenze</h1>
                            </div>
                            <div class="profile-additions-body">
                                <ul>
                                    '.$materie.'
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="opinions">
                    <h1>Recensioni su '.$nome.'</h1>
                    <div class = "review-allfather">';
                    
                if($code != "ospite") {
                    echo '<a href="tutor-profile-scrivi-recensione.php?tid='.$tutor_id.'" id="create-app"><div>Scrivi una recensione</div></a>';
                }
                echo '</div>';

            printRecensioni($tutor_id);
        
            echo'
                </div>
            </div>
';
}

function build_area_privata_studente_profile_vetrina(){
    $student_id = $_REQUEST['sid'];

    
    $query = "
        SELECT *
        FROM studente, utente
        WHERE utente.email_utente = studente.email_studente_utente 
            AND utente.email_utente = '" .$student_id. "';
    ";

    $res = select($query);

    //var_dump($res);


    $nome = $res[0]['nome']. " ".$res[0]['cognome'];
    $titolo = $res[0]['short_bio'];
    $informazioni = $res[0]['descrizione'];
    $telefono = $res[0]['telefono'];
    $path_immagine = $res[0]['path_immagine'];


    echo ' 
   <div class="profile-container">
        <div class="profile-header">
            <div class="profile-picture">
                <div class="frame">
                    <img src="'.$path_immagine.'" alt="immagine profilo">
                </div>
            </div>
            <div class="info-container">
                <h1>'.$nome.'</h1>
                <h2><i>'.$titolo.'</i></h2>
            </div>
        </div>
        <div class="profile-body">
            <div class="info-container get-lower">
                <div id="other-info-container">
                    <div class="profile-additions">
                        <div class="single-add-container">
                            <div class="profile-additions-header">
                                <h1>Informazioni su '.$nome.'</h1>
                            </div>
                            <div class="profile-additions-body">
                                <p>'.$informazioni.'</p>
                            </div>
                        </div>
                        <div class="single-add-container">
                                <div class="profile-additions-header">
                                    <h1>Contatti</h1>
                                </div>
                                <div class="profile-additions-body">
                                    <ul>
                                        <li><label for="mail"> Mail: </label name= "mail"><span>'.$student_id.'</span></li>
                                        <li><label for="tel"> Cellulare: </label name= "tel"><span>'.$telefono.'</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
';
}


//FUNZIONE DI RICERCA AVANZATA
function getResults(){
    $ASSubject = register('ASSubject');
    $ASCity = register('ASCity');
    $price_range = register('price-range');
    $star = register('star');


    $code= "";

    $splitted_course = preg_split('/--/', $ASSubject);
    if(count($splitted_course) == 3){
        $code = trim($splitted_course[1]);
    }

    $sql ="
        select utente.nome, utente.cognome, utente.email_utente, comune.nome as citta, competenza_corso.tariffa, utente.path_immagine, avg(valutazione) as media
        from utente, tutor, competenza_corso, comune, corso_studio, recensione
        where utente.email_utente = tutor.email_tutor_utente
        and corso_studio.id_corso_studio = competenza_corso.fk_corso_studio
        and competenza_corso.fk_corso_studio = '".$code."'
        and tutor.email_tutor_utente= competenza_corso.email_tutor
        and utente.fk_comune = comune.id_comune
        and comune.nome = '".$ASCity."'
        and competenza_corso.tariffa <  ".$price_range."
        and recensione.email_tutor = utente.email_utente
        ";
    if(register('ASAct') == 'on')
        $sql.=" and tutor.visita = 1";
    if(register('ASAcs') == 'on')
        $sql.=" and tutor.ospita = 1";
    if(register('ASWc') == 'on')
        $sql.=" and tutor.remoto = 1";
        
	$sql .= " group by email_utente";
	if($star != null)
		$sql.=" having media > ".$star."";


    $res = select($sql);
    for ($i = 0; $i < count($res); $i++){
        $valutazione = round($res[$i]['media']);
        $nome = $res[$i]['nome']. " ".$res[$i]['cognome'];
       echo "
                    <div class='result-container'>
                        <div class = 'result-module'>
                            <div class = 'result-picture'>
                                <img class = 'result-profile-pic' src='".$res[$i]['path_immagine']."' alt='immagine profilo'>
                            </div>
                            <div class = 'result-body'>
                                <div class = 'result-info'>
                                    <span class = 'result-name'>".$nome."</span>
                                    <span class = 'result-city'>".$res[$i]['citta']."</span>
                                    <span class = 'result-money'>".$res[$i]['tariffa']." &euro;/h</span>
                                    <div class = 'result-rating'>";

                                    for($j=0;$j<$valutazione; $j++){
                                        echo "<span class = \"res-star\"></span>";
                                    }
                                    for(;$j<5; $j++){
                                        echo "<span class = 'res-star res-inactive'></span>";
                                    }

       echo "                       </div>  
                                </div>
                            </div>
                            <a href='tutor-profile.php?tid=".$res[$i]['email_utente']."' class = 'result-profile-link'><span>Visita il profilo</span></a>
                        </div>
                    </div>
        ";
    }
}

function getResultsFromQuickSearch(){

    $ASSubject = register('ASSubject');
    $ASCity = register('ASCity');

    $splitted_course = preg_split('/--/', $ASSubject);
    if(count($splitted_course) == 3){
        $code = trim($splitted_course[1]);
    }


    $sql ="
        select utente.nome, utente.cognome, utente.email_utente, comune.nome as citta, utente.path_immagine
        from utente, tutor, competenza_corso, comune, corso_studio
        where utente.email_utente = tutor.email_tutor_utente
        and corso_studio.id_corso_studio = competenza_corso.fk_corso_studio
        and competenza_corso.fk_corso_studio = '".$code."'
        and tutor.email_tutor_utente= competenza_corso.email_tutor
        and utente.fk_comune = comune.id_comune
        and comune.nome = '".$ASCity."'
        ";

    $res = select($sql);
    for ($i = 0; $i < count($res); $i++){
        $query_stelle = "
        select avg(recensione.valutazione) as media
        from recensione
        where email_tutor = '".$res[$i]['email_utente']."'";
        $res_stelle= select($query_stelle);
        $valutazione = round($res_stelle[$i]['media']);
        $nome = $res[$i]['nome']. " ".$res[$i]['cognome'];
        echo "
                    <div class='result-container'>
                        <div class = 'result-module'>
                            <div class = 'result-picture'>
                                <img class = 'result-profile-pic' src='".$res[$i]['path_immagine']."' alt='immagine profilo'>
                            </div>
                            <div class = 'result-body'>
                                <div class = 'result-info'>
                                    <span class = 'result-name'>".$nome."</span>
                                    <span class = 'result-city'>".$res[$i]['citta']."</span>
                                    <span class = 'result-money'>".$res[$i]['tariffa']."</span>
                                    <div class = 'result-rating'>";

                                    for($j=0;$j<$valutazione; $j++){
                                        echo "<span class = 'res-star'></span>";
                                    }
                                    for(;$j<5; $j++){
                                        echo "<span class = 'res-star res-inactive'></span>";
                                    }

       echo "                    
                                    </div>
                                </div>
                            </div>
                            <a href='tutor-profile.php?tid=".$res[$i]['email_utente']."' class = 'result-profile-link'><span>Visita il profilo</span></a>
                        </div>
                    </div>
        ";
    }

}
?> 

