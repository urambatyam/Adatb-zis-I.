<?php
include_once("functions.php");
session_start();
if(isset($_POST["add_dok"])){
    $errors = [];
    if(!isset($_POST["mkode"]) || trim($_POST['mkode']) ==="" ||
        !isset($_POST["mdik"]) || trim($_POST['mdik']) ===""||
        !isset($_POST["Dday"]) || trim($_POST['Dday']) ===""||
        !isset($_POST["e_Dday"]) || trim($_POST['e_Dday']) ===""||
        !isset($_POST["fname"]) || trim($_POST['fname']) ===""||
        !isset($_POST["participant"]) || trim($_POST['participant']) ===""||
        !isset($_POST["money"]) || trim($_POST['money']) ===""){
        $errors[] = "Ki kell tölteni a mezőket!";
        $_SESSION["reg_dok_err"] = $errors;
        header("location: ala_dok_add.php");
    }else{
        $mkode = htmlspecialchars($_POST["mkode"]);
        $mdik = htmlspecialchars($_POST["mdik"]);
        $dday = htmlspecialchars($_POST["Dday"]);
        $e_dday = htmlspecialchars($_POST["e_Dday"]);
        $fname = htmlspecialchars($_POST["fname"]);
        $participant = htmlspecialchars($_POST["participant"]);
        $money = htmlspecialchars($_POST["money"]);
        if(strlen($mkode) > 8){
            $errors[] = "túl hoszzú";
        }
        if(strlen($mdik) > 3){
            $errors[] = "túl nagy sorszám";
        }
        if(strlen($fname) > 10){
            $errors[] = "túl hoszzú fáljnév";
        }
        if(strlen($participant) > 20){
            $errors[] = "túl hoszzú név";
        }
        if(strlen($money) > 10){
            $errors[] = "túl nagy összeg";
        }
        if(isset($_POST["betext"])){
            $betext = htmlspecialchars($_POST["betext"]);
            if(strlen($betext) > 255){
                $errors[] = "túl hosszú szöveg";
            }
        }else{
            $betext = null;
        }
        if(count($errors) === 0){
            $add = add_all_dok($mkode,$mdik,$dday,$e_dday,$fname,$participant,$money,$betext);
            if(!$add){
                $_SESSION["reg_dok_err"] = $errors;
                header("location: ala_dok_add.php");
                die("Nem sikerült hozzáadni!");
            }else{
                $_SESSION["sik_dok"] = "Sikerült hozzáaddni a pályázatott";
                header("location: ala_dok_add.php");
            }
        }
        $_SESSION["reg_dok_err"] = $errors;
        header("location: ala_dok_add.php");
    }
}
