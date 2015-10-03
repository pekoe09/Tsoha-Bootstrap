<?php

class Asiakasvaraus extends Varaus{
    public $asiakas_etunimi, $asiakas_sukunimi, $palvelu_nimi, $toimitila_nimi, 
            $katuosoite, $tyontekija_etunimi, $tyontekija_sukunimi;
            
    public function __construct($attributes) {
        parent::__construct($attributes);        
    }
}
