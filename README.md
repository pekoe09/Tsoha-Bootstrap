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

Sovellukseen on toteutettu malliluokkia (Asiakas, Palvelu, Toimitila, Tyontekija, Varaus) joissa on all()-metodi kaikkien olioiden hakuun, find()-metodi tietyn olion hakuun ja save()-metodi olion tallennukseen. Kutakin mallia kohden on luotu kontrolleri, joka tukee mallin olioiden listausta, tallennusta sekä yksittäisen olion tietojen esittämistä; näkymiä on myös muokattu vastaavasti. 

Palvelu-tallennusta on alettu muuttaa JSON-pohjaiseksi, jotta palveluun soveltuvien toimitilojen ja terapeuttien tiedot saisi siirrettyä siististi kontrollerille (tallennettavat tiedot poimitaan näkymästä jQuery-pätkällä). Tämä on kesken; jostain syystä näkymästä lähtevä json-muotoinen tieto onkin muuttunut uriksi, kun sen poimii kontrollerissa file_get_contents('php://input') -kutsulla. Syy toistaiseksi epäselvä allekirjoittaneelle.

## Päivitykset viikolla 4

(Tapahtunut so far) Palvelu-tallennus toimii nyt JSONin avulla. Form-tagiin oli jäänyt method- ja action-attribuutit jolloin submit-tapahtumakin laukesi sen lisäksi että data lähti skriptillä kontrollerille; ilmeisesti kilpajuoksua kun välillä voitti json-POST ja välillä querystring-POST... Tämä on nyt fiksattu ja kontrollerille menee pelkästään skriptin POST json-payloadilla - mutta jostain syystä redirect ei toimi. Selaimella näkyy että palvelimelta tulee 200:na sivu, jolle ohjaus tapahtuu (näyttää vieläpä sisältävän kaiken tarpeellisen) mutta selainpa ei sitä suostu näyttämään vaan lillii edelleen muokkaus-sivulla. Epäilen liittyvän siihen, että lomakkeen oletus-submit estetään nyt palauttamalla skriptin funktiosta false sen jälkeen kun ajax-kutsu on lähtenyt... 

Korjattu toimitilojen ja terapeuttien tallennuksessa olleita bugeja. Lisätty muokkaus- ja poistomahdollisuudet Asiakas- Toimitila- ja Työntekijä-tietokohteille. Palvelu-tietokohteella nyt vain poisto lisätty; muokkaus lisätään kunhan lisäys-toiminnon redirect-ongelma tulee ratkaistua.
