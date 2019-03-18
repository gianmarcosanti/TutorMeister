#!/usr/local/bin/python
# coding: utf-8

import codecs
import time
import hashlib
import urllib2
from bs4 import BeautifulSoup

def charReplace(string):

    return string\
        .replace("'","''")\
        .strip()

def corsoStudioStringReplace(string):

	return string\
		.replace(u' (Logistica Padova)', u'')\
		.replace(u' (Da A a E)', u'')\
		.replace(u' ( Numerosita'' canale 1)', u'')\
		.replace(u' (Ult. numero di matricola dispari)', u'')\
		.replace(u' (Ult. numero di matricola da  0 a 4)', u'')\
		.replace(u' (Iniziali cognome A-L)', u'')\
		.replace(u' (Iniziali cognome A-K)', u'')\
		.replace(u' (Iniziali cognome A-C)', u'')\
		.replace(u' (Canale A)', u'')\
		.replace('--', '')\
		.replace('\n', '')\
		.replace(u'--\n', u'')\
		.replace(u'Primosemestre', u'Primo Semestre')\
		.replace(u'Secondosemestre', u'Secondo Semestre')\
		.replace(u'Primotrimestre', u'Primo trimestre')\
		.replace(u'Secondotrimestre', u'Secondo trimestre')\
		.replace(u'Terzotrimestre', u'Terzo trimestre')\
		.replace(u'Annuale', u'Annuale')\
		.replace(u"\u2018", "''")\
		.replace(u"\u2019", "''")\
		.replace("'","''")\
		.strip()

