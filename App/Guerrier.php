<?php
namespace App;

class Guerrier extends Personnage
{
    const TYPE = "Guerrier";
    const DEFAULT_PV = 21250;
    const DEFAULT_FORCE = 1675;
    const DEFAULT_SPD = 105;
    const DEFAULT_NIVEAU = 1;
    const DEFAULT_EXPERIENCE = 0;
    const DEFAULT_REVEIL = 0;

    public function __construct($ligne)
    {
        $this->_pv = self::DEFAULT_PV;
        $this->_force = self::DEFAULT_FORCE;
        $this->_spd = self::DEFAULT_SPD;
        $this->_niveau = self::DEFAULT_NIVEAU;
        $this->_experience = self::DEFAULT_EXPERIENCE;
        $this->_reveil = self::DEFAULT_REVEIL;
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