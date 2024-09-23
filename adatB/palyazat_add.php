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
    <legend>Pályázat hozzáadása</legend>
    <form method="post" accept-charset="UTF-8" action="palyazat_add_insert.php">
        <label>A témafeleköse</label>
        <?php
        if($opciok = op_paly()){
            echo "<select name='nev'>";
            while ($row = mysqli_fetch_assoc($opciok)){

                echo "<option value='".$row["nev"]."'>".$row["nev"]."</option>";
            }
            echo "</select><br>";
            echo '
                    <label>kód</label><input type="text" name="kode"><br>
                    <label>témaszám</label><input type="text" name="topic"><br>
                    <label>cím</label><input type="text" name="title"><br>
                    <label>pályázat kezdete</label><input type="date" name="begin"><br>
                    <label>pályázat vége</label><input type="date" name="end"><br>
                    <label>pályázott összeg</label><input type="text" name="apply"><br>
                    <label>elnyert összeg</label><input type="text" name="got"><br>
                    <label>pályázat célja</label><input type="text" name="goal"><br>
                    <input type="submit" value="Hozzáadd" name="palyazat_add">
                    <a href="palyazatok_kezelese.php">Vissza</a>';
        }else{
            echo "<p>Nincs Olyan felhasználó aki felelőslehetne a pályázatnak, így nem lehet felveni</p>";
        }
        mysqli_free_result($opciok);



        ?>
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