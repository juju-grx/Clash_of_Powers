<?php
namespace App;


class Archer extends Personnage
{
    const TYPE = "Archer";
    const DEFAULT_PV = 21250;
    const DEFAULT_FORCE = 1675;
    const DEFAULT_SPD = 105;
    const DEFAULT_DEF = 10;
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
        print('<input type="submit" name="competence" value="speedShoot"           <br>');
        if($this->getNiveau() >= 5){
            print('<input type="submit" name="competence" value="multiShoot"       <br>');}
            /*
        if($this->getNiveau() >= 10){
            print('<input type="submit" name="competence" value="roulade"          <br>');
            print('<input type="submit" name="competence" value="tireDePrécision" <br>');}
            */
    }

    public function passif(){

    }

    public function speedShoot($_ennemie)
    {
        $ennemie = unserialize($_ennemie);
        $atk = $this->_force;
        $ennemie->setPv($ennemie->getPv() - $atk);
        $_SESSION['ennemie'] = serialize($ennemie);
    }

    public function multiShoot($_ennemie)
    {
        $ennemie = unserialize($_ennemie);
        $pourcent = rand(0, 100);

        if($pourcent <= 100 && $pourcent >= 45){
            $atk = (($this->_force)*0.8)*2;
            $ennemie->setPv($ennemie->getPv() - $atk);
            $_SESSION['ennemie'] = serialize($ennemie);
        }
        elseif($pourcent < 45 && $pourcent >= 20){
            $atk = (($this->_force)*0.7)*3;
            $ennemie->setPv($ennemie->getPv() - $atk);
            $_SESSION['ennemie'] = serialize($ennemie);
        }
        elseif($pourcent < 20 && $pourcent >= 5 ){
            $atk = (($this->_force)*0.6)*4;
            $ennemie->setPv($ennemie->getPv() - $atk);
            $_SESSION['ennemie'] = serialize($ennemie);
        }
        elseif($pourcent < 5  && $pourcent >= 0 ){
            $atk = (($this->_force)*0.5)*5;
            $ennemie->setPv($ennemie->getPv() - $atk);
            $_SESSION['ennemie'] = serialize($ennemie);
        }
    }

    public function roulade($_ennemie)
    {
        
    }
    
    //accesseur----------------------------------

    public function getPv(){
        return $this->_pv;
    }

    public function getForce(){
        return $this->_force;
    }

    public function getSpd(){
        return $this->spd;
    }
}