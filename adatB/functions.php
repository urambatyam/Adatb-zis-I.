<?php
function menu(){
    echo "<a  class='menu' href='felhasznalo_kezeles.php'>Felhasználok kezelése</a>";
    echo "<a class='menu' href='palyazatok_kezelese.php'>Pályazatok kezelése</a>";
    echo "<a class='menu'href='merfoldko_kezeles.php'>Mérföldkövek kezelése</a>";
    echo "<a class='menu' href='ala_dok_ell.php'>Allátámasztó dokumentumok kezelése</a>";
}
function conn(){
    $conn = mysqli_connect("localhost","root","") or die("Nem csatlakozott az adatbázishoz");
    if(!mysqli_select_db($conn, "palyazat")){
        return null;
    }
    mysqli_query($conn, 'SET NAMES UTF-8');
    mysqli_query($conn, 'SET character_set_results=utf-8');
    mysqli_set_charset($conn, 'utf-8');
    return $conn;

}

function login($name,$password){
    if(!($conn = conn())){
        return false;
    }
    $q = sprintf("SELECT * FROM felhasznalo WHERE felhasznalo.nev = '%s'",mysqli_real_escape_string($conn,$name));
    $result = mysqli_query($conn,$q);

    if (mysqli_num_rows($result) == 1) {
        $arra = mysqli_fetch_assoc($result);
        if (password_verify($password, $arra["jelszo"])) {
            $q2 = sprintf("UPDATE felhasznalo SET bevanejelentkezve=TRUE, utolsobelepesidopontja=CURRENT_TIMESTAMP WHERE felhasznalo.nev = '%s'",mysqli_real_escape_string($conn,$name));
            mysqli_query($conn, $q2);
            $result2 = mysqli_query($conn,$q);
            $arra2 = mysqli_fetch_assoc($result2);
            mysqli_close($conn);
            return $arra2;
        }
    }

    mysqli_close($conn);
    return false;
}
function regiszt($email, $nev, $jelszo){
    if(!($conn = conn())){
        return false;
    }

    $elo = mysqli_prepare($conn, "INSERT INTO felhasznalo(email, nev, jelszo) VALUES(?, ?, ?)");
    mysqli_stmt_bind_param($elo, 'sss', $email, $nev, $jelszo);
    $res = mysqli_stmt_execute($elo);
    if(!$res){
        die(mysqli_error($conn));
    }
    mysqli_close($conn);
    return true;
}
function id_paly($kode){
    if(!($conn = conn())){
        return false;
    }
    $q = sprintf("SELECT * FROM palyazatok WHERE palyazatok.kodja = '%s'",mysqli_real_escape_string($conn,$kode));
    $result = mysqli_query($conn,$q);

    if (mysqli_num_rows($result) == 1) {
        mysqli_close($conn);
        return $result;
    }
    mysqli_close($conn);
    return false;
}
function id_fel($nev){
    if(!($conn = conn())){
        return false;
    }
    $q = sprintf("SELECT * FROM felhasznalo WHERE felhasznalo.nev = '%s'",mysqli_real_escape_string($conn,$nev));
    $result = mysqli_query($conn,$q);

    if (mysqli_num_rows($result) == 1) {
        mysqli_close($conn);
        return $result;
    }
    mysqli_close($conn);
    return false;
}
function id_mer($id){
    if(!($conn = conn())){
        return false;
    }
    $q = sprintf("SELECT * FROM merfoldko WHERE merfoldko.merfoldko = '%s'",mysqli_real_escape_string($conn,$id));
    $result = mysqli_query($conn,$q);

    if (mysqli_num_rows($result) == 1) {
        mysqli_close($conn);
        return $result;
    }
    mysqli_close($conn);
    return false;
}
function add_paly($nev,$kode,$topic,$title,$begin,$end,$apply,$got,$goal){
    if(!($conn = conn())){
        return false;
    }
    $elo = mysqli_prepare($conn, "INSERT INTO palyazatok(nev, kodja,temaszam, cime, kezdete, vege, palyazott, elnyert, cel) VALUES(?, ?, ?,?, ?, ?,?, ?, ?)");
    mysqli_stmt_bind_param($elo, 'ssdsssdds', $nev,$kode, $topic, $title, $begin, $end, $apply, $got, $goal);
    $res = mysqli_stmt_execute($elo);
    if(!$res){
        die(mysqli_error($conn));
    }
    mysqli_close($conn);
    return true;
}

