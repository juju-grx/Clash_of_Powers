<?php
namespace App;

class Guerrier extends Personnage
{
    const TYPE = "Guerrier";
    const DEFAULT_PV = 30000;
    const DEFAULT_FORCE = 1150;
    const DEFAULT_SPD = 98;
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

    public function afficherCompetance(){
        print('<input type="submit" name="competance" value="Sword strike" id="skinCompetance"<br>');
        print('<input type="submit" name="competance" value="Coup de bouclier" id="skinCompetance"<br>');
    }

    public function competance(){
        print('test');
    }







}