<?php

/**
 * @param $document
 */
if(isset($_SESSION['TYPE'])){
    $type = $_SESSION['TYPE'];
    if($type == 'tutor'){
        $personalArea = 'personal-area-tutor-profile.php';
    }else{
        $personalArea = 'personal-area-studente-profile.php';
    }
    $login = '<a href="logout.php" id = "login-link"><div>logout</div></a>';
    $loginFooter = 'logout.php';
}else{
    $personalArea = 'login.php';
    $login = '<a href="login.php" id = "login-link"><div>login</div></a>';
    $loginFooter = 'login.php';
}

function injectNavbar($document){
    global $personalArea;
    global $login;

        switch ($document){
            case "index":
                echo '<div id = "navbar">
                        <picture id="logo-container">
                            <source srcset="../images/navbar/logo-icon.svg" media="screen and (max-width: 768px)"/>
                            <img id="logo" src="../images/navbar/logo-full.svg" alt="TutorMeister">
                        </picture>
                        <div id="main-nav" class="hidden">
                            <div class = "nav-link-active">  <a href="#">home</a></div>
                            <div class = "nav-link">  <a href="ricerca_avanzata.php">cerca</a></div>
                            <div class = "nav-link">  <a href="sign-up.php">iscriviti</a></div>
                            <div class = "nav-link">  <a href="'.$personalArea.'">Area privata</a></div>
                            '.$login.'
                        </div>
                        <button id = "menu-icon" aria-label="icona menù" onclick="toggleOpenMenu()"><div></div></button>
                    </div>';
                break;
            case "ricerca":
                echo '<div id = "navbar">
                        <picture id="logo-container">
                            <source srcset="../images/navbar/logo-icon.svg" media="screen and (max-width: 768px)"/>
                            <img id="logo" src="../images/navbar/logo-full.svg" alt="TutorMeister">
                        </picture>
                        <div id="main-nav" class="hidden">
                            <div class = "nav-link">  <a href="index.php">home</a></div>
                            <div class = "nav-link-active">  <a href="#">cerca</a></div>
                            <div class = "nav-link">  <a href="sign-up.php">iscriviti</a></div>
                            <div class = "nav-link">  <a href="' .$personalArea.'">Area privata</a></div>
                            '.$login.'
                        </div>
                        <button id = "menu-icon" aria-label="icona menù"  onclick="toggleOpenMenu()"><div></div></button>
                    </div>';
                break;
            case "Area privata":
                echo '<div id = "navbar">
                        <picture id="logo-container">
                            <source srcset="../images/navbar/logo-icon.svg" media="screen and (max-width: 768px)"/>
                            <img id="logo" src="../images/navbar/logo-full.svg" alt="TutorMeister">
                        </picture>
                        <div id="main-nav" class="hidden">
                            <div class = "nav-link">  <a href="index.php">home</a></div>
                            <div class = "nav-link">  <a href="ricerca_avanzata.php">cerca</a></div>
                            <div class = "nav-link">  <a href="sign-up.php">iscriviti</a></div>
                            <div class = "nav-link-active">  <a href="' .$personalArea.'">Area privata</a></div>
                            '.$login.'
                        </div>
                        <button id = "menu-icon" aria-label="icona menù"  onclick="toggleOpenMenu()"><div></div></button>
                    </div>';
                break;
            case "signup":
                echo '<div id = "navbar">
                        <picture id="logo-container">
                            <source srcset="../images/navbar/logo-icon.svg" media="screen and (max-width: 768px)"/>
                            <img id="logo" src="../images/navbar/logo-full.svg" alt="TutorMeister">
                        </picture>
                        <div id="main-nav" class="hidden">
                            <div class = "nav-link">  <a href="index.php">home</a></div>
                            <div class = "nav-link">  <a href="ricerca_avanzata.php">cerca</a></div>
                            <div class = "nav-link-active">  <a href="#">iscriviti</a></div>
                            <div class = "nav-link">  <a href="' .$personalArea.'">Area privata</a></div>
                            '.$login.'
                        </div>
                        <button id = "menu-icon" aria-label="icona menù"  onclick="toggleOpenMenu()"><div></div></button>
                    </div>';
                break;
            default:
                echo '<div id = "navbar">
                        <picture id="logo-container">
                            <source srcset="../images/navbar/logo-icon.svg" media="screen and (max-width: 768px)"/>
                            <img id="logo" src="../images/navbar/logo-full.svg" alt="TutorMeister">
                        </picture>
                        <div id="main-nav" class="hidden">
                            <div class = "nav-link">  <a href="index.php">home</a></div>
                            <div class = "nav-link">  <a href="ricerca_avanzata.php">cerca</a></div>
                            <div class = "nav-link">  <a href="sign-up.php">iscriviti</a></div>
                            <div class = "nav-link">  <a href="' .$personalArea.'">Area privata</a></div>
                            '.$login.'
                        </div>
                        <button id = "menu-icon" aria-label="icona menù"  onclick="toggleOpenMenu()"><div></div></button>
                    </div>';
                break;
            case "profile":
                echo '<div id = "navbar">
                        <picture id="logo-container">
                            <source srcset="../images/navbar/logo-icon.svg" media="screen and (max-width: 768px)"/>
                            <img id="logo" src="../images/navbar/logo-full.svg" alt="TutorMeister">
                        </picture>
                        <div id="main-nav" class="hidden">
                            <div class = "nav-link">  <a href="index.php">home</a></div>
                            <div class = "nav-link-active">  <a href="ricerca_avanzata.php">cerca</a></div>
                            <div class = "nav-link">  <a href="sign-up.php">iscriviti</a></div>
                            <div class = "nav-link">  <a href="' .$personalArea.'">Area privata</a></div>
                            '.$login.'
                        </div>
                        <button id = "menu-icon" aria-label="icona menù" onclick="toggleOpenMenu()"><div></div></button>
                    </div>';
                break;
        }
    }