function add_mer($id,$leiras,$title,$ido,$kod){
    if(!($conn = conn())){
        return false;
    }
    $elo = mysqli_prepare($conn, "INSERT INTO merfoldko(merfoldko,leiras,megnevezes,idopont,palyazat) VALUES(?, ?, ?,?, ?)");
    mysqli_stmt_bind_param($elo, 'sssss', $id,$leiras,$title,$ido,$kod);
    $res = mysqli_stmt_execute($elo);
    if(!$res){
        die(mysqli_error($conn));
    }
    mysqli_close($conn);
    return true;
}
function add_all_dok($mkode,$mdik,$dday,$e_dday,$fname,$participant,$money,$betext){
    if(!($conn = conn())){
        return false;
    }
    $elo = mysqli_prepare($conn, "INSERT INTO dokumentum(merfoldko,sorszam ,hatarido,ellhatarido,dokumentum , rneve, kifizetett, beszamolo) VALUES(?, ?, ?,?, ?,?,?,?)");
    mysqli_stmt_bind_param($elo, 'ssssssds', $mkode,$mdik,$dday,$e_dday,$fname,$participant,$money,$betext);
    $res = mysqli_stmt_execute($elo);
    if(!$res){
        die(mysqli_error($conn));
    }
    mysqli_close($conn);
    return true;
}

function op_paly(){
    if(!($conn = conn())){
        return false;
    }
    $q = mysqli_query($conn,"SELECT nev FROM felhasznalo");
    if(mysqli_num_rows($q) > 0){
        mysqli_close($conn);
        return $q;
    }
    mysqli_close($conn);
    return false;
}
function op_mer(){
    if(!($conn = conn())){
        return false;
    }
    $q = mysqli_query($conn,"SELECT kodja FROM palyazatok");
    if(mysqli_num_rows($q) > 0){
        mysqli_close($conn);
        return $q;
    }
    mysqli_close($conn);
    return false;
}
function op_all(){
    if(!($conn = conn())){
        return false;
    }
    $q = mysqli_query($conn,"SELECT merfoldko FROM merfoldko");
    if(mysqli_num_rows($q) > 0){
        mysqli_close($conn);
        return $q;
    }
    mysqli_close($conn);
    return false;
}

function palyazatok_lekeres(){
    if(!($conn = conn())){
        return false;
    }
    $q = mysqli_query($conn,"SELECT * FROM palyazatok");
    if(mysqli_num_rows($q) > 0){
        mysqli_close($conn);
        return $q;
    }
    mysqli_close($conn);
    return false;
}
function up_paly($eredeti,$kode,$topic,$title,$begin,$end,$apply,$got,$goal){
    if(!($conn = conn())){
        return false;
    }
    $stmt = mysqli_prepare($conn,"UPDATE palyazatok SET cel=?,elnyert=?,palyazott=?,vege=?,kezdete=?,cime=?,temaszam=?,kodja=? WHERE kodja=?");
    mysqli_stmt_bind_param($stmt,"sddsssdss",$goal,$got,$apply,$end,$begin,$title,$topic,$kode,$eredeti);
    $s = mysqli_stmt_execute($stmt);
    if(!$s){
        die("nem sikerült a modosítás");
    }

    mysqli_close($conn);
    return $s;
}
function up_mer($eredet,$id,$kod,$name,$time,$leiras,$tej){
    if(!($conn = conn())){
        return false;
    }
    $stmt = mysqli_prepare($conn,"UPDATE merfoldko SET merfoldko=?,palyazat=?,megnevezes=?,idopont=?,leiras=?,teljesul=? WHERE merfoldko=?");
    mysqli_stmt_bind_param($stmt,"sssssds",$id,$kod,$name,$time,$leiras,$tej, $eredet);
    $s = mysqli_stmt_execute($stmt);
    if(!$s){
        die("nem sikerült a modosítás");
    }

    mysqli_close($conn);
    return $s;
}

