<?php

class Kayttaja extends BaseModel {
    
    public $id, $sahkoposti, $salasana, $etunimi, $sukunimi, $tyyppi;
    
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
}
