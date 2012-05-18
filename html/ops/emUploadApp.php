<?php
require_once("../inc/db_ops.inc");
require_once("../inc/util_ops.inc");
require_once("../inc/countries.inc");
require_once("../inc/utilidades.inc");

db_init();


function print_plataformas() {
        $plataformas = get_mysql_model("SELECT name FROM platform   ");
        foreach($plataformas as $plataforma)
        {
                $nombre = $plataforma["name"];
		echo "<option value=\"$nombre\" >$nombre</option>\n";
        }

} 


admin_page_head(tra("Upload New App Version"));
echo " <script src=\"http://code.jquery.com/jquery-latest.js\"></script> " ;
echo "
  <style>
  </style>

<script> 


</script>";
echo "<form action=\"emUpload_file.php\" method=\"post\" enctype=\"multipart/form-data\">";
start_table();
row2(tra("NEW APPLICATION BINARY %1 Browse to select. %2", "<br><span class=note>", "</span>"),
    "<label for=\"file\">Filename:</label>"
);
row2_init(tra("PLATFORM %1 For which Operating System. %2", "<br><span class=note>", "</span>"),
"<select name=platform  >"
);
print_plataformas();
echo "</select></td></tr>\n";
row2("", "<input type=\"file\" name=\"file\" id=\"file\" /> ");
row2("", "<input type=\"submit\" name=\"submit\" value=\"Submit\" />");
end_table();
echo "</form>\n";
echo "<label for=\"tra\" id=\"tra\">Traza</label>";
echo "<td>
<a href=\"emLanzaForm.php\">". "Create Task" ."</a>
<a href=\"home.php\">". "Back Home " ."</a>
</td>
";
admin_page_tail();
?>
