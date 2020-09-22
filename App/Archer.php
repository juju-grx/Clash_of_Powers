<?php
namespace App;


class Archer extends Personnage
{
    const TYPE = "Archer";
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
        print('<input type="submit" name="competance" value="speedShoot"<br>');
        if($this->getNiveau() <= 5){
            print('<input type="submit" name="competance" value="multiShoot"<br>');}
        elseif($this->getNiveau() <= 10){
            print('<input type="submit" name="competance" value="multiShoot"<br>');
            print('<input type="submit" name="competance" value="multiShoot"<br>');}
    }

    public function competance(){
        print('test');
    }

    public function passif(){

    }

    public function speedShoot($ennemie)
    {
        $ennemie->hp -= $this->_force;
    }

    public function multiShoot($ennemie)
    {
        $pourcent = rand(0, 100);

        if($pourcent <= 100 && $pourcent >= 45){
            $ennemie->hp -= (($this->atk)-(($this->atk)*0.8))*2;
            print(2);
        }
        elseif($pourcent < 45 && $pourcent >= 20){
            $ennemie->hp -= (($this->atk)-(($this->atk)*0.7))*3;
            print(3);
        }
        elseif($pourcent < 20 && $pourcent >= 5 ){
            $ennemie->hp -= (($this->atk)-(($this->atk)*0.6))*4;
            print(4);
        }
        elseif($pourcent < 5  && $pourcent >= 0 ){
            $ennemie->hp -= (($this->atk)-(($this->atk)*0.5))*5;
            print(5);
        }

    }
    
    //accesseur----------------------------------

    public function getHp(){
        return $this->hp;
    }

    public function getAtk(){
        return $this->atk;
    }

    public function getSpd(){
        return $this->spd;
    }
}