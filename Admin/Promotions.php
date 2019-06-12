<?php
include("../connectionFiles/checkConnect.php");
if(isset($_POST["reduc"])){
  $reduc = ($_POST["reduc"] / 100);
  $req1 = $dbh ->query("UPDATE Produit SET reduc=$reduc WHERE idProd IN (SELECT idProd FROM Magasin WHERE idMagasin IN (SELECT idMagasin FROM CommandeClient GROUP BY idMagasin HAVING COUNT(id_C) < 3));");
}

if(isset($_POST["cancel"])){
  $cancelReq = $dbh ->query("UPDATE Produit SET reduc=1.0 WHERE reduc!=1.0;");
}

?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>MicroGames - Promotion</title>
  <link rel="stylesheet" href="/css/master.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE 1Pi6jizo" crossorigin="anonymous"></script>
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

    <h1>Gestion des réduction des magasins</h1>
    <h2>Insérez la réduction souhaité à appliquer (en %) sur tous les magasins qui possèdent moins de trois commandes </h2>
    <?php
    $red = $dbh ->query("SELECT DISTINCT reduc FROM Produit") -> fetch()[0];

    if($red == 1){ //pas de réduction
      echo "<br><h3>Il n'y a pas de réduction appliquée à l'heure actuelle</h3>";
      echo "<br>
      <form class=\".form-inline my-2 my-lg-0\" method=\"post\" action=\"Promotions.php\">
        <input style=\"margin-left: 5em\" name=\"reduc\" type=\"number\" min=\"1\" max=\"99\">
        <button style=\"margin-left: 2em\" class=\"btn btn-outline-primary my-2 my-sm-0\" type=\"submit\">Appliquer la réduction</button>
      </form>";
    } else { // réduction
      echo "<br><h3>Actuellement, il y a une réduction de ". $red*100 ."%</h3>";
      echo "<br>
      <form class=\".form-inline my-2 my-lg-0\" method=\"post\" action=\"Promotions.php\">
        <input style=\"margin-left: 5em\" name=\"reduc\" type=\"number\" min=\"1\" max=\"99\">
        <button style=\"margin-left: 2em\" class=\"btn btn-outline-primary my-2 my-sm-0\" type=\"submit\">Appliquer une nouvelle réduction</button>
      </form>
      <br>
      <form class=\".form-inline my-2 my-lg-0\" method=\"post\" action=\"Promotions.php\">
        <input name=\"cancel\" value=\"1\" type=\"hidden\">
        <button style=\"margin-left: 11.5em\" class=\"btn btn-outline-primary my-2 my-sm-0\" type=\"submit\">Annuler la réduction</button>
      </form>";
    }

     ?>

  </div>
</body>
</html>
