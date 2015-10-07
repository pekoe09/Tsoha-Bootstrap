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
        $statement = 'SELECT * FROM varaus'
                . ' ORDER BY aloitusaika DESC';
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
    
    public static function findForResource($resurssi_id, $resurssi_tyyppi){
        $statement = 'SELECT v.id, v.palvelu_id, p.nimi AS palvelu_nimi,'
                . ' v.tyontekija_id, t.etunimi AS tyontekija_etunimi,'
                . ' t.sukunimi AS tyontekija_sukunimi,'
                . ' v.asiakas_id, a.etunimi AS asiakas_etunimi, a.sukunimi AS asiakas_sukunimi,'
                . ' v.toimitila_id, o.nimi AS toimitila_nimi, o.katuosoite,'
                . ' v.aloitusaika, v.on_peruutettu'
                . ' FROM varaus v'
                . ' INNER JOIN palvelu p ON v.palvelu_id = p.id'
                . ' INNER JOIN asiakas a ON v.asiakas_id = a.id'
                . ' INNER JOIN tyontekija t ON v.tyontekija_id = t.id'
                . ' INNER JOIN toimitila o ON v.toimitila_id = o.id';
        if($resurssi_tyyppi == 'asiakas')
            $statement = $statement . ' WHERE asiakas_id = :resurssi_id ORDER BY aloitusaika DESC';
        else if($resurssi_tyyppi == 'tyontekija')
            $statement = $statement . ' WHERE tyontekija_id = :resurssi_id ORDER BY aloitusaika DESC';
        else if($resurssi_tyyppi == 'toimitila')
            $statement = $statement . ' WHERE toimitila_id = :resurssi_id ORDER BY aloitusaika DESC';
        else
            $statement = $statement . ' ORDER BY aloitusaika DESC';
        $query = DB::connection()->prepare($statement);
        if($resurssi_id != null)
            $query->execute(array('resurssi_id' => $resurssi_id));
        else
            $query->execute();
        $rows = $query->fetchAll();
        $varaukset = array();
        foreach($rows as $row)
            $varaukset[] = new Asiakasvaraus(array(
                'id' => $row['id'],
                'palvelu_id' => $row['palvelu_id'],
                'palvelu_nimi' => $row['palvelu_nimi'],
                'tyontekija_id' => $row['tyontekija_id'],
                'tyontekija_etunimi'=> $row['tyontekija_etunimi'],
                'tyontekija_sukunimi' => $row['tyontekija_sukunimi'],
                'asiakas_id' => $row['asiakas_id'],
                'asiakas_etunimi'=> $row['asiakas_etunimi'],
                'asiakas_sukunimi' => $row['asiakas_sukunimi'],
                'toimitila_id' => $row['toimitila_id'],
                'toimitila_nimi' => $row['toimitila_nimi'],
                'katuosoite' => $row['katuosoite'],
                'aloitusaika' => $row['aloitusaika'],
                'on_peruutettu' => $row['on_peruutettu']
            ));
        return $varaukset;
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
    
    public function check_overlaps(){
        $errors = array();
        
        $statement = "SELECT COUNT(*) AS count FROM tyontekija_palvelu"
                . " WHERE tyontekija_id = " . $this->tyontekija_id
                . " AND palvelu_id = " . $this->palvelu_id;
        $query = DB::connection()->prepare($statement);
        $query->execute();
        $row = $query->fetch();
        if(!$row || $row['count'] == 0){
            $errors[] = "Valitsemasi terapeutti ei tarjoa haluamaasi palvelua";
        }
        
        $statement = "SELECT COUNT(*) AS count FROM toimitila_palvelu"
                . " WHERE toimitila_id = " . $this->toimitila_id
                . " AND palvelu_id = " . $this->palvelu_id;
        $query = DB::connection()->prepare($statement);
        $query->execute();
        $row = $query->fetch();
        if(!$row || $row['count'] == 0){
            $errors[] = "Valitsemassasi toimipaikassa ei ole tarjolla haluamaasi palvelua";
        }
        
        $dimensions = array(            
            'asiakas' => $this->asiakas_id,
            'tyontekija'  => $this->tyontekija_id,
            'toimitila' => $this->toimitila_id            
        );
        $input = array(
            'aloitusaika' => $this->aloitusaika,
            'lopetusaika' => $this->lopetusaika
        );
        
        foreach($dimensions as $key => $value){
            $statement = "SELECT COUNT(*) AS count FROM varaus"
                    . " WHERE " . $key . "_id = " . $value
                    . " AND ((aloitusaika <= :aloitusaika AND lopetusaika > :aloitusaika)"
                        . " OR (aloitusaika < :lopetusaika AND lopetusaika >= :lopetusaika)"
                        . " OR (aloitusaika >= :aloitusaika AND lopetusaika <= :lopetusaika))"
                    . " AND on_peruutettu IS NOT TRUE";            
            $query = DB::connection()->prepare($statement);
            $query->execute($input);
            $row = $query->fetch();
            if($row && $row['count'] > 0){
                $varattu;
                if($key == 'asiakas'){
                    $varattu = 'Sinulla';
                }else if($key == 'tyontekija'){
                    $varattu = 'Terapeutilla';
                }else{
                    $varattu = 'Toimitilassa'; 
                }
                $errors[] = $varattu . " on toinen päällekäinen varaus; varausta ei voi tehdä.";
            }
        }
        
        // tarkistetaan vielä että varausaika mahtuu toimipaikan aukioloaikaan ja terapeutin työaikaan
        $statement = "SELECT COUNT(*) AS count FROM aukiolopaiva"
                . " WHERE toimitila_id = " . $this->toimitila_id
                . " AND paiva = '" . date('Y-m-d', strtotime($this->aloitusaika)) . "'"
                . " AND alkaen <= '" . date('H:i', strtotime($this->aloitusaika)) . "'"
                . " AND asti >= '" . date('H:i', strtotime($this->lopetusaika)) . "'";
        $query = DB::connection()->prepare($statement);
        $query->execute();
        $row = $query->fetch();
        if(!$row || $row['count'] == 0){
            $errors[] = "Toimitila ei ole auki valitsemanasi terapia-aikana (" 
                    . date('H:i', strtotime($this->aloitusaika)) . " - " . date('H:i', strtotime($this->lopetusaika)) . ")";
        }
        
        $statement = "SELECT COUNT(*) AS count FROM tyopaiva"
                . " WHERE tyontekija_id = " . $this->tyontekija_id
                . " AND paiva = '" . date('Y-m-d', strtotime($this->aloitusaika)) . "'"
                . " AND alkaen <= '" . date('H:i', strtotime($this->aloitusaika)) . "'"
                . " AND asti >= '" . date('H:i', strtotime($this->lopetusaika)) . "'";
        $query = DB::connection()->prepare($statement);
        $query->execute();
        $row = $query->fetch();
        if(!$row || $row['count'] == 0){
            $errors[] = "Terapeutin työaika ei kata valitsemaasi terapia-aikaa (" 
                    . date('H:i', strtotime($this->aloitusaika)) . " - " . date('H:i', strtotime($this->lopetusaika)) . ")";
        }        
        
        return $errors;
    }
}
