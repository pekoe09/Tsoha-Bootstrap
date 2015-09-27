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
        $attributes = array(
            'sukunimi' => $params['sukunimi'],
            'etunimi' => $params['etunimi'],
            'sahkoposti' => $params['sahkoposti'],
            'salasana' => $params['salasana']
        );
        $asiakas = new Asiakas($attributes);
        $errors = $asiakas->errors();
        
        if(count($errors) > 0){
            View::make('asiakas/asiakas_lisaa.html', 
                    array('errors' => $errors, 'asiakas' => $asiakas));
        } else {
            $asiakas->save();        
            Redirect::to('/', array('message' => 'Tiedot tallennettu - tervetuloa asiakkaaksi!'));
        }
    }
    
    public static function edit($id) {
        $asiakas = Asiakas::find($id);
        View::make('asiakas/asiakas_muokkaa.html', array('asiakas' => $asiakas));
    }
    
    public static function update($id) {
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'sukunimi' => $params['sukunimi'],
            'etunimi' => $params['etunimi'],
            'sahkoposti' => $params['sahkoposti'],
            'salasana' => $params['salasana']
        );
        
        $asiakas = new Asiakas($attributes);
        $errors = $asiakas->errors();
        
        if(count($errors) > 0){
            View::make('asiakas/asiakas_muokkaa.html', 
                    array('errors' => $errors, 'asiakas' => $asiakas));
        } else {
            $asiakas->update();
            Redirect::to('/asiakas', array('message' => 
                'Asiakkaan (' . $asiakas->etunimi . ' ' . $asiakas->sukunimi . ') tiedot päivitetty!'));
        }
    }
    
    public static function destroy($id) {
//        $asiakas = new Asiakas(array('id' => $id));
        $asiakas = Asiakas::find($id);
        $asiakas->destroy();        
        Redirect::to('/asiakas', 
                array('message' => 'Asiakas (' . $asiakas->etunimi . ' ' . $asiakas->sukunimi . ') poistettu.'));
    }    
        
    public static function ownShow($id){
        $asiakas = Asiakas::find($id);
        $varaukset = Varaus::findForCustomer($id);
        View::make('asiakas/omat_tiedot.html', array(
            'asiakas'=>$asiakas,
            'varaukset'=>$varaukset
            ));
    }
    
    public static function ownUpdate($id){
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'sukunimi' => $params['sukunimi'],
            'etunimi' => $params['etunimi'],
            'sahkoposti' => $params['sahkoposti'],
            'salasana' => $params['salasana']
        );
        
        $asiakas = new Asiakas($attributes);
        $errors = $asiakas->errors();
        
        if(count($errors) > 0){
            View::make('asiakas/' .$id . 'omat_tiedot.html', 
                    array('errors' => $errors, 'asiakas' => $asiakas));
        } else {
            $asiakas->update();
            Redirect::to('/asiakas/' . $id . '/omat_tiedot', array('message' => 
                'Tietosi on päivitetty!'));
        }
    }
}
