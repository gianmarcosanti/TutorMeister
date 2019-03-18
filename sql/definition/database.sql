SET FOREIGN_KEY_CHECKS=0;

-- Lista regioni italiane
-- INSERT INTO regione VALUES (id_regione, nome);
DROP TABLE IF EXISTS regione;
CREATE TABLE regione(

	id_regione			VARCHAR(2) PRIMARY KEY,
	nome				VARCHAR(40) NOT NULL 

) ENGINE=InnoDB;

-- Lista provincie italiane
-- INSERT INTO provincia VALUES (id_provincia, nome, fk_regione);
DROP TABLE IF EXISTS provincia;
CREATE TABLE provincia(

	id_provincia		VARCHAR(3) PRIMARY KEY,
	nome				VARCHAR(40) NOT NULL,
	fk_regione			VARCHAR(40) NOT NULL,

	FOREIGN KEY (fk_regione) REFERENCES regione(id_regione)

) ENGINE=InnoDB;

-- Lista comuni italiani
-- INSERT INTO comune VALUES (id_comune, nome, fk_provincia);
DROP TABLE IF EXISTS comune;
CREATE TABLE comune(

	id_comune			VARCHAR(6) PRIMARY KEY,
	nome				VARCHAR(40) NOT NULL,
	fk_provincia		VARCHAR(40) NOT NULL,

	FOREIGN KEY (fk_provincia) REFERENCES provincia(id_provincia)

) ENGINE=InnoDB;

-- Lista degli utenti registrati
-- INSERT INTO utente VALUES (email_utente, email_verifica, password, data_registrazione, path_immagine, nome, cognome, data_nascita, telefono, fk_comune , cap, via, short_bio, is_tutor);
DROP TABLE IF EXISTS utente;
CREATE TABLE utente (

	email_utente		VARCHAR(40) PRIMARY KEY,
	email_verifica		BIT NOT NULL DEFAULT 0,
	
	password			VARCHAR(255) NOT NULL,

	data_registrazione 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

	path_immagine		VARCHAR(100) NOT NULL DEFAULT '../images/boss.png', 

	nome				VARCHAR(30) NOT NULL,
	cognome				VARCHAR(30) NOT NULL,
	data_nascita		DATE NOT NULL,

	telefono			VARCHAR(10),
	fk_comune			VARCHAR(6),
	cap					VARCHAR(5),
	via					VARCHAR(60),

	short_bio			VARCHAR(200),
	is_tutor			BIT NOT NULL DEFAULT 0,

	FOREIGN KEY (fk_comune) REFERENCES comune(id_comune)

) ENGINE=InnoDB;

-- Lista degli utenti registrati come studente
-- INSERT INTO studente VALUES (email_studente_utente, anno_iscrizione, matricola, descrizione, fk_corso_laurea);
DROP TABLE IF EXISTS studente;
CREATE TABLE studente (

	email_studente_utente	VARCHAR(40) PRIMARY KEY,

	anno_iscrizione			SMALLINT NOT NULL DEFAULT 1,
	matricola				VARCHAR(15),

	descrizione				VARCHAR(2000),

	fk_corso_laurea			VARCHAR(8) NOT NULL,

	FOREIGN KEY (email_studente_utente) REFERENCES utente(email_utente),
	FOREIGN KEY (fk_corso_laurea) REFERENCES corso_laurea(id_corso_laurea)

) ENGINE=InnoDB;

-- Lista degli utenti registrati come tutor
-- INSERT INTO tutor VALUES (email_tutor_utente, visita, ospita, remoto, luogo_concordato, insegnante_privato, lezioni_gruppo, metodo, descrizione, fk_corso_laurea, fk_abbonamento);
DROP TABLE IF EXISTS tutor;
CREATE TABLE tutor (

	email_tutor_utente		VARCHAR(40) PRIMARY KEY,

	visita					BIT NOT NULL DEFAULT 0,
	ospita					BIT NOT NULL DEFAULT 0,
	remoto					BIT NOT NULL DEFAULT 0,

	luogo_concordato		BIT NOT NULL DEFAULT 0,

	insegnante_privato		BIT NOT NULL DEFAULT 0,
	lezioni_gruppo			BIT NOT NULL DEFAULT 0,

	metodo					VARCHAR(2000),

	descrizione				VARCHAR(2000),

	fk_corso_laurea			VARCHAR(8),
	fk_abbonamento			VARCHAR(20),
	
	FOREIGN KEY (email_tutor_utente) REFERENCES utente(email_utente),
	FOREIGN KEY (fk_corso_laurea) REFERENCES corso_laurea(id_corso_laurea),
	FOREIGN KEY (fk_abbonamento) REFERENCES abbonamento(cadenza)

) ENGINE=InnoDB ;