function injectMenuPersonalArea($document){

    switch ($document){
        case "profilo":
            echo '<div id = "header-lower">
                <div id = "pa-links-container"> 
                        <a  href="#" class = "pa-nav-link pa-nl-active"><div>Profilo</div></a>
                        <a  href="personal-area-tutor-alunni.php" class = "pa-nav-link"><div>Alunni</div></a>
                        <a  href="personal-area-tutor-appuntamenti.php" class = "pa-nav-link"><div>Agenda</div></a>
                        <a  href="personal-area-tutor-settings.php" class = "pa-nav-link"><div>Opzioni</div></a>
                </div>
            </div>';
            break;
        case "agenda":
            echo '<div id = "header-lower">
                <div id = "pa-links-container"> 
                        <a  href="personal-area-tutor-profile.php"" class = "pa-nav-link"><div>Profilo</div></a>
                        <a  href="personal-area-tutor-alunni.php" class = "pa-nav-link"><div>Alunni</div></a>
                        <a  href="#" class = "pa-nav-link pa-nl-active"><div>Agenda</div></a>
                        <a  href="personal-area-tutor-settings.php" class = "pa-nav-link"><div>Opzioni</div></a>
                </div>
            </div>';
            break;
        case "alunni":
            echo '<div id = "header-lower">
                <div id = "pa-links-container"> 
                        <a  href="personal-area-tutor-profile.php"" class = "pa-nav-link"><div>Profilo</div></a>
                        <a  href="#" class = "pa-nav-link pa-nl-active"><div>Alunni</div></a>
                        <a  href="personal-area-tutor-appuntamenti.php" class = "pa-nav-link"><div>Agenda</div></a>
                        <a  href="personal-area-tutor-settings.php" class = "pa-nav-link"><div>Opzioni</div></a>
                </div>
            </div>';
            break;
        case "settings":
            echo '<div id = "header-lower">
                <div id = "pa-links-container"> 
                        <a  href="personal-area-tutor-profile.php"" class = "pa-nav-link"><div>Profilo</div></a>
                        <a  href="personal-area-tutor-alunni.php" class = "pa-nav-link"><div>Alunni</div></a>
                        <a  href="personal-area-tutor-appuntamenti.php" class = "pa-nav-link"><div>Agenda</div></a>
                        <a  href="#" class = "pa-nav-link pa-nl-active"><div>Opzioni</div></a>
                </div>
            </div>';
            break;
        default:
            echo '<div id = "header-lower">
                <div id = "pa-links-container"> 
                        <a  href="personal-area-tutor-profile.php"" class = "pa-nav-link"><div>Profilo</div></a>
                        <a  href="personal-area-tutor-alunni.php" class = "pa-nav-link"><div>Alunni</div></a>
                        <a  href="personal-area-tutor-appuntamenti.php" class = "pa-nav-link"><div>Agenda</div></a>
                        <a  href="personal-area-tutor-settings.php" class = "pa-nav-link"><div>Opzioni</div></a>
                </div>
            </div>';
            break;
    }
}

