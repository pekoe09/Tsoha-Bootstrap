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
        $attributes = array(
            'nimi' => $params['nimi'],
            'katuosoite' => $params['katuosoite'],
            'paikkakunta' => $params['paikkakunta']
        );        
        $toimitila = new Toimitila($attributes);
        $errors = $toimitila->errors();
        
        if(count($errors) > 0){
            View::make('toimitila/toimitila_lisaa.html',
                    array('errors' => $errors, 'toimitila' => $toimitila));
        } else {
            $toimitila->save();
            Redirect::to('/toimitila', array('message' => 'Toimitila tallennettu.'));
        }  
    }
        
    public static function edit($id) {
        $toimitila = Toimitila::find($id);
        View::make('toimitila/toimitila_muokkaa.html', array('toimitila' => $toimitila));
    }
    
    public static function update($id) {
        $params = $_POST;
        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'katuosoite' => $params['katuosoite'],
            'paikkakunta' => $params['paikkakunta']
        );
        
        $toimitila = new Toimitila($attributes);
        $errors = $toimitila->errors();
        
        if(count($errors) > 0){
            View::make('toimitila/muokkaa.html', 
                    array('errors' => $errors, 'toimitila' => $toimitila));
        } else {
            $toimitila->update();
            Redirect::to('/toimitila', array('message' => 
                'Toimitilan (' . $toimitila->nimi . ') tiedot päivitetty!'));
        }
    }
    
    public static function destroy($id) {
        $toimitila = Toimitila::find($id);
        $toimitila->destroy();        
        Redirect::to('/toimitila', 
                array('message' => 'Toimitila (' . $toimitila->nimi . ') poistettu.'));
    }
}
