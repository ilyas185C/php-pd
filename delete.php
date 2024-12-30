<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit();
}
include "connection.php";
$reference=$_GET['reference'];
$sql="DELETE FROM Produit WHERE reference=:reference";
$stmt=$conn->prepare($sql);
$stmt->bindParam(':reference',$reference);
$stmt->execute();
header("location:dashboard.php");
exit();
?>