CREATE TABLE tyontekija(
	id SERIAL PRIMARY KEY,
	sukunimi varchar(50) NOT NULL,
	etunimi varchar(50) NOT NULL,
	sahkoposti varchar(200) UNIQUE,
	on_johtaja BOOLEAN DEFAULT FALSE,
	aloitus_pvm DATE NOT NULL,
	lopetus_pvm DATE,
	salasana char(40) NOT NULL
);

CREATE TABLE palvelu(
	id SERIAL PRIMARY KEY,
	nimi varchar(100) NOT NULL UNIQUE,
	kesto TIME NOT NULL,
	kuvaus varchar(5000)
);

CREATE TABLE tyontekija_palvelu(
	tyontekija_id INTEGER REFERENCES tyontekija(id) NOT NULL,
	palvelu_id INTEGER REFERENCES palvelu(id) NOT NULL,
	hinta MONEY NOT NULL,
        PRIMARY KEY(tyontekija_id, palvelu_id)
);

CREATE TABLE toimitila(
	id SERIAL PRIMARY KEY,
	nimi varchar(100) NOT NULL UNIQUE,
	katuosoite varchar(200) NOT NULL,
	paikkakunta varchar(50) NOT NULL
);

CREATE TABLE toimitila_palvelu(
	toimitila_id INTEGER REFERENCES toimitila(id) NOT NULL,
	palvelu_id INTEGER REFERENCES palvelu(id) NOT NULL,
        PRIMARY KEY(toimitila_id, palvelu_id)
);

CREATE TABLE tyopaiva(
	id SERIAL PRIMARY KEY,
	tyontekija_id INTEGER REFERENCES tyontekija(id),
	paiva DATE NOT NULL,
	alkaen TIME NOT NULL,
	asti TIME NOT NULL
);

CREATE TABLE aukiolopaiva(
	id SERIAL PRIMARY KEY,
	toimitila_id INTEGER REFERENCES toimitila(id),
	paiva DATE NOT NULL,
	alkaen TIME NOT NULL,
	asti TIME NOT NULL
);

CREATE TABLE asiakas(
	id SERIAL PRIMARY KEY,
	sukunimi varchar(100) NOT NULL,
	etunimi varchar(100) NOT NULL,
	sahkoposti varchar(200) NOT NULL UNIQUE,
	salasana char(40)
);

CREATE TABLE varaus(
	id SERIAL PRIMARY KEY,
	asiakas_id INTEGER NOT NULL REFERENCES asiakas(id),
	palvelu_id INTEGER NOT NULL REFERENCES palvelu(id),
	tyontekija_id INTEGER NOT NULL REFERENCES tyontekija(id),
	toimitila_id INTEGER NOT NULL REFERENCES toimitila(id),
	aloitusaika TIMESTAMP NOT NULL,
	lopetusaika TIMESTAMP NOT NULL,
	on_peruutettu BOOLEAN
);
