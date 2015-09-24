<?php

class Palvelu extends BaseModel {
    
    public $id, $nimi, $kesto, $kuvaus;
    
    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_kesto', 'validate_kuvaus');
    }
    
    public static function all(){
        $statement = 'SELECT * FROM palvelu';
        $query = DB::connection()->prepare($statement);
        $query->execute();
        $rows = $query->fetchAll();
        $palvelut = array();
        foreach($rows as $row)
            $palvelut[] = new Palvelu(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kesto' => $row['kesto'],
                'kuvaus' => $row['kuvaus']
            ));
        return $palvelut;
    }
    
    public static function find($id){
        $statement = 'SELECT * FROM palvelu WHERE id = :id LIMIT 1';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $palvelu = new Palvelu(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'kesto' => $row['kesto'],
                'kuvaus' => $row['kuvaus']
            ));
            return $palvelu;
        }
        
        return null;
    }
    
    public function save(){
        $statement = 'INSERT INTO palvelu ("nimi", "kesto", "kuvaus")'
                    . 'VALUES (:nimi, :kesto, :kuvaus) RETURNING id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'nimi' => $this->nimi,
            'kesto' => $this->kesto,
            'kuvaus' => $this->kuvaus
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
        
    public function update(){
        $statement = 'UPDATE palvelu SET "nimi" = :nimi, "kesto" = :kesto, "kuvaus" = :kuvaus,'
                . ' WHERE "id" = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'nimi' => $this->nimi,
            'kesto' => $this->kesto,
            'kuvaus' => $this->kuvaus,
            'id' => $this->id
        ));
    }
    
    public function destroy(){
        $statement = 'DELETE FROM palvelu WHERE "id" = :id';
                $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'id' => $this->id
        ));
    }
    
    public function validate_nimi(){
        return $this->validate_string_length('Nimi', $this->nimi, 1, 100, false);
    }
    
    public function validate_kesto(){
        return $this->validate_time('Kesto', $this->kesto, 
                new DateInterval('PT0H15M'), new DateInterval('PT10H'), false);
    }
    
    public function validate_kuvaus(){
        return $this->validate_string_length('Kuvaus', $this->kuvaus, 0, 5000, true);
    }
}
