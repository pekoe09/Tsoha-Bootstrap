<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  echo 'Tämä on etusivu';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make('helloworld.html');
    }
    
    public static function palvelu_lista(){
        View::make('suunnitelmat/palvelu_lista.html');
    }
    
    public static function palvelu(){
        View::make('suunnitelmat/palvelu.html');
    }    
        
    public static function tyontekija_lista(){
        View::make('suunnitelmat/tyontekija_lista.html');
    }
    
    public static function tyontekija(){
        View::make('suunnitelmat/tyontekija.html');
    }
    
    public static function toimitila_lista(){
        View::make('suunnitelmat/toimitila_lista.html');
    }
    
    public static function toimitila(){
        View::make('suunnitelmat/toimitila.html');
    }
    
    public static function varaus_lista(){
        View::make('suunnitelmat/varaus_lista.html');
    }
    
    public static function varaus(){
        View::make('suunnitelmat/varaus.html');
    }
    
    public static function tilastot(){
        View::make('suunnitelmat/tilastot.html');
    }
  }
