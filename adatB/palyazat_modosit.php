<?php
session_start();
include_once("functions.php");
if (!isset($_SESSION["user"]) || !($_SESSION["user"]["szerepkor"] === "admin")) {
    header("location: index.php");

}
if(isset($_POST["modosit"])){
    $_SESSION["pak_kod"] = $_POST["pak"];
    $opciok = id_paly($_SESSION["pak_kod"]);
    $v = mysqli_fetch_assoc($opciok);
}elseif (isset($_SESSION["pak_kod"])){
    $opciok = id_paly($_SESSION["pak_kod"]);
    $v = mysqli_fetch_assoc($opciok);
}
?>
<!DOCTYPE HTML>
<html lang="hu">
<head>
    <title>palyazat modositas</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" type="text/css" href="base.css">
</head>
<body>
<fieldset>
    <legend>Pályázat modósítása</legend>
    <form method="post" accept-charset="UTF-8" action="up_pa.php">
        <label for="kode">kód</label><input type="text" name="kode" value="<?php  echo $v['kodja']; ?>"><br>
        <label for="topic">témaszám</label><input type="text" name="topic" value="<?php  echo $v['temaszam']; ?>"><br>
        <label for="title">cím</label><input type="text" name="title" value="<?php  echo $v['cime']; ?>"><br>
        <label for="begin">pályázat kezdete</label><input type="date" name="begin" value="<?php  echo $v['kezdete']; ?>"><br>
        <label for="end">pályázat vége</label><input type="date" name="end" value="<?php  echo $v['vege']; ?>"><br>
        <label for="apply">pályázott összeg</label><input type="text" name="apply" value="<?php  echo $v['palyazott']; ?>"><br>
        <label for="got">elnyert összeg</label><input type="text" name="got" value="<?php  echo $v['elnyert']; ?>"><br>
        <label for="goal">pályázat célja</label><input type="text" name="goal" value="<?php  echo $v['cel']; ?>"><br>
        <input type="submit" value="Modósít" name="up_pa">
        <input type="hidden" name="eredet" value="<?php  echo $v['kodja']; ?>">
        <a href="palyazatok_kezelese.php">Vissza</a>
    </form>
</fieldset>
<?php
if(isset($_SESSION["reg_paly_err"])){
    foreach ($_SESSION["reg_paly_err"] as $e){
        echo "<p style='color: red'>".$e."</p>";
    }
    $_SESSION["reg_paly_err"] = [];
}
if(isset($_SESSION["sik_paly"]) && $_SESSION["sik_paly"] !== ""){
    echo "<h3 style='color: green'>".$_SESSION["sik_paly"]."</h3>";
    $_SESSION["sik_paly"] = "";
}
?>
</body>
</html>
