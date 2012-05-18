<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");
require_once("../inc/utilidades.inc");


#############################
### FIN : DATA      SELECT
#############################

#############################
### INI : FUNCTIONS SELECT
#############################
const DEFINE_ISQUEMIC_ZONE = 'Isquemic Zone';
function print_model_select() {
	$modelos = get_mysql_model("SELECT modelo_id, nombre FROM modelo  order by modelo_id asc ");
	foreach($modelos as $modelo)
	{
		$modelo_id = $modelo["modelo_id"];
		$nombre = $modelo["nombre"];
		echo "<option value=\"$modelo_id\" >$nombre</option>\n";
	}
	echo "<option value=\"99\" selected>None Yet</option>\n";

} 

#############################
### FIN : FUNCTIONS SELECT
#############################


db_init();
$user = get_logged_in_user();

page_head(tra("Simulation Workunit Creation"));
echo " <script src=\"http://code.jquery.com/jquery-latest.js\"></script> " ;
echo "
  <style>
  parametro { color:blue; margin:5px; cursor:pointer; }
  parametro:hover { background:green; }
  burst { color:blue; margin:5px; cursor:pointer; }
  burst:hover { background:green; }
  stimulus { color:blue; margin:5px; cursor:pointer; }
  stimulus:hover { background:green; }
  fileParameters { color:blue; margin:5px; cursor:pointer; }
  fileParameters:hover { background:green; }
  allFileParameters { color:blue; margin:5px; cursor:pointer; }
  allFileParameters:hover { background:green; }
  fileCurrents { color:blue; margin:5px; cursor:pointer; }
  fileCurrents:hover { background:green; }
  allFileCurrents { color:blue; margin:5px; cursor:pointer; }
  allFileCurrents:hover { background:green; }
  </style>