function injectStudentMenuPersonalArea($document){

    switch ($document){
        case "profilo":
            echo '<div id = "header-lower">
                <div id = "pa-links-container" class="student"> 
                        <a  href="#" class = "pa-nav-link pa-nl-active"><div>Profilo</div></a>
                        <a  href="personal-area-studente-appuntamenti.php" class = "pa-nav-link"><div>Agenda</div></a>
                        <a  href="personal-area-studente-settings.php" class = "pa-nav-link"><div>Opzioni</div></a>
                </div>
            </div>';
            break;
        case "agenda":
            echo '<div id = "header-lower">
                <div id = "pa-links-container" class="student"> 
                        <a  href="personal-area-studente-profile.php"" class = "pa-nav-link"><div>Profilo</div></a>
                        <a  href="#" class = "pa-nav-link pa-nl-active"><div>Agenda</div></a>
                        <a  href="personal-area-studente-settings.php" class = "pa-nav-link"><div>Opzioni</div></a>
                </div>
            </div>';
            break;
        case "settings":
            echo '<div id = "header-lower">
                <div id = "pa-links-container" class="student"> 
                        <a  href="personal-area-studente-profile.php"" class = "pa-nav-link"><div>Profilo</div></a>
                        <a  href="personal-area-studente-appuntamenti.php" class = "pa-nav-link"><div>Agenda</div></a>
                        <a  href="#" class = "pa-nav-link pa-nl-active"><div>Opzioni</div></a>
                </div>
            </div>';
            break;
        default:
            echo '<div id = "header-lower">
                <div id = "pa-links-container" class="student"> 
                        <a  href="personal-area-studente-profile.php"" class = "pa-nav-link"><div>Profilo</div></a>
                        <a  href="personal-area-studente-appuntamenti.php" class = "pa-nav-link"><div>Agenda</div></a>
                        <a  href="personal-area-studente-settings.php" class = "pa-nav-link"><div>Opzioni</div></a>
                </div>
            </div>';
            break;
    }
}

function injectFooter(){
    global $personalArea;
    global $loginFooter;
    echo "
        <footer>
            <div id= 'footer-container'>
                <div class='footer-section'>
                    <h1> Naviga il sito </h1>
                    <div id='naviga-sito-icon'>
                        <a class='mini-menu-item' aria-label='icona home' href='index.php'><span class='mini-menu-item home-footer' title='Home'></span></a>
                        <a class='mini-menu-item' aria-label='icona ricerca avanzata' href='ricerca_avanzata.php'><span class='mini-menu-item ricerca-footer' title='Cerca'></span></a>
                        <a class='mini-menu-item' aria-label='icona sign-up' href='sign-up.php'><span class='mini-menu-item sign-up-footer' title='Iscriviti'></span></a>
                        <a class='mini-menu-item' aria-label='icona area personale' href='" .$personalArea."'><span class='mini-menu-item area-personale-footer' title='Area privata'></span></a>
                        <a class='mini-menu-item' aria-label='icona login' href='".$loginFooter."'><span class='mini-menu-item login-footer' title='Login'></span></a>
                        <a class='mini-menu-item' aria-label='icona torna su' href='#navbar'><span class='mini-menu-item torna-su-footer' title='Torna su'></span></a>
                    </div>
                </div>
                <div class='footer-section info'>
                    <h1> Contatti </h1>
                    <span class='info-point-item'>Telefono: +39 0123456789</span>
                    <span class='info-point-item'>Fax: +39 9876543210</span>
                    <span class='info-point-item'><a href='mailto:info@tutormeister.com' title='info@tutormeister.com'>Scrivi agli sviluppatori</a></span>
                </div>
                <div class='footer-section'>
                    <h1> Gli sviluppatori </h1>
                    <div id='naviga-sito'>
                        <a class='mini-menu-item' href='https://www.linkedin.com/in/gianmarco-santi-a52446148/'><img src='../images/footer/gian.jpg' alt='Sviluppatore: Gianmarco Santi' title='Gianmarco Santi' class='developer'/></a>
                        <a class='mini-menu-item' href='https://www.linkedin.com/in/nictartaggia/'><img src='../images/footer/nic.jpg' alt='Sviluppatore: Nicolò Tartaggia' title='Nicolò Tartaggia' class='developer'/></a>
                        <a class='mini-menu-item' href='https://www.linkedin.com/in/andrea-trevisin-1b9622154/'><img src='../images/footer/andrea.jpg' alt='Sviluppatore: Andrea Trevisin' title='Andrea Trevisin' class='developer'/></a>
                        <a class='mini-menu-item' href='https://www.linkedin.com/in/cvoinea/'><img src='../images/footer/cip.jpg' alt='Sviluppatore: Ciprian Voinea' title='Ciprian Voinea' class='developer'/></a>
                    </div>
                </div>
            </div>
            <div class='last-thing'>
                <img src='../images/logo2.svg' alt='Logo del sito'/>
                <span>© TutorMeister 2018</span>
            </div>
        </footer>
        ";
}
?>



