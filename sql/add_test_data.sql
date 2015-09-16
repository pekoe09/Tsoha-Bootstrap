-- tyontekija-taulun testidata
INSERT INTO tyontekija (sukunimi, etunimi, sahkoposti, on_johtaja, aloitus_pvm, lopetus_pvm, salasana)
VALUES
('Testaaja', 'Terttu', 'terttu.testaaja@vallila.fi', false, '1997-07-20', null, 'xxx'),
('Toka', 'Totte', 'totte.toka@vallila.fi', false, '2003-03-31', null, 'xxx'),
('Joku', 'Arska', 'arska.joku@vallila.fi', false, '2008-12-01', '2008-12-02', 'xxx'),
('Kolmonen', 'Keijo', 'keijo.kolmonen@vallila.fi', false, '2011-03-01', null, 'xxx'),
('Tarkka', 'Taina', 'taina.tarkka@vallila.fi', true, '2015-08-20', null, 'xxx')
;

-- palvelu-taulun testidata
INSERT INTO palvelu (nimi, kesto, kuvaus)
VALUES
('Niskahieronta', '1:00', 'Nam molestie nec tortor. Donec placerat leo sit amet velit. Vestibulum id justo ut vitae massa. Proin in dolor mauris consequat aliquam. Donec ipsum, vestibulum ullamcorper venenatis augue. Aliquam tempus nisi in auctor vulputate, erat felis pellentesque augue nec, pellentesque lectus justo nec erat. Aliquam et nisl. Quisque sit amet dolor in justo pretium condimentum.'),
('Askeltutkimus', '1:00', 'Mauris sed libero. Suspendisse facilisis nulla in lacinia laoreet, lorem velit accumsan velit vel mattis libero nisl et sem. Proin interdum maecenas massa turpis sagittis in, interdum non lobortis vitae massa. Quisque purus lectus, posuere eget imperdiet nec sodales id arcu. Vestibulum elit pede dictum eu, viverra non tincidunt eu ligula.'),
('Kävelyharjoittelu', '3:00', 'Vivamus placerat lacus vel vehicula scelerisque, dui enim adipiscing lacus sit amet sagittis, libero enim vitae mi. In neque magna posuere, euismod ac tincidunt tempor est. Ut suscipit nisi eu purus. Proin ut pede mauris eget ipsum. Integer vel quam nunc commodo consequat. Integer ac eros eu tellus dignissim viverra.')
;

-- tyontekija_palvelu-taulun testidata
INSERT INTO tyontekija_palvelu (tyontekija_id, palvelu_id, hinta)
VALUES ((SELECT id FROM tyontekija WHERE sahkoposti='terttu.testaaja@vallila.fi'), 
		(SELECT id FROM palvelu WHERE nimi='Niskahieronta'),
		75.00);
INSERT INTO tyontekija_palvelu (tyontekija_id, palvelu_id, hinta)
VALUES ((SELECT id FROM tyontekija WHERE sahkoposti='terttu.testaaja@vallila.fi'), 
		(SELECT id FROM palvelu WHERE nimi='Kävelyharjoittelu'),
		323.00);
INSERT INTO tyontekija_palvelu (tyontekija_id, palvelu_id, hinta)
VALUES ((SELECT id FROM tyontekija WHERE sahkoposti='totte.toka@vallila.fi'), 
		(SELECT id FROM palvelu WHERE nimi='Askeltutkimus'),
		62.00);
INSERT INTO tyontekija_palvelu (tyontekija_id, palvelu_id, hinta)
VALUES ((SELECT id FROM tyontekija WHERE sahkoposti='totte.toka@vallila.fi'), 
		(SELECT id FROM palvelu WHERE nimi='Kävelyharjoittelu'),
		380.00);
INSERT INTO tyontekija_palvelu (tyontekija_id, palvelu_id, hinta)
VALUES ((SELECT id FROM tyontekija WHERE sahkoposti='arska.joku@vallila.fi'), 
		(SELECT id FROM palvelu WHERE nimi='Niskahieronta'),
		50.00);

-- toimitila-taulun testidata
INSERT INTO toimitila (nimi, katuosoite, paikkakunta)
VALUES
('Hauki', 'Haukilahdenkatu 4', 'Helsinki'),
('Allu', 'Aleksis Kiven katu 9', 'Helsinki'),
('Portti', 'Maistraatinportti 2', 'Helsinki');

