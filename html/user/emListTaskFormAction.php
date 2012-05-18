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
row1("Data Deleting.". '9');
$contador=1;
foreach($_REQUEST as $key => $value)
{
	if($stcmp($key,"cancel")==0){
		//lanzar comando de borrado.
	}else{
		//echo "key : " . $key . " value : " . $value . "<br/>";
		$pathBorrado="../../sample_results/";
		$fichero0=$pathBorrado . $key . "_0.gz";
		$fichero1=$pathBorrado . $key . "_1.gz";
		$salida=shell_exec('rm -f ' . $fichero0 . " " . $fichero1);

		row2("Deleted File", $fichero0);
		row2("Deleted File", $fichero1);
		$result=mysql_query("delete from user_workunit where workunit_id = " . $value );
	}
	$contador+=1;	
} 
row2("", " Deleted Database References ");


end_table();
page_tail();


?>

</body>
</html>
