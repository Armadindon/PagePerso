<?php
include("../connectionFiles/checkConnect.php");
if(isset($_POST["prenom"])){
  if(isset($_POST["password"]) && $_POST["password"]!=""){
  if($_POST["password"] == $_POST["password2"]){
      $dbh->query("UPDATE Client SET nomClient=\"".$_POST["nom"]."\",  PrenomClient=\"".$_POST["prenom"]."\",  Age=\"".$_POST["age"]."\",  Sexe=\"".$_POST["sexe"]."\", AdresseMail=\"".$_POST["email"]."\", idMagasin=\"".$_POST["Magasin"]."\", login=\"".$_POST["login"]."\", motDePasse=SHA1(\"".$_POST["password"]."\") WHERE idClient = \"".$_POST["idC"]."\";");
      $error=false;
  }else {
    $error = true;
  }
}else{
  $dbh->query("UPDATE Client SET nomClient=\"".$_POST["nom"]."\",  PrenomClient=\"".$_POST["prenom"]."\",  Age=\"".$_POST["age"]."\" , Sexe=\"".$_POST["sexe"]."\", AdresseMail=\"".$_POST["email"]."\", idMagasin=\"".$_POST["Magasin"]."\" ,login=\"".$_POST["login"]."\" WHERE idClient = \"".$_POST["idC"]."\";");
  $error=false;
}
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>MicroGames</title>
  <link rel="stylesheet" href="/css/master.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">MicroGames - Administrateur</a>
    <ul class="navbar-nav" id="navbar">
          <li class="nav-item">
            <a class="nav-link" href="mainAdmin.php">Mon espace Perso</a>
          </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="post" action="/connectionFiles/logout.php">
      <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Disconnect</button>
    </form>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

  </nav>
  <div class="Contenue">
    <?php
    if(isset($_POST["idC"])){
      if (isset($error)) {
        if($error){
          $infoClient = $dbh->query("SELECT * FROM Client WHERE idClient =\"".$_POST["idC"]."\" ;")->fetch();
          ?><div class="alert alert-danger">
            <p>Les mots de passe ne correspondent pas</p>
          </div>
          <h1>Modification Client</h1>
          <form method="post">
            <input type="hidden" name="idC" value="<?php echo $_POST["idC"]; ?>">
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <input type="text" class="form-control" placeholder="Prenom" name="prenom" value="<?php echo $infoClient[2]; ?>" required>
                </div>
                <div class="col">
                  <input type="text" class="form-control" placeholder="Nom" name="nom" value="<?php echo $infoClient[1]; ?>" required>
                </div>
                <div class="col">
                  <input type="number" class="form-control" placeholder="Age" name="age" min="0" value="<?php echo $infoClient[3]; ?>" required>
                </div>
              </div>
              <br>
            </div>
            <div class="form-group">
              <select class="form-control" name="sexe" required>
                <option value="H" <?php if($infoClient[4]=="H"){echo "selected";} ?>>Homme</option>
                <option value="F" <?php if($infoClient[4]=="F"){echo "selected";} ?>>Femme</option>
              </select>
            </div>

            <div class="form-group">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">@</span>
                </div>
                <input type="text" class="form-control" placeholder="email" aria-label="email" aria-describedby="basic-addon1" name="email" value="<?php echo $infoClient[5]; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <h3>Magasin</h3>
              <select class="form-control" name="Magasin">
                <?php
                $req = $dbh->query("SELECT idMagasin,NomMagasin,AdresseMagasin FROM Magasin;");
                while($ligne= $req->fetch()){
                  if ($infoClient[7]==$ligne[0]) {
                    $select = "selected";
                  }else{
                    $select = "";
                  }
                  echo "<option value=\"".$ligne[0]."\"".$select.">".$ligne[1]." - ".$ligne[2]." </option>";
                }

                 ?>
              </select>
            </div>

            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <input type="text" class="form-control" placeholder="login" name="login" value="<?php echo $infoClient[8]; ?>"required>
                </div>
                <div class="col">
                  <input type="password" class="form-control" placeholder="Mot de Passe" name="password" >
                </div>
                <div class="col">
                  <input type="password" class="form-control" placeholder="Mot de Passe (Valider)" name="password2" >
                </div>
              </div>

              <div class="form-group">
                <button type="submit" name="button" class="btn btn-primary" style="margin-top:1%;">Valider</button>
              </div>
            </div>

          </form><?php
        }else{
          ?><div class="alert alert-primary">
            <p>Les modifications ont été enregistrés</p>
          </div><?php
        }
      }else{
        $infoClient = $dbh->query("SELECT * FROM Client WHERE idClient =\"".$_POST["idC"]."\" ;")->fetch();
        ?><h1>Modification Client</h1>
        <form method="post">
          <input type="hidden" name="idC" value="<?php echo $_POST["idC"]; ?>">
          <div class="form-group">
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" placeholder="Prenom" name="prenom" value="<?php echo $infoClient[2]; ?>" required>
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="Nom" name="nom" value="<?php echo $infoClient[1]; ?>" required>
              </div>
              <div class="col">
                <input type="number" class="form-control" placeholder="Age" name="age" min="0" value="<?php echo $infoClient[3]; ?>" required>
              </div>
            </div>
            <br>
          </div>
          <div class="form-group">
            <select class="form-control" name="sexe" required>
              <option value="H" <?php if($infoClient[4]=="H"){echo "selected";} ?>>Homme</option>
              <option value="F" <?php if($infoClient[4]=="F"){echo "selected";} ?>>Femme</option>
            </select>
          </div>

          <div class="form-group">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">@</span>
              </div>
              <input type="text" class="form-control" placeholder="email" aria-label="email" aria-describedby="basic-addon1" name="email" value="<?php echo $infoClient[5]; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <h3>Magasin</h3>
            <select class="form-control" name="Magasin">
              <?php
              $req = $dbh->query("SELECT idMagasin,NomMagasin,AdresseMagasin FROM Magasin;");
              while($ligne= $req->fetch()){
                if ($infoClient[7]==$ligne[0]) {
                  $select = "selected";
                }else{
                  $select = "";
                }
                echo "<option value=\"".$ligne[0]."\"".$select.">".$ligne[1]." - ".$ligne[2]." </option>";
              }

               ?>
            </select>
          </div>

          <div class="form-group">
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" placeholder="login" name="login" value="<?php echo $infoClient[8]; ?>"required>
              </div>
              <div class="col">
                <input type="password" class="form-control" placeholder="Mot de Passe" name="password" >
              </div>
              <div class="col">
                <input type="password" class="form-control" placeholder="Mot de Passe (Valider)" name="password2" >
              </div>
            </div>

            <div class="form-group">
              <button type="submit" name="button" class="btn btn-primary" style="margin-top:1%;">Valider</button>
            </div>
          </div>

        </form><?php
      }

      ?>

      <?php
    }
    echo "<hr>";
     ?>
    <h1>Liste des Clients</h1>
    <?php
    $req = $dbh ->query("SELECT * FROM Client;");

    if($req->rowCount()!=0){
      ?>

      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID Client</th>
            <th scope="col">Nom Client</th>
            <th scope="col">Prenom Client</th>
            <th scope="col">Age</th>
            <th scope="col">Sexe</th>
            <th scope="col">Adresse mail</th>
            <th scope="col">Date d'inscription</th>
            <th scope="col">ID Magasin lié</th>
            <th scope="col">Login</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($ligne = $req->fetch()) {
            echo "
            <td>$ligne[0]</td>
            <td>$ligne[1]</td>
            <td>$ligne[2]</td>
            <td>$ligne[3]</td>
            <td>$ligne[4]</td>
            <td>$ligne[5]</td>
            <td>$ligne[6]</td>
            <td>$ligne[7]</td>
            <td>$ligne[8]</td>
            <form method=\"post\">
            <input type=\"hidden\" name=\"idC\" value=\"".$ligne[0]."\" >
            <td><button type=\"submit\" class=\"btn btn-primary\">Modifier</buttton></td>
            </form>
            </tr>";
          }
        }
          ?>
        </tbody>
      </table>
  </div>
</body>
</html>
