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

#############################
### INI : DATA      SELECT
#############################
#  select case (t_cel)
#  case(-1);    Vi = Vi_IZ       !.Ischemic Zone;
#  case(0);     Vi = Vi_RMC      !.Roger y McCulloc;
#  case(1:3);   Vi = Vi_TT       !.Ten Tusscher
#  case(4:6);   Vi = Vi_LR       !.Luo Rudy
#  case(7:9);   Vi = Vi_FK       !.Fenton Karma
#  case(10);    Vi = Vi_NY       !.Nygren
#  case(11);    Vi = Vi_PKF      !.Purkinje Stewart
#  case(12);    Vi = Vi_GR_end   !.Grandi ENDO
#  case(13);    Vi = Vi_GR_epi   !.Grandi EPI
#  case(14);    Vi = Vi_CRR_end  !.Carro ENDO
#  case(15);    Vi = Vi_CRR_epi  !.Carro EPI
#  case(16);    Vi = Vi_GRHF_end !.Grandi Heart Failure ENDO
#  case(17);    Vi = Vi_GRHF_epi !.Grandi Heart Failure EPI
#  case(18);    Vi = Vi_GPV   !.GPV

#############################
### FIN : DATA      SELECT
#############################

#############################
### INI : FUNCTIONS SELECT
#############################
const DEFINE_ISQUEMIC_ZONE = 'Isquemic Zone';

$models = array(
    "Ischemic Zone" => "-1",
    "Roger y McCulloc " => "0",
    "Ten Tusscher ENDO" => "1",
    "Ten Tusscher MID " => "2",
    "Ten Tusscher EPI " => "3",
    "Leo Rudy ENDO " => "4",
    "Leo Rudy MID " => "5",
    "Leo Rudy EPI " => "6",
    "Fenton Karma ENDO " => "7",
    "Fenton Karma MID " => "8",
    "Fenton Karma EPI " => "9",
    "Nygren " => "10",
    "Purkinje Stewart" => "11",
    "Grandi ENDO" => "12",
    "Grandi EPI" => "13",
    "Carro ENDO" => "14",
    "Carro EPI" => "15",
    "Grandi Heart Failure ENDO" => "16",
    "Grandi Heart Failure EPI" => "17",
    "GPV " => "18"
);

function print_model_select() {
    global $models;
    foreach($models as $i => $value){
	    echo "<option value=\"$value\" >$i</option>\n";
    }
} 

#############################
### FIN : FUNCTIONS SELECT
#############################


db_init();
$user = get_logged_in_user();

page_head(tra("New Task Params"));
echo " <script src=\"http://code.jquery.com/jquery-latest.js\"></script> " ;
echo "<hola> Cadena </hola>";
echo "
<script> 
var cur;
var numeroStim = 9;
function addRowToTable()
{
document.getElementById('tra').innerHTML = 'addRowTable!! '; 

$(\"st\").append(\" <tr><td width=40% class=fieldname>#STIMULUS <br><span class=note> Extra STIMULUS parameters </span></td><td class=fieldvalue><input name=stimulus\" + numeroStim + \" type=text size=30 ></td></tr> \" ); 
numeroStim+=1;
}

var numeroParameter = 9;
function addParameterTable()
{
document.getElementById('tra').innerHTML = 'addParameterTable!! '; 

var restoSelect='';
			for(var i=0;i<cur.length;i++)
			{
document.getElementById('tra').innerHTML += ' cur text !! ' + cur[i]; 
restoSelect+='<option value=' + i + ' >' + cur[i] + '</option>';
			}


$(\"sp\").append(\"<tr> <td width=40% class=fieldname>#PARAMETERS <br><span class=note> Extra PARAMETERS </span></td><td class=fieldvalue><select name=pxx > \" + restoSelect + \"</select></td> </tr> \" ); 



numeroParameter+=1;


document.getElementById('tra').innerHTML += ' campo añadido!! '; 
		if(!cur){return;}
document.getElementById('tra').innerHTML += ' cur existe!! '; 
			d=document.getElementById('sp');
if(!d){
document.getElementById('tra').innerHTML += ' d NO existe!! '; 
}else{
document.getElementById('tra').innerHTML += ' d SI existe!! '; 
}
document.getElementById('tra').innerHTML += ' sp encontrado!! '; 
document.getElementById('tra').innerHTML += ' cur length!! ' + cur.length; 
			//d.options.length=0;
			//d.options.length=cur.length;
document.getElementById('tra').innerHTML += ' asigna  length!! ';
			for(var i=0;i<cur.length;i++)
			{
document.getElementById('tra').innerHTML += ' cur text !! ' + cur[i]; 
				d.options[i].text=cur[i];
				d.options[i].value=i;
			}
document.getElementById('tra').innerHTML += ' hecho !! ' ;

}


		function populate(o)
		{
			//d=document.getElementById('de');
document.getElementById('tra').innerHTML = 'dentro!! '; 
			//if(!d){return;}			
document.getElementById('tra').innerHTML += 'd existe!! '; 
			var mitems=new Array();
			mitems['Ischemic Zone']=['Burger Meals','Breakfast','Steaks','Fish Dishes','Vegetarian Dishes'];
			mitems['Snacks']=['Brownies','Cookies'];
			mitems['Drinks']=['Shakes','Sodas','Cocktails','Juices'];
			mitems['Salads']=['Tuna Salad','Cesar Salad','Green Salad','Prawn Salad'];
			mitems['Deserts']=['Pancakes','Waffles','Ice Cream','Fresh Fruit'];
document.getElementById('tra').innerHTML += ' array de datos'; 
			//d.options.length=0;
			cur=mitems[o.options[o.selectedIndex].text];
document.getElementById('tra').innerHTML += ' indice ' + o.selectedIndex + ' valor ' + o.options[o.selectedIndex].value + ' text ' + o.options[o.selectedIndex].text ; 
			if(!cur){return;}
document.getElementById('tra').innerHTML += ' cur existe '; 
			//d.options.length=cur.length;
			for(var i=0;i<cur.length;i++)
			{
			//	d.options[i].text=cur[i];
			//	d.options[i].value=i;
			}
		}

</script>";
echo "<form method=get action=emLanzaEjecucion.php>";
echo "<input type=\"button\" value=\"Add\" onclick=\"addRowToTable();\" />";
echo "<input type=\"button\" value=\"Add Parameter\" onclick=\"addParameterTable();\" />";
echo form_tokens($user->authenticator);
start_table();
//row2(tra("#MODEL %1 Defines the model ID %2", "<br><span class=note>", "</span>"),
//    "<input name=model type=text size=2 >"
//);
row2_init(tra("#MODEL"),
    "<select name=model  onchange=\"populate(this)\">"
);
print_model_select();
echo "</select><sp> </sp></td></tr>\n";
//row2(tra("#PARAMETERS %1 It is defining a mask values %2", "<br><span class=note>", "</span>"),
//    "<input name=parameters type=text size=30 > "
//);
//row2_init(tra("#P1"),
//"
//<select name=\"de\" id=\"de\">
//	</select>
//    <input name=parameters1 type=text size=30 >
//");
//echo "</select></td></tr>\n";
//row2_init(tra("#P2"),
//"
//<select name=\"de\" id=\"de\">
//	</select>
//    <input name=parameters2 type=text size=30 >
//");
//echo "</select></td></tr>\n";
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
echo "<label for=\"tra\" id=\"tra\">Traza</label>";
page_tail();
?>
