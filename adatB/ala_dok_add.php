<?php
include_once("functions.php");
session_start();
if(!isset($_SESSION["user"]) || !($_SESSION["user"]["szerepkor"] === "témafelelös")){
    header("location: index.php");
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
    <legend>Allátámasztó dokumentum hozzáadása</legend>
    <form method="post" accept-charset="UTF-8" action="ala_dok_insert.php">
        <?php
        if($opciok = op_all()) {
            echo "<label>Mérföldkő azonosítója</label>";
            echo "<select name='mkode'>";
            while ($row = mysqli_fetch_assoc($opciok)) {
                echo "<option value='" . $row["merfoldko"] . "'>" . $row["merfoldko"] . "</option>";
            }
            echo "</select><br>";

            echo '
        <label>Mérföldkő sroszáma</label><input type="text" name="mdik"><br>
        <label>határidő</label><input type="date" name="Dday"><br>
        <label>Elenörzési határidő</label><input type="date" name="e_Dday"><br>
        <label>Fáljnév</label><input type="text" name="fname"><br>
        <label>Beadó személy</label><input type="text" name="participant"><br>
        <label>kifizetett összeg</label><input type="number" name="money"><br>
        <label>Beszámoló</label><br><textarea name="betext" rows="30" cols="50"></textarea><br>
        <input type="submit" value="Hozzáadd" name="add_dok">';
        }else{
            echo "<p>Nincs Olyan mérföldkő amihez hozzárendelhetnéd az alátámasztó dokumentumot</p>";
        }
        ?>
        <a href="profil.php">Vissza</a>
    </form>
</fieldset>
<?php
if(isset($_SESSION["reg_dok_err"])){
    foreach ($_SESSION["reg_dok_err"] as $e){
        echo "<p style='color: red'>".$e."</p>";
    }
    $_SESSION["reg_dok_err"] = [];
}
if(isset($_SESSION["sik_dok"]) && $_SESSION["sik_dok"] !== ""){
    echo "<h3 style='color: green'>".$_SESSION["sik_dok"]."</h3>";
    $_SESSION["sik_dok"] = "";
}
?>
</body>
</html>




