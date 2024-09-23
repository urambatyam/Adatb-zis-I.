<?php
session_start();
include_once('functions.php');
if(isset($_POST["buttom"])){
    $error = [];
    if(!isset($_POST["name"]) || trim($_POST["name"] === "") || !isset($_POST["password"]) || trim($_POST["password"]) === ""){
        $error[] = "Tölsd ki az összes mezőt!";
        $_SESSION["log_err"] = $error;
        header("location: index.php");
    }else{
        $name_clear = htmlspecialchars($_POST["name"]);
        $password_clear = htmlspecialchars($_POST["password"]);
        if($_SESSION["user"] = login($name_clear,$password_clear)){
            if($_SESSION["user"]["szerepkor"] === "admin"){
                header("location: felhasznalo_kezeles.php");
            }elseif ($_SESSION["user"]["szerepkor"] === "témafelelös"){
                header("location: profil.php");
            }
        }else{
            $error[] = "Helytelen jelszó és/vagy felhasználónév";
            $_SESSION["log_err"] = $error;
            header("location: index.php");
        }

    }
}
