<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });
  
  $routes->get('/etusivu', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/palvelu', function(){
      PalveluController::index();
  });
  
  $routes->get('/palvelu/:id', function($id){
      PalveluController::show($id);
  });
  
  $routes->get('/tyontekija', function(){
      HelloWorldController::tyontekija_lista();
  });
  
  $routes->get('/tyontekija/1', function(){
      HelloWorldController::tyontekija();
  });
    
  $routes->get('/toimitila', function(){
      HelloWorldController::toimitila_lista();
  });
  
  $routes->get('/toimitila/1', function(){
      HelloWorldController::toimitila();
  });
      
  $routes->get('/varaus', function(){
      HelloWorldController::varaus();
  });
  
  $routes->get('/varaus/1', function(){
      HelloWorldController::varaus();
  });
    
  $routes->get('/tilastot', function(){
      HelloWorldController::tilastot();
  });
  
  $routes->get('/kirjaudu', function(){
      HelloWorldController::kirjaudu();
  });
  
  $routes->get('/omat_tiedot', function(){
      HelloWorldController::omat_tiedot();
  });