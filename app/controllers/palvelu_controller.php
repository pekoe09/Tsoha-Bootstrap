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
        $toimitilat = Toimitila::all();
        $tyontekijat =  Tyontekija::all();
        View::make('palvelu/palvelu_lisaa.html', array(
            'toimitilat' => $toimitilat,
            'tyontekijat' => $tyontekijat
        ));
    }

    public static function store(){
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
        
//        $params = $_POST;
//        $palvelu = new Palvelu(array(
//            'nimi' => $params['nimi'],
//            'kesto' => $params['kesto'],
//            'kuvaus' => $params['kuvaus']
//        ));
        
//        $palvelu->save();
        
//        Redirect::to('/palvelu/' . $palvelu->id, array('message' => 'Palvelu tallennettu.'));
        Redirect::to('/palvelu', array('message' => $tsekki . ' ' . $request . ' ' . $input));
    }
    
}
