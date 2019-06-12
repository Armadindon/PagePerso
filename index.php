<?php
include("connectionFiles/connectionLOG.inc.php");

//Bloc d'envoi de mail de réinitialisation
if(isset($_POST["email"])){
  $req = $dbh->query("SELECT idClient FROM Client WHERE AdresseMail=\"".$_POST["email"]."\";");
  if($req->rowCount()!=0){
    $errorMail = 0;
    $idCMail =$req->fetch()[0];
    mail($_POST["email"],"Mot de Passe Perdu MicroGames","Bonjour/Bonsoir\nCliquez ici pour réinitialiser votre mdp\nhttps://microgamesdut.000webhostapp.com/newMdp.php?idC=$idCMail");
  }else{
    $errorMail= 1;
  }
}

//on récupère les données du formulaire
$login=isset($_POST['login']) ? $_POST['login'] : null ;
$mdp=isset($_POST['mdp']) ? $_POST['mdp'] : null ;
//on vérifie la connection
if($login != null && $mdp != null){
  //on fait deux requêtes pour vérifier les deux BDD
  $req = $dbh -> query("SELECT * FROM Client WHERE login=\"".$login."\" AND motDePasse=SHA1(\"".$_POST["mdp"]."\");");
  $req2 = $dbh -> query("SELECT * FROM Magasin WHERE login=\"".$login."\" AND motDePasse=SHA1(\"".$_POST["mdp"]."\");");
  $req3 = $dbh -> query("SELECT * FROM Administrateur WHERE login=\"".$login."\" AND motDePasse=SHA1(\"".$_POST["mdp"]."\");");
  if($req -> rowCount() !=0){//on vérifie si il y a un résultat , si oui , c'est que la connexion est validée
    $_SESSION["login"] = $login;
    $_SESSION["mdp"] = $mdp;
    $_SESSION["type"] = 0;
    header("location: Client_Interaction/mainClient.php");
    exit;
  }else if($req2 -> rowCount() !=0){
    $_SESSION["login"] = $login;
    $_SESSION["mdp"] = $mdp;
    $_SESSION["type"] = 1;
    header("location: Magasin_Interaction/mainMagasin.php");
    exit;
  }else if($req3 -> rowCount() !=0){
    $_SESSION["login"] = $login;
    $_SESSION["mdp"] = $mdp;
    $_SESSION["type"] = 2;
    header("location: Admin/mainAdmin.php");
    exit;
  }else{
    $error =1;
  }
}


?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>MicroGames - Acceuil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/master.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">MicroGames</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav" id="navbar">
      <?php
      //on propose si le client veut aller vers son espace personnel
      if(isset($_SESSION["login"])){
        switch ($_SESSION["type"]) {
          case 0:
          ?>
          <li class="nav-item">
            <a class="nav-link" href="Client_Interaction/mainClient.php">Mon espace Perso</a>
          </li>
          <?php
          break;

          case 1:
          ?>
          <li class="nav-item">
            <a class="nav-link" href="Magasin_Interaction/mainMagasin.php">Mon espace Perso</a>
          </li>
          <?php
          break;
        }
      }


      ?>

    </ul>
    <?php
    if(isset($_SESSION["login"])){
      //Bouton déconnexion
      ?>
      <form class="form-inline my-2 my-lg-0" method="post" action="connectionFiles/logout.php">
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Disconnect</button>
      </form>
      <?php
    }else{
      ?>
      <form class="form-inline my-2 my-lg-0" method="post">

        <input  class="form-control mr-sm-2" type="text" placeholder="Utilisateur" name="login" required>
        <input class="form-control mr-sm-2" type="password" placeholder="Password" name="mdp" required>
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Login</button>
      </form>
      <?php
    }
    ?>


  </nav>
  <div class="Contenue">

    <?php
    if (isset($_GET["nMdp"])) {
      ?><div class="alert alert-primary">
        <p>Votre mot de Passe est réinitialisé, vous pouvez vous connecter</p>
      </div><?php

    }
    if (isset($_GET["sucess"])){
      ?><div class="alert alert-primary">
        <p>Votre compte est crée, vous pouvez vous connecter</p>
      </div><?php
    }
    if(isset($errorMail)){
      switch ($errorMail) {
        case 1:
        ?><div class="alert alert-danger">
          <p>Le mail n'a pas été envoyé : il n'a pas été trouvé dans notre base de données</p>
        </div><?php
        break;

        case 0:
        ?><div class="alert alert-primary">
          <p>Le mail a été envoyé</p>
        </div><?php
        break;
      }
    }
    if (isset($error)) {
      ?>
      <div class="alert alert-danger">
        <p>La connexion a échoué , le couple Login/MotDePasse n'a pas été trouvé dans nos bases de données</p>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Mot De passe Oublié ?
        </button>
      </div>
      <!-- Button trigger modal -->


      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Voulez vous envoyer un mail ?<p>
                <form class="" method="post">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">@</span>
                    </div>
                    <input type="text" class="form-control" placeholder="email" aria-describedby="basic-addon1" name="email" required>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Envoyer un mail</button>
                </form>

              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>

      <p>Découvrez <b>MicroGames</b> la plus Petite entreprise de Jeux Vidéos De France ! Nous possédons un catalogue de moins de 15 jeux et consoles pour vos parties endiablés a la maison de retraite avec Giselle !</p>
      <p></p>
      <?php
      if(!isset($_SESSION["login"])){
        ?>
        <a href="inscription.php">Nouveau Client ?</a>
        <?php
      }

      ?>

    </div>

  </body>
  </html>
