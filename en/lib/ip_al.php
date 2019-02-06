<?php
function IPAl(){
if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}
$x  = @$_SERVER['HTTP_CLIENT_IP'];
$y = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$z  = $_SERVER['REMOTE_ADDR'];
if(filter_var($x, FILTER_VALIDATE_IP)){
$ip = $x;
}
elseif(filter_var($y, FILTER_VALIDATE_IP)){
$ip = $y;
}
else{
$ip = $z;
}
return $ip;
}
$ip_adresi = IPAl();
?>