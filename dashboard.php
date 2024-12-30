<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit();
}
include 'connection.php';
$login=$_SESSION['login'];
$sql="SELECT * FROM CompteProprietaire where loginProp='$login'";
$stm=$conn->query($sql);
$compte=$stm->fetch(PDO::FETCH_ASSOC);
$hour=date('H');

$sql1 = "SELECT * FROM Produit INNER JOIN Categorie ON Produit.idCategorie = Categorie.idCategorie ORDER BY libelle";
$stm1=$conn->query($sql1);
$produits=$stm1->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        img {
            display: block;
            max-width: 100px;
            height: auto;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 2px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
        button a {
            color: white;
            text-decoration: none;
        }
        button:hover {
            background-color: #45a049;
        }
        .delete {
            background-color: #f44336;
        }
        .delete:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>
    <?php 
        if($hour<18 && $hour>6){
            echo '<h1>Bonjour '. $compte['prenom'].' '.$compte['nom'].'</h1>';
        }else{
            echo '<h1>Bonsoir '. $compte['prenom'].' '.$compte['nom'].'</h1>';
        }
    ?>

    <h2>Produits</h2>
    <table>
        <tr>
            <th>Reference</th>
            <th>Libelle</th>
            <th>Prix Unitaire</th>
            <th>Date Achat</th>
            <th>Photo produit</th>
            <th>Categorie</th>
            <th>Action</th>
        </tr>
    
    <?php foreach( $produits as $produit){?>
        <tr>
            <td><?php echo $produit['reference']; ?></td>
            <td><?php echo $produit['libelle']; ?></td> 
            <td><?php echo $produit['prixUnitaire']; ?></td>
            <td><?php echo $produit['dateAchat']; ?></td>
            <td><img src="<?php echo $produit['photoProduit']; ?>" alt="<?php echo $produit['libelle']; ?>"></td>
            <td><?php echo $produit['denomination']; ?></td>
            <td>
                <button><a href="modifier.php?reference=<?php echo $produit['reference']; ?>">Modifier</a></button>
                <button class="delete"><a href="delete.php?reference=<?php echo $produit['reference']; ?>"
                onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?')">Supprimer</a></button>
            </td>
        </tr>
    <?php }?>
    </table>
</body>
</html>