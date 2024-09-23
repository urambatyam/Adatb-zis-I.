<?php
include_once("functions.php");
session_start();
if(isset($_POST["Modósít"])){
    $error = [];
    if(
        !isset($_POST["palykod"]) || trim($_POST['palykod']) ==="" ||
        !isset($_POST["id"]) || trim($_POST['id']) ==="" ||
        !isset($_POST["name"]) || trim($_POST['name']) ==="" ||
        !isset($_POST["time"]) || trim($_POST['time']) ==="" ||
        !isset($_POST["description"]) || trim($_POST['description']) ==="" ||
        !isset($_POST["completed"]) || trim($_POST['completed']) ===""){
        $error[] = "Ki kell tölteni a mezőket";
        $_SESSION["reg_mer_err"] = $error;
        header("location: merfoldko_modosit.php");
    }else{
        $eredet = htmlspecialchars($_POST["eredet"]);
        $kod = htmlspecialchars($_POST["palykod"]);
        $id = htmlspecialchars($_POST["id"]);
        $name = htmlspecialchars($_POST["name"]);
        $time = htmlspecialchars($_POST["time"]);
        $leiras = htmlspecialchars($_POST["description"]);
        $tej = htmlspecialchars($_POST["completed"]);



        if(strlen($kod) > 8){
            $error[] = "túl hosszú pályázat kód";
        }
        if(strlen($id) > 8){
            $error[] = "túl hosszú azonosító";
        }
        if(strlen($name) > 10){
            $error[] = "túl hosszú megnevezés";
        }

        if(strlen($leiras) > 200){
            $error[] = "túl hosszú leirás";
        }
        if($tej > 100 || $tej < 0){
            $error[] = "nem lehet nagyobb a tejesülés 100%-nál vagy kisebb 0-nál";
        }
        if(!filter_var($tej,FILTER_SANITIZE_NUMBER_INT)){
            $error[] = "a tejesülés csak egászszámot tartalmazhat";
        }

        if(id_mer($id) && $id !== $eredet){
            $error[] = "Ilyen merföldkő azonosító már van";
        }

        if(count($error) === 0){
            $add = up_mer($eredet,$id,$kod,$name,$time,$leiras,$tej);
            if(!$add){
                $_SESSION["reg_mer_err"] = $error;
                header("location: merfoldko_modosit.php");
                die("Nem sikerült a modositás!");
            }else{
                $_SESSION["sik_mer"] = "Sikerült a mérföldkövet modosítani";
                header("location: merfoldko_modosit.php");
            }
        }
        $_SESSION["reg_mer_err"] = $error;
        header("location: merfoldko_modosit.php");
    }
}

