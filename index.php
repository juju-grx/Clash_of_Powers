<?php 
namespace App;
session_start();
use App\Autoloader;
use PDO;

require 'App/Autoloader.php';
Autoloader::register();

$dsn = 'mysql:dbname=battlegame;host=127.0.0.1';
$user = 'root';
$password = '';
    $db = new PDO($dsn, $user, $password); 
    $erreur ='';
    if(isset($_POST['utiliser'])){
      if($_POST['utiliser'] == 'Connection') {
        if($_POST['_login']){
          $nom = $_POST['_login'];
          $manager = new PersonnageManager($db);
          $valide = $manager->getNomValide($nom);
          if(!$valide){
            $erreur = "<h4> Ce personnage n'existe pas </h4>";
          }else{
            $_SESSION['nom'] = $nom;
            header('Location: menu.php');
          }
        }else{
          $erreur = '<h4> Veuillez saisir tous les champs </h4>';
        }
      }elseif($_POST['utiliser'] == 'Création'){
        if($_POST['_login']){
          if(isset($_POST['Type'])){
            $nom = $_POST['_login'];
            $type = $_POST['Type'];
            $manager = new PersonnageManager($db);
            $valide = $manager->getNomValide($nom);
            if($valide){
              $erreur = "<h4> Ce personnage existe déja </h4>";
            }else{
              $ligne = array(
                'nom' => $nom,
                );
                print("test");
              switch ($type) {
                case 'Guerrier':
                  $perso = new Guerrier($ligne); 
                  break;
                case 'Magicien':
                  $perso = new Magicien($ligne); 
                  break;
                case 'Archer':
                  $perso = new Archer($ligne); 
                  break;
                
                default:
                  $erreur = '<h4> Ce type de personnage n\'existe pas </h4>';
                  break;
              }
              $manager->add($perso);
              $_SESSION['nom'] = $nom;
              header('Location: menu.php');
            }
          }else{
            $erreur = '<h4> Veuillez saisir tous les champs </h4>';
          }
        }else{
          $erreur = '<h4> Veuillez saisir tous les champs </h4>';
        }
      }
    }
?>
<!DOCTYPE >
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Formulaire d'authentification</title>
    <link rel="stylesheet" href="style/style_connect.css">
  </head>
  <body>
    <div id="connect" >
      <center>
      <form action="" method="post" >
        <fieldset>
          <legend>Identifiez-vous</legend>
          <p>
            <label for="_login">Login: </label> 
            <input type="text" name="_login" id="_login" value="" />
          </p>
          <p class="choice">
            <label for="Magicien">Magicien </label> 
            <input type="radio" name="Type" id="Magicien" value="Magicien"/><br/>
            <label for="Guerrier">Guerrier </label> 
            <input type="radio" name="Type" id="Guerrier" value="Guerrier"/><br/>
            <label for="Archer">Archer </label> 
            <input type="radio" name="Type" id="Archer" value="Archer"/>
          </p>
          <p><input type="submit" name="utiliser" value="Connection" /></p>
          <p><input type="submit" name="utiliser" value="Création" id="new"/></p>
          <p style="color: red;" id="_erreur"><?php print($erreur); ?></p>
        </fieldset>
      </form>
      </center>
    </div>
  </body>
</html>