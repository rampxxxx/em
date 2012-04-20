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
  </style>

<script> 
////////////////////////////////////////////////////
///   Declaracion, inicializacion de variables /////
////////////////////////////////////////////////////
numeroParameter=1;
////////////////////////////////////////////////////
///   Añade Model Modificable Parameter        /////
////////////////////////////////////////////////////
function addModificableTable()
{
document.getElementById('tra').innerHTML = 'addRowTable!! '; 
var elementoSimple = 'x'+numeroParameter;
var elementoComplejo = 'xs'+numeroParameter;
var code = '<script>$(\"' + elementoSimple + '\").click(function(){\$(\"' + elementoComplejo + '\").remove();});</scr'+'ipt>' + '<style>' + elementoSimple + ':hover { background:red; } ' + elementoSimple + ' { color:blue; margin:5px; cursor:pointer; } ' + '</style>';

$(\"sp\").append('<' + elementoComplejo + '>' + code +  '<input name=parameter' + numeroParameter + ' type=text size=5 >' + '<' + elementoSimple + '>X'+ '</' + elementoSimple+'>' + '<br> ' + '</'+elementoComplejo+'>' ); 
numeroParameter+=1;
}


</script>";
start_table();
row2(tra(" MODEL ID %1 Unique ID as used in simulation program(fortran)  %2 ", "<br><span class=note>", "</span>"),
$modelNumber);
row2(tra("MODEL NAME %1 Friendly name %2", "<br><span class=note>", "</span>"),
    "<input name=modelName type=text size=40 >"
);  
row2(tra("<parametro> ADD PARAMETERS </parametro> %1 Allow adding modificable parameters to the model %2 ", "<br><span class=note>", "</span>"),
    "<sp > </sp> 

    <script>
    $(\"parametro\").click(function () {
addModificableTable();
});
    </script>"

);
end_table();
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
