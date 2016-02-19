<?php

##################################################################################
#    HOTELDRUID
#    Copyright (C) 2001-2015 by Marco Maria Francesco De Santis (marco@digitaldruid.net)
#
#    This program is free software: you can redistribute it and/or modify
#    it under the terms of the GNU Affero General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    any later version accepted by Marco Maria Francesco De Santis, which
#    shall act as a proxy as defined in Section 14 of version 3 of the
#    license.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU Affero General Public License for more details.
#
#    You should have received a copy of the GNU Affero General Public License
#    along with this program.  If not, see <http://www.gnu.org/licenses/>.
##################################################################################



function num_caratteri_testo ($testo) {

return strlen(utf8_decode($testo));

} # fine function num_caratteri_testo



function tronca_testo ($testo,$inizio,$lunghezza = "NO") {

$num_caratteri = 0;
$num_byte = strlen($testo);
for ($num1 = 0 ; $num1 < $num_byte ; $num1++) {
$num_caratteri++;
$byte_car = 1;
$byte = ord($testo[$num1]);
if ($byte & 128) {
$byte = $byte << 1;
while ($byte & 128) {
$num1++;
$byte_car++;
$byte = $byte << 1;
} # fine while ($byte & 128)
} # fine if ($byte & 128)
$num_byte_car[$num_caratteri] = $byte_car;
} # fine for $num1

$n_ini = 0;
while ($inizio < 0) $inizio = $num_caratteri + $inizio;
for ($num1 = 1 ; $num1 <= $inizio ; $num1++) $n_ini = $n_ini + $num_byte_car[$num1];
if ($lunghezza == "NO") $testo = substr($testo,$n_ini);
else {
$n_lun = 0;
if ($lunghezza < 0) {
while ($lunghezza < 0) $lunghezza = $num_caratteri + $lunghezza;
$lunghezza = $lunghezza - $inizio;
} # fine if ($lunghezza < 0)
for ($num1 = ($inizio + 1) ; $num1 <= ($inizio + $lunghezza) ; $num1++) $n_lun = $n_lun + $num_byte_car[$num1];
$testo = substr($testo,$n_ini,$n_lun);
} # fine else if ($lunghezza == "NO")

return $testo;

} # fine function tronca_testo



