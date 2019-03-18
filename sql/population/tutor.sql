
TRUNCATE TABLE tutor;		

SET FOREIGN_KEY_CHECKS=0;

-- INSERT INTO tutor VALUES (mail_tutor_utente, visita, ospita, remoto, luogo_concordato, insegnante_privato, lezioni_gruppo, metodo, descrizione, fk_corso_laurea, fk_abbonamento);

INSERT INTO tutor VALUES ( 'gino@gmail.com',    0, 1, 0, 1, 0, 1, '', '', 'SC1176', 'mensile');
INSERT INTO tutor VALUES ( 'dina@gmail.com',    1, 0, 1, 0, 1, 0, '', '', 'SC1176', 'mensile');
INSERT INTO tutor VALUES ( 'mirko@gmail.com',   0, 1, 0, 1, 0, 1, '', '', 'FA1732', 'semestrale');
INSERT INTO tutor VALUES ( 'davide@gmail.com' , 1, 0, 1, 0, 1, 0, '', '', 'IN0508', 'annuale');

SET FOREIGN_KEY_CHECKS=1;