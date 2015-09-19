<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });
  
  $routes->get('/etusivu', function() {
      EtusivuController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/palvelu', function(){
      PalveluController::index();
  });
  
  $routes->post('/palvelu', function(){
      PalveluController::store();
  });
  
  $routes->get('/palvelu/uusi', function(){
      PalveluController::create();
  });
  
  $routes->get('/palvelu/:id', function($id){
      PalveluController::show($id);
  });
  
  $routes->get('/tyontekija', function(){
      TyontekijaController::index();
  });
  
  $routes->post('/tyontekija', function(){
      TyontekijaController::store();
  });
    
  $routes->get('/tyontekija/uusi', function(){
      TyontekijaController::create();
  });
  
  $routes->get('/tyontekija/:id', function($id){
      TyontekijaController::show($id);
  });
    
  $routes->get('/toimitila', function(){
      ToimitilaController::index();
  });
    
  $routes->post('/toimitila', function(){
      ToimitilaController::store();
  });
    
  $routes->get('/toimitila/uusi', function(){
      ToimitilaController::create();
  });
  
  $routes->get('/toimitila/:id', function($id){
      ToimitilaController::show($id);
  });
            
  $routes->get('/asiakas', function(){
      AsiakasController::index();
  });
    
  $routes->post('/asiakas', function(){
      AsiakasController::store();
  });
  
  $routes->get('/asiakas/uusi', function(){
      AsiakasController::create();
  });
  
  $routes->get('/varaus', function(){
      VarausController::index();
  });
  
  $routes->post('/varaus', function(){
      VarausController::store();
  });
    
  $routes->get('/varaus/uusi', function(){
      VarausController::create();
  });
  
  $routes->get('/varaus/:id', function($id){
      VarausController::show($id);
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