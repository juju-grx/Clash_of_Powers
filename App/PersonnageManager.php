<?php
namespace App;
use PDO;

class PersonnageManager{
    private $_db;

    public function __construct($db){

        $this->setDb($db);
    }

    public function add(Personnage $perso)
    {
        var_dump($perso);
        // Préparation de la requête d'insertion.
        // Assignation des valeurs pour le nom, la force, les dégâts, l'expérience et le niveau du personnage.
        // Exécution de la requête.
        $request = $this->_db->prepare('INSERT INTO personnages SET nom = :nom, 
                                        `force` = :force, pv = :pv, niveau = :niveau, experience = :experience, `type` = :type;');

        $request->bindValue(':nom', $perso->getNom(), PDO::PARAM_STR);
        $request->bindValue(':force', $perso->getForce(), PDO::PARAM_INT);
        $request->bindValue(':pv', $perso->getPv(), PDO::PARAM_INT);
        $request->bindValue(':niveau', $perso->getNiveau(), PDO::PARAM_INT);
        $request->bindValue(':experience', $perso->getExperience(), PDO::PARAM_INT);
        $request->bindValue(':type', $perso->getType(), PDO::PARAM_STR);

        $request->execute();
        if ($request->errorCode() != '00000') {
            echo "<br/>Une erreur SQL est intervenue : ";
            print_r($request->errorInfo()[2]);
        }
    }

    public function delete(Personnage $perso)
    {
        // Exécute une requête de type DELETE.
        $this->_db->exec('DELETE FROM personnages WHERE id = '.$perso->getId().';');
    }

    public function getOne(string $persoNom)
    {
        // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
        $request = $this->_db->query("SELECT id, nom, `force`, pv, niveau, experience, `type` FROM personnages WHERE nom = '". $persoNom ."';");
        $ligne = $request->fetch(PDO::FETCH_ASSOC);

        if($ligne['type'] == 'Guerrier') {
            return new Guerrier($ligne);
        }elseif($ligne['type'] == 'Magicien'){
            return new Magicien($ligne);
        }elseif($ligne['type'] == 'Archer'){
            return new Archer($ligne);
        }
    }
    public function getNomValide(string $nom)
    {
        // Exécute une requête de type SELECT avec une clause WHERE.
        $request = $this->_db->query("SELECT nom FROM personnages WHERE nom = '".$nom."';");
        $personnages = $request->fetchAll();
        $nombre = count($personnages);
        $valide = ($nombre != 0);
        return $valide;
    }

    public function getList()
    {
        // Retourne la liste de tous les personnages.

        $persos = array();

        $request = $this->_db->query('SELECT id, nom, `force`, pv, niveau, experience, `type` FROM personnages ORDER BY nom;');
        while ($ligne = $request->fetch(PDO::FETCH_ASSOC))
        {
            if(isset($ligne)){
                if($ligne['type'] == 'Guerrier'){
                    $persos[] = new Guerrier($ligne);
                }elseif($ligne['type'] == 'Magicien'){
                    $persos[] = new Magicien($ligne);
                }elseif($ligne['type'] == 'Archer'){
                    $persos[] = new Archer($ligne);
                }
            }
        }
        return $persos;
    }
    
    public function update(Personnage $perso)
    {
        // Prépare une requête de type UPDATE.
        // Assignation des valeurs à la requête.
        // Exécution de la requête.

        $request = $this->_db->prepare('UPDATE personnages SET `force` = :force, 
                                        pv = :pv, niveau = :niveau, experience = :experience, `type` = :type WHERE id = :id;');

        $request->bindValue(':force', $perso->getForce(), PDO::PARAM_INT);
        $request->bindValue(':pv', $perso->getPv(), PDO::PARAM_INT);
        $request->bindValue(':niveau', $perso->getNiveau(), PDO::PARAM_INT);
        $request->bindValue(':experience', $perso->getExperience(), PDO::PARAM_INT);
        $request->bindValue(':type', $perso->getType(), PDO::PARAM_STR);
        $request->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
        $request->execute();
    }

    private function setDb($_db){
        
        $this->_db = $_db;
    }
  }