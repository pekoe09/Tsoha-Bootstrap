<?php

class Asiakas extends BaseModel {
    
    public $id, $sukunimi, $etunimi, $sahkoposti, $salasana;
    
    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validate_sukunimi', 'validate_etunimi', 'validate_sahkoposti', 'validate_salasana');
    }
    
    public static function all(){
        $statement = 'SELECT * FROM asiakas';
        $query = DB::connection()->prepare($statement);
        $query->execute();
        $rows = $query->fetchAll();
        $asiakkaat = array();
        foreach($rows as $row)
            $asiakkaat[] = new Asiakas(array(
                'id' => $row['id'],
                'sukunimi' => $row['sukunimi'],
                'etunimi' => $row['etunimi'],
                'sahkoposti' => $row['sahkoposti'],
                'salasana' => $row['salasana']
            ));
        return $asiakkaat;
    }
    
    public static function find($id){
        $statement = 'SELECT * FROM asiakas WHERE id = :id LIMIT 1';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $asiakas = new Asiakas(array(
                'id' => $row['id'],
                'sukunimi' => $row['sukunimi'],
                'etunimi' => $row['etunimi'],
                'sahkoposti' => $row['sahkoposti'],
                'salasana' => $row['salasana']
            ));
            return $asiakas;
        }
        
        return null;
    }
    
    public function save(){
        $statement = 'INSERT INTO asiakas ("sukunimi", "etunimi", "sahkoposti", "salasana")'
                    . 'VALUES (:sukunimi, :etunimi, :sahkoposti, :salasana) RETURNING id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'sukunimi' => $this->sukunimi,
            'etunimi' => $this->etunimi,
            'sahkoposti' => $this->sahkoposti,
            'salasana' => $this->salasana
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function update(){
        $statement = 'UPDATE asiakas SET "sukunimi" = :sukunimi, "etunimi" = :etunimi, "sahkoposti" = :sahkoposti,'
                . '"salasana" = :salasana WHERE "id" = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'sukunimi' => $this->sukunimi,
            'etunimi' => $this->etunimi,
            'sahkoposti' => $this->sahkoposti,
            'salasana' => $this->salasana,
            'id' => $this->id
        ));
    }
    
    public function destroy(){
        $statement = 'DELETE FROM asiakas WHERE "id" = :id';
                $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'id' => $this->id
        ));
    }
    
    public function validate_sukunimi(){
        return $this->validate_string_length('Sukunimi', $this->sukunimi, 1, 100, false);
    }
    
    public function validate_etunimi(){
        return $this->validate_string_length('Etunimi', $this->etunimi, 1, 100, false);
    }
    
    public function validate_sahkoposti(){
        return $this->validate_email('Sähköposti', $this->sahkoposti, false);
    }
    
    public function validate_salasana(){
        return $this->validate_password('Salasana', $this->salasana);
    }
}
