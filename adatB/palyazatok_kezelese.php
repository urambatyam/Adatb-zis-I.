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
<?php menu();?>

<h2>Palyazatok</h2>
<table border="1">
    <tr>
        <th>kód</th>
        <th>témaszám</th>
        <th>cím</th>
        <th>pályázat kezdete</th>
        <th>pályázat vége</th>
        <th>pályázott összeg</th>
        <th>elnyert összeg</th>
        <th>pályázat célja</th>
        <th>Témafelelöse</th>
        <th>Modosít</th>
        <th>Töröl</th>
    </tr>
    <?php
        $pa = palyazatok_lekeres();
        while($row = mysqli_fetch_assoc($pa)){
            echo '<form action="palyazat_modosit.php" method="POST" >';
            echo "<tr>";
            echo "<td>".$row["kodja"]."</td>";
            echo "<td>".$row["temaszam"]."</td>";
            echo "<td>".$row["cime"]."</td>";
            echo "<td>".$row["kezdete"]."</td>";
            echo "<td>".$row["vege"]."</td>";
            echo "<td>".$row["palyazott"]."</td>";
            echo "<td>".$row["elnyert"]."</td>";
            echo "<td>".$row["cel"]."</td>";
            echo "<td>".$row["nev"]."</td>";
            echo "<td><input type='submit' value='modosít' name='modosit'></td>";
            echo "<td><input type='submit' value='töröl' name='torol'></td>";
            echo "</tr>";
            echo '<input type="hidden"  name="pak" value="'.$row["kodja"].'">';
            echo "</form>";
        }
    mysqli_free_result($pa);
   ?>
</table>
<a href="palyazat_add.php">Pályázaz hozzáadása</a>
</body>
</html>


