<?php

class KayttajaController extends BaseController {
    
    public static function login(){
        View::make('kirjaudu.html');
    }
    
    public static function handleLogin(){
        $params = $_POST;
        
        $errors = array();
        if(!isset($params['sahkoposti']) || $params['sahkoposti'] == null || $params['sahkoposti'] == ''){
            $issue = array('Sähköposti puuttuu!');
            $errors = array_merge($errors, $issue);
        }
        if(!isset($params['salasana']) || $params['salasana'] == null || $params['salasana'] == ''){
            $issue = array('Salasana puuttuu!');
            $errors = array_merge($errors, $issue);
        }
        $kayttaja = null;
        $tyyppi = '';
        if(count($errors) == 0){
            $kayttaja = Kayttaja::authenticate($params['sahkoposti'], $params['salasana']);
        }
        
        if($kayttaja == null){
            // lisätään yleinen virheilmoitus vain jos sekä s-posti että salasana oli annettu
            if(count($errors) == 0){
                $issue = array('error'=>'Sähköpostiosoite tai salasana väärin.');
                $errors = array_merge($errors, $issue);
            }
            View::make('kirjaudu.html', array(
                'errors' => $errors, 
                'sahkoposti' => isset($params['sahkoposti']) ?  $params['sahkoposti'] : null
                ));
        } else {
            $_SESSION['user'] = $kayttaja->id;
            $_SESSION['tyyppi'] = $kayttaja->tyyppi;
            
            Redirect::to('/', array('message' =>'Hei ' . $kayttaja->etunimi));
        }        
    }
    
    public static function logout(){
        $_SESSION['user'] = null;
        Redirect::to('/', array('message' => 'Olet kirjautunut ulos; tervetuloa uudelleen!'));
    }
}
