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
	$cadena=$key;
	if(stristr($cadena, 'stimulus') != FALSE) {
		echo 'Encontrado en :' . $contador . "<br/>";
	}	
	echo $key;
	echo ": " . $value;
	echo "<br/>";
	$contador+=1;	
} 


$salida=shell_exec('echo "desde php" > /tmp/php.out');
echo "Resultado de ejecucion de shell : ". "<pre>" . $salida . "<pre>" . "<BR/>";




?>

</body>
</html>
