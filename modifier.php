<?php
    session_start();

    if(!isset($_SESSION['login'])){
        header("Location: login.php");
        exit();
    }
    include "connection.php";

    // Process form if submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $reference = $_POST['reference'];
        $libelle = $_POST['libelle'];
        $prixu = $_POST['prixu'];
        $datea = $_POST['datea'];
        $idCategorie = $_POST['cat'];

        $sql = "UPDATE produit SET libelle=:libelle, prixUnitaire=:prixu, dateAchat=:datea, idCategorie=:idCategorie WHERE reference=:reference";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':reference', $reference);
        $stm->bindParam(':libelle', $libelle);
        $stm->bindParam(':prixu', $prixu);
        $stm->bindParam(':datea', $datea);
        $stm->bindParam(':idCategorie', $idCategorie);
        $stm->execute();

        header('Location: dashboard.php');
        exit();
    }

    // Fetch categories
    $sql = "SELECT * FROM Categorie";
    $stm = $conn->query($sql);
    $categories = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Fetch product details
    $reference = $_GET['reference'];
    $sql1 = "SELECT * FROM Produit WHERE reference = :reference";
    $stm1 = $conn->prepare($sql1);
    $stm1->bindParam(':reference', $reference);
    $stm1->execute();
    $produit = $stm1->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        form {
            background-color: #fff;
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="black" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            background-repeat: no-repeat;
            background-position-x: 98%;
            background-position-y: 50%;
        }
        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        @media screen and (max-width: 600px) {
            form {
                width: 100%;
                margin: 20px 0;
            }
        }
    </style>
</head>
<body>
<?php include "header.php"; ?>
    <form action="modifier.php" method="post">
        <h1>Modifier Produit</h1>
        <input type="hidden" name="reference" value="<?php echo $produit['reference']; ?>">
        <label for="libelle">Libelle</label>
        <input type="text" name="libelle" id="libelle" value="<?php echo $produit['libelle']; ?>" required>
        <label for="prixu">Prix Unitaire</label>
        <input type="text" name="prixu" id="prixu" value="<?php echo $produit['prixUnitaire']; ?>" required>
        <label for="datea">Date Achat</label>
        <input type="date" name="datea" id="datea" value="<?php echo $produit['dateAchat']; ?>" required>
        <label for="cat">Categorie</label>
        <select name="cat" id="cat" required>
            <?php foreach ($categories as $categorie) { ?>
                <option value="<?php echo $categorie['idCategorie']; ?>" <?php if ($produit['idCategorie'] == $categorie['idCategorie']) { echo "selected"; } ?>>
                    <?php echo $categorie['denomination']; ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit">Modifier</button>
    </form>
</body>
</html>