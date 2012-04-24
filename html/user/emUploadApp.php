<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");


db_init();
$user = get_logged_in_user();

page_head(tra("Upload New App Version"));
echo " <script src=\"http://code.jquery.com/jquery-latest.js\"></script> " ;
echo "
  <style>
  </style>

<script> 


</script>";
echo "<form action=\"emUpload_file.php\" method=\"post\" enctype=\"multipart/form-data\">";
echo form_tokens($user->authenticator);
start_table();
row2(tra("NEW APPLICATION BINARY %1 Browse to select. %2", "<br><span class=note>", "</span>"),
    "<label for=\"file\">Filename:</label>"
);

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
page_tail();
?>
