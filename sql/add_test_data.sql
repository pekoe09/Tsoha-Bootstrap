-- tyontekija-taulun testidata
INSERT INTO tyontekija (sukunimi, etunimet, sahkoposti, on_johtaja, aloitus_pvm, lopetus_pvm, salasana, suola)
SELECT
'Testaaja', 'Terttu', 'terttu.testaaja@vallila.fi', false, '1997-07-20', null, 'xxx' UNION ALL
'Toka', 'Totte', 'totte.toka@vallila.fi', false, '2003-03-31', null, 'xxx' UNION ALL
'Joku', 'Arska', 'arska.joku@vallila.fi', false, '2008-12-01', '2008-12-02', 'xxx' UNION ALL
'Kolmonen', 'Keijo', 'keijo.kolmonen@vallila.fi', false, '2011-03-01', null, 'xxx' UNION ALL
'Tarkka', 'Taina', 'taina.tarkka@vallila.fi', true, '2015-08-20', null, 'xxx'
;

-- palvelu-taulun testidata
INSERT INTO palvelu (nimi, kesto, kuvaus)
SELECT
'Niskahieronta', '1:00', 'Nam molestie nec tortor. Donec placerat leo sit amet velit. Vestibulum id justo ut vitae massa. Proin in dolor mauris consequat aliquam. Donec ipsum, vestibulum ullamcorper venenatis augue. Aliquam tempus nisi in auctor vulputate, erat felis pellentesque augue nec, pellentesque lectus justo nec erat. Aliquam et nisl. Quisque sit amet dolor in justo pretium condimentum.' UNION ALL
'Askeltutkimus', '1:00', 'Mauris sed libero. Suspendisse facilisis nulla in lacinia laoreet, lorem velit accumsan velit vel mattis libero nisl et sem. Proin interdum maecenas massa turpis sagittis in, interdum non lobortis vitae massa. Quisque purus lectus, posuere eget imperdiet nec sodales id arcu. Vestibulum elit pede dictum eu, viverra non tincidunt eu ligula.' UNION ALL
'Kävelyharjoittelu', '3:00', 'Vivamus placerat lacus vel vehicula scelerisque, dui enim adipiscing lacus sit amet sagittis, libero enim vitae mi. In neque magna posuere, euismod ac tincidunt tempor est. Ut suscipit nisi eu purus. Proin ut pede mauris eget ipsum. Integer vel quam nunc commodo consequat. Integer ac eros eu tellus dignissim viverra.'
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
SELECT
'Hauki', 'Haukilahdenkatu 4', 'Helsinki' UNION ALL
'Allu', 'Aleksis Kiven katu 9', 'Helsinki' UNION ALL
'Portti', 'Maistraatinportti 2', 'Helsinki';

-- toimitila_palvelu-taulun testidata
INSERT INTO toimitila_palvelu (toimitila_id, palvelu_id)
VALUES ((SELECT id FROM toimitila WHERE nimi='Hauki'),
		(SELECT id FROM palvelu WHERE nimi='Askeltutkimus');
INSERT INTO toimitila_palvelu (toimitila_id, palvelu_id)
VALUES ((SELECT id FROM toimitila WHERE nimi='Hauki'),
		(SELECT id FROM palvelu WHERE nimi='Kävelyharjoittelu');
INSERT INTO toimitila_palvelu (toimitila_id, palvelu_id)
VALUES ((SELECT id FROM toimitila WHERE nimi='Allu'),
		(SELECT id FROM palvelu WHERE nimi='Askeltutkimus');
INSERT INTO toimitila_palvelu (toimitila_id, palvelu_id)
VALUES ((SELECT id FROM toimitila WHERE nimi='Allu'),
		(SELECT id FROM palvelu WHERE nimi='Niskahieronta');
INSERT INTO toimitila_palvelu (toimitila_id, palvelu_id)
VALUES ((SELECT id FROM toimitila WHERE nimi='Portti'),
		(SELECT id FROM palvelu WHERE nimi='Niskahieronta');

-- tyopaiva-taulun testidata
DECLARE @i INTEGER = 0;
DECLARE @paiva DATE = CURRENT_DATE;
DECLARE @viikonpaivanumero INTEGER;
WHILE @i < 30
BEGIN
	
	INSERT INTO tyopaiva (tyontekija_id, paiva, alkaen, asti)
	SET @paiva = @paiva + 1;
	SET @i = @i + 1;
END

-- aukiolopaiva-taulun testidata


-- asiakas-taulun testidata


-- varaus-taulun testidata
