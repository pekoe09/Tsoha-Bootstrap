<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/palvelu', function(){
      HelloWorldController::palvelu_lista();
  });
  
  $routes->get('/palvelu/1', function(){
      HelloWorldController::palvelu();
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