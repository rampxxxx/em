<html>
<body>

<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");
function seccion($tok,$seccion)
{
$nombreSeccion="";
if(stristr($tok,'#') != FALSE)
{
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
////////////////////////////////////////
////////////////////////////////////////
////////////////////////////////////////

$size = (int) count($_REQUEST);


db_init();
$user = get_logged_in_user();


page_head(tra("Parameters "));
//start_table("align=\"center\"");
start_table();
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

	}
}
else
{
	$result=mysql_query("select parametersE from user_workunit where workunit_id = " . $workunit_id );
	while($row=mysql_fetch_array($result))
	{
		//echo "<tr><td> " . nl2br($row['parametersE']) . "</td>";
		$tok = strtok($row['parametersE'], " \n\t");
		$cntSeccion=0;
		$cntEstimulo=1;
		$camposSeccion=0;
		while ($tok !== false) {
			//echo "<tr><td>$tok HAHA</td></tr>";
			if(strcmp(($seccion=seccion($tok,$seccion)),"#MODEL")==0)
			{
				if(strcmp($seccion,$tok)==0)
				{
				}
				else
				{
				row2(tra("#MODEL %1  %2", "<br><span class=note>", "</span>"),$tok);
				}
			}
			else if(strcmp(($seccion=seccion($tok,$seccion)),"#PARAMETERS")==0)
			{
				if(strcmp($seccion,$tok)==0)
				{
					$cntSeccion=-1;
				}
				else
				{
					if($cntSeccion==-1){
						$cntSeccion=1;
						$camposSeccion=$tok;
					}else{
						if($cntSeccion<=$camposSeccion){
							$parametros[$cntSeccion++]=$tok;
						}else{
							$valParametros[$cntSeccion-$camposSeccion]=$tok;
							$cntSeccion++;
						}
					}
				}
			}
			else if(strcmp(($seccion=seccion($tok,$seccion)),"#STEP")==0)
			{
				if(strcmp($seccion,$tok)==0)
				{
					foreach($parametros as $key => $value){
						$elParametro=" ".$key.".- ".$value."(".$valParametros[$key].")";
						row2(tra("#PARAMETERS %1  %2", "<br><span class=note>", "</span>"),$elParametro);
					}
					$cntSeccion=1;
				}else{
					$step[$cntSeccion++]=$tok;
				}
			}
			else if(strcmp(($seccion=seccion($tok,$seccion)),"#STIMULUS")==0)
			{
				if(strcmp($seccion,$tok)==0)
				{
					foreach($step as $key => $value){
						if($key==1){
						$elStep="INI :(".$value.")";
						}else if($key==2){
						$elStep=$elStep." END :(".$value.")";
						}else if($key==3){
						$elStep=$elStep." INC :(".$value.")";
						}
					}
					row2(tra("#STEP %1 msec  %2", "<br><span class=note>", "</span>"),$elStep);
					$cntSeccion=-1;
				}
				else
				{
					if($cntSeccion==-1){
						$cntSeccion=1;
					}else{
					if($cntSeccion==1){
						$estimulo="START :(".$tok.")";
					}else if($cntSeccion==2){
						$estimulo=$estimulo." BCL :(".$tok.")";
					}else if($cntSeccion==3){
						$estimulo=$estimulo." DURA :(".$tok.")";
					}else if($cntSeccion==4){
						$estimulo=$estimulo." CURRNT :(".$tok.")";
						$estimulos[$cntEstimulo++]=$estimulo;
						$cntSeccion=0;
					}
					$cntSeccion++;
					}
				}
			}
			else if(strcmp(($seccion=seccion($tok,$seccion)),"#POST")==0)
			{
				if(strcmp($seccion,$tok)==0)
				{
					foreach($estimulos as $key => $value){
						row2(tra("#STIMULUS %1 msec  %2", "<br><span class=note>", "</span>"),$value);
					}
					$cntSeccion=1;
				} else{
					if($cntSeccion==1){
					$elPost=$elPost." START:(".$tok.")";
					$cntSeccion++;
					}else{
					$elPost=$elPost." NUM. INCRE.:(".$tok.")";
					}
				}
			}
			else if(strcmp(($seccion=seccion($tok,$seccion)),"#FILE_PARAMETERS")==0)
			{
				if(strcmp($seccion,$tok)==0)
				{
					row2(tra("#POST %1       %2", "<br><span class=note>", "</span>"),$elPost);
					$cntSeccion=1;
				} else{
					$fileParameters[$cntSeccion++]=$tok;
				}
			}
			else if(strcmp(($seccion=seccion($tok,$seccion)),"#FILE_CURRENTS")==0)
			{
				if(strcmp($seccion,$tok)==0)
				{
					foreach($fileParameters as $key => $value){
						if($key==1){
						row2(tra("Number of #FILE_PARAMETERS %1       %2", "<br><span class=note>", "</span>"),$value);
						}else{
						row2(tra("#FILE_PARAMETERS %1       %2", "<br><span class=note>", "</span>"),$value);
						}
					}
					$cntSeccion=1;
				} else{
					$fileCurrents[$cntSeccion++]=$tok;
				}
			}
			
			$tok = strtok(" \n\t");
		}

		foreach($fileCurrents as $key => $value){
			if($key==1){
				row2(tra("Number of #FILE_CURRENTS %1       %2", "<br><span class=note>", "</span>"),$value);
			}else{
				row2(tra("#FILE_CURRENTS %1       %2", "<br><span class=note>", "</span>"),$value);
			}
		}
		}	
}


end_table();
page_tail();


?>

</body>
</html>
