<html>
<body>
<?php
    include_once 'conf.php';
	// Run query
	$q ='';
    $name= '';
    $uni= '';
	if(isset($_REQUEST["q"])){
		$q = $_REQUEST["q"];
		$name = $_REQUEST["name"];
	}

    if(isset($_REQUEST["uni"])){
        $uni = $_REQUEST["uni"];
    }

	$hint = "";

	// lookup all hints from array if $q is different from "" 
	if ($q !== "") {
	    $q = strtolower($q);
	    $len=strlen($q);
	    switch ($name) {
	    	case 'ASSubject':
	    		$sql = "SELECT  id_corso_studio, sub1.nome as nome_corso, corso_laurea.nome as nome_laurea FROM corso_laurea join (select * from corso_studio where nome like '%$q%') as sub1 on corso_laurea.id_corso_laurea = sub1.fk_corso_laurea";
                $res = select($sql);
                if(count($res)>0) {
                    for ($i = 0; $i < count($res) - 1; $i++) {
				        $hint .= '<a name= "'.utf8_encode($name).'" href= "#" onclick="elementSelected(this.innerHTML, this.name)" class= "notLast">'.utf8_encode($res[$i]["nome_corso"]).' -- '.utf8_encode($res[$i]["id_corso_studio"]).'-- '.utf8_encode($res[$i]["nome_laurea"]).'</a>';
				    }
				    $hint .= '<a name= "'.utf8_encode($name).'" href= "#" class= "" onclick="elementSelected(this.innerHTML,this.name)">'.utf8_encode($res[$i]["nome_corso"]).'-- '.utf8_encode($res[$i]["id_corso_studio"]).'-- '.utf8_encode($res[$i]["nome_laurea"]).'</a>';
				} 
	    		break;
	    	case 'ASCity':
	    		$sql = "SELECT comune.nome as com, provincia.nome as prov, regione.nome as reg FROM comune join (provincia join regione on provincia.fk_regione = regione.id_regione) on fk_provincia = provincia.id_provincia and comune.nome like '%".$q."%'";
                $res = select($sql);
                if(count($res)>0) {
                    for ($i = 0; $i < count($res) - 1; $i++) {
				        $hint .= '<a id="responseNumber-'.$i.'" name= "'.utf8_encode($name).'" href= "#" onclick="elementSelected(this.id, this.name)" class= "notLast"><h1>'.utf8_encode($res[$i]["com"]).'</h1><h2>'.utf8_encode($res[$i]["prov"]).' - '.utf8_encode($res[$i]["reg"]).'</h2></a>';
				    }
				    $hint .= '<a id="responseNumber-'.$i.'" name= "'.utf8_encode($name).'" href= "#" onclick="elementSelected(this.id, this.name)" class= ""><h1>'.utf8_encode($res[$i]["com"]).'</h1><h2>'.utf8_encode($res[$i]["prov"]).' - '.utf8_encode($res[$i]["reg"]).'</h2></a>';
				} 
	    		break;
            case 'ACUni':
                $sql = "
	    		    select id_universita, nome
                    from universita
                    where nome like '%".$q."%' or id_universita like '%".$q."%'
	    		";
                $res = select($sql);
                if(count($res)>0) {
                    for($i = 0 ; $i < count($res)-1; $i++){
                        $hint .= '<a id="'.utf8_encode($res[$i]['id_universita']).'" name= "'.utf8_encode($name).'" onclick="elementSelected(this.innerHTML,this.name)" class= "notLast">'.utf8_encode($res[$i]["id_universita"]).'-'.utf8_encode($res[$i]["nome"]).'</a>';
                    }
                    $hint .= '<a id="'.utf8_encode($res[$i]['id_universita']).'" name= "'.utf8_encode($name).'" onclick="elementSelected(this.innerHTML,this.name)" >'.utf8_encode($res[$i]["id_universita"]).'-'.utf8_encode($res[$i]["nome"]).'</a>';
                }
                 break;
            case 'ACCorso_di_laurea':
                $sql = "
                        select corso_laurea.nome, corso_laurea.id_corso_laurea from  scuola, corso_laurea
                        where scuola.fk_universita = '".$uni."'
                        and corso_laurea.fk_scuola = scuola.id_scuola
                        and corso_laurea.nome like '%".$q."%'
                    ";
                $res = select($sql);
                 if(count($res)>0) {
                     for ($i = 0; $i < count($res) - 1; $i++) {
                         $hint .= '<a id="' . utf8_encode($res[$i]['id_corso_laurea']) . '" name= "' .utf8_encode( $name ). '" onclick="elementSelected(this.innerHTML,this.name)" class= "notLast">' .utf8_encode( $res[$i]["id_corso_laurea"]) . '-' . utf8_encode($res[$i]["nome"]) . '</a>';
                     }
                     $hint .= '<a id="' . utf8_encode($res[$i]['id_corso_laurea']). '" name= "' . utf8_encode($name). '" onclick="elementSelected(this.innerHTML,this.name)" >' . utf8_encode($res[$i]["id_corso_laurea"]). '-' . utf8_encode($res[$i]["nome"]) . '</a>';
                 }break;
            case 'ACCorso_di_studio':
                $sql = "
                        select corso_studio.id_corso_studio, corso_studio.nome
                        from corso_studio
                        where corso_studio.fk_corso_laurea = '".$uni."'
                        and corso_studio.nome like '%".$q."%';
                    ";
                $res = select($sql);
                if(count($res)>0) {
                    for ($i = 0; $i < count($res) - 1; $i++) {
                        $hint .= '<a id="' . utf8_encode($res[$i]['id_corso_studio']) . '" name= "' .utf8_encode( $name) . '" onclick="elementSelected(this.innerHTML,this.name)" class= "notLast">' .utf8_encode( $res[$i]["id_corso_studio"]). '-' . utf8_encode($res[$i]["nome"]) . '</a>';
                    }
                    $hint .= '<a id="' . utf8_encode($res[$i]['id_corso_studio']) . '" name= "' . utf8_encode($name) . '" onclick="elementSelected(this.innerHTML,this.name)" >' . utf8_encode($res[$i]["id_corso_studio"]). '-' . utf8_encode($res[$i]["nome"]) . '</a>';
                }break;
            case 'CAMateria':
                $sql = "
                    select corso_studio.id_corso_studio, corso_studio.nome
                    from competenza_corso, corso_studio
                    where competenza_corso.email_tutor= '".$_SESSION['ID']."'
                    and competenza_corso.fk_corso_studio = corso_studio.id_corso_studio
                    and corso_studio.nome like '%".$q."%'
	    		";
                $res = select($sql);
                if(count($res)>0) {
                    for ($i = 0; $i < count($res) - 1; $i++) {
                        $hint .= '<a id="' . utf8_encode($res[$i]['id_corso_studio']) . '" name= "' . utf8_encode($name) . '" onclick="elementSelected(this.innerHTML,this.name)" class= "notLast">' . utf8_encode($res[$i]["id_corso_studio"]) . '-' . utf8_encode($res[$i]["nome"]) . '</a>';
                    }
                    $hint .= '<a id="' . utf8_encode($res[$i]['id_corso_studio']) . '" name= "' . utf8_encode($name) . '" onclick="elementSelected(this.innerHTML,this.name)" >' . utf8_encode($res[$i]["id_corso_studio"]) . '-' . utf8_encode($res[$i]["nome"]) . '</a>';
                }break;
            case 'CAStudente':
                $sql = "
	    		    select  utente.nome, utente.cognome, utente.email_utente from studente, allievo, utente
                    where studente.email_studente_utente = allievo.email_studente
                    and allievo.email_tutor = '".$_SESSION['ID']."'
                    and studente.email_studente_utente = utente.email_utente
                    and (utente.nome like '%".$q."%'
                    or utente.cognome like '%".$q."%');
	    		";
                $res = select($sql);
                if(count($res)>0) {
                    for ($i = 0; $i < count($res) - 1; $i++) {
                        $hint .= '<a id="' . utf8_encode($res[$i]['nome']) . utf8_encode($res[$i]['cognome']) . '" name= "' . utf8_encode($name) . '" onclick="elementSelected(this.innerHTML,this.name)" class= "notLast">' . utf8_encode($res[$i]["cognome"]) . ' ' . utf8_encode($res[$i]["nome"]) . ' (' . utf8_encode($res[$i]['email_utente']) . ')' . '</a>';
                    }
                    $hint .= '<a id="' . utf8_encode($res[$i]['nome']) . utf8_encode($res[$i]['cognome']) . '" name= "' . utf8_encode($name) . '" onclick="elementSelected(this.innerHTML,this.name)" >' . utf8_encode($res[$i]["cognome"]) . ' ' . utf8_encode($res[$i]["nome"]) . ' (' . utf8_encode($res[$i]['email_utente']) . ')' . '</a>';
                }
                break;
	    	default:
	    		break;
	    }
	}

	// Output "no suggestion" if no hint was found or output correct values 
	echo $hint === "" ? "no suggestion" : $hint;
	$conn->close();
?>
</body>
</html>
