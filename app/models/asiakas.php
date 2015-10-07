<?php

class Asiakas extends Kayttaja {
    
    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array_merge(
                $this->validators, 
                array('validate_sahkoposti')
            );
    }
    
    public static function all(){
        $statement = 'SELECT * FROM asiakas'
                . ' ORDER BY sukunimi, etunimi';
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
            
    public function validate_sahkoposti(){
        return array_merge(
                $this->validate_string_length('Sähköposti', $this->sahkoposti, 1, 200, false),
                $this->validate_string_uniqueness($this->sahkoposti, 'asiakas', 'sahkoposti', $this->id)
            );
    }
    
    public function validate_destroyability(){
        $issues = array();
        
        $statement = "SELECT COUNT(*) AS count FROM varaus WHERE asiakas_id = :asiakas_id";
        $query = DB::connection()->prepare($statement);
        $query->execute(array('asiakas_id' => $this->id));
        $row = $query->fetch();
        if($row){
            if($row['count'] > 0){
                $issues[] = 'Asiakasta ' . $this->etunimi . ' ' . $this->sukunimi . ' ei pystytä poistamaan; asiakkaaseen on liitetty varaustietoja.';
            }
        } else {
            $issues[] = 'Asiakkaan ' . $this->etunimi . ' ' . $this->sukunimi . ' poistettavuutta ei pystytty tarkistamaan.';
        }
        
        return $issues;
    }
}
