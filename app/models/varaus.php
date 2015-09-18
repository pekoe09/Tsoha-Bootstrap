<?php

class Varaus extends BaseModel {
    
    public $id, $asiakas_id, $palvelu_id, $tyontekija_id, $toimitila_id,
            $aloitusaika, $lopetusaika, $on_peruutettu;
    
    public function __construct($attributes){
        parent::__construct($attributes);
    }
    
    public static function all(){
        $statement = 'SELECT * FROM varaus';
        $query = DB::connection()->prepare($statement);
        $query->execute();
        $rows = $query->fetchAll();
        $varaukset = array();
        foreach($rows as $row)
            $varaukset[] = new Varaus(array(
                'id' => $row['id'],
                'asiakas_id' => $row['asiakas_id'],
                'palvelu_id' => $row['palvelu_id'],
                'tyontekija_id' => $row['tyontekija_id'],
                'toimitila_id' => $row['toimitila_id'],
                'aloitusaika' => $row['aloitusaika'],
                'lopetusaika' => $row['lopetusaika'],
                'on_peruutettu' => $row['on_peruutettu']
            ));
        return $varaukset;
    }
    
    public static function find($id){
        $statement = 'SELECT * FROM varaus WHERE id = :id LIMIT 1';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $varaus = new Varaus(array(
                'id' => $row['id'],
                'asiakas_id' => $row['asiakas_id'],
                'palvelu_id' => $row['palvelu_id'],
                'tyontekija_id' => $row['tyontekija_id'],
                'toimitila_id' => $row['toimitila_id'],
                'aloitusaika' => $row['aloitusaika'],
                'lopetusaika' => $row['lopetusaika'],
                'on_peruutettu' => $row['on_peruutettu']
            ));
            return $varaus;
        }
        
        return null;
    }
    
    public function save(){
        $statement = 'INSERT INTO varaus ("asiakas_id", "palvelu_id", "tyontekija_id", '
                    . '"toimitila_id", "aloitusaika", "lopetusaika", "on_peruutettu")'
                    . 'VALUES (:asiakas_id, :palvelu_id, :tyontekija_id, '
                    . ':toimitila_id, :aloitusaika, :lopetusaika, :on_peruutettu) RETURNING id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'asiakas_id' => $this->asiakas_id,
            'palvelu_id' => $this->palvelu_id,
            'tyontekija_id' => $this->tyontekija_id,
            'toimitila_id' => $this->toimitila_id,
            'aloitusaika' => $this->aloitusaika,
            'lopetusaika' => $this->lopetusaika,
            'on_peruutettu' => $this->on_peruutettu
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
}
