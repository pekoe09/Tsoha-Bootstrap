<?php

class Asiakas extends BaseModel {
    
    public $id, $sukunimi, $etunimi, $sahkoposti, $salasana;
    
    public function __construct($attributes){
        parent::__construct($attributes);
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
}