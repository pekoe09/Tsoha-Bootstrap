<?php

class AsiakasController extends BaseController {
    
    public static function index(){
        $asiakkaat = Asiakas::all();
        View::make('asiakas/asiakas_lista.html', array('asiakkaat'=>$asiakkaat));
    }
    
    public static function show($id){
        $asiakas = Asiakas::find($id);
        View::make('asiakas/asiakas.html', array('asiakas'=>$asiakas));
    }
    
    public static function create(){
        View::make('asiakas/asiakas_lisaa.html');
    }

    public static function store(){
        $params = $_POST;
        $asiakas = new Asiakas(array(
            'sukunimi' => $params['sukunimi'],
            'etunimi' => $params['etunimi'],
            'sahkoposti' => $params['sahkoposti'],
            'salasana' => $params['salasana']
        ));
        $asiakas->save();
        
        Redirect::to('/asiakas/' . $asiakas->id, array('message' => 'Tiedot tallennettu - tervetuloa asiakkaaksi!'));
    }
}
