<?php
namespace App;

class Magicien extends Personnage
{
    const TYPE = "Magicien";
    const DEFAULT_PV = 22500;
    const DEFAULT_FORCE = 1595;
    const DEFAULT_SPD = 102;
    const DEFAULT_NIVEAU = 1;
    const DEFAULT_EXPERIENCE = 0;

    public function __construct($ligne)
    {
        $this->_pv = self::DEFAULT_PV;
        $this->_force = self::DEFAULT_FORCE;
        $this->_spd = self::DEFAULT_SPD;
        $this->_niveau = self::DEFAULT_NIVEAU;
        $this->_experience = self::DEFAULT_EXPERIENCE;
        $this->_type = self::TYPE;
        
        parent::__construct();
        $this->hydrate($ligne);
    }

    public function afficherCompetence(){
        print('<input type="submit" name="competence" value="Energie spikes"<br>');
        if($this->getNiveau() >= 5){
        print('<input type="submit" name="competence" value="feu-follet"    <br>');}
    }

}