/* eslint-env browser */
function showHintLogin(str, name) {
    var myNode = document.getElementById("research-outputs-" + name);
    if (str.length === 0) {
        while (myNode.firstChild) {
            myNode.removeChild(myNode.firstChild);
        }
        myNode.classList.remove("research-outputs-visible");
    } else {

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                myNode.innerHTML = this.responseText;
                myNode.classList.add("research-outputs-visible");
            }
        };
        xmlhttp.open("GET", "getHint.php?q=" + str + "&name=" + name, true);
        xmlhttp.send();
    }
}



function showHintCompetenza(str, name, uni) {
    if(document.getElementById(uni).value == ""){
        alert("Riempire prima il campo precedente");
    }else {
        corso = document.getElementById(uni).value.split('-')[0];
        var myNode = document.getElementById("research-outputs-" + name);
        if (str.length === 0) {
            while (myNode.firstChild) {
                myNode.removeChild(myNode.firstChild);
            }
            myNode.classList.remove("research-outputs-visible");
        } else {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    myNode.innerHTML = this.responseText;
                    myNode.classList.add("research-outputs-visible");
                }
            };
            xmlhttp.open("GET", "getHint.php?q=" + str + "&name=" + name + "&uni=" + corso, true);
            xmlhttp.send();
        }
    }
}

function stayUp(field) {
    if (!(field.value.length==0)) 
        field.classList.add("stay-up");   
    else 
        field.classList.remove("stay-up");
}

function showPsw() {
  var x = document.getElementById("input-password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

//funzione che viene invocata quando l'utente sceglie un opzione dalla lista di opzioni
//se la chiamata viene da un tag con nome ASCity verrà attuato una procedura per ricavare solo il nome della cit
function elementSelected(str, name) {
    if (name === 'ASCity') {
        str = document.getElementById(str).firstChild.innerHTML;
    }
    document.getElementById("input-" + name).value = str;
    showHintLogin("",name);
}

//function hide(str){
//    document.getElementById(str).classList.remove("research-outputs-visible");
//    document.getElementById(str).classList.add("notVisible");
//}


function checkMail(check){
    var email = document.getElementById("input-mail-1");
    if( email.value != check.value){
        check.setCustomValidity("L'indirizzo e-mail deve combaciare!");
    }else{
        check.setCustomValidity("");
    }
}

function toggleOpenMenu() {
    var icon = document.getElementById("menu-icon");
    var navbar = document.getElementById("main-nav");
    document.getElementsByTagName("body")[0].classList.toggle("lock-scroll");
    icon.classList.toggle("open-icon");
    navbar.classList.toggle("visible");
}

function getHintCity(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            myNode.innerHTML = this.responseText;
            myNode.classList.add("research-outputs-visible");
        }
    };
    xmlhttp.open("GET", "getHint.php?q=" + str + "&name=" + name, true);
    xmlhttp.send();
}

function checkIfFinal(pos) {
    var steps = document.getElementsByClassName("form-group").length;
    var fwd = document.getElementById("go-fwd");
    var sub = document.getElementById("go-sub");
    if (pos === steps-1) {
        fwd.style.display = "none";
        sub.style.display = "inline-block";
    } else {
        fwd.style.display = "inline-block";
        sub.style.display = "none";
    }
}

function checkValid(group) {
    var valid = true;
    var fields = group.getElementsByTagName("input");
    for (var i = 0; i < fields.length; i++) {
        if(!fields[i].checkValidity())
            valid = false;
        console.log(fields[i].checkValidity());
    }
    return valid;
}

var activePos = 0;
function moveForm (direction) {
    var groups = document.getElementById("info-container").getElementsByClassName("form-group");
    var progress = document.getElementsByClassName("progress-bar")[0].getElementsByTagName("li");
    if (!checkValid(groups[activePos]) && direction == 1) {
        alert("Completa tutti i campi prima di proseguire!");
        return;
    }
        
    if (direction === -1) {
        switch(activePos) {
            case 0:
                break;
            default:
                groups[activePos].style.display = "none";
                groups[activePos-1].style.display = "block";
                groups[activePos].classList.toggle("active-group");
                groups[activePos-1].classList.toggle("active-group");
                progress[activePos].classList.toggle("active-step");
                progress[activePos-1].classList.toggle("active-step");
                activePos -= 1;
            break;
        }
    } else {
        switch(activePos) {
            case (groups.length - 1):
                break;
            default:
                groups[activePos].style.display = "none";
                groups[activePos+1].style.display = "block";
                groups[activePos].classList.toggle("active-group");
                groups[activePos+1].classList.toggle("active-group");
                progress[activePos].classList.toggle("active-step");
                progress[activePos+1].classList.toggle("active-step");
                activePos += 1;
            break;
        }
    }
    checkIfFinal(activePos);
}

function showPrice(price){
    var showIn = document.getElementById("tariffa");
    if (price == 0) {
        showIn.innerHTML = "GRATIS";
    }else if (price == 100) {
        showIn.innerHTML = "Qualsiasi";
    }else{
        showIn.innerHTML = price-(price%5) + " € l'ora.";
    }
}

function minRatingChoosed(id){
    var ratingHovered  = id.split("-");
    document.getElementById("minRatingChoice").value = ratingHovered[1];
}