function trova_prima_data ($testo,$stile_data,$lingua) {
global $lingua_mex;

$prima_data = "";
$lung_prima_data = strlen($testo);

if (preg_match("|[^0-9][0-9]{1,2}[-/ ][0-9]{1,2}[-/ ][0-9]{4,4}[^0-9]|",$testo)) {
$prima_data_vett = preg_split("|[0-9]{1,2}[-/ ][0-9]{1,2}[-/ ][0-9]{4,4}|",$testo);
$lung_prima_data_corr = strlen($prima_data_vett[0]);
if ($lung_prima_data_corr < $lung_prima_data) {
$lung_prima_data = $lung_prima_data_corr;
$prima_data = substr($testo,$lung_prima_data);
if ($prima_data_vett[1]) {
$prima_data = explode($prima_data_vett[1],$prima_data);
$prima_data = $prima_data[0];
} # fine if ($prima_data_vett[1])
$prima_data_corr = preg_split("|[-/ ]|",$prima_data);
if (strlen($prima_data_corr[0]) < 2) $prima_data_corr[0] = "0".$prima_data_corr[0];
if (strlen($prima_data_corr[1]) < 2) $prima_data_corr[1] = "0".$prima_data_corr[1];
if ((integer) $prima_data_corr[0] > 12) $prima_data = $prima_data_corr[2]."-".$prima_data_corr[1]."-".$prima_data_corr[0];
else {
if ((integer) $prima_data_corr[1] > 12) $prima_data = $prima_data_corr[2]."-".$prima_data_corr[0]."-".$prima_data_corr[1];
else {
if ($stile_data == "usa") $prima_data = $prima_data_corr[2]."-".$prima_data_corr[0]."-".$prima_data_corr[1];
else $prima_data = $prima_data_corr[2]."-".$prima_data_corr[1]."-".$prima_data_corr[0];
} # fine else if ($prima_data_corr[1] > 12)
} # fine else if ($prima_data_corr[0] > 12)
} # fine if ($lung_prima_data_corr < $lung_prima_data)
} # fine if (preg_match("|[^0-9][0-9]{1,2}[-/ ][0-9]{1,2}[-/ ][0-9]{4,4}|",$testo))

if (preg_match("|[^0-9][0-9]{4,4}[-/ ][0-9]{1,2}[-/ ][0-9]{1,2}[^0-9]|",$testo)) {
$prima_data_vett = preg_split("|[0-9]{4,4}[-/ ][0-9]{1,2}[-/ ][0-9]{1,2}|",$testo);
$lung_prima_data_corr = strlen($prima_data_vett[0]);
if ($lung_prima_data_corr < $lung_prima_data) {
$lung_prima_data = $lung_prima_data_corr;
$prima_data = substr($testo,$lung_prima_data);
if ($prima_data_vett[1]) {
$prima_data = explode($prima_data_vett[1],$prima_data);
$prima_data = $prima_data[0];
} # fine if ($prima_data_vett[1])
$prima_data_corr = preg_split("|[-/ ]|",$prima_data);
if (strlen($prima_data_corr[1]) < 2) $prima_data_corr[1] = "0".$prima_data_corr[1];
if (strlen($prima_data_corr[2]) < 2) $prima_data_corr[2] = "0".$prima_data_corr[2];
$prima_data = $prima_data_corr[0]."-".$prima_data_corr[1]."-".$prima_data_corr[2];
} # fine if ($lung_prima_data_corr < $lung_prima_data)
} # fine if (preg_match("|[^0-9][0-9]{4,4}[-/ ][0-9]{1,2}[-/ ][0-9]{1,2}[^0-9]|",$testo))

$lingua_orig = $lingua_mex;
$lingua_mex = $lingua;
$Gen = mex("Gen",'giorni_mesi.php');
$Feb = mex("Feb",'giorni_mesi.php');
$Mar = mex("Mar",'giorni_mesi.php');
$Apr = mex("Apr",'giorni_mesi.php');
$Mag = mex("Mag",'giorni_mesi.php');
$Giu = mex("Giu",'giorni_mesi.php');
$Lug = mex("Lug",'giorni_mesi.php');
$Ago = mex("Ago",'giorni_mesi.php');
$Set = mex("Set",'giorni_mesi.php');
$Ott = mex("Ott",'giorni_mesi.php');
$Nov = mex("Nov",'giorni_mesi.php');
$Dic = mex("Dic",'giorni_mesi.php');
$Gennaio = mex("Gennaio",'giorni_mesi.php');
$Febbraio = mex("Febbraio",'giorni_mesi.php');
$Marzo = mex("Marzo",'giorni_mesi.php');
$Aprile = mex("Aprile",'giorni_mesi.php');
$Maggio = mex("Maggio",'giorni_mesi.php');
$Giugno = mex("Giugno",'giorni_mesi.php');
$Luglio = mex("Luglio",'giorni_mesi.php');
$Agosto = mex("Agosto",'giorni_mesi.php');
$Settembre = mex("Settembre",'giorni_mesi.php');
$Ottobre = mex("Ottobre",'giorni_mesi.php');
$Novembre = mex("Novembre",'giorni_mesi.php');
$Dicembre = mex("Dicembre",'giorni_mesi.php');
$lingua_mex = $lingua_orig;
$mesi_alternativi = "$Gen|$Feb|$Mar|$Apr|$Mag|$Giu|$Lug|$Ago|$Set|$Ott|$Nov|$Dic|$Gennaio|$Febbraio|$Marzo|$Aprile|$Maggio|$Giugno|$Luglio|$Agosto|$Settembre|$Ottobre|$Novembre|$Dicembre";

if (preg_match("=[^0-9a-z]($mesi_alternativi)[, -/]+[0-9]{1,2}[, -/]+[0-9]{4,4}[^0-9a-z]=i",$testo)) {
$prima_data_vett = preg_split("=($mesi_alternativi)[, -/]+[0-9]{1,2}[, -/]+[0-9]{4,4}=i",$testo);
$lung_prima_data_corr = strlen($prima_data_vett[0]);
if ($lung_prima_data_corr < $lung_prima_data) {
$lung_prima_data = $lung_prima_data_corr;
$prima_data = substr($testo,$lung_prima_data);
if ($prima_data_vett[1]) {
$prima_data = explode($prima_data_vett[1],$prima_data);
$prima_data = $prima_data[0];
} # fine if ($prima_data_vett[1])
$prima_data_corr = preg_split("|[, -/]+|",$prima_data);
if ($prima_data_corr[0] == $Gen or $prima_data_corr[0] == $Gennaio) $mese = "01";
if ($prima_data_corr[0] == $Feb or $prima_data_corr[0] == $Febbraio) $mese = "02";
if ($prima_data_corr[0] == $Mar or $prima_data_corr[0] == $Marzo) $mese = "03";
if ($prima_data_corr[0] == $Apr or $prima_data_corr[0] == $Aprile) $mese = "04";
if ($prima_data_corr[0] == $Mag or $prima_data_corr[0] == $Maggio) $mese = "05";
if ($prima_data_corr[0] == $Giu or $prima_data_corr[0] == $Giugno) $mese = "06";
if ($prima_data_corr[0] == $Lug or $prima_data_corr[0] == $Luglio) $mese = "07";
if ($prima_data_corr[0] == $Ago or $prima_data_corr[0] == $Agosto) $mese = "08";
if ($prima_data_corr[0] == $Set or $prima_data_corr[0] == $Settembre) $mese = "09";
if ($prima_data_corr[0] == $Ott or $prima_data_corr[0] == $Ottobre) $mese = "10";
if ($prima_data_corr[0] == $Nov or $prima_data_corr[0] == $Novembre) $mese = "11";
if ($prima_data_corr[0] == $Dic or $prima_data_corr[0] == $Dicembre) $mese = "12";
if (strlen($prima_data_corr[1]) < 2) $prima_data_corr[1] = "0".$prima_data_corr[1];
$prima_data = $prima_data_corr[2]."-".$mese."-".$prima_data_corr[1];
} # fine if ($lung_prima_data_corr < $lung_prima_data)
} # fine if (preg_match("=[^0-9a-z]($mesi_alternativi)[, -/]+[0-9]{1,2}[, -/]+[0-9]{4,4}[^0-9a-z]=i",$testo))

if (preg_match("=[^0-9a-z][0-9]{1,2}[, -/]+($mesi_alternativi)[, -/]+[0-9]{4,4}[^0-9a-z]=i",$testo)) {
$prima_data_vett = preg_split("=[0-9]{1,2}[, -/]+($mesi_alternativi)[, -/]+[0-9]{4,4}=i",$testo);
$lung_prima_data_corr = strlen($prima_data_vett[0]);
if ($lung_prima_data_corr < $lung_prima_data) {
$lung_prima_data = $lung_prima_data_corr;
$prima_data = substr($testo,$lung_prima_data);
if ($prima_data_vett[1]) {
$prima_data = explode($prima_data_vett[1],$prima_data);
$prima_data = $prima_data[0];
} # fine if ($prima_data_vett[1])
$prima_data_corr = preg_split("|[, -/]+|",$prima_data);
if ($prima_data_corr[1] == $Gen or $prima_data_corr[1] == $Gennaio) $mese = "01";
if ($prima_data_corr[1] == $Feb or $prima_data_corr[1] == $Febbraio) $mese = "02";
if ($prima_data_corr[1] == $Mar or $prima_data_corr[1] == $Marzo) $mese = "03";
if ($prima_data_corr[1] == $Apr or $prima_data_corr[1] == $Aprile) $mese = "04";
if ($prima_data_corr[1] == $Mag or $prima_data_corr[1] == $Maggio) $mese = "05";
if ($prima_data_corr[1] == $Giu or $prima_data_corr[1] == $Giugno) $mese = "06";
if ($prima_data_corr[1] == $Lug or $prima_data_corr[1] == $Luglio) $mese = "07";
if ($prima_data_corr[1] == $Ago or $prima_data_corr[1] == $Agosto) $mese = "08";
if ($prima_data_corr[1] == $Set or $prima_data_corr[1] == $Settembre) $mese = "09";
if ($prima_data_corr[1] == $Ott or $prima_data_corr[1] == $Ottobre) $mese = "10";
if ($prima_data_corr[1] == $Nov or $prima_data_corr[1] == $Novembre) $mese = "11";
if ($prima_data_corr[1] == $Dic or $prima_data_corr[1] == $Dicembre) $mese = "12";
if (strlen($prima_data_corr[0]) < 2) $prima_data_corr[0] = "0".$prima_data_corr[0];
$prima_data = $prima_data_corr[2]."-".$mese."-".$prima_data_corr[0];
} # fine if ($lung_prima_data_corr < $lung_prima_data)
} # fine if (preg_match("=[^0-9a-z][0-9]{1,2}[, -/]+($mesi_alternativi)[, -/]+[0-9]{4,4}[^0-9a-z]=i",$testo))

return $prima_data;

} # fine function trova_prima_data



