<?php
error_reporting(0);
require_once "wcp_config.php";
session_start();
$guvenliktbl = $dbbaglan->query("SELECT * FROM guvenlik", PDO::FETCH_ASSOC);
$ekstratbl = $dbbaglan->query("SELECT * FROM ekstra", PDO::FETCH_ASSOC);
$ipbantbl = $dbbaglan->query("SELECT * FROM ipban", PDO::FETCH_ASSOC);

if ( $ipbantbl->rowCount() ){
foreach( $ipbantbl as $row3 ){
require_once "lib/ip_al.php";
$ipyicek = htmlspecialchars($row3['ip']);
if($ip_adresi == $ipyicek){
die('<script>document.write(\'<title>Access Denied</title><center><font color="red" face="Courier New"><b><h3>Access Denied<br></h3><font color="green">Protected by WebCOP Firewall\');</script>');
}
}
}

if ( $guvenliktbl->rowCount() ){
foreach( $guvenliktbl as $row ){

$mirrorkorumasi = $row['mirrorkorumasi'];
$saldirganizleme = $row['saldirganizleme'];
$saldirgantespit = $row['saldirgantespit'];
$urlyonlendir = $row['urlyonlendir'];
$bakimmodu = $row['bakimmodu'];

if($mirrorkorumasi == 1){
require_once "lib/ip_al.php";
$engelle = array(
"195.154.58.181", 
"193.202.110.25",
"195.154.48.95",
"188.121.57.12",
"62.4.0.95",
"193.70.19.218",
"162.220.11.2",
"54.37.156.89",
"217.79.181.80",
"208.98.49.44",
"18.220.122.240",
"195.154.58.181",
"51.38.218.12",
"207.241.225.226",
"46.4.238.70",
"46.166.139.172"
);
if(in_array($ip_adresi, $engelle)){
die('<script>document.write(\'<title>This Website is Protected</title><center><font color="red" face="Courier New"><b><h3>Access Denied<br></h3><font color="green">Protected by WebCOP Firewall\');</script>');
}
}

if($saldirganizleme == 1){
if(!$_SESSION['tekrar']){
    $_SESSION['tekrar'] = 1;
    $_SESSION['ilk'] = time();
    $_SESSION['uyari'] = false;
}
else{
    $_SESSION['tekrar']++; 
}

if($_SESSION['ilk'] < time() - 15){
    $_SESSION['tekrar'] = 1;
}

if($_SESSION['tekrar'] > 20){
    $_SESSION['uyari'] = true; 
require_once "lib/ip_al.php";
$google = array("64.233.160", "64.233.191", "66.102.0", "66.102.15", "66.249.64", "66.249.95", "72.14.192", "72.14.255", "74.125.0", "74.125.255", "209.85.128", "209.85.255", "216.239.32", "216.239.63");
foreach($google as $googleip){
if(!stristr($ip_adresi, $googleip)){
if(filter_var($ip_adresi, FILTER_VALIDATE_IP)){
$engellekomut = $dbbaglan->prepare("INSERT INTO ipban SET ip = ?, aciklama = 'flood-saldirisi'");
$engellekomut->execute(array($ip_adresi));
die('<script>document.write(\'<title>Attack Detected</title><center><font color="red" face="Courier New"><b><h3>Attack Detected - Access Denied<br></h3><font color="green">Protected by WebCOP Firewall \');</script>');
}
}
// ban ip address if request 20+ in 15 seconds
}
}
}

if($saldirgantespit == 1){
if($_GET){
$engelliliste = array("'", '"', '<', '>', '@', '=', ')', '(', ';', '$', '|', '`');
foreach($_GET as $anahtar){
foreach($engelliliste as $engelleget){
if(stristr($anahtar, $engelleget)){
require_once "lib/ip_al.php";
$google = array("64.233.160", "64.233.191", "66.102.0", "66.102.15", "66.249.64", "66.249.95", "72.14.192", "72.14.255", "74.125.0", "74.125.255", "209.85.128", "209.85.255", "216.239.32", "216.239.63");
foreach($google as $googleip){
if(!stristr($ip_adresi, $googleip)){
if(filter_var($ip_adresi, FILTER_VALIDATE_IP)){
$engellekomut = $dbbaglan->prepare("INSERT INTO ipban SET ip = ?, aciklama = 'saldiri-girisimi'");
$engellekomut->execute(array($ip_adresi));
die('<script>document.write(\'<title>Attack Detected</title><center><font color="red" face="Courier New"><b><h3>Attack Detected - Access Denied<br></h3><font color="green">Protected by WebCOP Firewall\');</script>');
}
}
}
}
}
}
}
}

if($urlyonlendir == 1){
if ( $ekstratbl->rowCount() ){
     foreach( $ekstratbl as $row2 ){	 
header('Location: '.$row2['yeniurl']);
	 }
}
}

if($bakimmodu == 1){
if ( $ekstratbl->rowCount() ){
     foreach( $ekstratbl as $row2 ){	 
die($row2['bakimindex']);
	 }
}
}
	  
     }
}