-- toimitila_palvelu-taulun testidata
INSERT INTO toimitila_palvelu (toimitila_id, palvelu_id)
VALUES ((SELECT id FROM toimitila WHERE nimi='Hauki'),
		(SELECT id FROM palvelu WHERE nimi='Askeltutkimus'));
INSERT INTO toimitila_palvelu (toimitila_id, palvelu_id)
VALUES ((SELECT id FROM toimitila WHERE nimi='Hauki'),
		(SELECT id FROM palvelu WHERE nimi='Kävelyharjoittelu'));
INSERT INTO toimitila_palvelu (toimitila_id, palvelu_id)
VALUES ((SELECT id FROM toimitila WHERE nimi='Allu'),
		(SELECT id FROM palvelu WHERE nimi='Askeltutkimus'));
INSERT INTO toimitila_palvelu (toimitila_id, palvelu_id)
VALUES ((SELECT id FROM toimitila WHERE nimi='Allu'),
		(SELECT id FROM palvelu WHERE nimi='Niskahieronta'));
INSERT INTO toimitila_palvelu (toimitila_id, palvelu_id)
VALUES ((SELECT id FROM toimitila WHERE nimi='Portti'),
		(SELECT id FROM palvelu WHERE nimi='Niskahieronta'));

-- tyopaiva-taulun testidata
INSERT INTO tyopaiva (tyontekija_id, paiva, alkaen, asti)
SELECT 1, CURRENT_DATE + gs.d - 1, '9:00', '17:00'
FROM GENERATE_SERIES(1,30) AS gs(d)
WHERE EXTRACT(DOW FROM (CURRENT_DATE + gs.d)) BETWEEN 2 AND 6;

INSERT INTO tyopaiva (tyontekija_id, paiva, alkaen, asti)
SELECT 2, CURRENT_DATE + gs.d - 1, '9:00', '15:00'
FROM GENERATE_SERIES(1,30) AS gs(d)
WHERE EXTRACT(DOW FROM (CURRENT_DATE + gs.d)) BETWEEN 2 AND 6;

INSERT INTO tyopaiva (tyontekija_id, paiva, alkaen, asti)
SELECT 4, CURRENT_DATE + gs.d - 1, '12:00', '17:00'
FROM GENERATE_SERIES(1,30) AS gs(d)
WHERE EXTRACT(DOW FROM (CURRENT_DATE + gs.d)) BETWEEN 2 AND 6;

-- aukiolopaiva-taulun testidata
INSERT INTO aukiolopaiva (toimitila_id, paiva, alkaen, asti)
SELECT 1, CURRENT_DATE + gs.d - 1, '9:00', '17:00'
FROM GENERATE_SERIES(1,30) AS gs(d)
WHERE EXTRACT(DOW FROM (CURRENT_DATE + gs.d)) BETWEEN 2 AND 6;

INSERT INTO aukiolopaiva (toimitila_id, paiva, alkaen, asti)
SELECT 2, CURRENT_DATE + gs.d - 1, '13:00', '17:00'
FROM GENERATE_SERIES(1,30) AS gs(d)
WHERE EXTRACT(DOW FROM (CURRENT_DATE + gs.d)) BETWEEN 2 AND 6;

INSERT INTO aukiolopaiva (toimitila_id, paiva, alkaen, asti)
SELECT 3, CURRENT_DATE + gs.d - 1, '9:00', '13:00'
FROM GENERATE_SERIES(1,30) AS gs(d)
WHERE EXTRACT(DOW FROM (CURRENT_DATE + gs.d)) BETWEEN 2 AND 6;

-- asiakas-taulun testidata

INSERT INTO asiakas (sukunimi, etunimi, sahkoposti, salasana)
VALUES
('Lasinen', 'Lasse', 'llasinen@gmail.com', 'xxx'),
('Ötker', 'Doktor', 'd.otker@schlosswaldstein.ch', 'xxx'),
('McDonald', 'Ronnie', 'ronald.mcdonald@somewhere.com', 'xxx');

-- varaus-taulun testidata

INSERT INTO varaus (asiakas_id, palvelu_id, työntekijä_id, toimitila_id,
aloitusaika, lopetusaika, peruutettu)
VALUES
(1, 1, 2, '2015-09-30 13:00', '2015-09-30 14:00', false),
(2, 1, 2, '2015-09-30 14:00', '2015-09-30 15:00', false),
(2, 2, 1, '2015-09-30 10:00', '2015-09-30 11:00', false);