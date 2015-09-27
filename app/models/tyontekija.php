<?php

class Tyontekija extends Kayttaja{
    
//    public $id, $sukunimi, $etunimi, $sahkoposti, $on_johtaja, $aloitus_pvm, $lopetus_pvm, $salasana;
    public $on_johtaja, $aloitus_pvm, $lopetus_pvm;

    public function __construct($attributes){
        parent::__construct($attributes);
        $this->validators = array('validate_sukunimi', 'validate_etunimi', 'validate_sahkoposti',
            'validate_aloitus_pvm', 'validate_lopetus_pvm', 'validate_salasana');
    }
    
    public static function all(){
        $statement = 'SELECT * FROM tyontekija';
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
    
    public function save(){
        $statement = 'INSERT INTO tyontekija ("sukunimi", "etunimi", "sahkoposti", "on_johtaja", "aloitus_pvm", "lopetus_pvm", "salasana")'
                    . 'VALUES (:sukunimi, :etunimi, :sahkoposti, false, :aloitus_pvm, :lopetus_pvm, :salasana) RETURNING id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'sukunimi' => $this->sukunimi,
            'etunimi' => $this->etunimi,
            'sahkoposti' => $this->sahkoposti,
//            'on_johtaja' => $this->on_johtaja,
            'aloitus_pvm' => date('Y-m-d H:i', strtotime($this->aloitus_pvm)),
            'lopetus_pvm' => $this->lopetus_pvm == null? null : date('Y-m-d', $this->lopetus_pvm),
            'salasana' => $this->salasana            
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
        
    public function update(){
        $statement = 'UPDATE tyontekija SET "sukunimi" = :sukunimi, "etunimi" = :etunimi, "sahkoposti" = :sahkoposti,'
                . ' "aloitus_pvm" = :aloitus_pvm, "lopetus_pvm" = :lopetus_pvm, "salasana" = :salasana WHERE "id" = :id';
        $query = DB::connection()->prepare($statement);
        $query->execute(array(
            'sukunimi' => $this->sukunimi,
            'etunimi' => $this->etunimi,
            'sahkoposti' => $this->sahkoposti,
            'aloitus_pvm' => date('Y-m-d H:i', strtotime($this->aloitus_pvm)),
            'lopetus_pvm' => $this->lopetus_pvm == null? null : date('Y-m-d', $this->lopetus_pvm),
            'salasana' => $this->salasana,
            'id' => $this->id
        ));
    }
    
    public function destroy(){
        $statement = 'DELETE FROM tyontekija WHERE "id" = :id';
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
        return $this->validate_email('Sähköposti', $this->sahkoposti, FALSE);
    }
    
    public function validate_salasana(){
        return $this->validate_password('Salasana', $this->salasana);
    }
    
    public function validate_aloitus_pvm(){
        return $this->validate_date('Aloituspvm', $this->aloitus_pvm, null, null, false);
    }
    
    public function validate_lopetus_pvm(){
        return $this->validate_date('Lopetuspvm', $this->lopetus_pvm, null, null, true);
    }
}
