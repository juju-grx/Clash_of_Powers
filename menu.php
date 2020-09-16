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
    $allperso = $manager->getlist();
    $verif = count($allperso);

  if($verif == 0){
    session_destroy();
    header('Location: Index.php');
  }

  if(isset($_SESSION)){
    $main = $manager->getOne($_SESSION['nom']);
  }else{
    session_destroy();
    header('Location: Index.php');
  }
  if(isset($_POST['nom'])){
    $nomAtk['nom'] = $_POST['nom'];
    $atk = $manager->getOne($nomAtk['nom']);
    if($atk != null){
    $main->damage($atk);
    if($atk->getPv()< 1){
      $main->health($atk);
      $manager->delete($atk);
      $message = ('Vous avez tuer '. $_POST['nom'] .' !!! <br/> Vous gagner 50 points d\'Experience');
      $main->upExperience();
      $manager->update($main);
      
    }else{
      $manager->update($atk);
      $message = ('Vous avez infliger '. $main->getForce() .' point <br/> de dégats à '. $_POST['nom']);
    }}
  }

  if(isset($_POST['deconnection'])){
    session_destroy();
    header('Location: Index.php');
  }

  if(isset($_POST['ennemie'])){
    $nomAtk['ennemie'] = $_POST['ennemie'];
    $ennemie = $manager->getOne($nomAtk['ennemie']);
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
                  <p><label>Compétence:   </label> <?php print($main->getAtout());      ?></p>
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
                  if($verif>=1){
                    foreach ($allperso as $perso) {
                      if(strtoupper($perso->getNom()) != strtoupper($_SESSION['nom'])){
                        print('<input type="submit" name="ennemie" value="'. $perso->getNom() .'"<br>');
                      }
                    }
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
                    <legend><?php if(isset($_POST['ennemie'])){print($_POST['ennemie']);} ?></legend>
                  <?php
                    if(isset($ennemie)){
                      print("<p><label>Type:         </label>".  print($ennemie->getType())   ."</p>
                             <p><label>Point de vie: </label>".  print($ennemie->getPv())     ."</p>
                             <p><label>Niveau:       </label>".  print($ennemie->getNiveau()) ."</p>");
                    }else{
                      print("Veuillez choisir un ennemi à frapper");
                    }
                  ?></fieldset>
                </div>
                <div>
                  <?php
                    $main->afficherCompetance();
                  ?>
                </div>
            </fieldset>
          </center>
          </form>
        </div>
      </section>
    </body>
  </html>