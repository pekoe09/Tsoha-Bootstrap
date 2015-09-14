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

    public static function store(){
        
    }
    
}