def main():

	lista_query_scuola = ['']
	lista_query_corso_laurea = ['']
	lista_query_corso_studio = ['']

	# Link di partenza, contiene tutti gli insegnamenti recenti e passati    
	root = 'https://didattica.unipd.it'

	# Per ciascuna tipologia di insegnamento presente ...
	for l in ('LT', 'LM', 'CU'):

		offerta_url = root + '/off/2018/' + l
		offerta_page = urllib2.urlopen(offerta_url)
		offerta_html = BeautifulSoup(offerta_page, 'html.parser')

		# Cerco i link che mi rimandano alle pagine specifiche delle varie scuole
		link_scuole = offerta_html.find('tr', attrs={'class' : 'list_scuole'}).find_all('a')

		# Per ciascuna scuola ...
		for scuola in link_scuole:

			scuola_url = str(root + scuola['href'])
			scuola_page = urllib2.urlopen(str(scuola_url))
			scuola_html = BeautifulSoup(scuola_page, 'html.parser')

			nome_scuola = scuola.getText().replace("'", "\'").replace("'","''")
			id_scuola = hashlib.md5(nome_scuola.encode()).hexdigest()[:8]

			# Creo la query per l'inserimento della scuola nel db
			# INSERT INTO scuola VALUES (id_scuola, nome, fk_universita);
			query_scuola = "INSERT INTO scuola VALUES ('" + id_scuola + "', '" + nome_scuola + "', '" + "unipd" + "');"
			
			# print query_scuola
			lista_query_scuola.append(query_scuola.encode('utf-8'))

			# Cerco i link che mi rimandano ai corsi di laurea di tale scuola
			link_corsi_laurea = scuola_html.find('table', attrs={'class': 'dettaglio_righe borderless w100'}).find_all('tr')

			# Per ciascun corso di laurea ...
			for corso_laurea in link_corsi_laurea[1:]:

				# Creo la query per l'inserimento del corso di laurea nel db
				# INSERT INTO corso_laurea VALUES (id_corso_laurea, nome, descrizione, tipologia, informazioni, fk_scuola);
				query_corso_laurea = "INSERT INTO corso_laurea VALUES ("

				corsi_laurea = corso_laurea.find_all('td')

				# Siccome nella tabella l'anno di inizio erogazione del corso di laurea è insieme all'id nella prima cella di ogni riga, bisogna separarli
				
				try:
					campo = next(iter(corsi_laurea), None).getText().strip()	
				except AttributeError as err:
					continue
				
				id_corso_laurea = campo[:6]
				anno_corso_laurea = campo[-4:]

				query_corso_laurea += '\'' + id_corso_laurea + '\', \'' + anno_corso_laurea + '\', '

				for campo in corsi_laurea[1:]:
					query_corso_laurea += '\'' + campo.getText() + '\', '

				#.replace(u'\xa0', u' ').replace(u'\xc0', u"A'").replace(u'\xe0', u"a'").replace(u'\xc9', u'E')

				#query_corso_laurea = query_corso_laurea[:-2]
				query_corso_laurea += '\''
				query_corso_laurea += id_scuola
				query_corso_laurea += "');"

				# print query_corso_laurea
				lista_query_corso_laurea.append(query_corso_laurea.encode('utf-8'))

				# Cerco il link del corso di laurea che sto analizzando per accedere ai corsi specifici
				corso_laurea_url = corso_laurea.find('a')

				# Se questo link non esiste continuo
				if corso_laurea_url == None:
					continue

				corso_laurea_url = str(root + corso_laurea_url['href'])

				# Se non riesco ad aprire il link non è valido e quindi continuo
				try:
					corso_laurea_page = urllib2.urlopen(str(corso_laurea_url))
				except urllib2.URLError as err: 
					continue

				corso_laurea_html = BeautifulSoup(corso_laurea_page, 'html.parser')

				# Salvo le righe contenenti ciascun corso singolo del corso di studi che sto analizzando
				tabella_corsi_studio = corso_laurea_html.find('table', attrs={'class' : 'dettaglio_righe borderless elenco_af'}).find_all('tbody').pop(0).find_all('tr')

				# Per ciascuna riga della tabella che rappresenta un corso
				for corso_studio in tabella_corsi_studio[1:]:
	
					# Creo la query per l'inserimento del corso di studi nel db
					# INSERT INTO corso_studio(id_corso_studio, nome, descrizione, durata, crediti, anno, semestre, lingua, fk_corso_laurea);
					query_corso_studio = "INSERT INTO corso_studio VALUES ("

					campi_corso = corso_studio.find_all('td')
					
					# Lambda che eliminano i tag dalla stringa 
					[x.extract() for x in corso_studio.find_all('br')]
					[x.extract() for x in corso_studio.find_all('a')]

					# Aggiungo ciascun campo della riga alla query
					for campo in campi_corso[1:-1]:
						# Tenendo conto che per certi corsi di laurea ci sono corsi con varie 'logistiche' vado ad eliminarli in quanto uguali, ne tengo solamente uno
						# Vado a sostituire i inutili o che possono creare problemi nel db
						query_corso_studio += '\'' + corsoStudioStringReplace(campo.getText()) + '\', \''

					query_corso_studio += id_corso_laurea
					query_corso_studio += '\');'

					query_corso_studio = query_corso_studio.encode('utf-8')

					if ('(Logistica' not in query_corso_studio) and (query_corso_studio[28:38] not in lista_query_corso_studio[-1]):
						lista_query_corso_studio.append(query_corso_studio)

	lista_query_scuola = list(set(lista_query_scuola))
	lista_query_corso_laurea = list(set(lista_query_corso_laurea))
	lista_query_corso_studio = list(set(lista_query_corso_studio))

	# Scrittura su file
	try:
		f = codecs.open('unipd.sql', 'w', 'utf-8')
		for item in lista_query_scuola:
			f.write(codecs.decode(item + '\n', "utf-8"))
		for item in lista_query_corso_laurea:
			f.write(codecs.decode(item + '\n', "utf-8"))
		for item in lista_query_corso_studio:
			f.write(codecs.decode(item + '\n', "utf-8"))
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
	print("DONE!")
	print(secondsToMinutes(start_time))
