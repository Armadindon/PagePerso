<?php include("connectionFiles/connectionLOG.inc.php");
if(isset($_GET["idC"])){
  $idC = $_GET["idC"];
}else{
  $idC = $_GET["idC"];
}
if(isset($_POST["nMdp"])){
  if($_POST["nMdp"]== $_POST["nMdp2"]){
    $dbh->query("UPDATE Client SET motDePasse=SHA1(\"".$_POST["nMdp"]."\") WHERE idClient = $idC;");
    header("location: index.php?nMdp=true");
  }else{
    $error=true;
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
    <a class="navbar-brand" href="index.php">MicroGames</a>
  </nav>
  <div class="Contenue">
    <?php

    if (isset($error)) {
      ?>
      <div class="alert alert-primary">
        <p>Les Mots De passe ne correspondent pas</p>
      </div>
      <?php
    }
     ?>
    <h1>Réinitialisation du mot de Passe</h1>
    <form class="" method="post">
      <div class="form-group">
        <div class="form-row">
          <div class="col">
            <input type="password" class="form-control" placeholder="Nouveau Mot de Passe" name="nMdp" required>
          </div>
          <div class="col">
            <input type="password" class="form-control" placeholder="Verifier Mot de Passe" name="nMdp2" required>
          </div>
        </div>
      </div>
      <?php echo "<input type=\"hidden\" name=\"idC\" value=\"".$idC."\">"; ?>
      <button type="submit" name="button" class="btn btn-primary">Envoyer</button>
    </form>

  </div>

</body>
</html>
