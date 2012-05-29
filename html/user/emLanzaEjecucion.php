<html>
<body>

<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");
require_once("../inc/utilidades.inc");

page_head(tra("Simulation Workunit Creation"));
start_table();


$size = (int) count($_REQUEST);


db_init();
$user = get_logged_in_user();
/*
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
*/
$contador=1;
$indiceParametros=1;
$indiceParSave=1;
$indiceCurSave=1;
$indiceStimulus=1;
$burstCnt=0;
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
	if(stristr($name, 'model') != FALSE) 
	{
		$model=$value;
	}
	else if(stristr($name, 'parameterSelect') != FALSE) 
	{
		$indiceParametros=$value;
		$parametros[$indiceParametros]=0;
	}
	if(stristr($name, 'parameterInput') != FALSE) 
	{
		if(!$errorEnDatos){
			$errorEnDatos=compruebaFloat($indiceParametros, $value);
		}
		$parametros[$indiceParametros]=$value;
	}
	else if(stristr($name, 'burstSelect') != FALSE) 
	{
		$burstSelect=$value;
	}
	else if(stristr($name, 'burstStart') != FALSE) 
	{
		if(!$errorEnDatos){
			$errorEnDatos=compruebaFloat($name, $value);
		}
		$burstStart=$value;
	}
	else if(stristr($name, 'burstEnd') != FALSE) 
	{
		if(!$errorEnDatos){
			$errorEnDatos=compruebaFloat($name, $value);
		}
		$burstEnd=$value;
	}
	else if(stristr($name, 'burstGap') != FALSE) 
	{
		if(!$errorEnDatos){
			$errorEnDatos=compruebaFloat($name, $value);
		}
		$burstGap=$value;
	}
	else if(stristr($name, 'stepStart') != FALSE) 
	{
		if(!$errorEnDatos){
			$errorEnDatos=compruebaFloat($name, $value);
		}
		$stepStart=$value;
	}
	else if(stristr($name, 'stepEnd') != FALSE) 
	{
		if(!$errorEnDatos){
			$errorEnDatos=compruebaFloat($name, $value);
		}
		$stepEnd=$value;
	}
	else if(stristr($name, 'stepIncrement') != FALSE) 
	{
		if(!$errorEnDatos){
			$errorEnDatos=compruebaFloat($name, $value);
		}
		$stepIncrement=$value;
	}
	else if(stristr($name, 'stimStart') != FALSE) 
	{
		$indiceStimulus=filter_var($name, FILTER_SANITIZE_NUMBER_INT);
		if(!$errorEnDatos){
			$errorEnDatos=compruebaFloat($name, $value);
		}
		$tmpStim=new stimulus;
		$tmpStim->stimStart=$value;
		$stimulusArray[$indiceStimulus]=$tmpStim;
	}
	else if(stristr($name, 'stimBcl') != FALSE) 
	{
		if(!$errorEnDatos){
			$errorEnDatos=compruebaFloat($name, $value);
		}
		$stimulusArray[$indiceStimulus]->stimBcl=$value;
	}
	else if(stristr($name, 'stimDur') != FALSE) 
	{
		if(!$errorEnDatos){
			$errorEnDatos=compruebaFloat($name, $value);
		}
		$stimulusArray[$indiceStimulus]->stimDur=$value;
	}
	else if(stristr($name, 'stimCur') != FALSE) 
	{
		if(!$errorEnDatos){
			$errorEnDatos=compruebaFloat($name, $value);
		}
		$stimulusArray[$indiceStimulus]->stimCur=$value;
	}
	else if(stristr($name, 'postFirst') != FALSE) 
	{
		if(!$errorEnDatos){
			$errorEnDatos=compruebaInt($name, $value);
		}
		$postFirst=$value;
	}
	else if(stristr($name, 'postFrec') != FALSE) 
	{
		if(!$errorEnDatos){
			$errorEnDatos=compruebaInt($name, $value);
		}
		$postFrec=$value;
	}
	else if(stristr($name, 'parSave') != FALSE) 
	{
		$indiceParSave=filter_var($name, FILTER_SANITIZE_NUMBER_INT);
		$paraSaveArray[$indiceParSave++]=$value;
	}
	else if(stristr($name, 'curSave') != FALSE) 
	{
		$indiceCurSave=filter_var($name, FILTER_SANITIZE_NUMBER_INT);
		$curSaveArray[$indiceCurSave++]=$value;
	}
	else if(stristr($name, 'saveCurr') != FALSE) 
	{
		$saveCurr=$value;
	}
	//echo $name;
	//echo ": " . $value;
	//echo "<br/>";
	$contador+=1;	
}
/*
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
echo "Muestra array de cur save <br>";
foreach($curSaveArray as $id => $par)
{
echo " id:(" . $id . ")"  . " Cur : (" . $par . ")<br>";
}
echo "Muestra array de PARAMETROS <br>";
foreach($parametros as $id => $par)
{
echo " id:(" . $id . ")"  . " Param : (" . $par . ")<br>";
}


echo "count(paraSaveArray) :" . count($paraSaveArray) . "<br>";
echo "count(curSaveArray) :" . count($curSaveArray) . "<br>";
*/

