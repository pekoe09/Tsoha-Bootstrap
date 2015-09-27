<?php

class Asiakasvaraus extends Varaus{
    public $palvelu_nimi, $toimitila_nimi, $katuosoite, $etunimi, $sukunimi;
            
    public function __construct($attributes) {
        parent::__construct($attributes);        
    }
}
