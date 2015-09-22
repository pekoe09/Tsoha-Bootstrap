<?php

class TyontekijaController extends BaseController {
    
    public static function index(){
        $tyontekijat = Tyontekija::all();
        View::make('tyontekija/tyontekija_lista.html', array('tyontekijat'=>$tyontekijat));
    }
    
    public static function show($id){
        $tyontekija = Tyontekija::find($id);
        View::make('tyontekija/tyontekija.html', array('tyontekija'=>$tyontekija));
    }
    
    public static function create(){
        View::make('tyontekija/tyontekija_lisaa.html');
    }

    public static function store(){
        $params = $_POST;  
        $false = false;
        $tyontekija = new Tyontekija(array(
            'sukunimi' => $params['sukunimi'],
            'etunimi' => $params['etunimi'],
            'sahkoposti' => $params['sahkoposti'],
            'on_johtaja' => $false,
            'aloitus_pvm' => $params['aloitus_pvm'],
            'lopetus_pvm' => $params['lopetus_pvm'],
            'salasana' => 'xyz'
        ));
        $tyontekija->save();
        
        Redirect::to('/tyontekija/' . $tyontekija->id, array('message' => 'Työntekijä tallennettu.'));
    }
        
    public static function edit($id) {
        $tyontekija = Tyontekija::find($id);
        View::make('tyontekija/tyontekija_muokkaa.html', array('tyontekija' => $tyontekija));
    }
    
    public static function update($id) {
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'sukunimi' => $params['sukunimi'],
            'etunimi' => $params['etunimi'],
            'sahkoposti' => $params['sahkoposti'],
            'on_johtaja' => false,
            'aloitus_pvm' => $params['aloitus_pvm'],
            'lopetus_pvm' => $params['lopetus_pvm'],
            'salasana' => 'xyz'
        );
        
        $tyontekija = new Tyontekija($attributes);
        $errors = array();
//        $errors = $tyontekija->errors();
        
        if(count($errors) > 0){
            View::make('tyontekija/muokkaa.html', 
                    array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $tyontekija->update();
            Redirect::to('/tyontekija', array('message' => 
                'Työntekijän (' . $tyontekija->etunimi . ' ' . $tyontekija->sukunimi . ') tiedot päivitetty!'));
        }
    }
    
    public static function destroy($id) {
        $tyontekija = Tyontekija::find($id);
        $tyontekija->destroy();        
        Redirect::to('/tyontekija', 
                array('message' => 'Asiakas (' . $tyontekija->etunimi . ' ' . $tyontekija->sukunimi . ') poistettu.'));
    }
}
