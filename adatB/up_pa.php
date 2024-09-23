<?php
include_once("functions.php");
session_start();
if(isset($_POST["up_pa"])){
    $error = [];
    if(
        !isset($_POST["kode"]) || trim($_POST['kode']) ==="" ||
        !isset($_POST["topic"]) || trim($_POST['topic']) ==="" ||
        !isset($_POST["title"]) || trim($_POST['title']) ==="" ||
        !isset($_POST["begin"]) || trim($_POST['begin']) ==="" ||
        !isset($_POST["end"]) || trim($_POST['end']) ==="" ||
        !isset($_POST["apply"]) || trim($_POST['apply']) ==="" ||
        !isset($_POST["got"]) || trim($_POST['got']) ==="" ||
        !isset($_POST["goal"]) || trim($_POST['goal']) ===""){
        $error[] = "Ki kell tölteni a mezőket";
        $_SESSION["reg_paly_err"] = $error;
        header("location: palyazat_modosit.php");
    }else{
        $eredet = htmlspecialchars($_POST["eredet"]);

        $kode = htmlspecialchars($_POST["kode"]);
        $topic = htmlspecialchars($_POST["topic"]);
        $title = htmlspecialchars($_POST["title"]);
        $begin = htmlspecialchars($_POST["begin"]);
        $end = htmlspecialchars($_POST["end"]);
        $apply = htmlspecialchars($_POST["apply"]);
        $got = htmlspecialchars($_POST["got"]);
        $goal = htmlspecialchars($_POST["goal"]);

        if(strlen($kode) > 8){
            $error[] = "túl hosszú kód";
        }
        if(strlen($goal) > 200){
            $error[] = "túl hosszú cél";
        }
        if(strlen($title) > 20){
            $error[] = "túl hosszú cím";
        }
        if(strlen($got) > 10){
            $error[] = "túl nagy elnyert összeg";
        }
        if(strlen($apply) > 10){
            $error[] = "túl nagy pályázott összeg";
        }
        if(strlen($topic) > 2){
            $error[] = "túl nagy témaszám";
        }
        if(!filter_var($apply,FILTER_SANITIZE_NUMBER_INT)){
            $error[] = "a plyázot összeg csak egászszámot tartalmazhat";
        }
        if(!filter_var($got,FILTER_SANITIZE_NUMBER_INT)){
            $error[] = "az elnyert összeg csak egászszámot tartalmazhat";
        }
        if(!filter_var($topic,FILTER_SANITIZE_NUMBER_INT)){
            $error[] = "a témaszám csak egászszámot tartalmazhat";
        }
        if($kode !== $eredet && id_paly($kode)){
            $error[] = "Ilyen pályázat id már van";
        }
        if($begin > $end){
            $error[] = "a kezdődátum meg előzi a hátáidőt";
        }
        if(count($error) === 0){
            $add = up_paly($eredet,$kode,$topic,$title,$begin,$end,$apply,$got,$goal);
            if(!$add){
                $_SESSION["reg_paly_err"] = $error;
                header("location: palyazat_modosit.php");
                die("Nem sikerült a modositás!");
            }else{
                $_SESSION["sik_paly"] = "Sikerült a pályázatott modosítani";
                header("location: palyazat_modosit.php");
            }
        }
        $_SESSION["reg_paly_err"] = $error;
        header("location: palyazat_modosit.php");
    }
}