<html>
<body>

<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");

$size = (int) count($_REQUEST);


db_init();
$user = get_logged_in_user();

//echo "Tamano parametrosss  :(" . $size . ")";

page_head(tra("List Of Deleted Files "));
start_table();

$cancelacionTrabajos=false;
foreach($_REQUEST as $name => $value)
{
	//echo " name ".$name." value ".$value."\n";
	if(strcmp($name,"tipo")==0){
		if(strcmp($value,"cancel")==0){
			$cancelacionTrabajos=true;
		}else{
			$cancelacionTrabajos=false;
		}
	}else{
		$tablaParametros[$name]=$value;
	}

}


if($cancelacionTrabajos==true){
	row1("Work Canceling .", '9');
	foreach($tablaParametros as $work_id => $alias)
	{
		$salida=shell_exec('cd ../..;bin/cancel_jobs '.$work_id.' ' .$work_id.' >> /tmp/php.out 2>>/tmp/php.out ');
		$result=mysql_query("delete from user_workunit where workunit_id = " . $work_id );
		row2("Canceled Work ".$work_id, $alias);
	}
}else{
	row1("Data Deleting.", '9');
	$contador=1;
	foreach($tablaParametros as $work_id => $name)
	{
		//echo "key : " . $key . " value : " . $value . "<br/>";
		$pathBorrado="../../sample_results/";
		$fichero0=$pathBorrado . $name . "_0.gz";
		$fichero1=$pathBorrado . $name . "_1.gz";
		$salida=shell_exec('rm -f ' . $fichero0 . " " . $fichero1);

		row2("Deleted File", $fichero0);
		row2("Deleted File", $fichero1);
		$result=mysql_query("delete from user_workunit where workunit_id = " . $work_id );
		$contador+=1;	
	} 
	row2("", " Deleted Database References ");
}


end_table();
page_tail();


?>

</body>
</html>
