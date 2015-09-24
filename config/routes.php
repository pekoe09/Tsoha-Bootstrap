<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });
  
  $routes->get('/etusivu', function() {
      EtusivuController::index();
  });
  
  $routes->get('/login', function(){
      KayttajaController::login();
  });
  
  $routes->post('/login', function(){
      KayttajaController::handleLogin();
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
        
  $routes->get('/palvelu/:id/muokkaa', function($id){
      PalveluController::edit($id);
  });
  
  $routes->post('/palvelu/:id/muokkaa', function($id){
      PalveluController::update($id);
  });
  
  $routes->post('/palvelu/:id/poista', function($id){
      PalveluController::destroy($id);
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
      
  $routes->get('/tyontekija/:id/muokkaa', function($id){
      TyontekijaController::edit($id);
  });
  
  $routes->post('/tyontekija/:id/muokkaa', function($id){
      TyontekijaController::update($id);
  });
  
  $routes->post('/tyontekija/:id/poista', function($id){
      TyontekijaController::destroy($id);
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
    
  $routes->get('/toimitila/:id/muokkaa', function($id){
      ToimitilaController::edit($id);
  });
  
  $routes->post('/toimitila/:id/muokkaa', function($id){
      ToimitilaController::update($id);
  });
  
  $routes->post('/toimitila/:id/poista', function($id){
      ToimitilaController::destroy($id);
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
  
  $routes->get('/asiakas/:id/muokkaa', function($id){
      AsiakasController::edit($id);
  });
  
  $routes->post('/asiakas/:id/muokkaa', function($id){
      AsiakasController::update($id);
  });
  
  $routes->post('/asiakas/:id/poista', function($id){
      AsiakasController::destroy($id);
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
    
  $routes->get('/varaus/:id/muokkaa', function($id){
      VarausController::edit($id);
  });
  
  $routes->post('/varaus/:id/muokkaa', function($id){
      VarausController::update($id);
  });
  
  $routes->post('/varaus/:id/poista', function($id){
      VarausController::destroy($id);
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