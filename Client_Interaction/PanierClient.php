<?php
include("../connectionFiles/checkConnect.php");


//Fonction qui va executer la commande de suppression du produit
function removeArticle($qty, $produit, $client, $dbh)
{
  $actQty = $dbh ->query("SELECT Qty FROM DetailPanierC WHERE idProd = $produit;") -> fetch()[0];

  $res = $actQty - $qty;

  if($res >= 1)
  {
    $dbh->query("UPDATE DetailPanierC SET Qty = Qty - $qty WHERE idProd = $produit AND idClient = $client;");
  }
  else {
    $dbh->query("DELETE FROM DetailPanierC WHERE idProd = $produit AND idClient = $client;");
  }
}

function acheterPanier($dbh)
{

  // requete qui recupère les produits présents dans le panier de l'Utilisateur
  $req = $dbh->query("SELECT Produit.Nom, Categorie.libCat, Produit.prix, Qty, Qty * Produit.prix, Produit.idProd, idClient, idProd FROM DetailPanierC NATURAL JOIN Produit JOIN Categorie ON Produit.idCat = Categorie.idCat WHERE idClient IN ( SELECT idClient FROM DetailPanierC NATURAL JOIN Client WHERE Client.login=\"".$_SESSION["login"]."\");");

  if($req->rowCount()!=0){
    $clt = $dbh ->query("SELECT DISTINCT idClient FROM DetailPanierC NATURAL JOIN Client WHERE Client.login=\"".$_SESSION["login"]."\";") -> fetch()[0];

    $mag = $dbh ->query("SELECT DISTINCT idMagasin FROM Client WHERE idClient = $clt;") -> fetch()[0];

    $dbh ->query("INSERT INTO CommandeClient (Date, Etat, ModeLivraison, idClient, idMagasin) VALUES ('2019-05-18','En cours de Livraison','Livraison a Domicile', $clt, $mag);");

    $id_Commande = $dbh ->query("SELECT MAX(id_C) FROM CommandeClient WHERE 1;") -> fetch()[0];

    while($ligne= $req -> fetch()){

      $dbh ->query("INSERT INTO DetailCC VALUES ($id_Commande, '$ligne[7]', '$ligne[3]');");
    }

    //On delete le panier
    $dbh->query("DELETE FROM DetailPanierC WHERE idClient = $clt;");
  }
}

if (isset($_GET["idC"])) {
  removeArticle($_GET["Qty"], $_GET["idP"], $_GET["idC"],$dbh);
}

if(isset($_POST["flag"])){
  acheterPanier($dbh);
}

// requete qui recupère les produits présents dans le panier de l'Utilisateur
$req = $dbh->query("SELECT Produit.Nom, Categorie.libCat, Produit.prix, Qty, Qty * Produit.prix, Produit.idProd, idClient, idProd, Produit.reduc FROM DetailPanierC NATURAL JOIN Produit JOIN Categorie ON Produit.idCat = Categorie.idCat WHERE idClient IN ( SELECT idClient FROM DetailPanierC NATURAL JOIN Client WHERE Client.login=\"".$_SESSION["login"]."\");");


?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>MicroGames - Panier</title>
  <link rel="stylesheet" href="/css/master.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">MicroGames - Client</a>
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


    <h1>Mon panier</h1>

    <?php
    if($req->rowCount()!=0){
      ?>

      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Nom Produit</th>
            <th scope="col">Catégorie</th>
            <th scope="col">Prix Unitaire</th>
            <th scope="col">Quantité</th>
            <th scope="col">Prix Total</th>
            <th scope="col">Suppression</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php

          $prix = 0;
          while ($ligne = $req->fetch()) {
            $prix += $ligne[4]*$ligne[8];

            echo "<tr><th scope=\"row\">".$ligne[0]."</th>
            <td>".$ligne[1]."</td>
            <td>".$ligne[2]." euros</td>
            <td>".$ligne[3]."</td>
            <td>".$ligne[4]*$ligne[8]." euros</td>
            <form method=\"get\">
            <input type=\"hidden\" value=\"".$ligne[7]."\" name=\"idP\">
            <input type=\"hidden\" value=\"".$ligne[6]."\" name=\"idC\">
            <td>"."<input class=\"form-control\" type=\"number\" name=\"Qty\" min=\"1\" required>"."</td>
            <td>"."<button class=\"btn btn-primary\" type=\"submit\">Suppimer du panier</button>"."</td>
            </form>
            </tr>";
          }

            echo "<tr><th scope=\"row\">"."Total"."</th><td>".""."</td><td>".""."</td><td>".""."</td><td>".$prix." euros</td><td>".""."</td></tr>";
          ?>
        </tbody>
      </table>

      <!-- Ce boutton devra lancer la fonction "acheterPanier"-->
      <form class="form-inline my-2 my-lg-0" method="post" action="PanierClient.php">
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Acheter</button>
        <input type="hidden" id="flag" name="flag" value="1">
      </form>

      <?php

    }else{
      echo "<b>Votre panier est vide</b>";
    }
      ?>


  </div>
</body>
</html>