function trova_numero_vicino ($testo,$parola) {

$numero = 0;
$dist_dopo = 0;
$dist_prima = 0;
$testo_vett = preg_split("/$parola"."[^0-9a-z]/i",$testo);
if ($testo_vett[1]) {
$testo_vett[1] = " ".$testo_vett[1];
# Numero dopo la parola cercata
$num = preg_split("/[^0-9a-z][0-9]{1,2}[^0-9a-z]/i",substr($testo_vett[1],0,16));
if (count($num) > 1) {
$dist_dopo = (strlen($num[0]) + 1);
$numero = substr($testo_vett[1],$dist_dopo,1);
if (preg_match("/[0-9]/",substr($testo_vett[1],($dist_dopo + 1),1))) $numero .= substr($testo_vett[1],($dist_dopo + 1),1);
} # fine if (count($num) > 1)
# Numero prima della parola cercata
$num = preg_split("/[^0-9a-z][0-9]{1,2}[^0-9a-z]/i",substr($testo_vett[0],-16));
if (count($num) > 1) {
$dist_prima = (strlen($num[(count($num) - 1)]) + 1);
if (!$numero or $dist_prima < $dist_dopo) {
$numero = substr($testo_vett[0],(($dist_prima * -1) - 1),1);
if (preg_match("/[0-9]/",substr($testo_vett[0],(($dist_prima * -1) - 2),1))) $numero = substr($testo_vett[0],(($dist_prima * -1) - 2),1).$numero;
} # fine if (!$numero or $dist_prima < $dist_dopo)
} # fine if (count($num) > 1)
} # fine if ($testo_vett[1])

return $numero;

} # fine function trova_numero_vicino



?>