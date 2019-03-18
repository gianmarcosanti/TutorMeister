DELETE FROM abbonamento;

SET FOREIGN_KEY_CHECKS=0;

-- INSERT INTO abbonamento VALUES (cadenza, descrizione, tariffa);

INSERT INTO abbonamento (cadenza, descrizione, tariffa) VALUES ('mensile'      , '' , 10.00 );
INSERT INTO abbonamento (cadenza, descrizione, tariffa) VALUES ('semestrale'   , '' , 50.00 );
INSERT INTO abbonamento (cadenza, descrizione, tariffa) VALUES ('annuale'      , '' , 90.00 );

SET FOREIGN_KEY_CHECKS=1;
