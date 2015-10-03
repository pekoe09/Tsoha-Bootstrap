<?php

class Kayttaja extends BaseModel {
    
    public $id, $sahkoposti, $salasana, $salasana2, $etunimi, $sukunimi, $tyyppi;
    
    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validate_sukunimi', 'validate_etunimi', 'validate_salasana');
    }
    
    public static function authenticate($sahkoposti, $salasana){
        // etsitään käyttäjää ensin asiakas-taulusta ja sitten tyontekija-taulusta
        $tyyppi = 'asiakas';
        $statement = 'SELECT * FROM asiakas WHERE sahkoposti = :sahkoposti AND salasana = :salasana LIMIT 1';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('sahkoposti' =>  $sahkoposti, 'salasana' => $salasana));
        $row = $query->fetch();
        
        if(!$row){
            $tyyppi = 'tyontekija';
            $statement = 'SELECT * FROM tyontekija WHERE sahkoposti = :sahkoposti AND salasana = :salasana LIMIT 1';
            $query = DB::connection()->prepare($statement);
            $query->execute(array('sahkoposti' =>  $sahkoposti, 'salasana' => $salasana));
            $row = $query->fetch();
            if($row && $row['on_johtaja'] == 1){
                $tyyppi = 'johtaja';
            }
        }
        
        if(!$row){
            return null;
        }else{
            $user = new Kayttaja(array(
                'id' => $row['id'],
                'sukunimi' => $row['sukunimi'],
                'etunimi' => $row['etunimi'],
                'sahkoposti' => $row['sahkoposti'],
                'tyyppi' => $tyyppi
            ));
            return $user;
        }
            
    }
    
    public static function find($id, $tyyppi){
        $paatyyppi = $tyyppi;
        if($tyyppi == 'johtaja'){
            $paatyyppi = 'tyontekija';
        }
        $statement = 'SELECT * FROM ' . $paatyyppi . ' WHERE ID = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if(!$row){
            return null;
        } else {
            $user = new Kayttaja(array(
                'id' => $row['id'],
                'sukunimi' => $row['sukunimi'],
                'etunimi' => $row['etunimi'],
                'sahkoposti' => $row['sahkoposti'],
                'tyyppi' => $tyyppi
            ));
            return $user;
        }
    }
    
    public function validate_sukunimi(){
        return $this->validate_string_length('Sukunimi', $this->sukunimi, 1, 100, false);
    }
    
    public function validate_etunimi(){
        return $this->validate_string_length('Etunimi', $this->etunimi, 1, 100, false);
    }
    
    public function validate_salasana(){
        if(strcmp($this->salasana, $this->salasana2) != 0)
            return array('error' => 'Annetut salasanat eivät täsmää!');
        return $this->validate_string_length('Salasana', $this->salasana, 1, 40, false);
    }
}