function felhasznalo_lekeres(){
    if(!($conn = conn())){
        return false;
    }
    $q = mysqli_query($conn,"SELECT felhasznalo.*,COUNT(palyazatok.nev) AS db FROM felhasznalo LEFT JOIN palyazatok ON felhasznalo.nev = palyazatok.nev GROUP BY felhasznalo.nev");
    if(mysqli_num_rows($q) > 0){
        mysqli_close($conn);
        return $q;
    }
    mysqli_close($conn);
    return false;
}

function merfoldko_lekeres(){
    if(!($conn = conn())){
        return false;
    }
    $q = mysqli_query($conn,"SELECT merfoldko.*, COUNT(dokumentum.merfoldko) AS dokumentumok_szama, IF(COUNT(dokumentum.merfoldko) = 0, 0, SUM(CASE WHEN dokumentum.dokumentum IS NULL THEN 0 ELSE 1 END)) AS nem_ures_dokumentumok_szama, IF(COUNT(dokumentum.merfoldko) = 0, 0, SUM(dokumentum.kifizetett)) AS kifizettet_osszeg FROM merfoldko LEFT JOIN dokumentum ON merfoldko.merfoldko = dokumentum.merfoldko GROUP BY merfoldko.merfoldko;");
    if(mysqli_num_rows($q) > 0){
        mysqli_close($conn);
        return $q;
    }
    mysqli_close($conn);
    return false;
}

function all_dok_lekeres(){
    if(!($conn = conn())){
        return false;
    }
    $q = mysqli_query($conn,"SELECT * FROM dokumentum");
    if(mysqli_num_rows($q) > 0){
        mysqli_close($conn);
        return $q;
    }
    mysqli_close($conn);
    return false;
}
function my_paly_lekeres($nev){
    if(!($conn = conn())){
        return false;
    }
    $stmt = sprintf("SELECT * FROM palyazatok WHERE palyazatok.nev='%s'",mysqli_real_escape_string($conn,$nev));
    $q = mysqli_query($conn,$stmt);
    if(mysqli_num_rows($q) > 0){
        mysqli_close($conn);
        return $q;
    }
    mysqli_close($conn);
    return false;
}
function my_paly_mer_lekeres($nev){
    if(!($conn = conn())){
        return false;
    }
    $stmt = sprintf("SELECT * FROM merfoldko JOIN palyazatok ON merfoldko.palyazat = palyazatok.kodja WHERE palyazatok.nev='%s'",mysqli_real_escape_string($conn,$nev));
    $q = mysqli_query($conn,$stmt);
    if(mysqli_num_rows($q) > 0){
        mysqli_close($conn);
        return $q;
    }
    mysqli_close($conn);
    return false;
}
function my_paly_mer_all_lekeres($nev){
    if(!($conn = conn())){
        return false;
    }
    $stmt = sprintf("SELECT * FROM dokumentum JOIN merfoldko ON dokumentum.merfoldko = merfoldko.merfoldko JOIN palyazatok ON merfoldko.palyazat = palyazatok.kodja WHERE palyazatok.nev='%s'",mysqli_real_escape_string($conn,$nev));
    $q = mysqli_query($conn,$stmt);
    if(mysqli_num_rows($q) > 0){
        mysqli_close($conn);
        return $q;
    }
    mysqli_close($conn);
    return false;
}

function all_dok_null(){
    if(!($conn = conn())){
        return false;
    }
    $q = mysqli_query($conn,"SELECT * FROM `dokumentum` WHERE dokumentum.dokumentum IS NULL");
    if(mysqli_num_rows($q) > 0){
        mysqli_close($conn);
        return $q;
    }
    mysqli_close($conn);
    return false;
}




