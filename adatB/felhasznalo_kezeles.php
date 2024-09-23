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
<h2>Saját adataim</h2>
<fieldset>
    <legend>Profil</legend>
    <form method="post" accept-charset="UTF-8" action="profil_kezeles.php">
        <label>E-mail cím: </label><?php echo "<p>".$_SESSION["user"]["email"]."</p><br>"?>
        <label>Név: </label><?php echo "<p>".$_SESSION["user"]["nev"]."</p><br>"?>
        <label>Szerepkör: </label><?php echo "<p>".$_SESSION["user"]["szerepkor"]."</p><br>"?>
        <label>Útolsó belépés: </label><?php echo "<p>".$_SESSION["user"]["utolsobelepesidopontja"]."</p><br>"?>
        <input type="submit" value="Szerkesztés" name="mod"><input type="submit" value="Fiók törlése" name="delete"><input type="submit" value="kijelntkezés" name="out">
    </form>
</fieldset>
<h2>Felhasználok</h2>
<table border="1">
    <tr>
        <th>Email</th>
        <th>név</th>
        <th>be van-e jelentkezve</th>
        <th>szerepkör</th>
        <th>utlsó belépés időpontja</th>
        <th>Hány darab pályázatok van</th>
        <th>modosít</th>
        <th>töröl</th>
    </tr>
    <?php
        $users = felhasznalo_lekeres();
        while($row = mysqli_fetch_assoc($users)){
            echo '<form action="felhasznalot_modosit.php" method="post" accept-charset="UTF-8">';
            echo "<tr>";
            echo "<td>".$row["email"]."</td>";
            echo "<td>".$row["nev"]."</td>";
            echo "<td>".$row["bevanejelentkezve"]."</td>";
            echo "<td>".$row["szerepkor"]."</td>";
            echo "<td>".$row["utolsobelepesidopontja"]."</td>";
            echo "<td>".$row["db"]."db</td>";
            echo "<td><input type='submit' value='modosít' name='modosit'></td>";
            echo "<td><input type='submit' value='töröl' name='torol'></td>";
            echo "</tr>";
            echo "<input type='hidden' name='user' value='".$row["nev"]."'>";
            echo "</form>";
        }
    mysqli_free_result($users);

    ?>
</table>
<form action="regist.php" method="post"><input type="submit" value="Új felhasználó regisztrálása" name="gomb"></form>
</body>
</html>


