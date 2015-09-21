<?php

class Tyontekija extends BaseModel{
    
    public $id, $sukunimi, $etunimi, $sahkoposti, $on_johtaja, $aloitus_pvm, $lopetus_pvm, $salasana;
    
    public function __construct($attributes){
        parent::__construct($attributes);
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
}
