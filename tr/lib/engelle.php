<?php
function injblock($engellenecekdgr){
$engelliste = array("'", ";", '"', "\\", "<", ">");
return str_replace($engelliste, "", $engellenecekdgr);
return $engellenecekdgr;
}
