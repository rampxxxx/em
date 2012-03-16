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
    "Roger & McCulloc " => "0",
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
function addStim()
{
document.getElementById('tra').innerHTML = 'addRowTable!! '; 

$(\"st\").append(\"<stt> <input name=stimulus\" + numeroStim + \" type=text size=30 ><br> </stt>\" ); 
numeroStim+=1;
}

var numeroParameter = 1;
function addParameterTable()
{
document.getElementById('tra').innerHTML = 'addParameterTable!! '; 

var restoSelect='';
var ii=0;
			for(var i=0;i<cur.length;i++)
			{
			ii=i+1;
document.getElementById('tra').innerHTML += ' cur text !! ' + cur[i]; 
restoSelect+='<option value=' + ii + ' >' + cur[i] + '</option>';
			}


$(\"sp\").append(\"<spp> <select name=parameterSelect\" + numeroParameter + \" > \" + restoSelect + \"</select><input name=parameter\" + numeroParameter + \" type=text size=30 ><br> </spp> \" ); 



numeroParameter+=1;



}

/////////////////////////////////
// Delete new Parameter 'select'.
/////////////////////////////////
function deleteParameterTable()
{
$(\"spp\").remove();
}
/////////////////////////////////
// Delete new Parameter 'select'.
/////////////////////////////////
function deleteStim()
{
$(\"stt\").remove();
}
/////////////////////////////////
// Get a reference to array.
/////////////////////////////////
function populate(o)
{
	deleteParameterTable();//delete previous params.
	numeroParameter=1;
	//d=document.getElementById('de');
	document.getElementById('tra').innerHTML = 'dentro!! '; 
	//if(!d){return;}			
	document.getElementById('tra').innerHTML += 'd existe!! '; 
	var mitems=new Array();
	mitems['Ischemic Zone']=['v1','v2','G'];
	mitems['Roger & McCulloc']=['vp','eta1', 'eta2', 'eta3', 'G', 'vth'];
	mitems['Ten Tusscher ENDO']=['Cai','CaSR','CaSS','Nai', 'Ki', 'm', 'h', 'j', 'xs', 'r', 's', 'd', 'f', 'f2', 'fcass', 'rr', 'oo', 'xr1', 'xr2'];
	mitems['Ten Tusscher MID']=['Cai','CaSR','CaSS','Nai', 'Ki', 'm', 'h', 'j', 'xs', 'r', 's', 'd', 'f', 'f2', 'fcass', 'rr', 'oo', 'xr1', 'xr2'];
	mitems['Ten Tusscher EPI']=['Cai','CaSR','CaSS','Nai', 'Ki', 'm', 'h', 'j', 'xs', 'r', 's', 'd', 'f', 'f2', 'fcass', 'rr', 'oo', 'xr1', 'xr2'];
	mitems['Leo Rudy ENDO']=['Max. Conductance of the Na Channel (mS/uF)','ICaL channel conduction reduction factor','Max. Conductance of T Ca Channel (nS/uF)','Max. Conductance of IKr (nS/uF)', 'Max. Conductance of IKs (nS/uF)', 'Max. Conductance of IK1 (nS/uF)', 'Max. Conductance of IKp (nS/uF)', 'Maximum conductance of IKNa (mS/uF)', 'Channel density, channels/cm^2, IKATP', 'Nominal Conductance, IKATP', 'Intracellular ATP concentration, IKATP', 'Intracellular ADP concentration, IKATP', 'Max conductance of Ito', 'Scaling factor for inaca (uA/uF)', 'Max. current through Na-K pump (uA/uF)', 'Max. Ca current through sarcolemmal Ca pump (uA/uF)', 'Max conductance of Ca background current', 'Max conductance of Na background current (In the paper is 0.00141)', 'Max. current through iup channel (mM/ms)', 'Extracellular Na Concentration (mM)', 'Extracellular K Concentration (mM)', 'Extracellular Ca Concentration (mM)'];
	mitems['Leo Rudy MID']=['Max. Conductance of the Na Channel (mS/uF)','ICaL channel conduction reduction factor','Max. Conductance of T Ca Channel (nS/uF)','Max. Conductance of IKr (nS/uF)', 'Max. Conductance of IKs (nS/uF)', 'Max. Conductance of IK1 (nS/uF)', 'Max. Conductance of IKp (nS/uF)', 'Maximum conductance of IKNa (mS/uF)', 'Channel density, channels/cm^2, IKATP', 'Nominal Conductance, IKATP', 'Intracellular ATP concentration, IKATP', 'Intracellular ADP concentration, IKATP', 'Max conductance of Ito', 'Scaling factor for inaca (uA/uF)', 'Max. current through Na-K pump (uA/uF)', 'Max. Ca current through sarcolemmal Ca pump (uA/uF)', 'Max conductance of Ca background current', 'Max conductance of Na background current (In the paper is 0.00141)', 'Max. current through iup channel (mM/ms)', 'Extracellular Na Concentration (mM)', 'Extracellular K Concentration (mM)', 'Extracellular Ca Concentration (mM)'];
	mitems['Leo Rudy EPI']=['Max. Conductance of the Na Channel (mS/uF)','ICaL channel conduction reduction factor','Max. Conductance of T Ca Channel (nS/uF)','Max. Conductance of IKr (nS/uF)', 'Max. Conductance of IKs (nS/uF)', 'Max. Conductance of IK1 (nS/uF)', 'Max. Conductance of IKp (nS/uF)', 'Maximum conductance of IKNa (mS/uF)', 'Channel density, channels/cm^2, IKATP', 'Nominal Conductance, IKATP', 'Intracellular ATP concentration, IKATP', 'Intracellular ADP concentration, IKATP', 'Max conductance of Ito', 'Scaling factor for inaca (uA/uF)', 'Max. current through Na-K pump (uA/uF)', 'Max. Ca current through sarcolemmal Ca pump (uA/uF)', 'Max conductance of Ca background current', 'Max conductance of Na background current (In the paper is 0.00141)', 'Max. current through iup channel (mM/ms)', 'Extracellular Na Concentration (mM)', 'Extracellular K Concentration (mM)', 'Extracellular Ca Concentration (mM)'];
	mitems['Fenton Karma ENDO']=['Vscl', 'Voff', 'uo', 'tetv', 'tetw', 'invtvp', 'ts1', 'ks', 'us', 'uu', 'tetvm', 'teto', 'tv1m', 'tv2m', 'tw1m', 'tw2m', 'kwm', 'uwm', 'invtwp', 'invtfi', 'to1', 'to2', 'tso1', 'tso2', 'kso', 'uso', 'ts2', 'invtsi', 'invtwinf', 'twinfst' ];
	mitems['Fenton Karma MID']=['Vscl', 'Voff', 'uo', 'tetv', 'tetw', 'invtvp', 'ts1', 'ks', 'us', 'uu', 'tetvm', 'teto', 'tv1m', 'tv2m', 'tw1m', 'tw2m', 'kwm', 'uwm', 'invtwp', 'invtfi', 'to1', 'to2', 'tso1', 'tso2', 'kso', 'uso', 'ts2', 'invtsi', 'invtwinf', 'twinfst' ];
	mitems['Fenton Karma EPI']=['Vscl', 'Voff', 'uo', 'tetv', 'tetw', 'invtvp', 'ts1', 'ks', 'us', 'uu', 'tetvm', 'teto', 'tv1m', 'tv2m', 'tw1m', 'tw2m', 'kwm', 'uwm', 'invtwp', 'invtfi', 'to1', 'to2', 'tso1', 'tso2', 'kso', 'uso', 'ts2', 'invtsi', 'invtwinf', 'twinfst' ];
	mitems['Nygren']=['pna', 'gcal', 'gt', 'gsus', 'gkfast', 'gkslow', 'gk1', 'gbna', 'gbca', 'taufl1', 'Vhm', 'Vrm', 'Ddof' ];
	mitems['Purkinje Stewart']=['pKNa', 'GKr', 'GK1', 'GKs', 'Gto', 'GNa', 'GCaL', 'GbNa', 'GbCa', 'GpCa', 'GpK', 'PNaK', 'kNaCa', 'Ko', 'Nao', 'Cao', 'Gsus', 'GfK', 'GfNa'];
	mitems['Grandi ENDO']=['pNaK', 'GKp', 'GKsJunc', 'GKsSL', 'Gtos', 'Gtof', 'GNa', 'GCa', 'GNaB', 'pNa', 'pCa', 'pK', 'GCab', 'GClCa', 'GClB', 'Cli', 'Clo', 'Ko', 'Nao', 'Cao', 'Mgi'];
	mitems['Grandi EPI']=['pNaK', 'GKp', 'GKsJunc', 'GKsSL', 'Gtos', 'Gtof', 'GNa', 'GCa', 'GNaB', 'pNa', 'pCa', 'pK', 'GCab', 'GClCa', 'GClB', 'Cli', 'Clo', 'Ko', 'Nao', 'Cao', 'Mgi'];
	mitems['Carro ENDO']=['GCal', 'tauf', 'tauf2', 'GKr', 'GKs', 'tauxs', 'GK1', 'GNaK', 'Gncx', 'Gto', 'GNa', 'Ko', 'Gtos', 'Gtof'];
	mitems['Carro EPI']=['GCal', 'tauf', 'tauf2', 'GKr', 'GKs', 'tauxs', 'GK1', 'GNaK', 'Gncx', 'Gto', 'GNa', 'Ko', 'Gtos', 'Gtof'];
	mitems['Grandi Heart Failure ENDO']=['INaL', 'Ikr', 'Iks', 'ICaL', 'JSRleak', 'Incx', 'ICab', 'IK1', 'Ito', 'INaK', 'Jserca', 'tauINaL', 'Gtos', 'Gtof'];
	mitems['Grandi Heart Failure EPI']=['INaL', 'Ikr', 'Iks', 'ICaL', 'JSRleak', 'Incx', 'ICab', 'IK1', 'Ito', 'INaK', 'Jserca', 'tauNaL', 'Gtos', 'Gtof'];
	mitems['GPV']=['pNaK', 'GKp', 'GKsJunc', 'GKsSL', 'Gtof', 'Gkur', 'ACh', 'GNa', 'GNaB', 'pNa', 'pCa', 'pK', 'GCaB', 'GClCa', 'GClB', 'Cli', 'Clo', 'Ko', 'Nao', 'Cao', 'Mgi', 'ATPi', 'kATP', 'GKATP', 'GNaL', 'Chlor', ];
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
echo "<input type=\"button\" value=\"Add Parameter\" onclick=\"addParameterTable();\" />";
echo "<input type=\"button\" value=\"Del Parameters\" onclick=\"deleteParameterTable();\" />";
echo "<input type=\"button\" value=\"Add Stimulus\" onclick=\"addStim();\" />";
echo "<input type=\"button\" value=\"Del Stimulus\" onclick=\"deleteStim();\" />";
echo form_tokens($user->authenticator);
start_table();
//row2(tra("#MODEL %1 Defines the model ID %2", "<br><span class=note>", "</span>"),
//    "<input name=model type=text size=2 >"
//);
row2_init(tra("#MODEL"),
    "<select name=model  onchange=\"populate(this)\">"
);
print_model_select();
echo "</select></td></tr>\n";
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
row2(tra("#PARAMETERS %1 It is defining a mask values %2", "<br><span class=note>", "</span>"),
    "<sp > </sp> "
);
row2(tra("#STEP %1 Defines total simulation time and time increment %2", "<br><span class=note>", "</span>"),
    "<input name=step type=text size=30 >"
);
row2(tra("#STIMULUS %1 Defines the stimulation protocol %2", "<br><span class=note>", "</span>"),
    "<st > </st> "
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
