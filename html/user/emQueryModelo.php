<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");


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
