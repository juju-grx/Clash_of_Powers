<?php
namespace App;
session_start();

use App\Magicien;
use App\Guerrier;
use App\Autoloader;
use PDO;

require 'App/Autoloader.php';
Autoloader::register();

  $dsn = 'mysql:dbname=battlegame;host=127.0.0.1';
  $user = 'root';
  $password = 'root';

  $message = '';

  try {
    $db = new PDO($dsn, $user, $password);
  }

  catch (PDOException $e){
    print('<br/>Erreur de connexion : ' . $e->getMessage());
  }
 
  $manager = new PersonnageManager($db);

  if($verif == 0){
    session_destroy();
    header('Location: Index.php');
  }

  if(isset($_SESSION['nom'])){
    $main = $manager->getOne($_SESSION['nom']);
  }else{
    session_destroy();
    header('Location: Index.php');
  }
  
  if(isset($_POST['deconnection'])){
    session_destroy();
    header('Location: Index.php');
  }
  if(isset($_POST['ennemie'])){
    $ennemie = $_POST['ennemie'];
    $ennemie = $manager->getOne($_POST['ennemie']);
    $manager->update($ennemie);
    $_SESSION['ennemie'] = serialize($ennemie);
  }

  if(isset($_SESSION['ennemie'])){
    $ennemie = unserialize($_SESSION['ennemie']);
    if($ennemie->getPv() <= 0)
    {
      $main->upExperience();
      $_SESSION['ennemie'] = null;
      $manager->delete($ennemie);
      $manager->update($main);
    }
    else{
      $manager->update($ennemie);
    }
  }
  ?>

<!DOCTYPE html>
  <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PetitJeuMaster</title>
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
      <section class="sec_1">
        <form action="" method="post"><input type="submit" name="deconnection" value="Déconnection" class="deconnection"></form>
        <div class="main">
          <form class="stat">
            <center>
            <fieldset class="Border">
              <legend class="legend">Mes informations</legend>
                <div class="description">
                  <p><label>Type:         </label> <?php print($main->getType());       ?></p>
                  <p><label>Nom:          </label> <?php print($main->getNom());        ?></p>
                  <p><label>Point de vie: </label> <?php print($main->getPv());         ?></p>
                  <p><label>Point d'atk:  </label> <?php print($main->getForce());      ?></p>
                  <p><label>Niveau:       </label> <?php print($main->getNiveau());     ?></p>
                  <p><label>Expérience:   </label> <?php print($main->getExperience()); ?></p>
                  <p><?php print($message);  ?></p>
                </div>
            </fieldset> 
            </center>
          </form>
        </div>
        <div class="enemy">
          <form class="list" action="" method="post">
            <center>
            <fieldset class="Border">
            <legend class="legend">Qui frapper</legend>
                <?php 
                  $allperso = $manager->getlist();
                  $verif = count($allperso);
                  if($verif>=1){
                    foreach ($allperso as $perso) {
                      if(strtoupper($perso->getNom()) != strtoupper($_SESSION['nom'])){
                        print('<input type="submit" name="ennemie" value="'. $perso->getNom() .'"<br>');
                      }
                    }
                  }
                  else
                  {
                    print("Aucun Ennemie n'a été détecté");
                  }
                ?>
            </fieldset>
          </center>
          </form>
        </div>
        <div class="skill">
          <form class="choice" action="" method="post">
            <center>
            <fieldset class="Border">
              <legend class="legend">Que faire ?</legend>
                <div class="choiceEnemy">
                  <fieldset>
                    <legend><?php if(isset($_SESSION['ennemie'])){
                                    $ennemie = unserialize($_SESSION['ennemie']);
                                    print("Cible: " . $ennemie->getNom());
                                  } 
                            ?>
                    </legend>
                  <?php
                    if(isset($_SESSION['ennemie'])){
                      $ennemie = unserialize($_SESSION['ennemie']);
                      print("<p>Type:         ".  $ennemie->getType()   ."</p>");
                      print("<p>Point de vie: ".  $ennemie->getPv()     ."</p>");
                      print("<p>Niveau:       ".  $ennemie->getNiveau() ."</p>");
                    }else{
                      print("Veuillez choisir un ennemi à frapper");
                    }
                  ?></fieldset>
                </div>
                <div id="competance">
                  <?php
                  if(isset($_SESSION['ennemie'])){
                    $main->afficherCompetence();
                    if(isset($_POST['competence'])){
                      $competence = $_POST['competence'];
                      $main->$competence($_SESSION['ennemie']);
                    }
                  }
                  ?>
                </div>
            </fieldset>
          </center>
          </form>
        </div>
      </section>
    </body>
  </html>