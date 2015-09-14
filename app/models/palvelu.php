<?php

class Palvelu extends BaseModel {
    
    public $id, $nimi, $kesto, $kuvaus;
    
    public function __construct($attributes){
        parent::__construct($attributes);
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
        $query->execute();
        $row = $query->fetch();
    }
}