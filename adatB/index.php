<?php
    session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" type="text/css" href="base.css">
</head>
<body>
<fieldset>
    <legend>Belépés</legend>
    <form method="post" accept-charset="UTF-8" action="login.php">
        <label>Felhasználó név</label><input type="text" name="name"><br>
        <label>Jelszó:</label><input type="text" name="password"><br>
        <input type="submit" value="Belépés" name="buttom">
        <a href="regist.php">Regisztráció</a>
    </form>
</fieldset>
<?php
if(isset($_SESSION["log_err"]))
    foreach ($_SESSION["log_err"] as $e){
        echo "<p style='color: red'>".$e."</p>";
    }
$_SESSION["log_err"] = [];
?>
</body>
</html>



