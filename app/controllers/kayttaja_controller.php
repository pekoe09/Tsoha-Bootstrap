<?php

class KayttajaController extends BaseController {
    
    public static function login(){
        View::make('kirjaudu.html');
    }
    
    public static function handleLogin(){
        $params = $_POST;
        $kayttaja = Kayttaja::authenticate($params['sahkoposti'], $params['salasana']);
        
        if(!$kayttaja){
            View::make('kirjaudu.html', array(
                'error' => 'Käyttäjätunnus tai salasana väärin.', 
                'sahkoposti' => $params['sahkoposti']));
        } else {
            $_SESSION['user'] = $kayttaja->id;
            $_SESSION['etunimi'] = $kayttaja->etunimi;           
            $_SESSION['tyyppi'] = get_class($kayttaja);
            if(is_a($kayttaja, 'tyontekija') && $kayttaja->on_johtaja)
                $_SESSION['tyyppi'] = 'johtaja';
            
            Redirect::to('/', array('message' =>'Hei ' . $kayttaja->etunimi));
        }        
    }    
}
