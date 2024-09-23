<?php
session_start();
include_once("functions.php");
if (!isset($_SESSION["user"]) || !($_SESSION["user"]["szerepkor"] === "admin")) {
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
    <legend>Mérföldkő hozzáadása</legend>
    <form method="post" accept-charset="UTF-8" action="merfoldko_add_insert.php">
        <?php
        if($opciok = op_mer()){
            echo "<label>A pályázat kódja</label>";
            echo "<select name='palykod'>";
            while ($row = mysqli_fetch_assoc($opciok)){
                echo "<option value='".$row["kodja"]."'>".$row["kodja"]."</option>";
            }
            echo "</select><br>";
            echo '<label>Azonosító</label><input type="text" name="id"><br>';
            echo '<label>megnevezés</label><input type="text" name="name"><br>';
            echo '<label>időpont</label><input type="date" name="time"><br>';
            echo '<label>leírás</label><input type="text" name="description"><br>';
            echo ' <input type="submit" value="Hozzáadd" name="add">';
            mysqli_free_result($opciok);
        }else{
            echo "<p>Nincs Olyan pályázat amihez hozzárendelhetnéd a mérföldkövet</p>";
        }
        ?>
        <a href="merfoldko_kezeles.php">Vissza</a>
    </form>
</fieldset>
<?php
if(isset($_SESSION["reg_mer_err"])){
    foreach ($_SESSION["reg_mer_err"] as $e){
        echo "<p style='color: red'>".$e."</p>";
    }
    $_SESSION["reg_mer_err"] = [];
}
if(isset($_SESSION["sik_mer"]) && $_SESSION["sik_mer"] !== ""){
    echo "<h3 style='color: green'>".$_SESSION["sik_mer"]."</h3>";
    $_SESSION["sik_mer"] = "";
}
?>
</body>
</html>
