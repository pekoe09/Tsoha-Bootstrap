<?php

class Terapeuttitilasto extends BaseModel {
    public $sukunimi, $etunimi, $tyoaika, $terapia_aika, $terapia_kaynnit, $myynti;
    
    public function __construct($attributes = null) {
        parent::__construct($attributes);
    }
    
    public static function allForPeriod($alkaen, $asti){
        $statement = 'SELECT *'
                . ' FROM'
                . ' (SELECT t.id, t.sukunimi, t.etunimi, COUNT(v.id) AS terapia_kaynnit,'
                . '     SUM(p.kesto) AS terapia_aika, SUM(tp.hinta) AS myynti'
                . ' FROM varaus v'
                . '     INNER JOIN tyontekija t ON v.tyontekija_id = t.id'
                . '     INNER JOIN palvelu p ON v.palvelu_id = p.id'
                . '     INNER JOIN tyontekija_palvelu tp ON (v.palvelu_id = tp.palvelu_id AND v.tyontekija_id = tp.tyontekija_id)'
                . ' WHERE v.aloitusaika >= :alkaen'
                . '     AND v.lopetusaika <= :asti'
                . ' GROUP BY t.id, t.sukunimi, t.etunimi) x'
                . ' INNER JOIN'
                . ' (SELECT t.id, SUM(tp.asti - tp.alkaen) AS tyoaika'
                . ' FROM tyontekija t INNER JOIN tyopaiva tp ON t.id = tp.tyontekija_id'
                . ' WHERE tp.paiva >= :alkaen and tp.paiva <= :asti'
                . ' GROUP BY t.id) y'
                . ' ON x.id = y.id'
                . ' ORDER BY sukunimi, etunimi';
        $query = DB::connection()->prepare($statement);
        $query->execute(array('alkaen' => $alkaen, 'asti' => $asti));
        $rows = $query->fetchAll();
        $terapeuttitilastot = array();
        foreach($rows as $row)
            $terapeuttitilastot[] = new Terapeuttitilasto(array(
                'sukunimi' => $row['sukunimi'],
                'etunimi' => $row['etunimi'],
                'tyoaika' => $row['tyoaika'],
                'terapia_aika' => $row['terapia_aika'],
                'terapia_kaynnit' => $row['terapia_kaynnit'],
                'myynti' => $row['myynti']
            ));
        return $terapeuttitilastot;
    }
}