<script> 
////////////////////////////////////////////////////
///   Declaracion, inicializacion de variables /////
////////////////////////////////////////////////////
var params;
var paramsSave;
var currents;
var numeroStim = 9;
var numeroParameter = 1;
var numeroParSave = 1;
var numeroCurSave = 1;
////////////////////////////////////////////////////
///   Añade input de Stimulus                  /////
////////////////////////////////////////////////////
function addStim()
{
//document.getElementById('tra').innerHTML = 'addRowTable!! '; 

var elementoSimple = 'z'+numeroStim;
var elementoComplejo = 'zs'+numeroStim;
var code = '<script>$(\"' + elementoSimple + '\").click(function(){\$(\"' + elementoComplejo + '\").remove();});</scr'+'ipt>' + '<style>' + elementoSimple + ':hover { background:red; } ' + elementoSimple + ' { color:blue; margin:5px; cursor:pointer; } ' + '</style>';

$(\"st\").append('<' + elementoComplejo + '>' + code +  'Start<input name=stimStart' + numeroStim + ' type=text size=5 >BCL<input name=stimBcl' + numeroStim + ' type=text size=5 >Duration<input name=stimDur' + numeroStim + ' type=text size=5 >Current<input name=stimCur' + numeroStim + ' type=text size=5 >' + '<' + elementoSimple + '>X'+ '</' + elementoSimple+'>' + '<br> ' + '</'+elementoComplejo+'>' ); 
numeroStim+=1;
}
////////////////////////////////////////////////////
///   Monta append Parametros a Disco        /////
////////////////////////////////////////////////////
function montaAppendParSave(restoSelect, numero)
{
var elementoSimple = 'v'+numero;
var elementoComplejo = 'vs'+numero;
var code = '<script>$(\"' + elementoSimple + '\").click(function(){\$(\"' + elementoComplejo + '\").remove();});</scr'+'ipt>' + '<style>' + elementoSimple + ':hover { background:red; } ' + elementoSimple + ' { color:blue; margin:5px; cursor:pointer; } ' + '</style>';



$(\"ss\").append('<'+ elementoComplejo + '>' + code +  ' <select name=parSave' + numero + ' > ' + restoSelect + '</select> '+ '<' + elementoSimple + '>X</'+ elementoSimple + '>' + ' <br> ' + '</' + elementoComplejo + '>' ); 
}
////////////////////////////////////////////////////
///   Monta select Parametros a Disco        /////
////////////////////////////////////////////////////
function montaAppendSelParSave(index)
{
var sel='';
var ii=0;
for(var i=0;i<paramsSave.length;i++)
{
	ii=i+1;
//	document.getElementById('tra').innerHTML += ' selected  ' + index + ' i ' + i + ' ii ' + ii;
	if(i==index)
	{
	//document.getElementById('tra').innerHTML += ' BINGO!';
		sel+='<option value=' + ii + ' selected >' + paramsSave[i] + '</option>';
	}
	else
	{
//	document.getElementById('tra').innerHTML += ' OPS!';
		sel+='<option value=' + ii + ' >' + paramsSave[i] + '</option>';
	}
}
return sel;
}
////////////////////////////////////////////////////
///   Monta select Parametros a Disco        /////
////////////////////////////////////////////////////
function montaSelParSave()
{
var sel='';
var ii=0;
for(var i=0;i<paramsSave.length;i++)
{
	ii=i+1;
//	document.getElementById('tra').innerHTML += ' params text !! ' + paramsSave[i]; 
	sel+='<option value=' + ii + ' >' + paramsSave[i] + '</option>';
}
return sel;
}
////////////////////////////////////////////////////
///   Añade select de ParSave                /////
////////////////////////////////////////////////////
function addParSave()
{
//document.getElementById('tra').innerHTML = 'addParSaveTable!! '; 

var restoSelect='';
restoSelect=montaSelParSave();

montaAppendParSave(restoSelect, numeroParSave);
numeroParSave+=1;

}
////////////////////////////////////////////////////
///   Añade select de ParSave                /////
////////////////////////////////////////////////////
function addAllParSave()
{
//document.getElementById('tra').innerHTML = 'addParSaveTable!! '; 

var restoSelect='';
for(var i=0;i<paramsSave.length;i++)
{
//document.getElementById('tra').innerHTML = 'numeroParSave ==  ' + numeroParSave; 
	restoSelect=montaAppendSelParSave(i);
	montaAppendParSave(restoSelect, numeroParSave);
	numeroParSave+=1;
}

}
////////////////////////////////////////////////////
///   Monta append Corrientes a Disco        /////
////////////////////////////////////////////////////
function montaAppendCurSave(restoSelect, numero)
{
var elementoSimple = 'w'+numero;
var elementoComplejo = 'ws'+numero;
var code = '<script>$(\"' + elementoSimple + '\").click(function(){\$(\"' + elementoComplejo + '\").remove();});</scr'+'ipt>' + '<style>' + elementoSimple + ':hover { background:red; } ' + elementoSimple + ' { color:blue; margin:5px; cursor:pointer; } ' + '</style>';



$(\"sc\").append('<'+ elementoComplejo + '>' + code +  ' <select name=curSave' + numero + ' > ' + restoSelect + '</select> '+ '<' + elementoSimple + '>X</'+ elementoSimple + '>' + ' <br> ' + '</' + elementoComplejo + '>' ); 
}
////////////////////////////////////////////////////
///   Monta select Corrientes a Disco        /////
////////////////////////////////////////////////////
function montaAppendSelCurSave(index)
{
var sel='';
var ii=0;
for(var i=0;i<currents.length;i++)
{
	ii=i+1;
//	document.getElementById('tra').innerHTML += ' selected  ' + index + ' i ' + i + ' ii ' + ii;
	if(i==index)
	{
//	document.getElementById('tra').innerHTML += ' BINGO!';
		sel+='<option value=' + ii + ' selected >' + currents[i] + '</option>';
	}
	else
	{
//	document.getElementById('tra').innerHTML += ' OPS!';
		sel+='<option value=' + ii + ' >' + currents[i] + '</option>';
	}
}
return sel;
}
////////////////////////////////////////////////////
///   Monta select Parametros a Disco        /////
////////////////////////////////////////////////////
function montaSelCurSave()
{
var sel='';
var ii=0;
for(var i=0;i<currents.length;i++)
{
	ii=i+1;
//	document.getElementById('tra').innerHTML += ' current text !! ' + currents[i]; 
	sel+='<option value=' + ii + ' >' + currents[i] + '</option>';
}
return sel;
}
////////////////////////////////////////////////////
///   Añade select de CurSave                /////
////////////////////////////////////////////////////
function addCurSave()
{
//document.getElementById('tra').innerHTML = 'addCurSaveTable!! '; 

var restoSelect='';
var ii=0;
if(currents.length!=0){
	restoSelect=montaSelCurSave();
//document.getElementById('tra').innerHTML += 'Tras el for , antes de append del select'; 

montaAppendCurSave(restoSelect, numeroCurSave);
//document.getElementById('tra').innerHTML += 'Despues de append'; 
numeroCurSave+=1;
}
else
{
//	document.getElementById('tra').innerHTML = '!!NO TIENE CORRIENTES QUE GUARDAR!!! '; 
}


}
////////////////////////////////////////////////////
///   Añade todas las corrientes             /////
////////////////////////////////////////////////////
function addAllCurSave()
{
//document.getElementById('tra').innerHTML = 'addParSaveTable!! '; 

var restoSelect='';
if(currents.length!=0){
for(var i=0;i<currents.length;i++)
{
//document.getElementById('tra').innerHTML = 'numeroCurSave ==  ' + numeroCurSave; 
	restoSelect=montaAppendSelCurSave(i);
	montaAppendCurSave(restoSelect, numeroCurSave);
	numeroCurSave+=1;
}
}
else
{
//	document.getElementById('tra').innerHTML = '!!NO TIENE CORRIENTES QUE GUARDAR!!! '; 
}
}
////////////////////////////////////////////////////
///   Añade select de Parameter                /////
////////////////////////////////////////////////////
function addParameterTable()
{
//document.getElementById('tra').innerHTML = 'addParameterTable!!=> '; 
//document.getElementById('tra').innerHTML = params.length; 

var restoSelect='';
var ii=0;
for(var i=0;i<params.length;i++)
{
	ii=i+1;
//	document.getElementById('tra').innerHTML += ' params text !! ' + params[i]; 
	restoSelect+='<option value=' + ii + ' >' + params[i] + '</option>';
}


var code = '<script>$(\"x' + numeroParameter + '\").click(function(){\$(\"' + 'xs' + numeroParameter + '\").remove();});</scr'+'ipt>' + '<style>' + 'x' + numeroParameter + ':hover { background:red; } ' + 'x' + numeroParameter + ' { color:blue; margin:5px; cursor:pointer; } ' + '</style>';

$(\"sp\").append( '<xs' + numeroParameter + '>' +  code + '<select name=parameterSelect' + numeroParameter + '>' + restoSelect + '</select><input name=parameterInput' + numeroParameter + ' type=text size=30 >' +  '<x' + numeroParameter + '>X  </x' + numeroParameter + '>'       + '<br>' +  '</xs' + numeroParameter + '>'  ); 

numeroParameter+=1;

}
////////////////////////////////////////////////////
///   Añade select de Burst                /////
////////////////////////////////////////////////////
function addBurst()
{
//document.getElementById('tra').innerHTML = 'addBurst!! '; 
deleteBurst();
var restoSelect='';
var ii=0;
for(var i=0;i<params.length;i++)
{
	ii=i+1;
//	document.getElementById('tra').innerHTML += ' params text !! ' + params[i]; 
	restoSelect+='<option value=' + ii + ' >' + params[i] + '</option>';
}

//	document.getElementById('tra').innerHTML += ' continuo ...';

var elemento = 'y' ;
var code = '<script>$(\"' + elemento + '\").click(function(){\$(\"' + 'ys' + '\").remove();});</scr'+'ipt>' + '<style>' + elemento + ':hover { background:red; } ' + elemento + ' { color:blue; margin:5px; cursor:pointer; } ' + '</style>';

//	document.getElementById('tra').innerHTML += ' mas ...';
$(\"sb\").append('<ys' + '>' + code + ' <select name=burstSelect > ' + restoSelect + '</select>Start<input name=burstStart type=text size=5 >End<input name=burstEnd type=text size=5 >Gap<input name=burstGap type=text size=5 > ' +  '<' + elemento + '>X  </' + elemento + '>    <br> </ys' + '>' ); 

//	document.getElementById('tra').innerHTML += ' fin ...';
numeroBurst+=1;

}
////////////////////////////////////////////////////
///   Inicializa contador de id select Parameter ///
////////////////////////////////////////////////////
function inicializaNumeroParameter()
{
numeroParameter=1;
}
////////////////////////////////////////////////////
///   Inicializa contador de id select ParSave ///
////////////////////////////////////////////////////
function inicializaNumeroParSave()
{
numeroParSave=1;
}
////////////////////////////////////////////////////
///   Inicializa contador de id select CurSave ///
////////////////////////////////////////////////////
function inicializaNumeroCurSave()
{
numeroCurSave=1;
}
////////////////////////////////////////////////////
///   Inicializa contador de id Stim ///
////////////////////////////////////////////////////
function inicializaNumeroStim()
{
numeroStim=9;
}
/////////////////////////////////
// Delete new Parameter 'select'.
/////////////////////////////////
function deleteParameterTable()
{
//	document.getElementById('tra').innerHTML = ' Borrando campos. numeroParameter ' + numeroParameter; 

for(var i = 1; i<= numeroParameter;i++)
{
//	document.getElementById('tra').innerHTML += ' xs' + i ; 
$('xs'+i).remove();
}

inicializaNumeroParameter();
}
/////////////////////////////////
// Delete new Burst 'select'.
/////////////////////////////////
function deleteBurst()
{

$('ys').remove();

}
/////////////////////////////////
// Delete new ParSave 'select'.
/////////////////////////////////
function deleteParSave()
{

for(var i = 1; i<= numeroParSave;i++)
{
$('vs'+i).remove();
}

inicializaNumeroParSave();
}
/////////////////////////////////
// Delete new CurSave 'select'.
/////////////////////////////////
function deleteCurSave()
{
$(\"scc\").remove();

for(var i = 1; i<= numeroCurSave;i++)
{
$('ws'+i).remove();
}

inicializaNumeroCurSave();
}
/////////////////////////////////
// Delete new Parameter 'select'.
/////////////////////////////////
function deleteStim()
{
inicializaNumeroStim();
$(\"stt\").remove();
}
";
echo "
/////////////////////////////////
// Get a reference to array.
/////////////////////////////////
function populate(o)
{
	deleteParameterTable();//delete previous params.
	deleteBurst();
	deleteParSave();
	deleteCurSave();
	numeroParameter=1;
	//d=document.getElementById('de');
//	document.getElementById('tra').innerHTML += 'dentro!! '; 
	//if(!d){return;}			
//	document.getElementById('tra').innerHTML += 'd existe!! '; 
	var parSave=new Array();
	var parData=new Array();
";

$modelos = get_mysql_model("SELECT modelo_id , nombre FROM modelo  order by modelo_id asc ");
foreach($modelos as $modelo)
{// Array .
	$modelo_id=$modelo["modelo_id"];
	$modelo_nombre=$modelo["nombre"];
	echo "parData['".$modelo_nombre."']=[";
	$modelo_parametro = get_mysql_model_param("SELECT p.nombre FROM modelo m, modelo_parametro p  WHERE m.modelo_id=".$modelo_id."  AND p.modelo_id=m.modelo_id ORDER BY p.parametro_id asc ");
	$haySiguiente=false;
	foreach($modelo_parametro as $param)
	{ // Array data.
		if($haySiguiente==true){
			echo ",";
		}
		else
		{
			$haySiguiente=true;
		}
		$parametro_nombre = $param["nombre"];
		echo "'".$parametro_nombre."'";
		//parData['Ischemic Zone']=['v1','v2','G'];

	}
	echo "];";
}

$modelos = get_mysql_model("SELECT modelo_id , nombre FROM modelo  order by modelo_id asc ");
foreach($modelos as $modelo)
{// Array .
	$modelo_id=$modelo["modelo_id"];
	$modelo_nombre=$modelo["nombre"];
	echo "parSave['".$modelo_nombre."']=[";
	$modelo_parametro = get_mysql_model_param("SELECT p.nombre FROM modelo m, modelo_variable p  WHERE m.modelo_id=".$modelo_id."  AND p.modelo_id=m.modelo_id ORDER BY p.variable_id asc ");
	$haySiguiente=false;
	foreach($modelo_parametro as $param)
	{ // Array data.
		if($haySiguiente==true){
			echo ",";
		}
		else
		{
			$haySiguiente=true;
		}
		$parametro_nombre = $param["nombre"];
		echo "'".$parametro_nombre."'";
		//parData['Ischemic Zone']=['v1','v2','G'];

	}
	echo "];";
}
echo"
//	document.getElementById('tra').innerHTML += ' array de datos '; 


	var parCurr=new Array();
";

$modelos = get_mysql_model("SELECT modelo_id , nombre FROM modelo  order by modelo_id asc ");
foreach($modelos as $modelo)
{// Array .
	$modelo_id=$modelo["modelo_id"];
	$modelo_nombre=$modelo["nombre"];
	echo "parCurr['".$modelo_nombre."']=[";
	$modelo_corriente = get_mysql_model_current("SELECT p.nombre FROM modelo m, modelo_corriente p  WHERE m.modelo_id=".$modelo_id." AND m.modelo_id=p.modelo_id order by p.corriente_id asc ");
	$haySiguiente=false;
	foreach($modelo_corriente as $current)
	{ // Array data.
		if($haySiguiente==true){
			echo ",";
		}
		else
		{
			$haySiguiente=true;
		}
		$corriente_nombre = $current["nombre"];
		echo "'".$corriente_nombre."'";
		//parData['Ischemic Zone']=['v1','v2','G'];

	}
	echo "];";
}





echo"
params=parData[o.options[o.selectedIndex].text];
paramsSave=parSave[o.options[o.selectedIndex].text];
currents=parCurr[o.options[o.selectedIndex].text];
//	document.getElementById('tra').innerHTML += ' indice ' + o.selectedIndex + ' valor ' + o.options[o.selectedIndex].value + ' text ' + o.options[o.selectedIndex].text ; 
//	document.getElementById('tra').innerHTML += ' Current size=>' + currents.length;
//	document.getElementById('tra').innerHTML += ' Params size=>' + params.length;
}


</script>";
echo "<form method=get action=emLanzaEjecucion.php>";
echo form_tokens($user->authenticator);
start_table();
row2(tra("ALIAS %1 Friendly name %2", "<br><span class=note>", "</span>"),
    "<input name=friendlyName type=text size=40 >"
);
row2_init(tra("#MODEL"),
    "<select name=model  onchange=\"populate(this)\">"
);
print_model_select();
echo "</select></td></tr>\n";
row2(tra("<parametro> ADD PARAMETERS </parametro> %1 Allow adding value to selected params  %2 ", "<br><span class=note>", "</span>"),
    "<sp > </sp> 

    <script>
    $(\"parametro\").click(function () {
addParameterTable();
});
    </script>"

);
row2(tra("<burst>BURST</burst> %1 It allows create a sort of tasks by telling star,end and gap%2", "<br><span class=note>", "</span>"),
    "<sb > </sb> 

    <script>
    $(\"burst\").click(function () {
addBurst();
});
    </script>"

);
row2(tra("#STEP %1 Defines total simulation time and time increment (time in msec)%2", "<br><span class=note>", "</span>"),
    "Simulation initiation at<input name=stepStart type=text size=10 >ending at<input name=stepEnd type=text size=10>Increment <input name=stepIncrement type=text size=10>"
);
row2(tra("<stimulus>#STIMULUS</stimulus> %1 Defines the stimulation protocol %2", "<br><span class=note>", "</span>"),
    "<st > </st> 

    <script>
    $(\"stimulus\").click(function () {
addStim();
});
    </script>"

);
row2(tra("#POST %1 Defines the output frequency and the first iteration at which data is saved %2", "<br><span class=note>", "</span>"),
    "First iteration saved is <input name=postFirst type=text size=10 >Saving frecuency <input name=postFrec type=text size=10 >"
);
row2(tra("<fileParameters>#FILE_PARAMETERS</fileParameters>%1 <allFileParameters>ADD ALL PARAMETERS TO DISK</allFileParameters> <br> Parameter that will be saved to file results.%2", "<br><span class=note>", "</span>"),
    "<ss> </ss>
    <script>
    $(\"fileParameters\").click(function () {
addParSave();
});
    $(\"allFileParameters\").click(function () {
addAllParSave();
});
    </script>"

);
row2(tra("<fileCurrents>#FILE_CURRENTS</fileCurrents> %1 <allFileCurrents>ADD ALL CURRENTS</allFileCurrents> <br> Currents that will be saved to file results.%2", "<br><span class=note>", "</span>"),
    "<sc> </sc>
    <script>
    $(\"fileCurrents\").click(function () {
addCurSave();
});
    $(\"allFileCurrents\").click(function () {
addAllCurSave();
});
    </script>"

);

row2("", "<input type=submit value='Go!'>");
end_table();
echo "</form>\n";
echo "<label for=\"tra\" id=\"tra\"></label>";
echo "<td>
<a href=\"emListTaskForm.php\">". "Check Created Task" ."</a>
<a href=\"home.php\">". "Back Home " ."</a>
</td>
";
page_tail();
?>
