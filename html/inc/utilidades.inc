<?php

require_once("../inc/util_basic.inc");
require_once("../project/project.inc");
require_once("../inc/countries.inc");
require_once("../inc/db.inc");
require_once("../inc/boinc_db.inc");
require_once("../inc/translation.inc");
require_once("../inc/profile.inc");

// don't allow /... at the end of URL

if (array_key_exists("PATH_INFO", $_SERVER)) {
    die("bad URL");
}

ini_set("memory_limit", "256M");

if (!defined('SECURE_URL_BASE')) {
    define('SECURE_URL_BASE', URL_BASE);
}

////////////////////////////////////////////////////
/// Comprueba si un parametro es de un tipo ////////
////////////////////////////////////////////////////
function compruebaFloat($name,$value)
{
        if(filter_var($value, FILTER_VALIDATE_FLOAT))
        {
        }else
        {
                echo "El parametro " . "(" . $name  . ") NO es FLOAT <br>";
                $errorEnDatos=true;
        }

return $errorEnDatos;
}
function compruebaInt($name,$value)
{
echo "<br>";
var_dump (filter_var($value, FILTER_VALIDATE_INT) );
var_dump (filter_var($value, FILTER_VALIDATE_BOOLEAN) );
echo "<br>";
	//tratamiento especial para '0' con FILTER_VALIDATE_BOOLEAN
        if(filter_var($value, FILTER_VALIDATE_INT) || !filter_var($value, FILTER_VALIDATE_BOOLEAN))
        {
        }else
        {
                echo "El parametro " . "(" . $name  . ") NO es INT <br>";
                $errorEnDatos=true;
        }

return $errorEnDatos;
}

////////////////////////////////////////////////////
/// Transforma numero de version de bbdd a filesystem ////
////////////////////////////////////////////////////
function convierteNumeroVersion($versionBBDD) {
      $cien=100;           
      $mayor=floor($versionBBDD/$cien);
      $minor=$versionBBDD%$cien;

    return array($mayor, $minor);
}
////////////////////////////////////////////////////
/// Obtiene el nombre de un parametro /////////////
////////////////////////////////////////////////////
function dameNombreParametro($modelo_id, $parametro_id) {
	$result=mysql_query("select p.nombre from modelo m,modelo_parametro p where m.modelo_id=p.modelo_id and m.modelo_id=".$modelo_id . " and p.parametro_id=".$parametro_id);
	$row=mysql_fetch_array($result);
	$nombre=$row["nombre"];

    return $nombre;
}
////////////////////////////////////////////////////
/// Obtiene el nombre de una corriente/////////////
////////////////////////////////////////////////////
function dameNombreCorriente($modelo_id, $corriente_id) {
	$result=mysql_query("select p.nombre from modelo m,modelo_corriente p where m.modelo_id=p.modelo_id and m.modelo_id=".$modelo_id . " and p.corriente_id=".$corriente_id);
	$row=mysql_fetch_array($result);
	$nombre=$row["nombre"];

    return $nombre;
}



////////////////////////////////////////////////////
/// Prepara un query sql //////////////////////////
////////////////////////////////////////////////////
function get_mysql_model($query) {
    //$user_workunits = unserialize(get_cached_data(3600, "get_mysql_user_workunit".$query));
    //if ($user_workunits == false) {
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result)) {
            $user_workunits[] = $row;
        }
        mysql_free_result($result);
        set_cached_data(3600, serialize($user_workunits), "get_mysql_model".$query);
    //}else{
//}
    return $user_workunits;
}

////////////////////////////////////////////////////
/// Prepara un query sql //////////////////////////
////////////////////////////////////////////////////
function get_mysql_model_param($query) {
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result)) {
            $user_workunits[] = $row;
        }
        mysql_free_result($result);
        set_cached_data(3600, serialize($user_workunits), "get_mysql_model_param".$query);
    return $user_workunits;
}
////////////////////////////////////////////////////
/// Prepara un query sql //////////////////////////
////////////////////////////////////////////////////
function get_mysql_model_current($query) {
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result)) {
            $user_workunits[] = $row;
        }
        mysql_free_result($result);
        set_cached_data(3600, serialize($user_workunits), "get_mysql_model_current".$query);
    return $user_workunits;
}

////////////////////////////////////////////////////
/// Prepara un query sql //////////////////////////
////////////////////////////////////////////////////
function get_mysql_plataformas($query) {
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result)) {
            $user_workunits[] = $row;
        }
        mysql_free_result($result);
        set_cached_data(3600, serialize($user_workunits), "get_mysql_plataformas".$query);
    return $user_workunits;
}
////////////////////////////////////////////////////
/// Prepara un query sql //////////////////////////
////////////////////////////////////////////////////
function get_mysql_lastVersion($query) {
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result)) {
            $user_workunits[] = $row;
        }
        mysql_free_result($result);
        set_cached_data(3600, serialize($user_workunits), "get_mysql_lastVersion".$query);
    return $user_workunits;
}
////////////////////////////////////////////////////
/// Prepara un query sql //////////////////////////
////////////////////////////////////////////////////
function get_mysql_myVersion($query) {
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result)) {
            $user_workunits[] = $row;
        }
        mysql_free_result($result);
        set_cached_data(3600, serialize($user_workunits), "get_mysql_myVersion".$query);
    return $user_workunits;
}






?>
