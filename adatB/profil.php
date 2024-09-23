<?php
session_start();
include_once("functions.php");
if (!isset($_SESSION["user"]) || !($_SESSION["user"]["szerepkor"] === "témafelelös")) {
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
    <legend>Profil</legend>
    <form method="post" accept-charset="UTF-8" action="profil_kezeles.php">
        <label>E-mail cím:</label><?php echo "<p>".$_SESSION["user"]["email"]."</p><br>"?>
        <label>Név:</label><?php echo "<p>".$_SESSION["user"]["nev"]."</p><br>"?>
        <label>Szerepkör:</label><?php echo "<p>".$_SESSION["user"]["szerepkor"]."</p><br>"?>
        <label>Útolsó belépés:</label><?php echo "<p>".$_SESSION["user"]["utolsobelepesidopontja"]."</p><br>"?>
        <input type="submit" value="Szerkesztés" name="mod"><input type="submit" value="Fiók törlése" name="delet"><input type="submit" value="Kijelentkezés" name="out">
    </form>
</fieldset>
<h2>Pályazataim</h2>
<table border="1">
    <tr>
        <th>kód</th>
        <th>témaszám</th>
        <th>cím</th>
        <th>pályázat kezdete</th>
        <th>pélyázat vége</th>
        <th>pályázott összeg</th>
        <th>elnyert összeg</th>
        <th>pályázat célja</th>
    </tr>
    <?php
    if($pa = my_paly_lekeres($_SESSION["user"]["nev"])){
        while($row = mysqli_fetch_assoc($pa)){
                echo "<tr>";
                echo "<td>".$row["kodja"]."</td>";
                echo "<td>".$row["temaszam"]."</td>";
                echo "<td>".$row["cime"]."</td>";
                echo "<td>".$row["kezdete"]."</td>";
                echo "<td>".$row["vege"]."</td>";
                echo "<td>".$row["palyazott"]."</td>";
                echo "<td>".$row["elnyert"]."</td>";
                echo "<td>".$row["cel"]."</td>";
                echo "</tr>";
        }
        mysqli_free_result($pa);
    }else{
        echo "<tr><td  colspan='8'  style='text-align: center'><p>nincsenek pályázataid!</p></td></tr>";
    }
    ?>
</table >
<h2>Pályázataim Mérföldkövei</h2>
<table border="1">
    <tr>
        <th>pályázat kód</th>
        <th>azonosító</th>
        <th>megnevezés</th>
        <th>időpont</th>
        <th>leírás</th>
        <th>tejesülése</th>
    </tr>
    <?php
    if($pa = my_paly_mer_lekeres($_SESSION["user"]["nev"])){
        while($row = mysqli_fetch_assoc($pa)){
            echo "<tr>";
            echo "<td>".$row["palyazat"]."</td>";
            echo "<td>".$row["merfoldko"]."</td>";
            echo "<td>".$row["megnevezes"]."</td>";
            echo "<td>".$row["idopont"]."</td>";
            echo "<td>".$row["leiras"]."</td>";
            echo "<td>".$row["teljesul"]."%</td>";
            echo "</tr>";
        }
        mysqli_free_result($pa);
    }else{
        echo "<tr><td  colspan='6'  style='text-align: center'><p>nincsenek mérföldkövei a pályázataidnak!</p></td></tr>";
    }
    ?>
</table>
<h2>Pályazatim Mérföldköveinek allátámasztó dokumetumai</h2>
<table border="1">
    <tr>
        <th>Mérföldkő azonosító</th>
        <th>sorszám</th>
        <th>Fáljnév</th>
        <th>Be küldő neve</th>
        <th>beadási határidő</th>
        <th>ellenörzési határidő</th>
        <th>tejesülés</th>
        <th>kifizetett összeg</th>
        <th>beszámoló</th>
        <th>Modosít</th>
        <th>Töröl</th>
    </tr>
    <?php
    if($pa = my_paly_mer_all_lekeres($_SESSION["user"]["nev"])){
        while($row = mysqli_fetch_assoc($pa)){
            echo "<form action='all_dok_mod.php' method='post'>";
            echo "<tr>";
            echo "<td>".$row["merfoldko"]."</td>";
            echo "<td>".$row["sorszam"]."</td>";
            echo "<td>".$row["dokumentum"]."</td>";
            echo "<td>".$row["rneve"]."</td>";
            echo "<td>".$row["hatarido"]."</td>";
            echo "<td>".$row["ellhatarido"]."</td>";
            echo "<td>".$row["teljesult"]."</td>";
            echo "<td>".$row["kifizetett"]."</td>";
            echo "<td>".$row["beszamolo"]."</td>";
            echo "<td><input type='submit' value='Modosít' name='modosit' ></td>";
            echo "<td><input type='submit' value='Töröl' name='torol' ></td>";
            echo "</tr>";
            echo "</form>";
        }
        mysqli_free_result($pa);
    }else{
        echo "<tr><td  colspan='11'  style='text-align: center'><p>nincsenek allátámasztó dokumentumaid!</p></td></tr>";
    }
    ?>
</table>
<a href="ala_dok_add.php">Allátámasztó dokumentum hozzáadása</a>
</body>
</html>