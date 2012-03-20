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
    "None Yet " => "99",
    "Ischemic Zone" => "-1",
    "Roger  McCulloc " => "0",
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
	    if($value==99){
		    echo "<option value=\"$value\" selected>$i</option>\n";
	    }else{
		    echo "<option value=\"$value\" >$i</option>\n";
	    }
    }
} 

#############################
### FIN : FUNCTIONS SELECT
#############################


db_init();
$user = get_logged_in_user();

page_head(tra("Simulation Workunit Creation"));
echo " <script src=\"http://code.jquery.com/jquery-latest.js\"></script> " ;
echo "
<script> 
////////////////////////////////////////////////////
///   Declaracion, inicializacion de variables /////
////////////////////////////////////////////////////
var params;
var currents;
var numeroStim = 9;
var numeroParameter = 1;
var numeroParSave = 1;
////////////////////////////////////////////////////
///   Añade input de Stimulus                  /////
////////////////////////////////////////////////////
function addStim()
{
document.getElementById('tra').innerHTML = 'addRowTable!! '; 

$(\"st\").append(\"<stt>Start<input name=stimStart\" + numeroStim + \" type=text size=5 >BCL<input name=stimBcl\" + numeroStim + \" type=text size=5 >Duration<input name=stimDur\" + numeroStim + \" type=text size=5 >Current<input name=stimCur\" + numeroStim + \" type=text size=5 ><br> </stt>\" ); 
numeroStim+=1;
}
////////////////////////////////////////////////////
///   Añade select de ParSave                /////
////////////////////////////////////////////////////
function addParSave()
{
document.getElementById('tra').innerHTML = 'addParSaveTable!! '; 

var restoSelect='';
var ii=0;
for(var i=0;i<params.length;i++)
{
	ii=i+1;
	document.getElementById('tra').innerHTML += ' params text !! ' + params[i]; 
	restoSelect+='<option value=' + ii + ' >' + params[i] + '</option>';
}


$(\"ss\").append(\"<sss> <select name=parSave\" + numeroParSave + \" > \" + restoSelect + \"</select><br> </sss> \" ); 

numeroParSave+=1;

}
////////////////////////////////////////////////////
///   Añade select de Parameter                /////
////////////////////////////////////////////////////
function addParameterTable()
{
document.getElementById('tra').innerHTML = 'addParameterTable!!=> '; 
document.getElementById('tra').innerHTML = params.length; 

var restoSelect='';
var ii=0;
for(var i=0;i<params.length;i++)
{
	ii=i+1;
	document.getElementById('tra').innerHTML += ' params text !! ' + params[i]; 
	restoSelect+='<option value=' + ii + ' >' + params[i] + '</option>';
}


$(\"sp\").append(\"<spp> <select name=parameterSelect\" + numeroParameter + \" > \" + restoSelect + \"</select><input name=parameterInput\" + numeroParameter + \" type=text size=30 ><br> </spp> \" ); 

numeroParameter+=1;

}
////////////////////////////////////////////////////
///   Añade select de Burst                /////
////////////////////////////////////////////////////
function addBurst()
{
document.getElementById('tra').innerHTML = 'addBurst!! '; 
deleteBurst();
var restoSelect='';
var ii=0;
for(var i=0;i<params.length;i++)
{
	ii=i+1;
	document.getElementById('tra').innerHTML += ' params text !! ' + params[i]; 
	restoSelect+='<option value=' + ii + ' >' + params[i] + '</option>';
}


$(\"sb\").append(\"<sbb> <select name=burstSelect > \" + restoSelect + \"</select>Start<input name=burstStart type=text size=5 >End<input name=burstEnd type=text size=5 >Gap<input name=burstGap type=text size=5 ><br> </sbb> \" ); 

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
inicializaNumeroParameter();
$(\"spp\").remove();
}
/////////////////////////////////
// Delete new Burst 'select'.
/////////////////////////////////
function deleteBurst()
{
$(\"sbb\").remove();
}
/////////////////////////////////
// Delete new ParSave 'select'.
/////////////////////////////////
function deleteParSaveTable()
{
inicializaNumeroParSave();
$(\"sss\").remove();
}
/////////////////////////////////
// Delete new Parameter 'select'.
/////////////////////////////////
function deleteStim()
{
inicializaNumeroStim();
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
	var parData=new Array();
	parData['Ischemic Zone']=['v1','v2','G'];
	parData['Roger  McCulloc']=['vp','eta1', 'eta2', 'eta3', 'G', 'vth'];
	parData['Ten Tusscher ENDO']=['Cai','CaSR','CaSS','Nai', 'Ki', 'm', 'h', 'j', 'xs', 'r', 's', 'd', 'f', 'f2', 'fcass', 'rr', 'oo', 'xr1', 'xr2'];
	parData['Ten Tusscher MID']=['Cai','CaSR','CaSS','Nai', 'Ki', 'm', 'h', 'j', 'xs', 'r', 's', 'd', 'f', 'f2', 'fcass', 'rr', 'oo', 'xr1', 'xr2'];
	parData['Ten Tusscher EPI']=['Cai','CaSR','CaSS','Nai', 'Ki', 'm', 'h', 'j', 'xs', 'r', 's', 'd', 'f', 'f2', 'fcass', 'rr', 'oo', 'xr1', 'xr2'];
	parData['Leo Rudy ENDO']=['Max. Conductance of the Na Channel (mS/uF)','ICaL channel conduction reduction factor','Max. Conductance of T Ca Channel (nS/uF)','Max. Conductance of IKr (nS/uF)', 'Max. Conductance of IKs (nS/uF)', 'Max. Conductance of IK1 (nS/uF)', 'Max. Conductance of IKp (nS/uF)', 'Maximum conductance of IKNa (mS/uF)', 'Channel density, channels/cm^2, IKATP', 'Nominal Conductance, IKATP', 'Intracellular ATP concentration, IKATP', 'Intracellular ADP concentration, IKATP', 'Max conductance of Ito', 'Scaling factor for inaca (uA/uF)', 'Max. current through Na-K pump (uA/uF)', 'Max. Ca current through sarcolemmal Ca pump (uA/uF)', 'Max conductance of Ca background current', 'Max conductance of Na background current (In the paper is 0.00141)', 'Max. current through iup channel (mM/ms)', 'Extracellular Na Concentration (mM)', 'Extracellular K Concentration (mM)', 'Extracellular Ca Concentration (mM)'];
	parData['Leo Rudy MID']=['Max. Conductance of the Na Channel (mS/uF)','ICaL channel conduction reduction factor','Max. Conductance of T Ca Channel (nS/uF)','Max. Conductance of IKr (nS/uF)', 'Max. Conductance of IKs (nS/uF)', 'Max. Conductance of IK1 (nS/uF)', 'Max. Conductance of IKp (nS/uF)', 'Maximum conductance of IKNa (mS/uF)', 'Channel density, channels/cm^2, IKATP', 'Nominal Conductance, IKATP', 'Intracellular ATP concentration, IKATP', 'Intracellular ADP concentration, IKATP', 'Max conductance of Ito', 'Scaling factor for inaca (uA/uF)', 'Max. current through Na-K pump (uA/uF)', 'Max. Ca current through sarcolemmal Ca pump (uA/uF)', 'Max conductance of Ca background current', 'Max conductance of Na background current (In the paper is 0.00141)', 'Max. current through iup channel (mM/ms)', 'Extracellular Na Concentration (mM)', 'Extracellular K Concentration (mM)', 'Extracellular Ca Concentration (mM)'];
	parData['Leo Rudy EPI']=['Max. Conductance of the Na Channel (mS/uF)','ICaL channel conduction reduction factor','Max. Conductance of T Ca Channel (nS/uF)','Max. Conductance of IKr (nS/uF)', 'Max. Conductance of IKs (nS/uF)', 'Max. Conductance of IK1 (nS/uF)', 'Max. Conductance of IKp (nS/uF)', 'Maximum conductance of IKNa (mS/uF)', 'Channel density, channels/cm^2, IKATP', 'Nominal Conductance, IKATP', 'Intracellular ATP concentration, IKATP', 'Intracellular ADP concentration, IKATP', 'Max conductance of Ito', 'Scaling factor for inaca (uA/uF)', 'Max. current through Na-K pump (uA/uF)', 'Max. Ca current through sarcolemmal Ca pump (uA/uF)', 'Max conductance of Ca background current', 'Max conductance of Na background current (In the paper is 0.00141)', 'Max. current through iup channel (mM/ms)', 'Extracellular Na Concentration (mM)', 'Extracellular K Concentration (mM)', 'Extracellular Ca Concentration (mM)'];
	parData['Fenton Karma ENDO']=['Vscl', 'Voff', 'uo', 'tetv', 'tetw', 'invtvp', 'ts1', 'ks', 'us', 'uu', 'tetvm', 'teto', 'tv1m', 'tv2m', 'tw1m', 'tw2m', 'kwm', 'uwm', 'invtwp', 'invtfi', 'to1', 'to2', 'tso1', 'tso2', 'kso', 'uso', 'ts2', 'invtsi', 'invtwinf', 'twinfst' ];
	parData['Fenton Karma MID']=['Vscl', 'Voff', 'uo', 'tetv', 'tetw', 'invtvp', 'ts1', 'ks', 'us', 'uu', 'tetvm', 'teto', 'tv1m', 'tv2m', 'tw1m', 'tw2m', 'kwm', 'uwm', 'invtwp', 'invtfi', 'to1', 'to2', 'tso1', 'tso2', 'kso', 'uso', 'ts2', 'invtsi', 'invtwinf', 'twinfst' ];
	parData['Fenton Karma EPI']=['Vscl', 'Voff', 'uo', 'tetv', 'tetw', 'invtvp', 'ts1', 'ks', 'us', 'uu', 'tetvm', 'teto', 'tv1m', 'tv2m', 'tw1m', 'tw2m', 'kwm', 'uwm', 'invtwp', 'invtfi', 'to1', 'to2', 'tso1', 'tso2', 'kso', 'uso', 'ts2', 'invtsi', 'invtwinf', 'twinfst' ];
	parData['Nygren']=['pna', 'gcal', 'gt', 'gsus', 'gkfast', 'gkslow', 'gk1', 'gbna', 'gbca', 'taufl1', 'Vhm', 'Vrm', 'Ddof' ];
	parData['Purkinje Stewart']=['pKNa', 'GKr', 'GK1', 'GKs', 'Gto', 'GNa', 'GCaL', 'GbNa', 'GbCa', 'GpCa', 'GpK', 'PNaK', 'kNaCa', 'Ko', 'Nao', 'Cao', 'Gsus', 'GfK', 'GfNa'];
	parData['Grandi ENDO']=['pNaK', 'GKp', 'GKsJunc', 'GKsSL', 'Gtos', 'Gtof', 'GNa', 'GCa', 'GNaB', 'pNa', 'pCa', 'pK', 'GCab', 'GClCa', 'GClB', 'Cli', 'Clo', 'Ko', 'Nao', 'Cao', 'Mgi'];
	parData['Grandi EPI']=['pNaK', 'GKp', 'GKsJunc', 'GKsSL', 'Gtos', 'Gtof', 'GNa', 'GCa', 'GNaB', 'pNa', 'pCa', 'pK', 'GCab', 'GClCa', 'GClB', 'Cli', 'Clo', 'Ko', 'Nao', 'Cao', 'Mgi'];
	parData['Carro ENDO']=['GCal', 'tauf', 'tauf2', 'GKr', 'GKs', 'tauxs', 'GK1', 'GNaK', 'Gncx', 'Gto', 'GNa', 'Ko', 'Gtos', 'Gtof'];
	parData['Carro EPI']=['GCal', 'tauf', 'tauf2', 'GKr', 'GKs', 'tauxs', 'GK1', 'GNaK', 'Gncx', 'Gto', 'GNa', 'Ko', 'Gtos', 'Gtof'];
	parData['Grandi Heart Failure ENDO']=['INaL', 'Ikr', 'Iks', 'ICaL', 'JSRleak', 'Incx', 'ICab', 'IK1', 'Ito', 'INaK', 'Jserca', 'tauINaL', 'Gtos', 'Gtof'];
	parData['Grandi Heart Failure EPI']=['INaL', 'Ikr', 'Iks', 'ICaL', 'JSRleak', 'Incx', 'ICab', 'IK1', 'Ito', 'INaK', 'Jserca', 'tauNaL', 'Gtos', 'Gtof'];
	parData['GPV']=['pNaK', 'GKp', 'GKsJunc', 'GKsSL', 'Gtof', 'Gkur', 'ACh', 'GNa', 'GNaB', 'pNa', 'pCa', 'pK', 'GCaB', 'GClCa', 'GClB', 'Cli', 'Clo', 'Ko', 'Nao', 'Cao', 'Mgi', 'ATPi', 'kATP', 'GKATP', 'GNaL', 'Chlor'];
	document.getElementById('tra').innerHTML += ' array de datos '; 


	var parCurr=new Array();
	parCurr['Ischemic Zone']=[];
	parCurr['Roger  McCulloc']=[];
	parCurr['Ten Tusscher ENDO']=['IKr','IKs','IK1','IpK','IKATP','Ito','INa','IbNa','INaK','INaCa','ICaL','IbCa','IpCa'];
	parCurr['Ten Tusscher MID']=['IKr','IKs','IK1','IpK','IKATP','Ito','INa','IbNa','INaK','INaCa','ICaL','IbCa','IpCa'];
	parCurr['Ten Tusscher EPI']=['IKr','IKs','IK1','IpK','IKATP','Ito','INa','IbNa','INaK','INaCa','ICaL','IbCa','IpCa'];
	parCurr['Leo Rudy ENDO']=['Fast Na Current (uA/uF)','Ca current through L-type Ca channel (uA/uF)','Na current through L-type Ca channel (uA/uF)','K current through L-type Ca channel (uA/uF)','Ca current through T-type Ca channel (uA/uF)','Rapidly Activating K Current (uA/uF)','Slowly Activating K Current (uA/uF)','Time-independant K current (uA/uF)','Plateau K current (uA/uF)','Na activated K channel','ATP-sensitive K current (uA/uF)','Transient outward current','NaCa exchanger current (uA/uF)','NaK pump current (uA/uF)','Non-specific Na current (uA/uF)','Non-specific K current (uA/uF)','Sarcolemmal Ca pump current (uA/uF)','Ca background current (uA/uF)','Na background current (uA/uF)','Total Na Ion Flow (uA/uF)','Total K Ion Flow (uA/uF)','Total Ca Ion Flow (uA/uF)','New rate of change of Ca entry','Total Current'];
	parCurr['Leo Rudy MID']=['Fast Na Current (uA/uF)','Ca current through L-type Ca channel (uA/uF)','Na current through L-type Ca channel (uA/uF)','K current through L-type Ca channel (uA/uF)','Ca current through T-type Ca channel (uA/uF)','Rapidly Activating K Current (uA/uF)','Slowly Activating K Current (uA/uF)','Time-independant K current (uA/uF)','Plateau K current (uA/uF)','Na activated K channel','ATP-sensitive K current (uA/uF)','Transient outward current','NaCa exchanger current (uA/uF)','NaK pump current (uA/uF)','Non-specific Na current (uA/uF)','Non-specific K current (uA/uF)','Sarcolemmal Ca pump current (uA/uF)','Ca background current (uA/uF)','Na background current (uA/uF)','Total Na Ion Flow (uA/uF)','Total K Ion Flow (uA/uF)','Total Ca Ion Flow (uA/uF)','New rate of change of Ca entry','Total Current'];
	parCurr['Leo Rudy EPI']=['Fast Na Current (uA/uF)','Ca current through L-type Ca channel (uA/uF)','Na current through L-type Ca channel (uA/uF)','K current through L-type Ca channel (uA/uF)','Ca current through T-type Ca channel (uA/uF)','Rapidly Activating K Current (uA/uF)','Slowly Activating K Current (uA/uF)','Time-independant K current (uA/uF)','Plateau K current (uA/uF)','Na activated K channel','ATP-sensitive K current (uA/uF)','Transient outward current','NaCa exchanger current (uA/uF)','NaK pump current (uA/uF)','Non-specific Na current (uA/uF)','Non-specific K current (uA/uF)','Sarcolemmal Ca pump current (uA/uF)','Ca background current (uA/uF)','Na background current (uA/uF)','Total Na Ion Flow (uA/uF)','Total K Ion Flow (uA/uF)','Total Ca Ion Flow (uA/uF)','New rate of change of Ca entry','Total Current'];
	parCurr['Fenton Karma ENDO']=['Ifi','Iso','Isi'];
	parCurr['Fenton Karma MID']=['Ifi','Iso','Isi'];
	parCurr['Fenton Karma EPI']=['Ifi','Iso','Isi'];
	parCurr['Nygren']=['INA','ICAL','ek','It','Isus','IKr','IKs','IK','IK1','ena','IBNA','IBCA','IB','ICAP','INAK','IUP','IREL','Iion'];
	parCurr['Purkinje Stewart']=['IK1','Ito','Isus','INa','ICaL','IKs','IKr','INaCa','INaK','IpCa','IpK','IbNa','IbCa','IfNa','IfK'];
	parCurr['Grandi ENDO']=['INaJunc','INaSL','INa','INaBkJunc','INaBkSL','INaBk','INaKJunc','INaKSrLl','INaK','Ikr','IksJunc','IksSL','Iks','IkpJunc','IkpSL','Ikp','Itos','Itof','Ito','Ik1','IClCaJunc','IClCaSL','IclCa','IClBk','ICaJunc','ICaSL','ICa','ICaK','ICaNaJunc','ICaNaSL','ICaNa','ICaL','IncxJunc','IncxSL','Incx','IpCaJunc','IpCaSL','IpCa','ICaBkJunc','ICaBkSL','ICaBk','INatotJunc','INatotSL','IKtot','ICatotJunc','ICatotSL','INatot','ICltot','ICatot','Itot'];
	parCurr['Grandi EPI']=['INaJunc','INaSL','INa','INaBkJunc','INaBkSL','INaBk','INaKJunc','INaKSrLl','INaK','Ikr','IksJunc','IksSL','Iks','IkpJunc','IkpSL','Ikp','Itos','Itof','Ito','Ik1','IClCaJunc','IClCaSL','IclCa','IClBk','ICaJunc','ICaSL','ICa','ICaK','ICaNaJunc','ICaNaSL','ICaNa','ICaL','IncxJunc','IncxSL','Incx','IpCaJunc','IpCaSL','IpCa','ICaBkJunc','ICaBkSL','ICaBk','INatotJunc','INatotSL','IKtot','ICatotJunc','ICatotSL','INatot','ICltot','ICatot','Itot'];
	parCurr['Carro ENDO']=['INaJunc','INaSL','INa','INaBkJunc','INaBkSL','INaBk','INaKJunc','INaKSL','INaK','Ikr','IksJunc','IksSL','Iks','Ikp','Itos','Itof','Ito','IK1','IClCaJunc','IClCaSL','IclCa','IClBk','ICaJunc','ICaSL','ICa','ICaK','ICaNaJunc','ICaNaSL','ICaNa','ICaL','IncxJunc','IncxSL','Incx','IpCaJunc','IpCaSL','IpCa','ICaBkJunc','ICaBkSL','ICaBk','INatotJunc','INatotSL','IKtot','ICatotJunc','ICatotSL','INatot','ICltot','ICatot','Itot'];
	parCurr['CarroEPI']=['INaJunc','INaSL','INa','INaBkJunc','INaBkSL','INaBk','INaKJunc','INaKSL','INaK','Ikr','IksJunc','IksSL','Iks','Ikp','Itos','Itof','Ito','IK1','IClCaJunc','IClCaSL','IclCa','IClBk','ICaJunc','ICaSL','ICa','ICaK','ICaNaJunc','ICaNaSL','ICaNa','ICaL','IncxJunc','IncxSL','Incx','IpCaJunc','IpCaSL','IpCa','ICaBkJunc','ICaBkSL','ICaBk','INatotJunc','INatotSL','IKtot','ICatotJunc','ICatotSL','INatot','ICltot','ICatot','Itot'];
	parCurr['Grandi Heart Failure ENDO']=['INaJunc','INaSL','INa','INaLJunc','INaLSL','INaL','INaBkJunc','INaBkSL','INaBk','INaKJunc','INaKSL','INaK','Ikr','IksJunc','IksSL','Iks','IkpJunc','IkpSL','Ikp','Itos','Itof','Ito','Ik1','IClCaJunc','IClCaSL','IclCa','IClBk','ICaJunc','ICaSL','ICa','ICaK','ICaNaJunc','ICaNaSL','ICaNa','ICaL','IncxJunc','IncxSL','Incx','IpCaJunc','IpCaSL','IpCa','ICaBkJunc','ICaBkSL','ICaBk','INatotJunc','INatotSL','IKtot','ICatotJunc','ICatotSL','INatot','ICltot','ICatot','Itot'];
	parCurr['Grandi Heart Failure EPI']=['INaJunc','INaSL','INa','INaLJunc','INaLSL','INaL','INaBkJunc','INaBkSL','INaBk','INaKJunc','INaKSL','INaK','Ikr','IksJunc','IksSL','Iks','IkpJunc','IkpSL','Ikp','Itos','Itof','Ito','Ik1','IClCaJunc','IClCaSL','IclCa','IClBk','ICaJunc','ICaSL','ICa','ICaK','ICaNaJunc','ICaNaSL','ICaNa','ICaL','IncxJunc','IncxSL','Incx','IpCaJunc','IpCaSL','IpCa','ICaBkJunc','ICaBkSL','ICaBk','INatotJunc','INatotSL','IKtot','ICatotJunc','ICatotSL','INatot','ICltot','ICatot','Itot'];
	parCurr['GPV']=['INaJunc','INaSL','INa','INaLJunc','INaLSL','INaL','INaBkJunc','INaBkSL','INaBk','INaKJunc','INaKSL','INaK','Ikr','IksJunc','IksSL','Iks','IkpJunc','IkpSL','Ikp','Itos','Itof','Ito','I_kur','I_KACh','I_KATP','Ik1','IClCaJunc','IClCaSL','IclCa','IClBk','ICaJunc','ICaSL','ICa','ICaK','ICaNaJunc','ICaNaSL','ICaNa','ICaL','IncxJunc','IncxSL','Incx','IpCaJunc','IpCaSL','IpCa','ICaBkJunc','ICaBkSL','ICaBk','INatotJunc','INatotSL','IKtot','ICatotJunc','ICatotSL','INatot','ICltot','ICatot','Itot'];

params=parData[o.options[o.selectedIndex].text];
currents=parCurr[o.options[o.selectedIndex].text];
	document.getElementById('tra').innerHTML += ' indice ' + o.selectedIndex + ' valor ' + o.options[o.selectedIndex].value + ' text ' + o.options[o.selectedIndex].text ; 
	document.getElementById('tra').innerHTML += ' Current size=>' + currents.length;
	document.getElementById('tra').innerHTML += ' Params size=>' + params.length;
}

</script>";
echo "<form method=get action=emLanzaEjecucion.php>";
echo "<input type=\"button\" value=\"Add Parameter\" onclick=\"addParameterTable();\" />";
echo "<input type=\"button\" value=\"Del Parameters\" onclick=\"deleteParameterTable();\" />";
echo "<input type=\"button\" value=\"Add Burst\" onclick=\"addBurst();\" />";
echo "<input type=\"button\" value=\"Del Burst\" onclick=\"deleteBurst();\" />";
echo "<input type=\"button\" value=\"Add Stimulus\" onclick=\"addStim();\" />";
echo "<input type=\"button\" value=\"Del Stimulus\" onclick=\"deleteStim();\" />";
echo "<input type=\"button\" value=\"Add Save Parameter\" onclick=\"addParSave();\" />";
echo "<input type=\"button\" value=\"Del Save Parameter\" onclick=\"deleteParSave();\" />";
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
row2(tra("#PARAMETERS %1 It is defining a mask values %2", "<br><span class=note>", "</span>"),
    "<sp > </sp> "
);
row2(tra("BURST %1 It allows create a sort of tasks by telling star,end and gap%2", "<br><span class=note>", "</span>"),
    "<sb > </sb> "
);
row2(tra("#STEP %1 Defines total simulation time and time increment (time in msec)%2", "<br><span class=note>", "</span>"),
    "Simulation initiation at<input name=stepStart type=text size=10 >ending at<input name=stepEnd type=text size=10>Increment <input name=stepIncrement type=text size=10>"
);
row2(tra("#STIMULUS %1 Defines the stimulation protocol %2", "<br><span class=note>", "</span>"),
    "<st > </st> "
);
row2(tra("#POST %1 Defines the output frequency and the first iteration at which data is saved %2", "<br><span class=note>", "</span>"),
    "First iteration saved is <input name=postFirst type=text size=10 >Saving frecuency <input name=postFrec type=text size=10 >"
);
row2(tra("#FILE_PARAMETERS %1 Defines the parameters that will be saved to disk %2", "<br><span class=note>", "</span>"),
    "<ss> </ss>"
);
row2(tra("#FILE_CURRENTS %1 Defines if the current are going to be saved to disk %2", "<br><span class=note>", "</span>"),
    "         <input type=radio name=saveCurr value=1> Yes<br>
<input type=radio name=saveCurr value=0 checked> No<br> "
);

row2("", "<input type=submit value='Go!'>");
end_table();
echo "</form>\n";
echo "<label for=\"tra\" id=\"tra\">Traza</label>";
echo "<td>
<a href=\"emListTaskForm.php\">". "Check Created Task" ."</a>
<a href=\"home.php\">". "Back Home " ."</a>
</td>
";
page_tail();
?>
