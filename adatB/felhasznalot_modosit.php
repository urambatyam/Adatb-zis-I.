<?php
session_start();
include_once("functions.php");
if (!isset($_SESSION["user"]) ) {
    header("location: index.php");
}
if(isset($_POST["modosit"])){
    $mysqlobject = id_fel($_POST["user"]);
    $user = mysqli_fetch_assoc($mysqlobject);
}else{
    $user = $_SESSION["user"];
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" type="text/css" href="base.css">
</head>
<body>
<fieldset>
    <legend>Felhasználó modósítása</legend>
    <form method="post" accept-charset="UTF-8" action="profil_kezeles.php">
        <label>E-mail cím</label><input type="text" name="email" value="<?php echo $user["email"];?>"><br>
        <label>név</label><input type="text" name="nev" value="<?php echo $user["nev"];?>"><br>
        <?php
            if($_SESSION["user"]["szerepkor"] === "admin"){
                if($user["szerepkor"] == "admin"){
                    echo '<label>szerepkör</label><select name="rang"><option value="admin">admin</option><option value="témafelelös">témafelelös</option></select><br>';
                }else{
                    echo '<label>szerepkör</label><select name="rang"><option value="témafelelös">témafelelös</option><option value="admin">admin</option></select><br>';
                }

            }

        ?>
        <input type="hidden" value="<?php echo $user["nev"];?>" name="en">


        <a href="<?php if($_SESSION["user"]["szerepkor"] === "admin"){echo "felhasznalo_kezeles.php";}else{echo "profil.php";}?>">Vissza</a>
        <input type="submit" value="Modósít" name="modify">
    </form>
</fieldset>
<?php

if(isset($_SESSION["mod_fel_err"]) && $_SESSION["mod_fel_err"] !== ""){
    echo "<p style='color: red'>".$_SESSION["mod_fel_err"]."</p>";
    $_SESSION["mod_fel_err"] = "";
}

?>
</body>
</html>