-- Lista allievi con tutor
-- INSERT INTO allievo VALUES (email_studente, email_tutor);
DROP TABLE IF EXISTS allievo;
CREATE TABLE allievo ( 

	email_studente			VARCHAR(40) NOT NULL,
	email_tutor				VARCHAR(40) NOT NULL,

	FOREIGN KEY (email_tutor) REFERENCES tutor(email_tutor_utente),
	FOREIGN KEY (email_studente) REFERENCES studente(email_studente_utente),

	PRIMARY KEY (email_tutor, email_studente)

) ENGINE=InnoDB ;

-- Lista universita in Italia
-- INSERT INTO universita (id_universita, nome, descrizione, sito, telefono, fax, fk_provincia, cap, sede);
DROP TABLE IF EXISTS universita;
CREATE TABLE universita (

	id_universita		VARCHAR(15) PRIMARY KEY,

	nome				VARCHAR(100) NOT NULL,
	descrizione			VARCHAR(5000),

	sito				VARCHAR(30),

	telefono			VARCHAR(20) NOT NULL,
	fax					VARCHAR(40),

	fk_provincia		VARCHAR(3) NOT NULL,
	cap					VARCHAR(10) NOT NULL,
	sede				VARCHAR(50) NOT NULL,

	FOREIGN KEY (fk_provincia) REFERENCES provincia(id_provincia)

) ENGINE=InnoDB ;

-- Lista scuole di ciascuna universita
-- INSERT INTO scuola (id_scuola, nome, fk_universita);
DROP TABLE IF EXISTS scuola;
CREATE TABLE scuola(

	id_scuola			VARCHAR(8) PRIMARY KEY,

	nome				VARCHAR(50) NOT NULL,

	fk_universita		VARCHAR(8) NOT NULL,

	FOREIGN KEY (fk_universita) REFERENCES universita(id_universita)

) ENGINE=InnoDB; 

-- Lista corsi di laurea di ciascuna scuola
-- INSERT INTO corso_laurea (id_corso_laurea, anno_erogazione, nome, durata_anni, tipologia, lingua, fk_scuola);
DROP TABLE IF EXISTS corso_laurea;
CREATE TABLE corso_laurea (

	id_corso_laurea		VARCHAR(6) PRIMARY KEY,

	anno_erogazione		SMALLINT(4),

	nome				VARCHAR(200) NOT NULL,
	durata_anni			SMALLINT(1),

	tipologia			VARCHAR(7),			
	lingua				VARCHAR(20),

	fk_scuola			VARCHAR(8) NOT NULL,

	FOREIGN KEY (fk_scuola) REFERENCES scuola(id_scuola)

) ENGINE=InnoDB;

-- Lista corsi di studio di ciascun corso di laurea 
-- INSERT INTO corso_studio (id_corso_studio, nome, crediti, anno_erogazione, semestre, lingua, fk_corso_laurea);
DROP TABLE IF EXISTS corso_studio;
CREATE TABLE corso_studio (

	id_corso_studio		VARCHAR(10),

	nome				VARCHAR(150) NOT NULL,
	crediti				SMALLINT(2) DEFAULT 0,
	anno_erogazione		VARCHAR(4),
	semestre			VARCHAR(30),
	lingua 				VARCHAR(20),

	fk_corso_laurea		VARCHAR(8) NOT NULL,

	FOREIGN KEY (fk_corso_laurea) REFERENCES corso_laurea(id_corso_laurea),
	PRIMARY KEY (id_corso_studio, fk_corso_laurea)

) ENGINE=InnoDB;

