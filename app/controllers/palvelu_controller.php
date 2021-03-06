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
        $attributes = array(
            'nimi' => $input['nimi'],
            'kesto' => $input['kesto'],
            'kuvaus' => $input['kuvaus']
        );
        $palvelu = new Palvelu($attributes);
        $errors = $palvelu->errors();
        
        if(count($errors) > 0){
            $response = json_encode(array(
                'status' => 'error',
                'errors' => $errors
            ));
            echo $response;
        } else {
            // tallennetaan ensin palvelu, sitten sen liitännäistiedot
            $palvelu->save();   
            if($palvelu->id != null){
                $palvelu->saveOffices($input['soveltuvat_toimitilat']);
                $palvelu->saveTherapists($input['tarjoavat_tyontekijat']);
            }
            
            // näkymän ajax-kutsulle palautetaan uudelleenohjausosoite, jotta se voi hoitaa ohjauksen
            $redirection = json_encode(array(
                'status' => 'success',
                'redirect' => urlencode($palvelu->id), 
                array('message' => 'Palvelu tallennettu')
                ));
            echo $redirection;
        }
    }    
    
    public static function edit($id) {
        self::check_logged_in(array("johtaja"));
        $palvelu = Palvelu::find($id);
        $toimitilat = Toimitila::allWithService($id);
        $tyontekijat =  Tyontekija::allWithService($id);
        View::make('palvelu/palvelu_muokkaa.html', array(
            'palvelu' => $palvelu,
            'toimitilat' => $toimitilat,
            'tyontekijat' => $tyontekijat
            ));
    }
    
    public static function update($id) {
        self::check_logged_in(array("johtaja"));
        $request = file_get_contents('php://input');
        $input = json_decode($request, true);
        $attributes = array(
            'id' => $id,
            'nimi' => $input['nimi'],
            'kesto' => $input['kesto'],
            'kuvaus' => $input['kuvaus']
        );
        
        $palvelu = new Palvelu($attributes);        
        $errors = $palvelu->errors();
        
        if(count($errors) > 0){
            $response = json_encode(array(
                'status' => 'error',
                'errors' => $errors
            ));
            echo $response;
        } else {
            // tallennetaan ensin palvelu, sitten sen liitännäistiedot            
            $palvelu->update();
            $palvelu->saveOffices($input['soveltuvat_toimitilat']);
            $palvelu->saveTherapists($input['tarjoavat_tyontekijat']);
            
            // näkymän ajax-kutsulle palautetaan uudelleenohjausosoite, jotta se voi hoitaa ohjauksen
            $redirection = json_encode(array(
                'status' => 'success',
                'redirect' => '/palvelu', 
                array('message' => 'Palvelu tallennettu')
                ));
            echo $redirection;
        }
    }
    
    public static function destroy($id) {
        self::check_logged_in(array("johtaja"));
        $palvelu = Palvelu::find($id);
        
        $errors = $palvelu->validate_destroyability();
        
        if(count($errors) > 0){
            Redirect::to('/palvelu', array('errors' => $errors));
        } else {  
            $palvelu->destroy();        
            Redirect::to('/palvelu', 
                    array('message' => 'Palvelu (' . $palvelu->nimi . ') poistettu.'));
        }
    }
    
    public static function findResources(){
        self::check_logged_in(array("johtaja", "tyontekija", "asiakas"));
        $request = file_get_contents('php://input');
        $input = json_decode($request, true);
        
        $toimitilat = Toimitila::findForService($input['palvelu_id']);
        $tyontekijat = Tyontekija::findForService($input['palvelu_id']);
        
        $response = json_encode(array(
            'toimitilat' => $toimitilat,
            'tyontekijat' => $tyontekijat
        ));
        
        echo $response;
    }
}
