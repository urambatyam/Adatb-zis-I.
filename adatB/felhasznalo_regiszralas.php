<?php
include_once('functions.php');
session_start();
if(isset($_POST["reg"])){
    $error = [];
    if( isset($_POST['email']) && isset($_POST['nev']) && isset($_POST['jelszo']) && isset($_POST['jelszo_megint']) &&
        trim($_POST['email']) !=="" && trim($_POST['nev']) !=="" && trim($_POST['jelszo']) !=="" && trim($_POST['jelszo_megint']) !==""){
        $email_tiszta = htmlspecialchars($_POST['email']);
        $nev_tiszta = htmlspecialchars($_POST['nev']);
        $jelszo_tiszta = htmlspecialchars($_POST['jelszo']);
        $jelszo_megint_tiszta = htmlspecialchars($_POST['jelszo_megint']);
        if(!filter_var($email_tiszta,FILTER_SANITIZE_EMAIL)){
            $error[] = "Nem email cím";
        }
        if(strlen($email_tiszta) > 20){
            $error[] = "email cím túl hoszzú";
        }
        if(strlen($nev_tiszta) > 30){
            $error[] = "név túl hoszzú";
        }
        if(id_fel($nev_tiszta)){
            $error[] = "Ilyen felhasználóbév már van";
        }
        if(strlen($jelszo_tiszta) > 8){
            $error[] = "jelszó cím túl hoszzú";
        }
        if($jelszo_tiszta !== $jelszo_megint_tiszta){
            $error[] = "jelszavak nem egyeznek";
        }
        if(count($error) === 0){
            $j = password_hash($jelszo_tiszta, PASSWORD_DEFAULT);
            $regisztral = regiszt($email_tiszta, $nev_tiszta, $j);
            if(!$regisztral){
                $_SESSION["reg_err"] = $error;
                header("location: regist.php");
                die("Nem sikerült a regisztráció!");
            }else{
                if(isset($_POST["gomb"])){
                    header("location: felhasznalo_kezeles.php");
                }else{
                    $_SESSION["user"] = login($nev_tiszta,$jelszo_tiszta);
                    header("location: profil.php");
                }
            }
        }
    }else{
        $error[] = "Nem töltöted ki a mezöket!";
        $_SESSION["reg_err"] = $error;
        header("location: regist.php");
    }

}

