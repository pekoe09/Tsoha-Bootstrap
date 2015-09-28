<?php
  
  class BaseController{   
      
    public static function get_user_logged_in(){
      if(isset($_SESSION['user'])){
          $user_id = $_SESSION['user'];
          $user = Kayttaja::find($user_id, $_SESSION['tyyppi']);
          return $user;
      }
      return null;
    }

    public static function check_logged_in($kayttajatyypit){
        if(!isset($_SESSION['user'])){
            Redirect::to('/kirjaudu', array('message' => 'Sinun on ensin kirjauduttava sisään.'));
        } else if(!in_array($_SESSION['tyyppi'], $kayttajatyypit)){
            $errors = array('Käyttöoikeutesi eivät riitä yrittämääsi toimintoon!');
            Redirect::to('/', array('errors' => $errors));
        }
    }

  }
