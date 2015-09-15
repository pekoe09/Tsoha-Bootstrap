<?php

class TyontekijaController extends BaseController {
    
    public static function index(){
        $tyontekijat = Tyontekija::all();
        View::make('tyontekija/tyontekija_lista.html', array('tyontekijat'=>$tyontekijat));
    }
    
//    public static function show($id){
//        $tyontekija = Tyontekija::find($id);
//        View::make('tyontekija/tyontekija.html', array('tyontekija'=>$tyontekija));
//    }
    
    public static function create(){
        View::make('tyontekija/tyontekija_lisaa.html');
    }

    public static function store(){
        $params = $_POST;
        $tyontekija = new Tyontekija(array(
            'sukunimi' => $params['sukunimi'],
            'etunimi' => $params['etunimi'],
            'sahkoposti' => $params['sahkoposti'],
            'on_johtaja' => $params['on_johtaja'],
            'aloitus_pvm' => $params['aloitus_pvm'],
            'lopetus_pvm' => $params['lopetus_pvm'],
            'salasana' => $params['salasana']
        ));
        $tyontekija->save();
        
        Redirect::to('/tyontekija/' . $tyontekija->id, array('message' => 'Työntekijä tallennettu.'));
    }
}
