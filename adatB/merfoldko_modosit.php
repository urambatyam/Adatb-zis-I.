<?php
session_start();
include_once("functions.php");
if (!isset($_SESSION["user"]) || !($_SESSION["user"]["szerepkor"] === "admin")) {
    header("location: index.php");
}
if(isset($_POST["modosit"])){
    $_SESSION["m_kod"] = $_POST["mkod"];
    $opciok = id_mer($_SESSION["m_kod"]);
    $v = mysqli_fetch_assoc($opciok);
}elseif (isset($_SESSION["m_kod"])){
    $opciok = id_mer($_SESSION["m_kod"]);
    $v = mysqli_fetch_assoc($opciok);
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
    <legend>Merföldkő modósítása</legend>
    <form method="post" accept-charset="UTF-8" action="up_mer.php">
        <?php
        echo "<label>A pályázat kódja</label>";
        echo "<select name='palykod'>";
        echo "<option value='".$v["palyazat"]."'>".$v["palyazat"]."</option>";
        $opciok = op_mer();
        while ($row = mysqli_fetch_assoc($opciok)){
            if($row["kodja"] !== $v["palyazat"]){
                echo "<option value='".$row["kodja"]."'>".$row["kodja"]."</option>";
            }
        }
        echo "</select><br>";
        mysqli_free_result($opciok);
        ?>
        <label>Azonosító</label><input type="text" name="id" value="<?php  echo $v['merfoldko'];?>" ><br>
        <label>megnevezés</label><input type="text" name="name" value="<?php  echo $v['megnevezes'];?>" ><br>
        <label>időpont</label><input type="date" name="time" value="<?php  echo $v['idopont']; ?>"><br>
        <label>leírás</label><input type="text" name="description" value="<?php  echo $v['leiras']; ?>"><br>
        <label>tejesülés</label><input type="number" name="completed" value="<?php  echo $v['teljesul']; ?>"><br>
        <input type="submit" value="Modósít" name="Modósít">
        <input type="hidden" name="eredet" value="<?php  echo $v['merfoldko'];?>">
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
