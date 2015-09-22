<?php

class VarausController extends BaseController {
    
    public static function index(){
        $varaukset = Varaus::all();
        View::make('varaus/varaus_lista.html', array('varaukset'=>$varaukset));
    }
    
    public static function show($id){
        $varaus = Varaus::find($id);
        View::make('varaus/varaus.html', array('varaus'=>$varaus));
    }
    
    public static function create(){
        $tyontekijat = Tyontekija::all();
        $palvelut = Palvelu::all();
        $toimitilat = Toimitila::all();
        View::make('varaus/varaus_lisaa.html', array(
            'tyontekijat' => $tyontekijat,
            'palvelut' => $palvelut,
            'toimitilat' => $toimitilat
        ));
    }

    public static function store(){
        $params = $_POST;
        $palvelu = Palvelu::find($params['palvelu_id']);
        $aloitusaika = strtotime($params['paiva'] . ' ' . $params['kellonaika']);
        list($tunnit, $minuutit, $sekunnit) = sscanf($palvelu->kesto, '%d:%d:%d');
        $kesto = new DateInterval(sprintf('PT%dH%dM', $tunnit, $minuutit));
        $lopetusaika = date_timestamp_get(date_add(new DateTime('@' . $aloitusaika), $kesto));
        $varaus= new Varaus(array(
            'asiakas_id' => $params['asiakas_id'],
            'palvelu_id' => $params['palvelu_id'],
            'tyontekija_id' => $params['tyontekija_id'],
            'toimitila_id' => $params['toimitila_id'],
            'aloitusaika' => date('Y-m-d H:i', $aloitusaika),
            'lopetusaika' => date('Y-m-d H:i', $lopetusaika),
            'on_peruutettu' => NULL
        ));
        $varaus->save();
        Redirect::to('/', array('message' => 'Varaus tallennettu.'));
    }
            
    public static function edit($id) {
        $varaus = Varaus::find($id);
        View::make('varaus/varaus_muokkaa.html', array('varaus' => $varaus));
    }
    
    public static function update($id) {
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
        $errors = array();
//        $errors = $varaus->errors();
        
        if(count($errors) > 0){
            View::make('varaus/varaus_muokkaa.html', 
                    array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $varaus->update();
            Redirect::to('/varaus', array('message' => 
                'Varauksen tiedot päivitetty!'));
        }
    }
    
    public static function destroy($id) {
        $varaus = Varaus::find($id);
        $varaus->destroy();        
        Redirect::to('/varaus', 
                array('message' => 'Varaus poistettu.'));
    }
}
