<?php
namespace App;

abstract class Personnage
{
    protected $_nom;
    protected $_force;
    protected $_pv;
    protected $_spd;
    protected $_def;
    protected $_niveau;
    protected $_experience;
    protected $_type;
    protected $_id;

    public function __construct()
    {
        get_class($this);
    }

    public function upExperience()
    {
        $this->_experience += (100 * (1-(1/$this->getNiveau())));
        $verif = $this->_experience;
        if($verif >= 100){
            $this->upNiveau();
            $this->_experience = 0;
        }
    }

    public function upNiveau()
    {
        $this->_niveau += 1;
    }

    //accesseur----------------------------------

    public function getid()
    {
        return $this->_id;
    }

    public function getNom()
    {
        return $this->_nom;
    }

    public function getForce()
    {
        return $this->_force;
    }

    public function getPv()
    {
        return $this->_pv;
    }

    public function getSpd()
    {
        return $this->_spd;
    }

    public function getDef()
    {
        return $this->_def;
    }

    public function getNiveau()
    {
        return $this->_niveau;
    }

    public function getExperience()
    {
        return $this->_experience;
    }

    public function getType()
    {
        return $this->_type;
    }

    //mutateur------------------------------------

    public function setId($_id)
    {
        $id = (int) $_id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setNom($_nom)
    {
        if (is_string($_nom))
      {
        $this->_nom = $_nom;
      }
    }

    public function setForce($_force)
    {
        $force = (int) $_force;
        $this->_force = $force;
    }

    public function setPv($_pv)
    {
        $pv = (int) $_pv;
        $this->_pv = $pv;
    }

    public function setSpd($_spd)
    { 
        $spd = (int) $_spd;
        $this->_spd = $spd;
    }

    public function setDef($_def)
    {   
        $def = (int) $_def;
        $this->_def = $def;
    }

    public function setNiveau($_niveau)
    {
        $this->_niveau = $_niveau;
    }

    public function setExperience($_experience)
    {
        $this->_experience = $_experience;
    }

    public function setType($_type)
    {
        $this->_type = $_type;
    }

    //hydrate--------------------------------------------

    public function hydrate(array $ligne)
    {
        foreach ($ligne as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }
}
