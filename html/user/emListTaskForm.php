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
require_once("../inc/cache.inc");
function get_mysql_user_workunit($query) {
    $user_workunits = unserialize(get_cached_data(3600, "get_mysql_user_workunit".$query));
    if ($user_workunits == false) {
        $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result)) {
            $user_workunits[] = $row;
        }
        mysql_free_result($result);
        set_cached_data(3600, serialize($user_workunits), "get_mysql_user_workunit".$query);
    }else{
}
    return $user_workunits;
}


db_init();
$user = get_logged_in_user();

page_head(tra("List Of Task Executed By The User "));

//echo "<form method=get action=emListBorra.php>";
echo form_tokens($user->authenticator);
start_table("align=\"center\"");
row1("Current finish works ", '9');

echo "<tr><td>Work ID</td>";
echo "<td width=\"15\">" . "First Data File" . "</td>\n";
echo "<td width=\"15\">" . "Second Data File" . "</td>\n";
echo "<td width=\"15\">" . "Delete Data Files From SERVER!!" . "</td>\n";
echo "</tr>";

    $user_workunits = get_mysql_user_workunit("SELECT workunit_id, w.name FROM user_workunit u, workunit w ,result r WHERE u.workunit_id=w.id and u.workunit_id=r.workunitid and r.outcome=1 and r.validate_state=1 and u.user_id=" . $user->id);
    foreach($user_workunits as $user_workunit) {
        $user_workunitid = $user_workunit["workunit_id"];
        $name = $user_workunit["name"];

    echo "<form action=\"emListTaskFormAction.php\" method=\"POST\">\n";

$downloadName0=$name . "_0.gz";
$downloadName1=$name . "_1.gz";
$dataDownloadName0="/data/" . $downloadName0 ;
$dataDownloadName1="/data/" . $downloadName1 ;
        echo "<tr><td>" . $user_workunitid . "</td>";
echo "<td><a href=" . $dataDownloadName0 . ">" . $downloadName0 . "</a>" . "</td>";
echo "<td><a href=" . $dataDownloadName1 . ">" . $downloadName1 . "</a>" . "</td>";
echo "<td><input type=\"checkbox\" name=\"$name\" value=\"1\"" . "></td>\n";
        echo " </tr>"
        ;
    }

    echo "<td><input type=\"submit\" value=\"Delete!\"></form></td>";
    echo "</tr>\n";



end_table();
echo "</form>\n";
page_tail();

?>
