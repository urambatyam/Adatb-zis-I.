<?php
include_once("functions.php");
session_start();
if(isset($_POST["out"])){

    if(!($conn = conn())){
        return false;
    }
    $name = $_SESSION["user"]["nev"];
    $q2 = sprintf("UPDATE felhasznalo SET bevanejelentkezve=FALSE WHERE felhasznalo.nev = '%s'",mysqli_real_escape_string($conn,$name));
    $res = mysqli_query($conn, $q2);
    if($res){
        echo "sikerult";
    }else{
        return false;
    }
    mysqli_close($conn);

    session_unset();
    session_destroy();
    header("Location: index.php");
}

if(isset($_POST["mod"])){
    header("Location: felhasznalot_modosit.php");
}
if(isset($_POST["dlete"])){
    echo "dele";
}
if(isset($_POST["modify"])){
    if(!($conn = conn())){
        return false;
    }
    if($_SESSION["user"]["szerepkor"] === "admin"){
        $szep = htmlspecialchars($_POST["rang"]);
    }else{
        $szep = $_SESSION["user"]["szerepkor"];
    }
    $nev = htmlspecialchars($_POST["nev"]);
    $email = htmlspecialchars($_POST["email"]);
    if(id_fel($nev)){
        $_SESSION["mod_fel_err"] = "nem sikerült a modosítás mert már létezik ilyen felhasználónév";
        header("Location: felhasznalot_modosit.php");
    }
    $stmt = mysqli_prepare($conn,"UPDATE felhasznalo SET nev=? ,email=? ,szerepkor=? WHERE nev=?");
    mysqli_stmt_bind_param($stmt,"ssss",$nev,$email,$szep,$nev);
    $s = mysqli_stmt_execute($stmt);
    if(!$s){
        $_SESSION["mod_fel_err"] = "nem sikerült a modosítás";
        header("Location: felhasznalot_modosit.php");
        die("nem sikerült a modosítás");
    }else{
        mysqli_close($conn);
        if($_SESSION["user"]["nev"] === $_POST["en"]){
            $o =id_fel($nev);
            $t = mysqli_fetch_assoc($o);
            $_SESSION["user"] = $t;
            mysqli_free_result($o);
        }
        if($_SESSION["user"]["szerepkor"] === "admin"){
            header("Location: felhasznalo_kezeles.php");
        }else{
            header("Location: profil.php");
        }
    }

    mysqli_close($conn);
    return $s;

}
