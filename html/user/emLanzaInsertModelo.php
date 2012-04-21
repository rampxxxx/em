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

page_head(tra("Simulation Model Insertion"));
db_init();
$user = get_logged_in_user();
$indiceParametros=1;
$indiceCorrientes=1;
foreach($_REQUEST as $name => $value)
{
//echo " REQUEST : " . $name . " " . $value . "<br>";
	if(stristr($name, 'current') != FALSE) 
	{
		$corrientes[$indiceCorrientes]=$value;
		$indiceCorrientes+=1;
	}
	else if(stristr($name, 'parameter') != FALSE) 
	{
		$parametros[$indiceParametros]=$value;
		$indiceParametros+=1;
	}
	else if(stristr($name, 'modelNumber') != FALSE) 
	{
		$modeloId=$value;
	}
	else if(stristr($name, 'modelName') != FALSE) 
	{
		$modeloName=$value;
	}
}

$result_ok=false;
//$result_ok = mysql_query("delete from modelo where modelo_id=".$modelo_id);




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
if($result_ok)
{
row1("Model INSERTED! ", '9');
}
else
{
row1("ERROR insertion model!!! ", '9');
}
start_table();
row1( "Model Data", '9');
row2( "Model ID", $modeloId);
row2( "Model Name", $modeloName);
foreach($parametros as $id => $par)
{
row2( "Paramenter Nº : ".$id , $par);
}
foreach($corrientes as $id => $par)
{
row2( "Current Nº : ".$id , $par);
}
end_table();
echo "<label for=\"tra\" id=\"tra\">Traza</label>";

echo "<td>
<a href=\"emQueryModelo.php\">". "Create/Delete Model" ."</a>
<a href=\"home.php\">". "Back Home " ."</a>
</td>
";
page_tail();
?>
