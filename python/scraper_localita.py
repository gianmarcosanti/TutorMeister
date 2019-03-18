
#!/usr/local/bin/python
# coding: utf-8

import codecs
import time
import csv

def charReplace(string):

    return string\
        .replace("'","''")\
        .strip()

def main():

    lista_query_comune = [''];
    lista_query_provincia = ['']
    lista_query_regione  = ['']

    elenco = open('Elenco-codici-statistici-e-denominazioni-al-30_06_2018.csv')
    csv_elenco = csv.reader(elenco)

    csv_elenco.next()

    for riga in csv_elenco:

        campo = riga[0].split(";")

        # ------------------------------------------

        # INSERT INTO regione VALUES ( id_regione , nome ) ;

        # [0] Codice Regione
        id_regione = campo[0].strip()
        
        # [9] Denominazione regione
        nome_regione = charReplace(campo[9].strip())

        if( id_regione != '' and nome_regione != '' ):
            query_regione = "INSERT INTO regione VALUES ( '" + id_regione + "' , '" + nome_regione + "' ) ;"
            lista_query_regione.append(unicode(query_regione, errors='replace'))

        # ------------------------------------------

        # INSERT INTO provincia VALUES ( id_provincia , nome , fk_regione ) :

        # [2] Codice Provincia (1)
        id_provincia = campo[2].strip()
        
        # [10] Denominazione Citta metropolitana (provincia)
        nome_provincia = charReplace(campo[10].strip())

        if(nome_provincia == "-"):
            # [11] Denominazione provincia
            nome_provincia = charReplace(campo[11].strip())

        if( id_provincia != '' and nome_provincia != '-' ):
            query_provincia = "INSERT INTO provincia VALUES ( '" + id_provincia + "' , '" + nome_provincia + "' , '" + id_regione + "' ) ;"
            lista_query_provincia.append(unicode(query_provincia, errors='replace'))

        # ------------------------------------------

        # INSERT INTO comune VALUES ( id_comune , nome , fk_provincia ) ;

        # [4] Codice Comune formato alfanumerico
        id_comune = campo[4].strip()
        
        # [5] Denominazione in italiano (del comune)
        nome_comune = charReplace(campo[5].strip())

        if( id_provincia != '' and nome_provincia != '-' ):
            query_comune = "INSERT INTO comune VALUES ( '" + id_comune + "' , '" + nome_comune + "' , '" + id_provincia + "' ) ;"
            lista_query_comune.append(unicode(query_comune, errors='replace'))
        
        # ------------------------------------------

    lista_query_regione = list(set(lista_query_regione))
    lista_query_citta = list(set(lista_query_comune))
    lista_query_provincia = list(set(lista_query_provincia))

    # Scrittura su file
    try:
        f = codecs.open('localita.sql', 'w', 'utf-8')

        for item in lista_query_regione:
            f.write(item + '\n')

        for item in lista_query_provincia:
            f.write(item + '\n')

        for item in lista_query_comune:
            f.write(item + '\n')

        f.close()
    except OSError as err:
        print err

def secondsToMinutes(seconds):

    hours, rem = divmod(time.time() - seconds, 3600)
    minutes, seconds = divmod(rem, 60)
    timeString = "{:0>2}:{:0>2}:{:05.2f}".format(int(hours),int(minutes),seconds)

    return timeString

if __name__ == "__main__":

    start_time = time.time()
    main()
    print("\n\n\nDONE!")
    print(secondsToMinutes(start_time))
