#!/usr/local/bin/python
# coding: latin-1

from bs4 import BeautifulSoup
import re
import codecs

def id_provincia(nome_provincia):

	return nome_provincia.lower()\
		.replace('piacenza' , '033')\
		.replace('ferrara' , '038')\
		.replace('milano' , '015')\
		.replace('lecco' , '097')\
		.replace('catania' , '087')\
		.replace('brindisi' , '074')\
		.replace('asti' , '005')\
		.replace('modena' , '036')\
		.replace('livorno' , '049')\
		.replace('grosseto' , '053')\
		.replace('siena' , '052')\
		.replace('parma' , '034')\
		.replace('trieste' , '032')\
		.replace('verona' , '023')\
		.replace('cosenza' , '078')\
		.replace('pordenone' , '093')\
		.replace('firenze' , '048')\
		.replace('messina' , '083')\
		.replace('vercelli' , '002')\
		.replace('cuneo' , '004')\
		.replace('pisa' , '050')\
		.replace('massa-carrara' , '045')\
		.replace('mantova' , '020')\
		.replace('oristano' , '095')\
		.replace('gorizia' , '031')\
		.replace('savona' , '009')\
		.replace('arezzo' , '051')\
		.replace('padova' , '028')\
		.replace('la spezia' , '011')\
		.replace('agrigento' , '084')\
		.replace('belluno' , '025')\
		.replace('siracusa' , '089')\
		.replace('aosta' , '007')\
		.replace('napoli' , '063')\
		.replace('udine' , '030')\
		.replace('genova' , '010')\
		.replace('barletta-andria-trani' , '110')\
		.replace('taranto' , '073')\
		.replace('vibo valentia' , '102')\
		.replace('fermo' , '109')\
		.replace('caltanissetta' , '085')\
		.replace('trapani' , '081')\
		.replace('bari' , '072')\
		.replace('pesaro e urbino' , '041')\
		.replace('lecce' , '075')\
		.replace('benevento' , '062')\
		.replace('pavia' , '018')\
		.replace('enna' , '086')\
		.replace('macerata' , '043')\
		.replace('rimini' , '099')\
		.replace('ascoli piceno' , '044')\
		.replace('caserta' , '061')\
		.replace('pistoia' , '047')\
		.replace('verbano-cusio-ossola' , '103')\
		.replace('chieti' , '069')\
		.replace('forl�-cesena' , '040')\
		.replace('sassari' , '090')\
		.replace('lodi' , '098')\
		.replace('bergamo' , '016')\
		.replace('lucca' , '046')\
		.replace('bologna' , '037')\
		.replace('venezia' , '027')\
		.replace('rovigo' , '029')\
		.replace('reggio di calabria' , '080')\
		.replace('bolzano/bozen' , '021')\
		.replace('pescara' , '068')\
		.replace('como' , '013')\
		.replace('cagliari' , '092')\
		.replace('matera' , '077')\
		.replace('frosinone' , '060')\
		.replace('roma' , '058')\
		.replace('ancona' , '042')\
		.replace('alessandria' , '006')\
		.replace('rieti' , '057')\
		.replace('brescia' , '017')\
		.replace('monza e della brianza' , '108')\
		.replace('salerno' , '065')\
		.replace('palermo' , '082')\
		.replace('cremona' , '019')\
		.replace('viterbo' , '056')\
		.replace('ravenna' , '039')\
		.replace('trento' , '022')\
		.replace('campobasso' , '070')\
		.replace('l''aquila' , '066')\
		.replace('sondrio' , '014')\
		.replace('avellino' , '064')\
		.replace('perugia' , '054')\
		.replace('reggio nell''emilia' , '035')\
		.replace('varese' , '012')\
		.replace('crotone' , '101')\
		.replace('latina' , '059')\
		.replace('sud sardegna' , '111')\
		.replace('foggia' , '071')\
		.replace('potenza' , '076')\
		.replace('torino' , '001')\
		.replace('catanzaro' , '079')\
		.replace('ragusa' , '088')\
		.replace('nuoro' , '091')\
		.replace('novara' , '003')\
		.replace('terni' , '055')\
		.replace('teramo' , '067')\
		.replace('prato' , '100')\
		.replace('vicenza' , '024')\
		.replace('biella' , '096')\
		.replace('treviso' , '026')\
		.replace('isernia' , '094')\
		.replace('imperia' , '008')

def main():	

	lista_query = []

	# Aprire file in locale
	# https://stackoverflow.com/questions/21570780/using-python-and-beautifulsoup-saved-webpage-source-codes-into-a-local-file
	url = r'universita.htm'
	page = open(url)
	html = BeautifulSoup(page.read(), 'html.parser')

	regione = html.find_all('p')

	for r in regione[1:-1]:

		nome_regione = r.find('b').extract().getText()

		lista_universita = []

		for universita in r.find_all('a'):

			# Query per ...
			# INSERT INTO universita VALUES (id_universita, nome, descrizione, sito, telefono, fax, regione, provincia, cap, sede);
			
			nome = re.sub(' +', ' ', universita.extract().getText().replace('\n' , ' ').replace(' - ', ' '))
			link = 'www.' + universita['href'][1:-3] + 'it'

			info_comuni = nome_regione + ' - ' + nome + ' - ' + link

			lista_universita.append(info_comuni)
		
		lista_info_universita = str(r).replace('<br/>', '').replace('\t', '').replace('<p>', '').replace('</p>', '').strip().split('\n\n')

		counter_lista_universita = 0
		for info_uni in lista_info_universita:

			raw_data = lista_universita[counter_lista_universita].replace('\'', '\'\'').strip().encode('utf-8') + ' - ' + info_uni
			#print raw_data
			raw_data = raw_data.split(' - ')

			id_uni = raw_data[2].split('.')[1]
			nome_uni = raw_data[1]
			descrizione_uni = ''
			sito_uni = raw_data[2]
			telefono_uni = raw_data[5]
			try:
				fax_uni = raw_data[6]
			except:
				fax_uni = ''

			regione_uni = raw_data[0].replace('\'', '\'\'')
			provincia_uni = raw_data[4].split(' ')[1].replace('\'', '\'\'')
			cap_uni = raw_data[4].split(' ')[0][0:6]
			sede_uni = raw_data[3].replace('\'', '\'\'')
		
			query = 'INSERT INTO universita VALUES (\'' + id_uni + '\', \'' + nome_uni + '\', \'' + descrizione_uni + '\', \'' + sito_uni + '\', \'' + telefono_uni + '\', \'' + fax_uni + '\', \'' + id_provincia(provincia_uni) + '\', \'' + cap_uni + '\', \'' + sede_uni + '\');'

			#print query
			lista_query.append(query)

			counter_lista_universita += 1

	try:
		f = codecs.open('universita.sql', 'w', 'utf-8')      	
		for item in lista_query:
			f.write(codecs.decode(item + '\n', "utf-8"))
		f.close()
	except OSError as err:
		print err


if __name__ == "__main__":
	main()		