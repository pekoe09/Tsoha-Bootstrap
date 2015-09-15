<?php

class Toimitila extends BaseModel {
    
    public $id, $nimi, $katuosoite, $paikkakunta;
    
    public function __construct($attributes){
        parent::__construct($attributes);
    }
    
    public static function all(){
        $statement = 'SELECT * FROM toimitila';
        $query = DB::connection()->prepare($statement);
        $query->execute();
        $rows = $query->fetchAll();
        $toimitilat = array();
        foreach($rows as $row)
            $toimitilat[] = new Toimitila(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'katuosoite' => $row['katuosoite'],
                'paikkakunta' => $row['paikkakunta']
            ));
        return $toimitilat;
    }
    
    public static function find($id){
        $statement = 'SELECT * FROM toimitila WHERE id = :id LIMIT 1';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $toimitila = new Toimitila(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'katuosoite' => $row['katuosoite'],
                'paikkakunta' => $row['paikkakunta']
            ));
            return $toimitila;
        }
        
        return null;
    }
    
    public function save(){
        $statement = 'INSERT INTO toimitila ("nimi", "katuosoite", "paikkakunta")'
                    . 'VALUES (:nimi, :katuosoite, :paikkakunta) RETURNING id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'nimi' => $this->nimi,
            'katuosoite' => $this->katuosoite,
            'paikkakunta' => $this->paikkakunta
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
}
