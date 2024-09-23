<?php
include_once("functions.php");
session_start();
if(isset($_POST["add"])){
    $error = [];
    if(!isset($_POST["id"]) || trim($_POST['id']) ==="" ||
        !isset($_POST["name"]) || trim($_POST['name']) ==="" ||
        !isset($_POST["time"]) || trim($_POST['time']) ==="" ||
        !isset($_POST["description"]) || trim($_POST['description']) ==="" ||
        !isset($_POST["palykod"]) || trim($_POST['palykod']) ===""){
        $error[] = "Ki kell tölteni a mezőket";
        $_SESSION["reg_mer_err"] = $error;
        header("location: merfoldko_add.php");
    }else{
        $id = htmlspecialchars($_POST["id"]);
        $title = htmlspecialchars($_POST["name"]);
        $ido = htmlspecialchars($_POST["time"]);
        $leiras = htmlspecialchars($_POST["description"]);
        $kod = htmlspecialchars($_POST["palykod"]);
        if(strlen($id) > 8){
            $error[] = "túl hosszú azonosító";
        }
        if(strlen($leiras) > 200){
            $error[] = "túl hosszú leirás";
        }
        if(strlen($title) > 10){
            $error[] = "túl hosszú megnevezés";
        }
        if(id_mer($id)){
            $error[] = "Ilyen merföldkő azonosító már van";
        }

        if(count($error) === 0){
            $add = add_mer($id,$leiras,$title,$ido,$kod);
            if(!$add){
                $_SESSION["reg_mer_err"] = $error;
                header("location: merfoldko_add.php");
                die("Nem sikerült hozzáadni!");
            }else{
                $_SESSION["sik_mer"] = "Sikerült hozzáaddni a mérföldkövet";
                header("location: merfoldko_add.php");
            }
        }
        $_SESSION["reg_mer_err"] = $error;
        header("location: merfoldko_add.php");
    }
}

