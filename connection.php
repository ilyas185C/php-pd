<?php
 $dsn = "mysql:host=sql211.infinityfree.com;dbname=if0_37993578_gestionproduit_v2";  
 $user = "if0_37993578"; 
 $pass = "vWfKRizcIsDnP";  
 try { $db = new PDO($dsn, $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo "<p> Erreur : " . $e->getMessage();
    die();
}
?>