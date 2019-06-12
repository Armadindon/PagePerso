<?php
include("../connectionFiles/checkConnect.php");
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


    <h1>Mes commandes</h1>
    <h2>Pour plus d'informations sur une commande , cliquez sur le numéro de commande</h2>

    <?php
    $req = $dbh->query("SELECT CommandeClient.id_C,CommandeClient.Date,Etat,ModeLivraison,Magasin.NomMagasin FROM CommandeClient NATURAL JOIN Magasin JOIN Client ON CommandeClient.idClient=Client.idClient WHERE Client.login=\"".$_SESSION["login"]."\";");
    if($req->rowCount()!=0  || !isset($_GET["idCommande"])){
      ?>

      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Numéro Commande</th>
            <th scope="col">Date</th>
            <th scope="col">Etat</th>
            <th scope="col">Mode de Livraison</th>
            <th scope="col">Nom Magasin</th>
            <th scope="col">Prix Total</th>
          </tr>
        </thead>
        <tbody>
          <?php

          while ($ligne = $req->fetch()) {
            $reqPrix = $dbh->query("SELECT SUM((Produit.prix*Produit.reduc)*DetailCC.Qty) FROM DetailCC NATURAL JOIN Produit WHERE id_C=".$ligne[0].";");
            $prix = $reqPrix->fetch();
            echo "<tr><th scope=\"row\"><a href=\"Commande.php?idCommande=".$ligne[0]."\">".$ligne[0]."</a></th><td>".$ligne[1]."</td><td>".$ligne[2]."</td><td>".$ligne[3]."</td><td>".$ligne[4]."</td><td>".$prix[0]." euros</td></tr>";
          }
          ?>
        </tbody>
      </table>
      <?php

    }else{
      echo "<b>Vous N'avez pas de commandes effectuées</b>";
    }
    if(isset($_GET["idCommande"])){
      ?>
      <h2>Détail Commande n° <?php echo $_GET["idCommande"]; ?></h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Numéro Commande</th>
            <th scope="col">Nom Produit</th>
            <th scope="col">Editeur</th>
            <th scope="col">Catégorie</th>
            <th scope="col">Prix Unitaire</th>
            <th scope="col">Quantité</th>
            <th scope="col">Prix total</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $req = $dbh->query("SELECT id_C,Produit.Nom,Produit.Editeur,Categorie.libCat,Produit.prix*Produit.reduc,Qty,Qty*Produit.prix FROM DetailCC NATURAL JOIN Produit JOIN Categorie ON Produit.idCat=Categorie.idCat WHERE id_C=".$_GET["idCommande"].";");
          while ($ligne = $req->fetch()) {
            echo "<tr><th scope=\"row\">".$ligne[0]."</th><td>".$ligne[1]."</td><td>".$ligne[2]."</td><td>".$ligne[3]."</td><td>".$ligne[4]." euros</td><td>".$ligne[5]."</td><td>".$ligne[6]." euros</td></tr>";
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
