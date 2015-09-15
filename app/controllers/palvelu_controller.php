<?php

class PalveluController extends BaseController{
    
    public static function index(){
        $palvelut = Palvelu::all();
        View::make('palvelu/palvelu_lista.html', array('palvelut'=>$palvelut));
    }
    
    public static function show($id){
        $palvelu = Palvelu::find($id);
        View::make('palvelu/palvelu.html', array('palvelu'=>$palvelu));
    }
    
    public static function create(){
        View::make('palvelu/palvelu_lisaa.html');
    }

    public static function store(){
        $params = $_POST;
        $palvelu = new Palvelu(array(
            'nimi' => $params['nimi'],
            'kesto' => $params['kesto'],
            'kuvaus' => $params['kuvaus']
        ));
        $palvelu->save();
        
        Redirect::to('/palvelu/' . $palvelu->id, array('message' => 'Palvelu tallennettu.'));
    }
    
}
