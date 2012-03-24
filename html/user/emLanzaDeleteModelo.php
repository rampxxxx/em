<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");
require_once("../inc/utilidades.inc");

#############################
### INI : DATA      SELECT
#############################

#############################
### FIN : DATA      SELECT
#############################

#############################
### INI : FUNCTIONS SELECT
#############################

#############################
### FIN : FUNCTIONS SELECT
#############################


db_init();
$user = get_logged_in_user();

foreach($_REQUEST as $name => $value)
{
	$modelo_id=$value;
	$nombre=$name;
}


$result_ok = mysql_query("delete from modelo where modelo_id=".$modelo_id);




page_head(tra("Simulation Model Deletion"));
echo " <script src=\"http://code.jquery.com/jquery-latest.js\"></script> " ;
echo "
  <style>
  parametro { color:blue; margin:5px; cursor:pointer; }
  parametro:hover { background:green; }
  </style>

<script> 
////////////////////////////////////////////////////
///   Declaracion, inicializacion de variables /////
////////////////////////////////////////////////////

</script>";
echo form_tokens($user->authenticator);
start_table();
if($result_ok)
{
row1("Model DELETED! ", '9');
}
else
{
row1("ERROR deleting model!!! ", '9');
}
echo "<tr><td width=\"15\">Model ID</td>";
echo "<td width=\"15\">" . "Name          " . "</td>\n";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo $modelo_id ;
echo "</td>";
echo "<td>";
echo $nombre;
echo "</td>";
echo "</tr>";
end_table();
echo "<label for=\"tra\" id=\"tra\">Traza</label>";

echo "<td>
<a href=\"emQueryModelo.php\">". "Create/Delete Model" ."</a>
<a href=\"home.php\">". "Back Home " ."</a>
</td>
";
page_tail();
?>
