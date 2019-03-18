DELETE FROM competenza_corso;

SET FOREIGN_KEY_CHECKS=0;

-- INSERT INTO competenza_corso VALUES (id_competenza_corso, descrizione, tariffa, email_tutor, fk_corso_studio);

INSERT INTO competenza_corso (descrizione, tariffa, email_tutor, fk_corso_studio) 
VALUES ('Passato con 30L', 15, 'davide@gmail.com', 'IN04111234');

INSERT INTO competenza_corso (descrizione, tariffa, email_tutor, fk_corso_studio) 
VALUES ('Corso affine ad uno in cui ho preso 30L', 17, 'davide@gmail.com', 'SC02121720');

INSERT INTO competenza_corso (descrizione, tariffa, email_tutor, fk_corso_studio) 
VALUES ('Passato con 30L', 15, 'davide@gmail.com', 'INP8084324');

INSERT INTO competenza_corso (descrizione, tariffa, email_tutor, fk_corso_studio) 
VALUES ('Passato con 26', 12, 'dina@gmail.com', 'SC01122464');

INSERT INTO competenza_corso (descrizione, tariffa, email_tutor, fk_corso_studio) 
VALUES ('Passato con 26', 10, 'dina@gmail.com', 'SCP4063959');

INSERT INTO competenza_corso (descrizione, tariffa, email_tutor, fk_corso_studio) 
VALUES ('Sono appassionata di matematica ed ho passato analisi con un ottimo voto!', 15, 'dina@gmail.com', 'SCN1036952');

INSERT INTO competenza_corso (descrizione, tariffa, email_tutor, fk_corso_studio) 
VALUES ('Passato con 24', 10, 'gino@gmail.com', 'SC02121720');

INSERT INTO competenza_corso (descrizione, tariffa, email_tutor, fk_corso_studio) 
VALUES ('Passato con 26', 10, 'gino@gmail.com', 'SC02123180');

INSERT INTO competenza_corso (descrizione, tariffa, email_tutor, fk_corso_studio) 
VALUES ('Passato con 25', 10, 'gino@gmail.com', 'SCP8084698');

INSERT INTO competenza_corso (descrizione, tariffa, email_tutor, fk_corso_studio) 
VALUES ('Passato con 30L', 15, 'gino@gmail.com', 'SCP4063958');

INSERT INTO competenza_corso (descrizione, tariffa, email_tutor, fk_corso_studio) 
VALUES ('Passato con 30L', 15, 'gino@gmail.com', 'SC01122887');

SET FOREIGN_KEY_CHECKS=1;
