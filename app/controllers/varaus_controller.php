<?php

class VarausController extends BaseController {
    
    public static function index(){
        self::check_logged_in(array("tyontekija", "johtaja"));
        $varaukset = Varaus::all();
        View::make('varaus/varaus_lista.html', array('varaukset'=>$varaukset));
    }
    
    public static function show($id){
        self::check_logged_in(array("tyontekija", "johtaja"));
        $varaus = Varaus::find($id);
        View::make('varaus/varaus.html', array('varaus'=>$varaus));
    }
    
    public static function create(){
        self::check_logged_in(array("asiakas", "tyontekija", "johtaja"));
        $tyontekijat = Tyontekija::all();
        $palvelut = Palvelu::all();
        $toimitilat = Toimitila::all();
        $asiakkaat = Asiakas::all();
        View::make('varaus/varaus_lisaa.html', array(
            'tyontekijat' => $tyontekijat,
            'palvelut' => $palvelut,
            'toimitilat' => $toimitilat,
            'asiakkaat' => $asiakkaat
        ));
    }

    public static function store(){
        self::check_logged_in(array("asiakas", "tyontekija", "johtaja"));
        $params = $_POST;
        $palvelu = Palvelu::find($params['palvelu_id']);
        $aloitusaika = strtotime($params['paiva'] . ' ' . $params['kellonaika']);
        list($tunnit, $minuutit, $sekunnit) = sscanf($palvelu->kesto, '%d:%d:%d');
        $kesto = new DateInterval(sprintf('PT%dH%dM', $tunnit, $minuutit));
        $lopetusaika = date_timestamp_get(date_add(new DateTime('@' . $aloitusaika), $kesto));
        $attributes = array(
            'asiakas_id' => $params['asiakas_id'],
            'palvelu_id' => $params['palvelu_id'],
            'tyontekija_id' => $params['tyontekija_id'],
            'toimitila_id' => $params['toimitila_id'],
            'aloitusaika' => date('Y-m-d H:i', $aloitusaika),
            'lopetusaika' => date('Y-m-d H:i', $lopetusaika),
            'on_peruutettu' => NULL
        );
        
        $varaus = new Varaus($attributes);
        $errors = $varaus->errors();
        
        if(count($errors) > 0){
            View::make('varaus/varaus_lisaa.html',
                    array('errors' => $errors, 'varaus' => $varaus));
        } else {        
            $varaus->save();
            Redirect::to('/', array('message' => 'Varaus tallennettu.'));
        }
    }
            
    public static function edit($id) {
        self::check_logged_in(array("tyontekija", "johtaja"));
        $varaus = Varaus::find($id);
        View::make('varaus/varaus_muokkaa.html', array('varaus' => $varaus));
    }
    
    public static function update($id) {
        self::check_logged_in(array("tyontekija", "johtaja"));
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'asiakas_id' => $params['asiakas_id'],
            'palvelu_id' => $params['palvelu_id'],
            'tyontekija_id' => $params['tyontekija_id'],
            'toimitila_id' => $params['toimitila_id'],
            'aloitusaika' => date('Y-m-d H:i', $aloitusaika),
            'lopetusaika' => date('Y-m-d H:i', $lopetusaika),
            'on_peruutettu' => NULL
        );
        
        $varaus = new Varaus($attributes);
        $errors = $varaus->errors();
        
        if(count($errors) > 0){
            View::make('varaus/varaus_muokkaa.html', 
                    array('errors' => $errors, 'varaus' => $varaus));
        } else {
            $varaus->update();
            Redirect::to('/varaus', array('message' => 
                'Varauksen tiedot päivitetty!'));
        }
    }
    
    public static function destroy($id) {
        self::check_logged_in(array("tyontekija", "johtaja"));
        $varaus = Varaus::find($id);
        $varaus->destroy();        
        Redirect::to('/varaus', 
                array('message' => 'Varaus poistettu.'));
    }
}
