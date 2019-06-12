<?php
  include("../connectionFiles/checkConnect.php");
  if(isset($_POST["nom"])){
    if(isset($_POST["password"]) && $_POST["password"]!=""){
    if($_POST["password"] == $_POST["password2"]){
        $dbh->query("UPDATE Magasin SET NomMagasin=\"".$_POST["nom"]."\",  AdresseMagasin=\"".$_POST["adresse"]."\",  login=\"".$_POST["login"]."\", motDePasse=SHA1(\"".$_POST["password"]."\")  WHERE idMagasin = \"".$_POST["idM"]."\";");
        $error=false;
    }else {
      $error = true;
    }
  }else{
    $dbh->query("UPDATE Magasin SET NomMagasin=\"".$_POST["nom"]."\",  AdresseMagasin=\"".$_POST["adresse"]."\",  login=\"".$_POST["login"]."\"  WHERE idMagasin = \"".$_POST["idM"]."\";");
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
      if(isset($_POST["idM"])){
        if (isset($error)) {
          if($error){
            $infoMagasin = $dbh->query("SELECT * FROM Magasin WHERE idMagasin =\"".$_POST["idM"]."\" ;")->fetch();
            ?><h1>Modification Magasin</h1>
            <form method="post">
              <input type="hidden" name="idM" value="<?php echo $_POST["idM"]; ?>">
              <div class="form-group">
                <div class="form-row">
                  <div class="col">
                    <input type="text" class="form-control" placeholder="Nom Magasin" name="nom" value="<?php echo $infoMagasin[1]; ?>" required>
                  </div>
                  <div class="col">
                    <input type="text" class="form-control" placeholder="Login" name="login" value="<?php echo $infoMagasin[3]; ?>" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col">
                    <input type="text" class="form-control" placeholder="AdresseMagasin" name="adresse" value="<?php echo $infoMagasin[2]; ?>" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col">
                    <input type="password" class="form-control" placeholder="Mot De Passe" name="password" >
                  </div>
                  <div class="col">
                    <input type="password" class="form-control" placeholder="Mot De Passe" name="password2" >
                  </div>
                </div>

              </div>
                <div class="form-group">
                  <button type="submit" name="button" class="btn btn-primary" style="margin-top:1%;">Valider</button>
                </div>

            </form><?php
          }else{
            ?><div class="alert alert-primary">
              <p>Les modifications ont été enregistrés</p>
            </div><?php
          }
        }else{
          $infoMagasin = $dbh->query("SELECT * FROM Magasin WHERE idMagasin =\"".$_POST["idM"]."\" ;")->fetch();
          ?><h1>Modification Magasin</h1>
          <form method="post">
            <input type="hidden" name="idM" value="<?php echo $_POST["idM"]; ?>">
            <div class="form-group">
              <div class="form-row">
                <div class="col">
                  <input type="text" class="form-control" placeholder="Nom Magasin" name="nom" value="<?php echo $infoMagasin[1]; ?>" required>
                </div>
                <div class="col">
                  <input type="text" class="form-control" placeholder="Login" name="login" value="<?php echo $infoMagasin[3]; ?>" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col">
                  <input type="text" class="form-control" placeholder="AdresseMagasin" name="adresse" value="<?php echo $infoMagasin[2]; ?>" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col">
                  <input type="password" class="form-control" placeholder="Mot De Passe" name="password" >
                </div>
                <div class="col">
                  <input type="password" class="form-control" placeholder="Mot De Passe" name="password2" >
                </div>
              </div>

            </div>
              <div class="form-group">
                <button type="submit" name="button" class="btn btn-primary" style="margin-top:1%;">Valider</button>
              </div>

          </form><?php
        }

        ?>

        <?php
      }
      echo "<hr>";
       ?>
      <h1>Liste des Magasins</h1>
      <?php
      $req = $dbh ->query("SELECT * FROM Magasin;");

      if($req->rowCount()!=0){
        ?>

        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">ID Magasin</th>
              <th scope="col">Nom Magasin</th>
              <th scope="col">Adresse Magasin</th>
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
              <form method=\"post\">
              <input type=\"hidden\" name=\"idM\" value=\"".$ligne[0]."\" >
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
