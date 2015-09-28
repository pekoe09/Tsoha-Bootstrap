<?php

class Toimitila extends BaseModel {
    
    public $id, $nimi, $katuosoite, $paikkakunta;
    
    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_katuosoite', 'validate_paikkakunta');
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
    
    public static function findForService($palvelu_id){
        $statement = 'SELECT t.id, t.nimi, t.katuosoite, t.paikkakunta'
                . ' FROM toimitila t'
                . ' INNER JOIN toimitila_palvelu tp ON t.id = tp.toimitila_id'
                . ' WHERE tp.palvelu_id = :palvelu_id'
                . ' ORDER BY t.nimi';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('palvelu_id' => $palvelu_id));
        $rows = $query->fetchAll();
        $toimitilat = array();
        foreach($rows as $row){
            $toimitilat[] = new Toimitila(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'katuosoite' => $row['katuosoite'],
                'paikkakunta' => $row['paikkakunta']
            ));
        }
        return $toimitilat;        
        
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
    
    public function update(){
        $statement = 'UPDATE toimitila SET "nimi" = :nimi, "katuosoite" = :katuosoite, "paikkakunta" = :paikkakunta'
                . ' WHERE "id" = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'nimi' => $this->nimi,
            'katuosoite' => $this->katuosoite,
            'paikkakunta' => $this->paikkakunta,
            'id' => $this->id
        ));
    }
    
    public function destroy(){
        $statement = 'DELETE FROM toimitila WHERE "id" = :id';
                $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'id' => $this->id
        ));
    }
    
    public function validate_nimi(){
        return $this->validate_string_length('Nimi', $this->nimi, 1, 100, false);
    }
    
    public function validate_katuosoite(){
        return $this->validate_string_length('Katuosoite', $this->katuosoite, 1, 200, false);
    }
    
    public function validate_paikkakunta(){
        return $this->validate_string_length('Paikkakunta', $this->paikkakunta, 1, 50, false);
    }
}
