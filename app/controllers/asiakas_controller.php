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
        
        Redirect::to('/', array('message' => 'Tiedot tallennettu - tervetuloa asiakkaaksi!'));
    }
    
    public static function edit($id) {
        $asiakas = Asiakas::find($id);
        View::make('asiakas/muokkaa.html', array('attributes' => $asiakas));
    }
    
    public static function update($id) {
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'sukunimi' => $params['sukunimi'],
            'etunimi' => $params['etunimi'],
            'sahkoposti' => $params['sahkoposti']
        );
        
        $asiakas = new Asiakas($attributes);
        $errors = $asiakas->errors();
        
        if(count($errors) > 0){
            View::make('asiakas/muokkaa.html', 
                    array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $asiakas->update();
            Redirect::to('/asiakas/' . $asiakas->id, array('message' => 'Tiedot päivitetty!'));
        }
    }
    
    public static function destroy($id) {
        $asiakas = new Asiakas(array('id' => $id));
        $asiakas->destroy();        
        Redirect::to('/asiakas', array('message' => 'Asiakas poistettu.'));
    }
}
