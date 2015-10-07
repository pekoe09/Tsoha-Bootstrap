<?php

class Tyontekija extends Kayttaja{
    
    public $on_johtaja, $aloitus_pvm, $lopetus_pvm;

    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array_merge(
                $this->validators, 
                array('validate_aloitus_pvm', 'validate_lopetus_pvm', 'validate_sahkoposti')
            );
    }
    
    public static function all(){
        $statement = 'SELECT * FROM tyontekija'
                . ' ORDER BY sukunimi, etunimi';
        $query = DB::connection()->prepare($statement);
        $query->execute();
        $rows = $query->fetchAll();
        $tyontekijat = array();
        foreach($rows as $row)
            $tyontekijat[] = new Tyontekija(array(
                'id' => $row['id'],
                'sukunimi' => $row['sukunimi'],
                'etunimi' => $row['etunimi'],
                'sahkoposti' => $row['sahkoposti'],
                'on_johtaja' => $row['on_johtaja'],
                'aloitus_pvm' => $row['aloitus_pvm'],
                'lopetus_pvm' => $row['lopetus_pvm'],
                'salasana' => $row['salasana']
            ));
        return $tyontekijat;
    }
    
    public static function allWithService($palvelu_id){
        $statement = 'SELECT t.id, t.etunimi, t.sukunimi, t.sahkoposti,'
                . ' t.on_johtaja, t.aloitus_pvm, t.lopetus_pvm, '
                . ' (SELECT tp.hinta FROM tyontekija_palvelu tp'
                . ' WHERE tp.palvelu_id = :palvelu_id AND tp.tyontekija_id = t.id) AS hinta'
                . ' FROM tyontekija t'
                . ' ORDER BY t.sukunimi, t.etunimi';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('palvelu_id' => $palvelu_id));
        $rows = $query->fetchAll();
        $tyontekijat = array();
        foreach($rows as $row){
            $tyontekijat[] = array(
                new Tyontekija(array(
                'id' => $row['id'],
                'etunimi' => $row['etunimi'],
                'sukunimi' => $row['sukunimi'],
                'sahkoposti' => $row['sahkoposti'],
                'on_johtaja' => $row['on_johtaja'],
                'aloitus_pvm' => $row['aloitus_pvm'],
                'lopetus_pvm' => $row['lopetus_pvm']
                )), 
                $row['hinta']
            );
        }
        return $tyontekijat;  
    }
    
    public static function find($id){
        $statement = 'SELECT * FROM tyontekija WHERE id = :id LIMIT 1';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $tyontekija = new Tyontekija(array(
                'id' => $row['id'],
                'sukunimi' => $row['sukunimi'],
                'etunimi' => $row['etunimi'],
                'sahkoposti' => $row['sahkoposti'],
                'on_johtaja' => $row['on_johtaja'],
                'aloitus_pvm' => $row['aloitus_pvm'],
                'lopetus_pvm' => $row['lopetus_pvm'],
                'salasana' => $row['salasana']
            ));
            return $tyontekija;
        }
        
        return null;
    }
    
    public static function findForService($palvelu_id){
        $statement = 'SELECT t.id, t.sukunimi, t.etunimi, t.sahkoposti, t.on_johtaja,'
                . ' t.aloitus_pvm, t.lopetus_pvm'
                . ' FROM tyontekija t'
                . ' INNER JOIN tyontekija_palvelu tp ON t.id = tp.tyontekija_id'
                . ' WHERE tp.palvelu_id = :palvelu_id'
                . ' ORDER BY t.sukunimi, t.etunimi';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('palvelu_id' => $palvelu_id));
        $rows = $query->fetchAll();
        $tyontekijat = array();
        foreach($rows as $row)
            $tyontekijat[] = new Tyontekija(array(
                'id' => $row['id'],
                'sukunimi' => $row['sukunimi'],
                'etunimi' => $row['etunimi'],
                'sahkoposti' => $row['sahkoposti'],
                'on_johtaja' => $row['on_johtaja'],
                'aloitus_pvm' => $row['aloitus_pvm'],
                'lopetus_pvm' => $row['lopetus_pvm']
            ));
        return $tyontekijat;
    }
    
    public function save(){
        $statement = 'INSERT INTO tyontekija ("sukunimi", "etunimi", "sahkoposti", "on_johtaja", "aloitus_pvm", "lopetus_pvm", "salasana")'
                    . 'VALUES (:sukunimi, :etunimi, :sahkoposti, :on_johtaja, :aloitus_pvm, :lopetus_pvm, :salasana) RETURNING id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'sukunimi' => $this->sukunimi,
            'etunimi' => $this->etunimi,
            'sahkoposti' => $this->sahkoposti,
            'on_johtaja' => isset($this->on_johtaja) ? true : 'f',
            'aloitus_pvm' => date('Y-m-d H:i', strtotime($this->aloitus_pvm)),
            'lopetus_pvm' => $this->lopetus_pvm == null? null : date('Y-m-d', $this->lopetus_pvm),
            'salasana' => $this->salasana            
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
        
    public function update(){
        $statement = 'UPDATE tyontekija SET "sukunimi" = :sukunimi, "etunimi" = :etunimi, "sahkoposti" = :sahkoposti,'
                . ' "aloitus_pvm" = :aloitus_pvm, "lopetus_pvm" = :lopetus_pvm, "salasana" = :salasana, "on_johtaja" = :on_johtaja'
                . ' WHERE "id" = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'sukunimi' => $this->sukunimi,
            'etunimi' => $this->etunimi,
            'sahkoposti' => $this->sahkoposti,
            'on_johtaja' => isset($this->on_johtaja) ? 't' : 'f',
            'aloitus_pvm' => date('Y-m-d H:i', strtotime($this->aloitus_pvm)),
            'lopetus_pvm' => $this->lopetus_pvm == null? null : date('Y-m-d', $this->lopetus_pvm),
            'salasana' => $this->salasana,
            'id' => $this->id
        ));
    }
    
    public function destroy(){
        // poistetaan ensin työntekijän ja palvelun liitostiedot ja työntekijän
        // työpaivätiedot, sitten vasta työntekijä
        
        $statement = 'DELETE FROM tyontekija_palvelu WHERE "tyontekija_id" = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'id' => $this->id
        ));
        
        $statement = 'DELETE FROM tyopaiva WHERE "tyontekija_id" = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'id' => $this->id
        ));
        
        $statement = 'DELETE FROM tyontekija WHERE "id" = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'id' => $this->id
        ));
    }
    
    public function validate_aloitus_pvm(){
        return $this->validate_date('Aloituspvm', $this->aloitus_pvm, null, null, false);
    }
    
    public function validate_lopetus_pvm(){
        return $this->validate_date('Lopetuspvm', $this->lopetus_pvm, null, null, true);
    }
                    
    public function validate_sahkoposti(){
        return array_merge(
                $this->validate_string_length('Sähköposti', $this->sahkoposti, 1, 200, false),
                $this->validate_string_uniqueness($this->sahkoposti, 'tyontekija', 'sahkoposti', $this->id)
            );
    }
        
    public function validate_destroyability(){
        $issues = array();
        
        $statement = "SELECT COUNT(*) AS count FROM varaus WHERE tyontekija_id = :tyontekija_id";
        $query = DB::connection()->prepare($statement);
        $query->execute(array('tyontekija_id' => $this->id));
        $row = $query->fetch();
        if($row){
            if($row['count'] > 0){
                $issues[] = 'Työntekijää ' . $this->etunimi . ' ' . $this->sukunimi . ' ei pystytä poistamaan; työntekijään on liitetty varaustietoja.';
            }
        } else {
            $issues[] = 'Työntekijän ' . $this->etunimi . ' ' . $this->sukunimi . ' poistettavuutta ei pystytty tarkistamaan.';
        }
        
        return $issues;
    }
}
