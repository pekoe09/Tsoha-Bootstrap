<?php

class Varaus extends BaseModel {
    
    public $id, $asiakas_id, $palvelu_id, $tyontekija_id, $toimitila_id,
            $aloitusaika, $lopetusaika, $on_peruutettu;
    
    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validate_asiakas_id', 'validate_palvelu_id', 
            'validate_tyontekija_id', 'validate_toimitila_id', 'validate_aloitusaika',
            'validate_lopetusaika');
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
        
    public function update(){
        $statement = 'UPDATE varaus SET "asiakas_id" = :asiakas_id, "palvelu_id" = :palvelu_id, "tyontekija_id" = :tyontekija_id,'
                . '"toimitila_id" = :toimitila_id, "aloitusaika" = aloitusaika, "lopetusaika" = lopetusaika, "on_peruutettu" = on_peruutettu WHERE "id" = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'asiakas_id' => $this->asiakas_id,
            'palvelu_id' => $this->palvelu_id,
            'tyontekija_id' => $this->tyontekija_id,
            'toimitila_id' => $this->toimitila_id,
            'aloitusaika' => $this->aloitusaika,
            'lopetusaika' => $this->lopetusaika,
            'on_peruutettu' => $this->on_peruutettu,
            'id' => $this->id
        ));
    }
    
    public function destroy(){
        $statement = 'DELETE FROM varaus WHERE "id" = :id';
                $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'id' => $this->id
        ));
    }
    
    public function validate_asiakas_id(){
        return $this->validate_number('Asiakas', $this->asiakas_id, 1, null, true, false);
    }
    
    public function validate_palvelu_id(){
        return $this->validate_number('Palvelu', $this->palvelu_id, 1, null, true, false);
    }
    
    public function validate_tyontekija_id(){
        return $this->validate_number('Terapeutti', $this->tyontekija_id, 1, null, true, false);
    }
    
    public function validate_toimitila_id(){
        return $this->validate_number('Toimipaikka', $this->toimitila_id, 1, null, true, false);
    }
    
    public function validate_aloitusaika(){
        return $this->validate_date('Aloitusaika', $this->aloitusaika, null, null, false);
    }
    
    public function validate_lopetusaika(){
        return $this->validate_date('Lopetusaika', $this->lopetusaika, null, null, false);
    }
}
