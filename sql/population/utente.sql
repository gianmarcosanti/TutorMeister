DELETE FROM utente;

SET FOREIGN_KEY_CHECKS=0;

-- INSERT INTO utente VALUES (email_utente, email_verifica, password, data_registrazione, path_immagine, nome, cognome, data_nascita, telefono, fk_comune , cap, via, short_bio, is_tutor);

INSERT INTO utente (email_utente, email_verifica, password, nome, cognome, data_nascita, telefono, fk_comune , cap, via, short_bio, is_tutor) VALUES ( 'luca@gmail.com', 1, '$2y$10$cJYgQuODTDn9MwqBHHcU7Ok70eV2s.yN7Wrz/CUqQrIZclG5OLAbC', 'Luca', 'Forst', '1999-02-06', '0123456789', '028060', '01234', 'Via Leopardi 60', '', 0);
INSERT INTO utente (email_utente, email_verifica, password, nome, cognome, data_nascita, telefono, fk_comune , cap, via, short_bio, is_tutor) VALUES ( 'matteo@gmail.com', 1, '$2y$10$Z850iWtNPMVW5T82IRQbc.HW0aAGs1Fpdr1n5xsj5TStQoifMNejK', 'Matteo', 'Birra', '1997-03-30', '0123456789', '028066', '01234', 'Via dei Fiorentini 73', '', 0);
INSERT INTO utente (email_utente, email_verifica, password, nome, cognome, data_nascita, telefono, fk_comune , cap, via, short_bio, is_tutor) VALUES ( 'simone@gmail.com', 1, '$2y$10$8OAistCr45LBITQ7LV92huHcKBGHFPzoKukQePCVsYlQr0Y/uiVje','Simone' ,'Anca','1990-06-30' ,'0123456789', '028032' , '01234', 'Via San Pietro Ad Aram 83', '' , 0);
INSERT INTO utente (email_utente, email_verifica, password, nome, cognome, data_nascita, telefono, fk_comune , cap, via, short_bio, is_tutor) VALUES ( 'paolo@gmail.com', 1, '$2y$10$7NwoKVbBUD5/FFHSdrlsPuv1XFt/NUozkFWJ4Ud3a.TDHZsBet6IW','Paolo','Solo','1998-05-12', '0123456789', '028013', '01234', 'Sottocolle 74','', 0);
INSERT INTO utente (email_utente, email_verifica, password, nome, cognome, data_nascita, telefono, fk_comune , cap, via, short_bio, is_tutor) VALUES ( 'gino@gmail.com', 1, '$2y$10$5tjzN4tcwPvf4E6XjpdmG.DiJLUdKcfNjZrFTjqo2xNpJgvyoSSAO' , 'Gino', 'Cerutti', '1997-07-17', '0123456789', '028015' , '01234', 'Via Gook 65', '' , 1);
INSERT INTO utente (email_utente, email_verifica, password, nome, cognome, data_nascita, telefono, fk_comune , cap, via, short_bio, is_tutor) VALUES ( 'dina@gmail.com', 1, '$2y$10$kdB48Am7noSRONJ3V0E0qeUGa8KenXIxdrpqe3yLYJX7NPb5X9Cqa' , 'Dina', 'Trombi' ,'1996-02-12' ,'0123456789', '028084', '01234', 'Via Alberti 75', '' , 1);
INSERT INTO utente (email_utente, email_verifica, password, nome, cognome, data_nascita, telefono, fk_comune , cap, via, short_bio, is_tutor) VALUES ( 'mirko@gmail.com', 1, '$2y$10$EhwbNBadK4zhXWP6rmLyreV9Xcl1dmitW84fi3UY5cNjYYeMGI0be', 'Mirko', 'Libro', '1997-11-13', '0123456789', '028008' , '01234', 'Via Pablito 15', '' , 1);
INSERT INTO utente (email_utente, email_verifica, password, nome, cognome, data_nascita, telefono, fk_comune , cap, via, short_bio, is_tutor) VALUES ( 'davide@gmail.com' , 1, '$2y$10$QaCpmBHStDBT5ekMClxWmuc3wSS0fBPyrG8wE5iYKvq5QBBUSQKAq' , 'Davide', 'Testa', '1994-02-10' ,'0123456789', '028023' , '01234', 'Via Tarvisio 15', '' , 1);


SET FOREIGN_KEY_CHECKS=1;