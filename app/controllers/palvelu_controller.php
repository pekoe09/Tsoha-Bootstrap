<?php

class PalveluController extends BaseController{
    
    public static function index(){
        $palvelut = Palvelu::all();
        View::make('palvelu/palvelu_lista.html', array('palvelut'=>$palvelut));
    }
    
    public static function show($id){
        $palvelu = Palvelu::find($id);
        $tyontekijat = Tyontekija::findForService($id);
        $toimitilat = Toimitila::findForService($id);
        View::make('palvelu/palvelu.html', array(
            'palvelu' => $palvelu,
            'tyontekijat' => $tyontekijat,
            'toimitilat' => $toimitilat
        ));
    }
    
    public static function create(){
        self::check_logged_in(array("johtaja"));
        $toimitilat = Toimitila::all();
        $tyontekijat =  Tyontekija::all();
        View::make('palvelu/palvelu_lisaa.html', array(
            'toimitilat' => $toimitilat,
            'tyontekijat' => $tyontekijat
        ));
    }

    public static function store(){     
        self::check_logged_in(array("johtaja"));
        $request = file_get_contents('php://input');
        $input = json_decode($request, true);
        $palvelu = new Palvelu(array(
            'nimi' => $input['nimi'],
            'kesto' => $input['kesto'],
            'kuvaus' => $input['kuvaus']
        ));
        $tsekki = 'ei mitään';
        if ($input)
            $tsekki = 'jotain'; else $tsekki = 'tyhjä';
        
        $palvelu->save();
        
        Redirect::to('/palvelu/' . $palvelu->id, array('message' => 'Palvelu tallennettu.'));
    }    
    
    public static function edit($id) {
        self::check_logged_in(array("johtaja"));
        $palvelu = Palvelu::find($id);
        View::make('palvelu/palvelu_muokkaa.html', array('palvelu' => $palvelu));
    }
    
    public static function update($id) {
        self::check_logged_in(array("johtaja"));
        $request = file_get_contents('php://input');
        $input = json_decode($request, true);
        $palvelu = new Palvelu(array(
            'id' => $id,
            'nimi' => $input['nimi'],
            'kesto' => $input['kesto'],
            'kuvaus' => $input['kuvaus']
        ));
        
        $errors = array();
//        $errors = $palvelu->errors();
        
        if(count($errors) > 0){
            View::make('palvelu/palvelu_muokkaa.html', 
                    array('errors' => $errors, 'palvelu' => $palvelu));
        } else {
            $palvelu->update();
            Redirect::to('/palvelu', array('message' => 
                'Palvelun (' . $palvelu->nimi . ') tiedot päivitetty!'));
        }
    }
    
    public static function destroy($id) {
        self::check_logged_in(array("johtaja"));
        $palvelu = Palvelu::find($id);
        $palvelu->destroy();        
        Redirect::to('/palvelu', 
                array('message' => 'Palvelu (' . $palvelu->nimi . ') poistettu.'));
    }
}
