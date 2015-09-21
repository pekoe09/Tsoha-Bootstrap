<?php

class ToimitilaController extends BaseController{
    
    public static function index(){
        $toimitilat = Toimitila::all();
        View::make('toimitila/toimitila_lista.html', array('toimitilat'=>$toimitilat));
    }
    
    public static function show($id){
        $toimitila = Toimitila::find($id);
        View::make('toimitila/toimitila.html', array('toimitila'=>$toimitila));
    }
    
    public static function create(){
        View::make('toimitila/toimitila_lisaa.html');
    }

    public static function store(){
        $params = $_POST;
        $toimitila = new Toimitila(array(
            'nimi' => $params['nimi'],
            'katuosoite' => $params['katuosoite'],
            'paikkakunta' => $params['paikkakunta']
        ));
        $toimitila->save();
        
        Redirect::to('/toimitila', array('message' => 'Toimitila tallennettu.'));
    }
}
