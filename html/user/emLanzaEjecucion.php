<html>
<body>

<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");

$size = (int) count($_REQUEST);


db_init();
$user = get_logged_in_user();

echo "User ID :(" . $user->id . ") User NAME (" . $user->name;
echo "Tamano parametros  :(" . $size . ")";
echo $_REQUEST["model"] . "<br/>";
echo $_REQUEST["parameters"] . "<br/>";
echo $_REQUEST["step"] . "<br/>";
echo $_REQUEST["stimulus1"] . "<br/>";
echo $_REQUEST["stimulus2"] . "<br/>";
echo $_REQUEST["stimulus9"] . "<br/>";
echo $_REQUEST["stimulus10"] . "<br/>";
echo $_REQUEST["post"] . "<br/>";

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


if($_REQUEST["model"]=="")
{
	echo("#MODEL is empty. <br/>");
}
elseif($_REQUEST["parameters"]=="")
{
	echo("#PARAMETERS is empty. <br/>");
}
elseif($_REQUEST["step"]=="")
{
	echo("#STEP is empty. <br/>");
}
elseif($_REQUEST["stimulus1"]=="")
{
	echo("#STIMULUS1 is empty. <br/>");
}
elseif($_REQUEST["stimulus2"]=="")
{
	echo("#STIMULUS2 is empty. <br/>");
}
elseif($_REQUEST["post"]=="")
{
	echo("#POST is empty. <br/>");
}
else
{ // INSERT TASK

$salida=shell_exec('echo "desde php" > /tmp/php.out');
echo "Resultado de ejecucion de shell : ". "<pre>" . $salida . "<pre>" . "<BR/>";



$fp = fopen("/tmp/newTask.txt", "a");
$salida=shell_exec('ls -l /tmp/newTask.txt >> /tmp/php.out');
if (flock($fp, LOCK_SH|LOCK_NB)) { // do an exclusive lock
    ftruncate($fp, 0); // truncate file
///////////////////////////////
////INI   CREATE FILE  ////////
///////////////////////////////
    fwrite($fp, "#MODEL\n");
    fwrite($fp, $_REQUEST["model"] . "\n");
    fwrite($fp, "#PARAMETERS\n");
    fwrite($fp, $_REQUEST["parameters"] . "\n");
    fwrite($fp, "#STEP\n");
    fwrite($fp, $_REQUEST["step"] . "\n");
    fwrite($fp, "#STIMULUS\n");
    fwrite($fp, "2\n");
    fwrite($fp, $_REQUEST["stimulus1"] . "\n");
    fwrite($fp, $_REQUEST["stimulus2"] . "\n");
    fwrite($fp, "#POST\n");
    fwrite($fp, $_REQUEST["post"] . "\n");
    fwrite($fp, "#FILE_PARAMETERS\n");
    fwrite($fp, $_REQUEST["file_parameters"] . "\n");
    fwrite($fp, "#END\n");
///////////////////////////////
////END   CREATE FILE  ////////
///////////////////////////////
///////////////////////////////
////INI RUN EXTERNAL PROGRAM///
///////////////////////////////
$salida=shell_exec('ls -l ../../bin/lanza.sh >> /tmp/php.out 2>>/tmp/php.out ');
$salida=shell_exec('echo ../../bin/lanza.sh ' . $user->id . '  >> /tmp/php.out  2>>/tmp/php.out');
$salida=shell_exec('../../bin/lanza.sh' . " " .  $user->id);
///////////////////////////////
////END RUN EXTERNAL PROGRAM///
///////////////////////////////
    flock($fp, LOCK_UN); // release the lock
} else {
    echo "Server Busy. Try it again in some minutes" . "<BR/>";
}
fclose($fp);


} // END INSERT TASK

?>

</body>
</html>
