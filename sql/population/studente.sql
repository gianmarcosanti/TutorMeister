DELETE FROM studente;		

SET FOREIGN_KEY_CHECKS=0;

-- INSERT INTO studente VALUES (email_studente_utente, anno_iscrizione, matricola, descrizione, fk_corso_laurea);

INSERT INTO studente VALUES ( 'luca@gmail.com', 2018, '01234', '', 'FA1732');
INSERT INTO studente VALUES ( 'matteo@gmail.com', 2016, '01234', '', 'SC1159');
INSERT INTO studente VALUES ( 'simone@gmail.com', 2014, '01234', '', 'SC1176');
INSERT INTO studente VALUES ( 'paolo@gmail.com', 2017, '01234', '', 'IN0508');

SET FOREIGN_KEY_CHECKS=0;