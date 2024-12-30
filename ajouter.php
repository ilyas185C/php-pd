<?php
    session_start();

    if(!isset($_SESSION['login'])){
        header("Location: login.php");
        exit();
    }
    include "connection.php";
    $sql="SELECT * FROM Categorie";
    $stm=$conn->query($sql);
    $categories=$stm->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Produit</title>
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

        table {
            width: 100%;
        }

        td {
            padding: 10px 0;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
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
            margin-top: 20px;
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
    <form action="ajouter.php" method="post" enctype="multipart/form-data">
        <h1>Ajouter Produit</h1>
        <table>
            <tr>
                <td>
                    Libelle
                    <input type="text" name="libelle" required>
                </td>
            </tr>
            <tr>
                <td>
                    Prix Unitaire 
                    <input type="text" name="prixu" id="" required>
                </td>
            </tr>
            <tr>
                <td>
                    Date Achat
                    <input type="date" name="datea" required>
                </td>
            </tr>
            <tr>
                <td>
                    Photo Produit 
                    <input type='file' name="photo" id="" required>
                </td>
            </tr>
            <tr>
                <td>
                    Categorie
                    <select name="categorie" required>
                        <?php foreach($categories as $categorie){?>
                            <option value="<?php echo $categorie['idCategorie'] ?>"><?php echo $categorie['denomination'] ?></option>
                        <?php }?>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $libelle = $_POST['libelle'];
        $prixu = $_POST['prixu'];
        $datea = $_POST['datea'];
        $categorie = $_POST['categorie'];
        if (isset($_FILES['photo'])) {
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["photo"]["name"]);
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $sql="INSERT INTO Produit(libelle, prixUnitaire, dateAchat, photoProduit, idCategorie) VALUES (:libelle, :prixu, :datea, :target_file, :idcategorie)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':libelle', $libelle);
                $stmt->bindParam(':prixu', $prixu);
                $stmt->bindParam(':datea', $datea);
                $stmt->bindParam(':target_file', $target_file);
                $stmt->bindParam(':idcategorie', $categorie);
                $stmt->execute();
                header('location:dashboard.php');
                exit();
            }else {
                echo "Désolé, une erreur est survenue lors du téléchargement de votre fichier.";
            }
        } else {
            echo "Aucun fichier n'a été téléchargé ou une erreur est survenue lors du téléchargement.";
        }
    }
?>