<?php

class Kayttaja extends BaseModel {
    
    public $id, $sahkoposti, $salasana, $etunimi, $sukunimi;
    
    public static function authenticate($sahkoposti, $salasana){
        // etsitään käyttäjää ensin asiakas-taulusta ja sitten tyontekija-taulusta
        $statement = 'SELECT * FROM asiakas WHERE sahkoposti = :sahkoposti AND salasana = :salasana LIMIT 1';
        $query = DB::connection()->prepare($statement, array(
           'sahkoposti'  => $sahkoposti,
           'salasana' => $salasana
        ));
        $query->execute();
        $row = $query->fetch();
        
        if(!$row){
            $statement = 'SELECT * FROM tyontekija WHERE sahkoposti = :sahkoposti AND salasana = :salasana LIMIT 1';
            $query = DB::connection()->prepare($statement, array(
                'sahkoposti'  => $sahkoposti,
                'salasana' => $salasana
            ));
            $query->execute();
            $row = $query->fetch();
        }
        
        if(!$row){
            ;
        }else{
            return ;
        }
            
    }
}
