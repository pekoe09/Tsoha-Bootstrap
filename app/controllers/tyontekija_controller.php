<?php

class TyontekijaController extends BaseController {
    
    public static function index(){
        self::check_logged_in(array("johtaja"));
        $tyontekijat = Tyontekija::all();
        View::make('tyontekija/tyontekija_lista.html', array('tyontekijat'=>$tyontekijat));
    }
    
    public static function show($id){
        self::check_logged_in(array("johtaja"));
        $tyontekija = Tyontekija::find($id);
        View::make('tyontekija/tyontekija.html', array('tyontekija'=>$tyontekija));
    }
    
    public static function ownShow($id){
        self::check_logged_in(array("tyontekija"));
        $tyontekija = Tyontekija::find($id);
        $varaukset = Varaus::findForResource($id, 'tyontekija');
        View::make('tyontekija/omat_tiedot.html', array(
            'tyontekija' => $tyontekija,
            'varaukset' => $varaukset
        ));
    }
    
    public static function create(){
        self::check_logged_in(array("johtaja"));
        View::make('tyontekija/tyontekija_lisaa.html');
    }

    public static function store(){
        self::check_logged_in(array("johtaja"));
        $params = $_POST;  
        $attributes = array(
            'sukunimi' => $params['sukunimi'],
            'etunimi' => $params['etunimi'],
            'sahkoposti' => $params['sahkoposti'],
            'on_johtaja' => false,
            'aloitus_pvm' => $params['aloitus_pvm'],
            'lopetus_pvm' => $params['lopetus_pvm'],
            'salasana' => $params['salasana'],
            'salasana2' => $params['salasana2']
        );
        
        $tyontekija = new Tyontekija($attributes);
        $errors = $tyontekija->errors();
        
        if(count($errors) > 0){
            View::make('tyontekija/tyontekija_lisaa.html',
                    array('errors' => $errors, 'tyontekija' => $tyontekija));
        }  else {
            $tyontekija->save();        
            Redirect::to('/tyontekija', array('message' => 'Työntekijä tallennettu.'));
        }
    }
        
    public static function edit($id) {
        self::check_logged_in(array("johtaja"));
        $tyontekija = Tyontekija::find($id);
        View::make('tyontekija/tyontekija_muokkaa.html', array('tyontekija' => $tyontekija));
    }
    
    public static function update($id) {
        self::check_logged_in(array("johtaja"));
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'sukunimi' => $params['sukunimi'],
            'etunimi' => $params['etunimi'],
            'sahkoposti' => $params['sahkoposti'],
            'on_johtaja' => false,
            'aloitus_pvm' => $params['aloitus_pvm'],
            'lopetus_pvm' => $params['lopetus_pvm'],
            'salasana' => $params['salasana'],
            'salasana2' => $params['salasana2']
        );
        
        $tyontekija = new Tyontekija($attributes);
        $errors = $tyontekija->errors();
        
        if(count($errors) > 0){
            View::make('tyontekija/tyontekija_muokkaa.html', 
                    array('errors' => $errors, 'tyontekija' => $tyontekija));
        } else {
            $tyontekija->update();
            Redirect::to('/tyontekija', array('message' => 
                'Työntekijän (' . $tyontekija->etunimi . ' ' . $tyontekija->sukunimi . ') tiedot päivitetty!'));
        }
    }
    
    public static function destroy($id) {
        self::check_logged_in(array("johtaja"));
        $tyontekija = Tyontekija::find($id);
        
        $errors = $tyontekija->validate_destroyability();
        
        if(count($errors) > 0){
            Redirect::to('/tyontekija', array('errors' => $errors));
        } else {            
            $tyontekija->destroy();        
            Redirect::to('/tyontekija', 
                    array('message' => 'Asiakas (' . $tyontekija->etunimi . ' ' . $tyontekija->sukunimi . ') poistettu.'));
        }
    }
}