/*
if(count($paraSaveArray)==0 && count($curSaveArray)== 0){
	$errorEnDatos=true;
	row1("Work Creation ERROR!",'9');
	row2("", "No parameters and currents to save.");
	row2("", "No data is going to be generated as result :-) .");
	row2("", "Are you sure?");
	row2("", "Try again.");
}
*/


if($errorEnDatos==true)
{
	row2("","Check input data .");
}
else
{ // INSERT TASK

$salida=shell_exec('echo "desde php" > /tmp/php.out');
//echo "Resultado de ejecucion de shell : ". "<pre>" . $salida . "<pre>" . "<BR/>";

// INI LOOP : BURST TASK GENERATION
/*
echo "burstCnt " . $burstCnt . "<br>";
echo "burstStart "  . $burstStart . "<br>";
echo "burstEnd " . $burstEnd . "<br>";
echo "burstGap " . $burstGap . "<br>";
echo "burstSelect " . $burstSelect . "<br>";
*/
$haveBurst=false;
if($burstStart == $burstEnd || $burstGap==0){
	$burstGap=1;
	$haveBurst=false;
}
else
{
	$haveBurst=true;
}
for($burstCnt = $burstStart; $burstCnt <= $burstEnd ; $burstCnt+=$burstGap)
{
$salida=shell_exec('echo  ' . ' burstStart ' . $burstStart . ' burstEnd ' . $burstEnd . ' burstGap ' . $burstGap . ' burstCnt ' . $burstCnt .  '  >> /tmp/php.out  2>>/tmp/php.out');
if($haveBurst)
{
	$parametros[$burstSelect] = $burstCnt;//Valor nuevo(o modificado) para ejecucion.
}

$fp = fopen("/tmp/newTask.txt", "a"); // Data File for workunit creation.
$fpe= fopen("/tmp/newTaskExplain.txt", "a"); // Data File friendly for user check.
$salida=shell_exec('ls -l /tmp/newTask.txt >> /tmp/php.out');
$salida=shell_exec('ls -l /tmp/newTaskExplain.txt >> /tmp/php.out');
if (flock($fp, LOCK_SH|LOCK_NB)) { // do an exclusive lock
    ftruncate($fp, 0); // truncate file
    ftruncate($fpe, 0); // truncate file
///////////////////////////////
////INI   CREATE FILE  ////////
///////////////////////////////
    $linea="#MODEL\n";
    fwrite($fp, $linea);
    fwrite($fpe, $linea);
    $linea=$model . "\n";
    fwrite($fp, $linea);
    $result=get_mysql_model("select nombre from modelo where modelo_id=".$model);
    foreach($result as $res)
    {
	    $linea=$res["nombre"];
    }
    fwrite($fpe, $linea . "\n");


    $linea="#PARAMETERS\n";
    fwrite($fp, $linea);
    fwrite($fpe, $linea);
    $parametrosAFicheroCnt=(string)count($parametros);
    $parametrosAFicheroNum="";
    $parametrosAFicheroVal="";
    $linea=" ";
    foreach($parametros as $id => $val)
    {
	$parametrosAFicheroNum=$parametrosAFicheroNum . " " . $id  ;
	$parametrosAFicheroVal=$parametrosAFicheroVal . " " . $val ;
	$linea=$linea . " " . dameNombreParametro($model, $id);
    }
    fwrite($fp, $parametrosAFicheroCnt . $parametrosAFicheroNum . $parametrosAFicheroVal . "\n");
    fwrite($fpe,$parametrosAFicheroCnt . $linea                 . $parametrosAFicheroVal . "\n");



    $linea="#STEP\n";
    fwrite($fp, $linea);
    fwrite($fpe,$linea);
    fwrite($fp, $stepStart . " " . $stepEnd . " " . $stepIncrement .  "\n");
    fwrite($fpe,$stepStart . " " . $stepEnd . " " . $stepIncrement .  "\n");


    $linea="#STIMULUS\n";
    fwrite($fp, $linea);
    fwrite($fpe,$linea);
    $linea=(string)count($stimulusArray) . "\n";
    fwrite($fp, $linea);
    fwrite($fpe,$linea);
    foreach($stimulusArray as $id => $objStim)
    {
	    $linea=$objStim->stimStart . " " . $objStim->stimBcl . " " . $objStim->stimDur . " " . $objStim->stimCur . "\n";
	    fwrite($fp, $linea);
	    fwrite($fpe,$linea);
    }

    $linea="#POST\n";
    fwrite($fp, $linea);
    fwrite($fpe,$linea);
    $linea=$postFirst . " " . $postFrec . "\n";
    fwrite($fp, $linea);
    fwrite($fpe,$linea);

    $linea="#FILE_PARAMETERS\n";
    fwrite($fp, $linea);
    fwrite($fpe,$linea);
    $linea=(string)count($paraSaveArray);
    fwrite($fp, $linea);
    fwrite($fpe,$linea);
    //$paramForSave='';
    $linea="";
    foreach($paraSaveArray as $id => $value)
    {
	    $paramForSave = $paramForSave . " " . $value;
	    $linea=$linea . " " . dameNombreVariable($model, $value);
    }
    fwrite($fp, $paramForSave . "\n");
    fwrite($fpe,$linea        . "\n");

    $linea="#FILE_CURRENTS\n";
    fwrite($fp, $linea);
    fwrite($fpe,$linea);
    if(count($curSaveArray) == 0)
    {
	    $linea="0" . "\n";
	    fwrite($fp, $linea);//Fichero vacio
	    $linea="NO CURRENTS" . "\n";
	    fwrite($fpe,$linea);//Fichero vacio
    }
    else
    {
	    $linea=(string)count($curSaveArray);
	    fwrite($fp, $linea);
	    fwrite($fpe,$linea);
	    //$curForSave='';
	    $linea="";
	    foreach($curSaveArray as $id => $value)
	    {
		    $curForSave = $curForSave . " " . $value;
		    $linea=$linea . " " . dameNombreCorriente($model, $id);
	    }
	    fwrite($fp, $curForSave . "\n");
	    fwrite($fpe,$linea      . "\n");
    }


    fwrite($fp, "#END\n");
///////////////////////////////
////END   CREATE FILE  ////////
///////////////////////////////
///////////////////////////////
////INI RUN EXTERNAL PROGRAM///
///////////////////////////////
$salida=shell_exec('ls -l ../../bin/lanza.sh >> /tmp/php.out 2>>/tmp/php.out ');
$salida=shell_exec('echo ../../bin/lanza.sh ' . $user->id . '  >> /tmp/php.out  2>>/tmp/php.out');
$salida=shell_exec('../../bin/lanza.sh' . " " .  $user->id . " \"" . $_REQUEST["friendlyName"] . "\"");
///////////////////////////////
////END RUN EXTERNAL PROGRAM///
///////////////////////////////
    flock($fp, LOCK_UN); // release the lock
} else {
    row2("", "Server Busy. Try it again in some minutes" );
    row2("", "Lock file  /tmp/newTask.txt in use!!! :-?  " ); 
}
fclose($fp);

}
// END LOOP : BURST TASK GENERATION
row1("TASK CREATION OK",'9');
row2("", " New task creation ok.");
row2("", " Please check <a href=\"emListTaskForm.php\">". "Check Created Task" ."</a>"." and refesh if needed to see active ones. ");
} // END INSERT TASK

end_table();
echo "<td>
<a href=\"emListTaskForm.php\">". "Check Created Task" ."</a>
<a href=\"home.php\">". "Back Home " ."</a>
</td>
";
page_tail();
?>

</body>
</html>
