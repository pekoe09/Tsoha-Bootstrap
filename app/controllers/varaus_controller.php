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
        $aloitusaika = $params['paiva'] + $params['kellonaika'];
        $lopetusaika = $aloitusaika + $palvelu->kesto;
        $varaus= new Varaus(array(
            'asiakas_id' => $params['asiakas_id'],
            'palvelu_id' => $params['palvelu_id'],
            'tyontekija_id' => $params['tyontekija_id'],
            'toimitila_id' => $params['toimitila_id'],
            'aloitusaika' => $aloitusaika,
            'lopetusaika' => $lopetusaika,
            'on_peruutettu' => NULL
        ));
        $varaus->save();
        
        Redirect::to('/varaus/' . $varaus->id, array('message' => 'Varaus tallennettu.'));
    }
}
