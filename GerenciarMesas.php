<?php 
    require ("conn/conn.php");
    session_start();
    if((!isset ($_SESSION['senha']) == true) and (!isset ($_SESSION['cpf']) == true) or ($_SESSION['nivel'] !== 2))
    {
        print "<script>alert('Ops!! Você ainda não possui acesso, se registre primeiro');</script>";
        print "<script>location.href='../Index.php';</script>";
    }
   
 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Sua Comanda</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css'>
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
   
    <script type="text/javascript" src="jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.4/angular.min.js"></script>
    
    
    <link rel="stylesheet" type="text/css" href="css/Comanda.css">
</head>

<body>

    <div class="container-fluid">

    <?php
        include "corpo/menu.php";

    ?>

   <br>
</body>
</html>