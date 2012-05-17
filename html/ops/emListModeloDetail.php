<html>
<body>

<?php
require_once("../inc/db_ops.inc");
require_once("../inc/util_ops.inc");
require_once("../inc/countries.inc");

$size = (int) count($_REQUEST);


db_init();


admin_page_head(tra("Model Detail "));
//start_table("align=\"center\"");
start_table();
$contador=1;
foreach($_REQUEST as $key => $value)
{

	if(stristr($key, 'model') != FALSE) 
	{
		$modelo_id=$value;
	}
	$contador+=1;	
} 
	// MODELO
	$result=mysql_query("select modelo.nombre from modelo where modelo.modelo_id = " . $modelo_id );
	while($row=mysql_fetch_array($result))
	{
		row1("Model : " .$row['nombre'] , '9');
	}

echo "<tr><td width=\"25\">Parameter </td>";
echo "<td width=\"25\">" . "Variable      " . "</td>\n";
echo "<td width=\"25\">" . "Current      " . "</td>\n";
echo "</tr>";

	// PARAMETROS
	$resultP=mysql_query("select parametro_id, nombre from modelo_parametro where modelo_id = " . $modelo_id );
	// VARIABLES
	$resultV=mysql_query("select variable_id, nombre from modelo_variable where modelo_id = " . $modelo_id );
	// CORRIENTES
	$resultC=mysql_query("select corriente_id, nombre from modelo_corriente where modelo_id = " . $modelo_id );
$hayDatos=true;
while($hayDatos)
	{
		$rowP=mysql_fetch_array($resultP) ;
		$rowV=mysql_fetch_array($resultV);
		$rowC=mysql_fetch_array($resultC);
if($rowP==FALSE && $rowV==FALSE && $rowC==FALSE)
{
$hayDatos=false;
}
else
{
$hayDatos=true;
}

echo "<tr>";
if($rowP==TRUE)
{
	echo "<td>" . $rowP['parametro_id']. ".:" . $rowP['nombre'] . "</td>";
}
else
{
	echo "<td>" . "</td>";
}
if($rowV==TRUE)
{
	echo "<td>" . $rowV['variable_id']. ".:" .$rowV['nombre'] . "</td>";
}
else
{
	echo "<td>" . "</td>";
}
if($rowC==TRUE)
{
	echo "<td>" . $rowC['corriente_id']. ".:" .$rowC['nombre'] . "</td>";
}
else
{
	echo "<td>" . "</td>";
}
echo "</tr>";
}

end_table();
admin_page_tail();

?>
</body>
</html>
