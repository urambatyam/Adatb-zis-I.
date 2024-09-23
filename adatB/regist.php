<?php
include_once("functions.php");
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" type="text/css" href="base.css">
</head>
<body>
<fieldset>
    <?php if(isset($_POST["gomb"])){
        echo "<legend>Új felhasználó regiszrálása</legend>";
    }else{
        echo "<legend>Regisztráció</legend>";
    }?>

    <form method="post" accept-charset="UTF-8" action="felhasznalo_regiszralas.php">
        <label>E-mail cím:</label><input type="text" name="email"><br>
        <label>Felhasználó név:</label><input type="text" name="nev"><br>
        <label>Jelszó:</label><input type="text" name="jelszo"><br>
        <label>Jelszó megint:</label><input type="text" name="jelszo_megint"><br>
        <input type="submit" value="Regisztráció" name="reg">
        <input type="hidden" name="gomb" value="gomb">
    </form>
    <?php if(isset($_POST["gomb"])){
        echo '<a href="felhasznalo_kezeles.php">Vissza</a>';
    }else{
        echo '<a href="index.php">Vissza</a>';
    }?>
</fieldset>
<?php
if(isset($_SESSION["reg_err"]))
foreach ($_SESSION["reg_err"] as $e){
    echo "<p style='color: red'>".$e."</p>";
}
$_SESSION["reg_err"] = [];
?>
</body>
</html>