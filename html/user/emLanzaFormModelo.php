<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");
require_once("../inc/utilidades.inc");

#############################
### INI : DATA      SELECT
#############################

#############################
### FIN : DATA      SELECT
#############################

#############################
### INI : FUNCTIONS SELECT
#############################

#############################
### FIN : FUNCTIONS SELECT
#############################


db_init();
$user = get_logged_in_user();

foreach($_REQUEST as $name => $value)
{
        if(stristr($name, 'modelNumber') != FALSE)
        {
                $errorEnDatos=compruebaInt($name, $value);
                $modelNumber=$value;
}

}

if($errorEnDatos==false){

$models = get_mysql_model("SELECT modelo_id, nombre FROM modelo  WHERE modelo_id=" . $modelNumber . " order by modelo_id asc ");
foreach($models as $modelo) 
{
        $modelo_id = $modelo["modelo_id"];
        $nombre = $modelo["nombre"];
}


if($modelo_id==$modelNumber)
{ // Borrar el modelo existente.


page_head(tra("Simulation Model Deletion"));

echo "<form method=get action=emLanzaDeleteModelo.php>";
echo form_tokens($user->authenticator);
start_table();
row1("Model EXISTS! ", '9');
echo "<tr><td width=\"15\">Model ID</td>";
echo "<td width=\"15\">" . "Name          " . "</td>\n";
echo "</tr>";

if($modelo_id=="")
{
	$models = get_mysql_model("SELECT modelo_id, nombre FROM modelo  order by modelo_id asc ");
	foreach($models as $modelo) 
	{
		$nombre = $modelo["nombre"];
		echo "<tr>";
		echo "<td>";
		echo $modelo["modelo_id"];
		echo "</td>";
		echo "<td>";
		echo $modelo["nombre"];
		echo "</td>";
		echo "</tr>";
	}

}
else
{
echo "<tr>";
echo "<td>";
echo $modelo_id ;
echo "</td>";
echo "<td>";
echo $nombre;
echo "</td>";
echo "</tr>";
echo "<input type=\"hidden\"  name=". $nombre . " value=" . $modelo_id . " />";
echo "<td><input type=\"submit\" value=\"Delete!\"></form></td>";
}
end_table();
echo "<label for=\"tra\" id=\"tra\">Traza</label>";

}
else
{ //Crear un nuevo modelo
page_head(tra("Simulation Model Creation"));
echo " <script src=\"http://code.jquery.com/jquery-latest.js\"></script> " ;
echo "
  <style>
  parametro { color:blue; margin:5px; cursor:pointer; }
  parametro:hover { background:green; }
  parametroDel { color:blue; margin:5px; cursor:pointer; }
  parametroDel:hover { background:red; }
  corriente { color:blue; margin:5px; cursor:pointer; }
  corriente:hover { background:green; }
  corrienteDel { color:blue; margin:5px; cursor:pointer; }
  corrienteDel:hover { background:red; }
  variable { color:blue; margin:5px; cursor:pointer; }
  variable:hover { background:green; }
  variableDel { color:blue; margin:5px; cursor:pointer; }
  variableDel:hover { background:red; }
  </style>

<script> 
////////////////////////////////////////////////////
///   Declaracion, inicializacion de variables /////
////////////////////////////////////////////////////
numeroParameter=1;
numeroCorriente=1;
numeroVariable=1;
////////////////////////////////////////////////////
///   Añade Model Modificable Parameter        /////
////////////////////////////////////////////////////
function addModificableParameter()
{
document.getElementById('tra').innerHTML = 'addRowTable!! '; 
var elementoSimple = 'x'+numeroParameter;
var elementoComplejo = 'xs'+numeroParameter;
var code = '<script>$(\"' + elementoSimple + '\").click(function(){\$(\"' + elementoComplejo + '\").remove();});</scr'+'ipt>' + '<style>' + elementoSimple + ':hover { background:red; } ' + elementoSimple + ' { color:blue; margin:5px; cursor:pointer; } ' + '</style>';

$(\"sp\").append('<' + elementoComplejo + '>' + ' ' + numeroParameter +  '<input name=parameter' + numeroParameter + ' type=text size=5 >' + '<' + elementoSimple + '>'+ '</' + elementoSimple+'>' + '<br> ' + '</'+elementoComplejo+'>' ); 
numeroParameter+=1;
}
////////////////////////////////////////////////////
///   Borra Model Modificable Parameter        /////
////////////////////////////////////////////////////
function delModificableParameter()
{
document.getElementById('tra').innerHTML = 'addRowTable!! '; 
for(var i = 1; i<= numeroParameter;i++)
{
	$('xs'+i).remove();
}


numeroParameter=1;
}
////////////////////////////////////////////////////
///   Añade Model Modificable Variable        /////
////////////////////////////////////////////////////
function addVariable()
{
document.getElementById('tra').innerHTML = 'addRowTable!! '; 
var elementoSimple = 'z'+numeroVariable;
var elementoComplejo = 'zs'+numeroVariable;
var code = '<script>$(\"' + elementoSimple + '\").click(function(){\$(\"' + elementoComplejo + '\").remove();});</scr'+'ipt>' + '<style>' + elementoSimple + ':hover { background:red; } ' + elementoSimple + ' { color:blue; margin:5px; cursor:pointer; } ' + '</style>';

$(\"sv\").append('<' + elementoComplejo + '>' + ' ' + numeroVariable +  '<input name=variable' + numeroVariable + ' type=text size=5 >' + '<' + elementoSimple + '>'+ '</' + elementoSimple+'>' + '<br> ' + '</'+elementoComplejo+'>' ); 
numeroVariable+=1;
}
////////////////////////////////////////////////////
///   Borra Model Modificable Variable        /////
////////////////////////////////////////////////////
function delVariable()
{
for(var i = 1; i<= numeroVariable;i++)
{
	$('zs'+i).remove();
}


numeroVariable=1;
}

////////////////////////////////////////////////////
///   Añade Model Currents                     /////
////////////////////////////////////////////////////
function addCurrents()
{
document.getElementById('tra').innerHTML = 'addRowTable!! '; 
var elementoSimple = 'y'+numeroCorriente;
var elementoComplejo = 'ys'+numeroCorriente;
var code = '<script>$(\"' + elementoSimple + '\").click(function(){\$(\"' + elementoComplejo + '\").remove();});</scr'+'ipt>' + '<style>' + elementoSimple + ':hover { background:red; } ' + elementoSimple + ' { color:blue; margin:5px; cursor:pointer; } ' + '</style>';

$(\"sc\").append('<' + elementoComplejo + '>' + ' ' + numeroCorriente + '<input name=current' + numeroCorriente + ' type=text size=5 >' + '<' + elementoSimple + '>'+ '</' + elementoSimple+'>' + '<br> ' + '</'+elementoComplejo+'>' ); 
numeroCorriente+=1;
}
////////////////////////////////////////////////////
///   Borra Model Modificable Corriente        /////
////////////////////////////////////////////////////
function delCurrents()
{
for(var i = 1; i<= numeroCorriente;i++)
{
	$('ys'+i).remove();
}


numeroCorriente=1;
}



</script>";
echo form_tokens($user->authenticator);
echo "<form method=get action=emLanzaInsertModelo.php>";
start_table();
row2(tra(" MODEL ID %1 Unique ID as used in simulation program(fortran)  %2 ", "<br><span class=note>", "</span>"),
$modelNumber);
row2(tra("MODEL NAME %1 Friendly name %2", "<br><span class=note>", "</span>"),
    "<input name=modelName type=text size=40 >"
);  
row2(tra("<parametro> ADD PARAMETERS </parametro> %1 Allow adding modificable parameters to the model %2 <br> <parametroDel> DELETE ALL PARAMETERS </parametroDel> ", "<br><span class=note>", "</span>"),
    "<sp > </sp> 

    <script>
    $(\"parametro\").click(function () {
addModificableParameter();
});
    $(\"parametroDel\").click(function () {
delModificableParameter();
});
    </script>"

);
row2(tra("<variable> ADD VARIABLES </variable> %1 Allow adding variables to the model %2 <br>  <variableDel> DELETE ALL VARIABLES </variableDel> ", "<br><span class=note>", "</span>"),
    "<sv > </sv> 

    <script>
    $(\"variable\").click(function () {
addVariable();
});
    $(\"variableDel\").click(function () {
delVariable();
});
    </script>"

);
row2(tra("<corriente> ADD CURRENTS </corriente> %1 Allow adding file saving currents to the model %2  <br>  <corrienteDel> DELETE ALL CURRENTS </corrienteDel>", "<br><span class=note>", "</span>"),
    "<sc > </sc> 

    <script>
    $(\"corriente\").click(function () {
addCurrents();
});
    $(\"corrienteDel\").click(function () {
delCurrents();
});
    </script>"

);
end_table();
echo "<input type=\"hidden\"  name=modelNumber value=" . $modelNumber . " />";
echo "<td><input type=\"submit\" value=\"Insert!\"></form></td>";
echo "<label for=\"tra\" id=\"tra\">Traza</label>";
}
}
echo "<td>
<a href=\"emListTaskForm.php\">". "Check Created Task" ."</a>
<a href=\"home.php\">". "Back Home " ."</a>
</td>
";
page_tail();
?>
