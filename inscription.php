<?php include("connectionFiles/connectionLOG.inc.php");

if(isset($_POST["prenom"])){
  if($_POST["password"] == $_POST["password2"]){
    $dbh->query("INSERT INTO Client (`nomClient`, `PrenomClient`, `Age`, `Sexe`, `AdresseMail`,`idMagasin`, `Date`, `login`, `motDePasse`) VALUES (\"".$_POST["nom"]."\",\"".$_POST["prenom"]."\",\"".$_POST["age"]."\",\"".$_POST["sexe"]."\",\"".$_POST["email"]."\",\"".$_POST["Magasin"]."\",DATE(NOW()),\"".$_POST["login"]."\",SHA1(\"".$_POST["password"]."\"));");
    header("location: index.php?sucess=true");
  }else {
    $error = true;
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
    <h1>Inscription</h1>
    <form method="post">
      <div class="form-group">
        <div class="form-row">
          <div class="col">
            <input type="text" class="form-control" placeholder="Prenom" name="prenom" required>
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="Nom" name="nom" required>
          </div>
          <div class="col">
            <input type="number" class="form-control" placeholder="Age" name="age" min="0" required>
          </div>
        </div>
        <br>
      </div>
      <div class="form-group">
        <select class="form-control" name="sexe" required>
          <option value="H">Homme</option>
          <option value="F">Femme</option>
        </select>
      </div>

      <div class="form-group">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">@</span>
          </div>
          <input type="text" class="form-control" placeholder="email" aria-label="email" aria-describedby="basic-addon1" name="email" required>
        </div>
      </div>
      <div class="form-group">
        <h2>Magasin</h2>
        <select class="form-control" name="Magasin">
          <?php
          $req = $dbh->query("SELECT idMagasin,NomMagasin,AdresseMagasin FROM Magasin;");
          while($ligne= $req->fetch()){
            echo "<option value=\"".$ligne[0]."\">".$ligne[1]." - ".$ligne[2]." </option>";
          }

           ?>
        </select>
      </div>

      <div class="form-group">
        <div class="form-row">
          <div class="col">
            <input type="text" class="form-control" placeholder="login" name="login" required>
          </div>
          <div class="col">
            <input type="password" class="form-control" placeholder="Mot de Passe" name="password" required>
          </div>
          <div class="col">
            <input type="password" class="form-control" placeholder="Mot de Passe (Valider)" name="password2" required>
          </div>
        </div>

        <div class="form-group">
          <button type="submit" name="button" class="btn btn-primary" style="margin-top:1%;">Valider</button>
        </div>
      </div>

    </form>
  </div>

</body>
</html>
