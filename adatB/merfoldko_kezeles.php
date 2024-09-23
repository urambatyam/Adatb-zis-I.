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
<h2>Merföldkövek</h2>
<table border="1">
    <tr>
        <th>Azanosító</th>
        <th>megnevezés</th>
        <th>időpont</th>
        <th>leírás</th>
        <th>tejesülés</th>
        <th>pályázat kódja</th>
        <th>hozzátartozó allátámasztó dokumentumok száma</th>
        <th>ebből feltöltve</th>
        <th>Az értük kifizetett összegek összege</th>
        <th>modosít</th>
        <th>töröl</th>
    </tr>
    <?php
        if($m = merfoldko_lekeres()){
            while($row = mysqli_fetch_assoc($m)){
                echo "<form action='merfoldko_modosit.php' method='POST' >";
                echo "<tr>";
                echo "<td>".$row["merfoldko"]."</td>";
                echo "<td>".$row["megnevezes"]."</td>";
                echo "<td>".$row["idopont"]."</td>";
                echo "<td>".$row["leiras"]."</td>";
                echo "<td>".$row["teljesul"]."</td>";
                echo "<td>".$row["palyazat"]."</td>";
                echo "<td>".$row["dokumentumok_szama"]."</td>";
                echo "<td>".$row["nem_ures_dokumentumok_szama"]."</td>";
                echo "<td>".$row["kifizettet_osszeg"]."</td>";
                echo "<td><input type='submit' value='modosít' name='modosit'></td>";
                echo "<td><input type='submit' value='törl' name='torol'></td>";
                echo "</tr>";
                echo "<input type='hidden' name='mkod' value='".$row["merfoldko"]."'>";
                echo "</form>";
            }
            mysqli_free_result($m);
        }else{
            echo "<tr><td  colspan='10'  style='text-align: center'><p>nincsenek mérfoldkővek!</p></td></tr>";
        }
    ?>
</table>
<a href="merfoldko_add.php">Mérföldkő hozzáadása</a>
</body>
</html>


