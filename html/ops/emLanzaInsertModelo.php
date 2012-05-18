<?php
require_once("../inc/db_ops.inc");
require_once("../inc/util_ops.inc");
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

admin_page_head(tra("Simulation Model Insertion"));
db_init();
$indiceParametros=1;
$indiceVariables=1;
$indiceCorrientes=1;
foreach($_REQUEST as $name => $value)
{
//echo " REQUEST : " . $name . " " . $value . "<br>";
	if(stristr($name, 'current') != FALSE) 
	{
		if($value!=""){
			$corrientes[$indiceCorrientes]=$value;
			$indiceCorrientes+=1;
		}
	}
	else if(stristr($name, 'parameter') != FALSE) 
	{
		if($value!=""){
			$parametros[$indiceParametros]=$value;
			$indiceParametros+=1;
		}
	}
	else if(stristr($name, 'variable') != FALSE) 
	{
		if($value!=""){
			$variables[$indiceVariables]=$value;
			$indiceVariables+=1;
		}
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
$elInsert="insert into modelo values (".$modeloId.",'".$modeloName."')";
//echo "SQL (" . $elInsert . ")<br>";
$result_ok = mysql_query($elInsert);
if($result_ok){

	foreach($parametros as $parId => $parName)
	{
		$elInsert="insert into modelo_parametro values (".$parId.",".$modeloId.",'".$parName . "'" . ")";
		//echo $elInsert . "<br>";
		$result_ok = mysql_query($elInsert);
		if($result_ok==false)
		{
			break;
		}
	}
	foreach($variables as $varId => $varName)
	{
		$elInsert="insert into modelo_variable values (".$varId.",".$modeloId.",'".$varName . "'" . ")";
		//echo $elInsert . "<br>";
		$result_ok = mysql_query($elInsert);
		if($result_ok==false)
		{
			break;
		}
	}
	foreach($corrientes as $curId => $curName)
	{
		$elInsert="insert into modelo_corriente values (".$curId.",".$modeloId.",'".$curName."'" . ")";
		//echo $elInsert . "<br>";
		$result_ok = mysql_query($elInsert);
		if($result_ok==false)
		{
			break;
		}
	}
	if($result_ok==false)
	{ //Borrado en cascada.
		echo "Error inserting in Database (modelo_parametro OR modelo_corriente)<br>";
		echo "Cleaning model data <br>";
		mysql_query("delete from modelo where modelo_id=".$modeloId);
	}




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
if($result_ok)
{
start_table();
row1("Model INSERTED! ", '9');
row2( "Model ID", $modeloId);
row2( "Model Name", $modeloName);
foreach($parametros as $id => $par)
{
row2( "Paramenter Nº : ".$id , $par);
}
foreach($variables as $id => $par)
{
row2( "Variable Nº : ".$id , $par);
}
foreach($corrientes as $id => $par)
{
row2( "Current Nº : ".$id , $par);
}
end_table();
//echo "<label for=\"tra\" id=\"tra\">Traza</label>";
}
else
{
row1("ERROR insertion model!!! ", '9');
}

} //check error insert modelo table.
else
{
echo "Error Inserting in Data Base (modelo table)!!!! <br>";
}
/*
echo "<td>
<a href=\"emQueryModelo.php\">". "Create/Delete Model" ."</a>
<a href=\"home.php\">". "Back Home " ."</a>
</td>
";
*/
admin_page_tail();
?>
