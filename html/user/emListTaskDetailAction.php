<html>
<body>

<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");
function seccion($tok,$seccion)
{
$nombreSeccion="";
if(stristr($tok,'#') != FALSE){
	if(stristr($tok, '#MODEL') != FALSE) 
	{
		$nombreSeccion="#MODEL";
	}
	else if(stristr($tok, '#PARAMETERS') != FALSE)
	{
		$nombreSeccion="#PARAMETERS";
	}
	else if(stristr($tok, '#STEP') != FALSE)
	{
		$nombreSeccion="#STEP";
	}
	else if(stristr($tok, '#STIMULUS') != FALSE)
	{
		$nombreSeccion="#STIMULUS";
	}
	else if(stristr($tok, '#POST') != FALSE)
	{
		$nombreSeccion="#POST";
	}
	else if(stristr($tok, '#FILE_PARAMETERS') != FALSE)
	{
		$nombreSeccion="#FILE_PARAMETERS";
	}
	else if(stristr($tok, '#FILE_CURRENTS') != FALSE)
	{
		$nombreSeccion="#FILE_CURRENTS";
	}
	else if(stristr($tok, '#END') != FALSE)
	{
		$nombreSeccion="#END";
	}
}
	if($nombreSeccion==$seccion || $nombreSeccion =="")
	{
		return $seccion;
	}
	else
	{
		return $nombreSeccion;
	}
}

$size = (int) count($_REQUEST);


db_init();
$user = get_logged_in_user();


page_head(tra("Parameters "));
start_table("align=\"center\"");
$contador=1;
foreach($_REQUEST as $key => $value)
{

	if(stristr($key, 'workunit_id') != FALSE) 
	{
		$workunit_id=$value;
	}
	else if(stristr($key, 'debug') != FALSE) 
	{
		$debug=$value;
	}
	$contador+=1;	
} 
if($debug==1)
{
	$result=mysql_query("select parameters from user_workunit where workunit_id = " . $workunit_id );
	while($row=mysql_fetch_array($result))
	{
		echo "<tr><td> " . nl2br($row['parameters']) . "</td>";
		$tok = strtok($row['parameters'], " \n\t");
		while ($tok !== false) {
			echo "<tr><td>$tok HAHA</td></tr>";
			if(($seccion=seccion($tok,$seccion))=="#MODEL")
			{
				$result=mysql_query("select nombre from modelo where modelo_id=".);
				$row=mysql_fetch_array($result);
				row1($modelo,'9');
			}
			else if(($seccion=seccion($tok,$seccion))=="#PARAMETERS")
				$tok = strtok(" \n\t");
		}
	}
}
else
{
	$result=mysql_query("select parametersE from user_workunit where workunit_id = " . $workunit_id );
	while($row=mysql_fetch_array($result))
	{
		echo "<tr><td> " . nl2br($row['parametersE']) . "</td>";
	}
}


end_table();
page_tail();


?>

</body>
</html>