-- Lista dei corsi in cui un tutor è competente e da la sua disponibilità
-- INSERT INTO competenza_corso VALUES (id_competenza_corso, descrizione, tariffa, email_tutor, fk_corso_studio);
DROP TABLE IF EXISTS competenza_corso;
CREATE TABLE competenza_corso (

	id_competenza_corso	INT AUTO_INCREMENT PRIMARY KEY,

	tariffa				SMALLINT NOT NULL,
	descrizione			VARCHAR(500),	

	email_tutor			VARCHAR(40) NOT NULL,
	fk_corso_studio		VARCHAR(10) NOT NULL,

	CONSTRAINT singola_competenza UNIQUE (email_tutor, fk_corso_studio),

	FOREIGN KEY (email_tutor) REFERENCES tutor(email_tutor_utente),
	FOREIGN KEY (fk_corso_studio) REFERENCES corso_studio(id_corso_studio)

) ENGINE=InnoDB;

-- INSERT INTO appuntamento VALUES (id_appuntamento, data, ora_inizio, durata, descrizione, tipo, location, email_studente, email_tutor, fk_competenza_corso);
DROP TABLE IF EXISTS appuntamento;
CREATE TABLE appuntamento (

	id_appuntamento			INT AUTO_INCREMENT PRIMARY KEY,
	
	data 					DATE NOT NULL,
	ora_inizio				TIME NOT NULL,
	durata					INT NOT NULL DEFAULT 1,
	descrizione				VARCHAR(500),
	
	tipo					VARCHAR(10),							-- Visita, remoto, ecc
	
	location				VARCHAR(100),

	email_studente			VARCHAR(40) NOT NULL,
	email_tutor				VARCHAR(40) NOT NULL,
	fk_competenza_corso		INT NOT NULL,

	FOREIGN KEY (email_studente) REFERENCES studente(email_studente_utente),
	FOREIGN KEY (email_tutor) REFERENCES tutor(email_tutor_utente),
	FOREIGN KEY (fk_competenza_corso) REFERENCES competenza_corso(id_competenza_corso),

	CONSTRAINT singolo_appuntamento UNIQUE (email_tutor, data, ora_inizio)

) ENGINE=InnoDB;

-- Lista delle recensioni che uno studente può lasciare ad un tutor
-- INSERT INTO recensione VALUES (id_recensione, data, valutazione, motivazione, email_studente, email_tutor);
DROP TABLE IF EXISTS recensione;
CREATE TABLE recensione (

	id_recensione			INT AUTO_INCREMENT PRIMARY KEY,

	data 					TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	valutazione				TINYINT NOT NULL,
	motivazione				VARCHAR(500),

	email_studente			VARCHAR(40) NOT NULL,
	email_tutor				VARCHAR(40) NOT NULL,

	FOREIGN KEY (email_studente) REFERENCES studente(email_studente_utente),
	FOREIGN KEY (email_tutor) REFERENCES tutor(email_tutor_utente)

) ENGINE=InnoDB;

-- Lista degli abbonamenti fra cui possono scegliere i tutor
-- INSERT INTO abbonamento VALUES (cadenza, descrizione, tariffa);
DROP TABLE IF EXISTS abbonamento;
CREATE TABLE abbonamento(

	cadenza				VARCHAR(20) PRIMARY KEY,
	descrizione			VARCHAR(500),
	tariffa				DECIMAL(5,2)

) ENGINE=InnoDB;

ALTER TABLE abbonamento CONVERT TO CHARACTER SET utf8;
ALTER TABLE allievo CONVERT TO CHARACTER SET utf8;
ALTER TABLE appuntamento CONVERT TO CHARACTER SET utf8;
ALTER TABLE competenza_corso CONVERT TO CHARACTER SET utf8;
ALTER TABLE comune CONVERT TO CHARACTER SET utf8;
ALTER TABLE corso_laurea CONVERT TO CHARACTER SET utf8;
ALTER TABLE corso_studio CONVERT TO CHARACTER SET utf8;
ALTER TABLE provincia CONVERT TO CHARACTER SET utf8;
ALTER TABLE recensione CONVERT TO CHARACTER SET utf8;
ALTER TABLE regione CONVERT TO CHARACTER SET utf8;
ALTER TABLE scuola CONVERT TO CHARACTER SET utf8;
ALTER TABLE studente CONVERT TO CHARACTER SET utf8;
ALTER TABLE tutor CONVERT TO CHARACTER SET utf8;
ALTER TABLE universita CONVERT TO CHARACTER SET utf8;
ALTER TABLE utente CONVERT TO CHARACTER SET utf8;

SET FOREIGN_KEY_CHECKS=1;


