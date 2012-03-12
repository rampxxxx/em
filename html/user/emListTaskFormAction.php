<html>
<body>

<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");

$size = (int) count($_REQUEST);


db_init();
$user = get_logged_in_user();

echo "Tamano parametros  :(" . $size . ")";

$contador=1;
foreach($_REQUEST as $key => $value)
{
	if($value==1){
	$pathBorrado="../../sample_results/";
	$fichero0=$pathBorrado . $key . "_0.gz";
	$fichero1=$pathBorrado . $key . "_1.gz";
	$salida=shell_exec('rm -f ' . $fichero0 . " " . $fichero1);
	}
	$contador+=1;	
} 


echo "FICHEROS BORRADOS!!!";




?>

</body>
</html>
