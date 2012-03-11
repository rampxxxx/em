<?php
// This file is part of BOINC.
// http://boinc.berkeley.edu
// Copyright (C) 2008 University of California
//
// BOINC is free software; you can redistribute it and/or modify it
// under the terms of the GNU Lesser General Public License
// as published by the Free Software Foundation,
// either version 3 of the License, or (at your option) any later version.
//
// BOINC is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public License
// along with BOINC.  If not, see <http://www.gnu.org/licenses/>.
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");


db_init();
$user = get_logged_in_user();

page_head(tra("New Task Params"));
echo " <script src=\"http://code.jquery.com/jquery-latest.js\"></script> " ;
echo "<hola> Cadena </hola>";
echo "
<script> 
var numero = 9;
function addRowToTable()
{

$(\"st\").append(\" <tr><td width=40% class=fieldname>#STIMULUS <br><span class=note> Extra STIMULUS parameters </span></td><td class=fieldvalue><input name=stimulus\" + numero + \" type=text size=30 ></td></tr> \" ); 
numero+=1;
}


</script>";
/*

fprintf(f,"#MODEL\n");
fprintf(f,"18\n");
fprintf(f,"#PARAMETERS\n");
fprintf(f,"1 1 1.0\n");
fprintf(f,"#STEP\n");
fprintf(f,"0.0 0.001 7000.0\n");
fprintf(f,"#STIMULUS\n");
fprintf(f,"2\n");
fprintf(f,"0.0 500.0 2.0 15.5\n");
fprintf(f,"5000.0 600.0 2.0 15.5\n");
fprintf(f,"#POST\n");
fprintf(f,"0 250\n");
fprintf(f,"#END\n");
*/
echo "<form method=get action=emLanzaEjecucion.php>";
echo "<input type=\"button\" value=\"Add\" onclick=\"addRowToTable();\" />";
echo form_tokens($user->authenticator);
start_table();
row2(tra("#MODEL %1 Defines the model ID %2", "<br><span class=note>", "</span>"),
    "<input name=model type=text size=2 >"
);
row2(tra("#PARAMETERS %1 It is defining a mask values %2", "<br><span class=note>", "</span>"),
    "<input name=parameters type=text size=30 >"
);
row2(tra("#STEP %1 Defines total simulation time and time increment %2", "<br><span class=note>", "</span>"),
    "<input name=step type=text size=30 >"
);
row2(tra("#STIMULUS %1 Defines the stimulation protocol %2", "<br><span class=note>", "</span>"),
    "<input name=stimulus1 type=text size=30 > "
);
row2(tra("#STIMULUS %1 Defines the stimulation protocol %2", "<br><span class=note>", "</span>"),
    "<input name=stimulus2 type=text size=30 ><st> </st>"
);
row2(tra("#POST %1 Defines the output frequency and the first iteration at which data is saved %2", "<br><span class=note>", "</span>"),
    "<input name=post type=text size=30 >"
);
row2(tra("#FILE_PARAMETERS %1 Defines the parameters that will be saved to disk %2", "<br><span class=note>", "</span>"),
    "<input name=file_parameters type=text size=30 >"
);

row2("", "<input type=submit value='Go!'>");
end_table();
echo "</form>\n";
page_tail();

?>
