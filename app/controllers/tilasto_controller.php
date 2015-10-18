<?php

class TilastoController extends BaseController{
    
    public static function index(){
        self::check_logged_in(array('johtaja'));
        View::make('tilastot/tyontekijatilasto.html');
    }  
    
    public static function getStats(){
        self::check_logged_in(array('johtaja'));
        $params = $_POST;
        $terapeuttitilastot = Terapeuttitilasto::allForPeriod($params['alkaen_pvm'], $params['asti_pvm']);
        View::make('tilastot/tyontekijatilasto.html', array(
            'terapeuttitilastot' => $terapeuttitilastot,
            'alkaen_pvm' => $params['alkaen_pvm'],
            'asti_pvm' => $params['asti_pvm']));
    }  
}
