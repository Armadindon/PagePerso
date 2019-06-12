<?php
include("../connectionFiles/checkConnect.php");

if(isset($_POST["idP"])){
  $idC = $dbh ->query("SELECT idClient FROM Client WHERE login=\"".$_SESSION["login"]."\";")->fetch()[0];
  $cat = $dbh -> query("SELECT Categorie.libCat FROM Produit NATURAL JOIN Categorie WHERE idProd=\"".$_POST["idP"]."\";")->fetch()[0];//pour garder la section ouverte
  $qty = $_POST["Qty"];$idP=$_POST['idP'];
  $req = $dbh -> query("INSERT INTO DetailPanierC VALUES ($idC,$idP,$qty);");
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>MicroGames - Acceuil</title>
  <link rel="stylesheet" href="/css/master.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">MicroGames</a>
    <ul class="navbar-nav" id="navbar">
          <li class="nav-item">
            <a class="nav-link" href="mainClient.php">Mon espace Perso</a>
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
    <h1>Quel catégorie de produit voulez-vous consulter ?</h1>
    <form method="post">
      <div class="input-group mb-3">

        <select class="custom-select" id="inputGroupSelect03" name="Categorie">
          <?php
          $req = $dbh -> query("SELECT libCat FROM Categorie;");

          while ($ligne=$req->fetch()) {
            echo "<option value=\"".$ligne[0]."\">".$ligne[0]."</option>";
          }

          ?>
        </select>
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">Envoyer</button>
        </div>
      </div>
    </form>
    <?php
    if(isset($_POST["Categorie"])){
      $cat=$_POST["Categorie"];
    }
    if (isset($cat)) {
      echo "<h1>Boutique ".$cat."</h1>";
      ?>
      <table>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Nom Produit</th>
              <?php
              if ($cat == "jeux-video" || $cat == "consoles") {
                echo "<th scope=\"col\">Editeur</th>";
              }
               ?>
               <th scope="col">Prix</th>
              <th scope="col">Quantité souhaitée</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $idC = $dbh ->query("SELECT idClient FROM Client WHERE login=\"".$_SESSION["login"]."\";")->fetch()[0];
            if ($cat == "jeux-video" || $cat == "consoles") {
              $req = $dbh ->query("SELECT Nom,Editeur,idProd,prix*reduc FROM Produit NATURAL JOIN Categorie WHERE idProd NOT IN(SELECT idProd FROM DetailPanierC WHERE idClient=$idC) AND Categorie.libCat =\"".$cat."\" ;");
            }else{
              $req = $dbh ->query("SELECT Nom,idProd,prix*reduc FROM Produit NATURAL JOIN Categorie WHERE idProd NOT IN(SELECT idProd FROM DetailPanierC WHERE idClient=$idC) AND Categorie.libCat =\"".$cat."\" ;");
            }
            while ($ligne=$req->fetch()) {
              if ($cat == "jeux-video" || $cat == "consoles") {
                echo "<tr><td>".$ligne[0]."</td><td>".$ligne[1]."</td><td>".$ligne[3]." euros</td>";
                echo "<form method=\"post\"><input type=\"hidden\" value=\"".$ligne[2]."\" name=\"idP\"><td><input class=\"form-control\" type=\"number\" name=\"Qty\" min=\"1\" required></td><td><button class=\"btn btn-primary\" type=\"submit\">Ajouter au panier</button></td></form></tr>";
              }else{
                echo "<tr><td>".$ligne[0]."</td><td>".$ligne[2]." euros</td>";
                echo "<form method=\"post\"><input type=\"hidden\" value=\"".$ligne[1]."\" name=\"idP\"><td><input class=\"form-control\" type=\"number\" name=\"Qty\" min=\"1\" required></td><td><button class=\"btn btn-primary\" type=\"submit\">Ajouter au panier</button></td></form></tr>";
              }

            }

             ?>
          </tbody>
      </table>

      <?php
    }
    ?>

  </div>
</body>
</html>
