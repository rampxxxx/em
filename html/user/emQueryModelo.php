<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");
require_once("../inc/utilidades.inc");


db_init();
$user = get_logged_in_user();

page_head(tra("Simulation Model Creation/Deletion"));
echo " <script src=\"http://code.jquery.com/jquery-latest.js\"></script> " ;
echo "
  <style>
  </style>

<script> 


</script>";
echo "<form method=get action=emLanzaFormModelo.php>";
echo form_tokens($user->authenticator);
start_table();
row1("List of Actual Models ", '9');
echo "<tr><td>Model ID</td>";
echo "<td width=\"15\">" . "Model Name     " . "</td>\n";
echo "</tr>";
row1("", '9');

$models = get_mysql_model("SELECT modelo_id, nombre FROM modelo order by modelo_id ASC ");
foreach($models as $model) {
	$model_id = $model["modelo_id"];
	$model_name = $model["nombre"];
		echo "<tr><td>" . $model_id . "</td>";
		echo "<td>" . $model_name . "</td>";
		echo " </tr>";
}
row2(tra("MODEL NUMBER %1 to Create OR Delete %2", "<br><span class=note>", "</span>"),
    "<input name=modelNumber type=text size=10 >"
);

row2("", "<input type=submit value='Go!'>");
end_table();
echo "</form>\n";
echo "<label for=\"tra\" id=\"tra\">Traza</label>";
echo "<td>
<a href=\"emLanzaForm.php\">". "Create Task" ."</a>
<a href=\"home.php\">". "Back Home " ."</a>
</td>
";
page_tail();
?>
