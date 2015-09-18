# Tietokantasovelluksen esittelysivu

Yleisiä linkkejä:

* [Linkki Vallila-sovellukseeni](http://jpkangas.users.cs.helsinki.fi/vallila/)
* [Linkki dokumentaatiooni](https://github.com/pekoe09/Tsoha-Bootstrap/blob/master/doc/dokumentaatio.pdf)

## Työn aihe

Aiheena on valmiina ollut aihe ["Palvelubisnes"](http://advancedkittenry.github.io/suunnittelu_ja_tyoymparisto/aiheet/Palvelubisnes.html).

Valmisaiheeseen verrattuna toteutettavassa sovelluksessa asiakkaan tulee kuitenkin rekisteröityä voidakseen varata palveluajan. Asiakkaasta tallennetaan perusyhteystiedot ja rekisteröitynyt asiakas voi sisäänkirjauduttuaan myös selata tekemiään varauksia ja peruuttaa niitä (jos varausaika on tulevaisuudessa). Sisäänkirjautumaton asiakas voi vain selata palveluiden tietoja sekä firman yleisesittelyä. Työntekijät voivat etsiä asiakkaiden varauksia ja peruuttaa niitä.

## Päivitykset viikolla 2

Tietokantarakenne on hahmottunut: sql-skriptit kannan luomiseen ja testidatalla populointiin on tehty ja dokumentaatio.pdf on päivitetty järjestelmän tietosisällön kuvauksen ja relaatiotietokantakaavion osalta. Lisäksi osasta sovelluksen sivuja on tehty staattiset HTML-hahmotelmat, alla suorat linkit:
* [Etusivu](http://jpkangas.users.cs.helsinki.fi/vallila/)
* [Ajanvaraus](http://jpkangas.users.cs.helsinki.fi/vallila/varaus)
* [Palvelulista](http://jpkangas.users.cs.helsinki.fi/vallila/palvelu)
* [Palvelukuvaus](http://jpkangas.users.cs.helsinki.fi/vallila/palvelu/1)
* [Terapeuttilista](http://jpkangas.users.cs.helsinki.fi/vallila/tyontekija)
* [Terapeutin muokkaus](http://jpkangas.users.cs.helsinki.fi/vallila/tyontekija/1)
* [Toimitilalista](http://jpkangas.users.cs.helsinki.fi/vallila/toimitila)
* [Toimitilan muokkaus](http://jpkangas.users.cs.helsinki.fi/vallila/toimitila/1)
* [Kirjautumissivu](http://jpkangas.users.cs.helsinki.fi/vallila/kirjaudu)

**HUOM!** Sivut on tehty Johtaja-käyttäjän näkökulmasta, jolloin näkyvissä on enemmän sivuja ja toimintoja kuin muille käyttäjille. Terapeuttisivut eivät ole näkyvissä muille lainkaan ja Tilastot-sivu näkyy vain työntekijöille. "Lisää"-, "Muokkaa"- ja "Poista"-painikkeet näkyvät vain Johtajalle. 

## Päivitykset viikolla 3

(Tapahtunut tähän asti) Sovellukseen on toteutettu malliluokkia (Asiakas, Palvelu, Toimitila, Tyontekija, Varaus) joissa on all()-metodi kaikkien olioiden hakuun, find()-metodi tietyn olion hakuun ja save()-metodi olion tallennukseen. Kutakin mallia kohden on luotu kontrolleri, joka tukee mallin olioiden listausta, tallennusta sekä yksittäisen olion tietojen esittämistä; näkymiä on myös muokattu vastaavasti. Varauksen tallennus on vielä toteuttamatta.
