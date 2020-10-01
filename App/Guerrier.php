<?php
namespace App;

class Guerrier extends Personnage
{
    const TYPE = "Guerrier";
    const DEFAULT_PV = 30000;
    const DEFAULT_FORCE = 1150;
    const DEFAULT_SPD = 98;
    const DEFAULT_DEF = 25;
    const DEFAULT_NIVEAU = 1;
    const DEFAULT_EXPERIENCE = 0;

    public function __construct($ligne)
    {
        $this->_pv = self::DEFAULT_PV;
        $this->_force = self::DEFAULT_FORCE;
        $this->_spd = self::DEFAULT_SPD;
        $this->_def = self::DEFAULT_DEF;
        $this->_niveau = self::DEFAULT_NIVEAU;
        $this->_experience = self::DEFAULT_EXPERIENCE;
        $this->_type = self::TYPE;
        
        parent::__construct();
        $this->hydrate($ligne);
    }

    public function afficherCompetence()
    {
        print('<input type="submit" name="competence" value="swordStrike" <br>');
        if($this->getNiveau() >= 5){
            print('<input type="submit" name="competence" value="shieldShot"  <br>');}
    }

    public function swordStrike($_ennemie)
    {
        $ennemie = unserialize($_ennemie);
        $atk = $this->_force;
        $ennemie->setPv($ennemie->getPv() - $atk);
        $_SESSION['ennemie'] = serialize($ennemie);
    }

    public function shieldShot($_ennemie)
    {
        $ennemie = unserialize($_ennemie);
        $atk = ($this->_force) * 0.25;
        $ennemie->setPv($ennemie->getPv() - $atk);
        $_SESSION['ennemie'] = serialize($ennemie);
    }
}