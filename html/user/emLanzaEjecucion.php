<html>
<body>

<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");


////////////////////////////////////////////////////
/// Comprueba si un parametro es Float, saca msg y devuelve estado.
////////////////////////////////////////////////////
function compruebaFloat($name,$value)
{
	if(filter_var($value, FILTER_VALIDATE_FLOAT))
	{
	}else
	{
		echo "El parametro " . "(" . $name  . ") NO es FLOAT <br>";
		$errorEnDatos=true;
	}

return $errorEnDatos;
}
function compruebaInt($name,$value)
{
	if(filter_var($value, FILTER_VALIDATE_INT))
	{
	}else
	{
		echo "El parametro " . "(" . $name  . ") NO es INT <br>";
		$errorEnDatos=true;
	}

return $errorEnDatos;
}



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
$indiceParametros=1;
$indiceParSave=1;
$indiceStimulus=1;
$burstSelect=0;
$burstStart=0;
$burstEnd=0;
$burstGap=0;
$stepStart=0;
$stepEnd=0;
$stepGap=0;
$errorEnDatos=false;
class stimulus{
var $stimStart;
var $stimBcl;
var $stimDur;
var $stimCur;
}
foreach($_REQUEST as $name => $value)
{
	if(stristr($name, 'parameterInput') != FALSE) 
	{
		$errorEnDatos=compruebaFloat($indiceParametros, $value);
		$parametros[$indiceParametros]=$value;
	}
	else if(stristr($name, 'parameterSelect') != FALSE) 
	{
		$indiceParametros=$value;
		$parametros[$value]=0;
	}
	else if(stristr($name, 'burstSelect') != FALSE) 
	{
		$burstSelect=$value;
	}
	else if(stristr($name, 'burstStart') != FALSE) 
	{
		$errorEnDatos=compruebaFloat($name, $value);
		$burstStart=$value;
	}
	else if(stristr($name, 'burstEnd') != FALSE) 
	{
		$errorEnDatos=compruebaFloat($name, $value);
		$burstEnd=$value;
	}
	else if(stristr($name, 'burstGap') != FALSE) 
	{
		$errorEnDatos=compruebaFloat($name, $value);
		$burstGap=$value;
	}
	else if(stristr($name, 'stepStart') != FALSE) 
	{
		$errorEnDatos=compruebaFloat($name, $value);
		$stepStart=$value;
	}
	else if(stristr($name, 'stepEnd') != FALSE) 
	{
		$errorEnDatos=compruebaFloat($name, $value);
		$stepEnd=$value;
	}
	else if(stristr($name, 'stepIncrement') != FALSE) 
	{
		$errorEnDatos=compruebaFloat($name, $value);
		$stepIncrement=$value;
	}
	else if(stristr($name, 'stimStart') != FALSE) 
	{
		$indiceStimulus=filter_var($name, FILTER_SANITIZE_NUMBER_INT);
		$errorEnDatos=compruebaFloat($name, $value);
		$tmpStim=new stimulus;
		$tmpStim->stimStart=$value;
		$stimulusArray[$indiceStimulus]=$tmpStim;
	}
	else if(stristr($name, 'stimBcl') != FALSE) 
	{
		$errorEnDatos=compruebaFloat($name, $value);
		$stimulusArray[$indiceStimulus]->stimBcl=$value;
	}
	else if(stristr($name, 'stimDur') != FALSE) 
	{
		$errorEnDatos=compruebaFloat($name, $value);
		$stimulusArray[$indiceStimulus]->stimDur=$value;
	}
	else if(stristr($name, 'stimCur') != FALSE) 
	{
		$errorEnDatos=compruebaFloat($name, $value);
		$stimulusArray[$indiceStimulus]->stimCur=$value;
	}
	else if(stristr($name, 'postFirst') != FALSE) 
	{
		$errorEnDatos=compruebaInt($name, $value);
		$postFirst=$value;
	}
	else if(stristr($name, 'postFrec') != FALSE) 
	{
		$errorEnDatos=compruebaInt($name, $value);
		$postFrec=$value;
	}
	else if(stristr($name, 'parSave') != FALSE) 
	{
		$indiceParSave=filter_var($name, FILTER_SANITIZE_NUMBER_INT);
		$paraSaveArray[$indiceParSave++]=$value;
	}
	else if(stristr($name, 'stimulus') != FALSE) 
	{
		echo 'Encontrado en :' . $contador . "<br/>";
	}	
	echo $name;
	echo ": " . $value;
	echo "<br/>";
	$contador+=1;	
}
echo "Muestra array de objs <br>";
foreach($stimulusArray as $id => $stimulo)
{
echo " id:(" . $id . ")"  . $stimulo->stimStart . " " . $stimulo->stimBcl . " " . $stimulo->stimDur . " " . $stimulo->stimCur . "<br>";
}
echo "Muestra array de parame save <br>";
foreach($paraSaveArray as $id => $par)
{
echo " id:(" . $id . ")"  . " Param : (" . $par . ")<br>";
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
