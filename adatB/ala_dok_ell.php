<?php
session_start();
include_once('functions.php');

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
<?php menu();?>
<h2>Allátámasztó dokumentumok</h2>
<table border="1">
    <tr>
        <th>Mérföldkő Azanosító</th>
        <th>Mérföldkő sorszáma</th>
        <th>határidő</th>
        <th>Ellenörzési határidő</th>
        <th>fáljnév</th>
        <th>Beküldő neve</th>
        <th>tejesülés</th>
        <th>kifizettet összeg</th>
        <th>beszámoló</th>
        <th>modosít</th>
        <th>töröl</th>
    </tr>
    <?php
    if($all_dok = all_dok_lekeres()){
        while($row = mysqli_fetch_assoc($all_dok)){
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
            echo "<input type='hidden' name='h' value='".$row["merfoldko"]."'>";
            echo "</form>";
        }
        mysqli_free_result($all_dok);
    }else{
        echo "<tr><td  colspan='10'  style='text-align: center'><p>nincsenek allátámasztódokumentumok!</p></td></tr>";
    }
    ?>
</table>
<h2>Nem elkészitett beszámolok</h2>
<table border="1">
    <tr>
        <th>Mérföldkő Azanosító</th>
        <th>Mérföldkő sorszáma</th>
        <th>határidő</th>
        <th>Elenörzési határidő</th>
        <th>fáljnév</th>
        <th>Beküldő neve</th>
        <th>tejesülés</th>
        <th>kifizettet összeg</th>
        <th>beszámoló</th>
    </tr>
    <?php
    if($all_dok = all_dok_null()){
        while($row = mysqli_fetch_assoc($all_dok)){
            echo "<tr>";
            echo "<td>".$row["merfoldko"]."</td>";
            echo "<td>".$row["sorszam"]."</td>";
            echo "<td>".$row["hatarido"]."</td>";
            echo "<td>".$row["ellhatarido"]."</td>";
            echo "<td>".$row["dokumentum"]."</td>";
            echo "<td>".$row["rneve"]."</td>";
            echo "<td>".$row["teljesult"]."</td>";
            echo "<td>".$row["kifizetett"]."</td>";
            echo "<td>".$row["beszamolo"]."</td>";
            echo "</tr>";
        }
        mysqli_free_result($all_dok);
    }else{
        echo "<tr><td  colspan='7'  style='text-align: center'><p>nincsenek allátámasztódokumentumok amik nem nem vannak kitöltve!</p></td></tr>";
    }
    ?>
</table>
</body>
</html>


