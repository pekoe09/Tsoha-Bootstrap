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
    
    public function saveOffices($soveltuvat_toimitilat){
        // pyyhitään ensin aiemmat toimitilaliitokset pois, sitten tallennetaan
        // kaikki puhtaalta pöydältä
        $this->destroy_toimitila_connections();
        foreach($soveltuvat_toimitilat as $toimitila){
            $statement = 'INSERT INTO toimitila_palvelu ("toimitila_id", "palvelu_id")'
                    . ' VALUES (:toimitila_id, :palvelu_id)';
            $query = DB::connection()->prepare($statement);
            $query->execute(array(
                'toimitila_id' => $toimitila['toimitila_id'],
                'palvelu_id' => $this->id
            ));
        }
    }
    
    public function saveTherapists($tarjoavat_tyontekijat){
        // pyyhitään ensin aiemmat tyontekijäliitokset pois, sitten tallennetaan
        // kaikki puhtaalta pöydältä       
        $this->destroy_tyontekija_connections();
        foreach($tarjoavat_tyontekijat as $tyontekija){
            $statement = 'INSERT INTO tyontekija_palvelu ("tyontekija_id", "palvelu_id", "hinta")'
                    . ' VALUES (:tyontekija_id, :palvelu_id, :hinta)';
            $query = DB::connection()->prepare($statement);
            $query->execute(array(
                'tyontekija_id' => $tyontekija['tyontekija_id'],
                'palvelu_id' => $this->id,
                'hinta' => $tyontekija['hinta']
            ));
        }
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
        // poistetaan ensin palvelun liitostiedot työntekijöihin sekä toimitiloihin,
        // sitten vasta itse palvelu
        
        $this->destroy_toimitila_connections();
        $this->destroy_tyontekija_connections();
        
        $statement = 'DELETE FROM palvelu WHERE "id" = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'id' => $this->id
        ));
    }
    
    public function destroy_toimitila_connections(){
        $statement = 'DELETE FROM toimitila_palvelu WHERE "palvelu_id" = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'id' => $this->id
        ));
    }
    
    public function destroy_tyontekija_connections(){
        $statement = 'DELETE FROM tyontekija_palvelu WHERE "palvelu_id" = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'id' => $this->id
        ));        
    }
    
    public function validate_nimi(){
        return array_merge(
                $this->validate_string_length('Nimi', $this->nimi, 1, 100, false),
                $this->validate_string_uniqueness($this->nimi, 'palvelu', 'nimi', $this->id)
            );
    }
    
    public function validate_kesto(){
        return $this->validate_time('Kesto', $this->kesto, 
                new DateInterval('PT0H15M'), new DateInterval('PT10H'), false);
    }
    
    public function validate_kuvaus(){
        return $this->validate_string_length('Kuvaus', $this->kuvaus, 0, 5000, true);
    }
            
    public function validate_destroyability(){
        $issues = array();
        
        $statement = "SELECT COUNT(*) AS count FROM varaus WHERE palvelu_id = :palvelu_id";
        $query = DB::connection()->prepare($statement);
        $query->execute(array('palvelu_id' => $this->id));
        $row = $query->fetch();
        if($row){
            if($row['count'] > 0){
                $issues[] = 'Palvelua ' . $this->nimi . ' ei pystytä poistamaan; palveluun on liitetty varaustietoja.';
            }
        } else {
            $issues[] = 'Palvelun ' . $this->nimi . ' poistettavuutta ei pystytty tarkistamaan.';
        }
        
        return $issues;
    }
}
