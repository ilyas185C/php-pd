<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .error-message {
            color: #f44336;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form action="login.php" method="post">
        <h1>Authentification</h1>
        <label for="login">Login :</label>
        <input type="text" name="login" id="login" required>
        <label for="password">Password :</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">S'authentifier</button>
        <?php
        if($_SERVER['REQUEST_METHOD']=='POST'){
            include "connection.php";
            $login = $_POST['login'];
            $password = $_POST['password'];
            if(empty($login) || empty($password)){
                echo "<p class='error-message'>Veuillez saisir un login et un mot de passe</p>";
            }else{
                $stm=$conn->prepare("SELECT * FROM CompteProprietaire WHERE loginProp=:login AND motPasse=:password");
                $stm->bindParam(':login',$login);
                $stm->bindParam(':password',$password);
                $stm->execute();
                $compte=$stm->fetch(PDO::FETCH_ASSOC);
                if(!$compte){
                    echo "<p class='error-message'>Erreur de login/mot de passe.</p>";
                }else{
                    session_start();
                    $_SESSION['login'] = $login;
                    header('Location: dashboard.php');
                    exit();
                }
            }
        }
        ?>
    </form>
</body>
</html>