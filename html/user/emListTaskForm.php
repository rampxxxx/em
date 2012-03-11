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
echo "INI get_mysql_user_workunit " . "<br/>";
    $user_workunits = unserialize(get_cached_data(3600, "get_mysql_user_workunit".$query));
echo "get_cached_data get_mysql_user_workunit " . "<br/>";
    if ($user_workunits == false) {
echo " user_workunits == false get_mysql_user_workunit " . "<br/>";
        $result = mysql_query($query);
echo " mysql_query get_mysql_user_workunit " . "<br/>";
        while($row = mysql_fetch_assoc($result)) {
echo " while get_mysql_user_workunit " . "<br/>";
            $user_workunits[] = $row;
        }
echo " end while get_mysql_user_workunit " . "<br/>";
        mysql_free_result($result);
echo " free result get_mysql_user_workunit " . "<br/>";
        set_cached_data(3600, serialize($user_workunits), "get_mysql_user_workunit".$query);
    }else{
echo "ELSE user_workunits==false get_mysql_user_workunit " . "<br/>";
}
echo "FIN get_mysql_user_workunit " . "<br/>";
    return $user_workunits;
}


db_init();
$user = get_logged_in_user();

//page_head(tra("List Of Task Executed By The User "));

//echo "<form method=get action=emListBorra.php>";
echo form_tokens($user->authenticator);
//start_table();

    $user_workunits = get_mysql_user_workunit("SELECT workunit_id, w.name FROM user_workunit u, workunit w ,result r WHERE u.workunit_id=w.id and u.workunit_id=r.workunitid and r.outcome=1 and r.validate_state=1 and u.user_id=" . $user->id);
    foreach($user_workunits as $user_workunit) {
        $user_workunitid = $user_workunit["workunit_id"];
        $name = $user_workunit["name"];
//row2(tra("User ID %1 User unique identifier %2", "<br><span class=note>", "</span>"),
//    "<input name=model type=text size=2 >"
//);
$downloadName=$name . "_0.gz";
echo "<a href=/data/" . $downloadName . ">" . $downloadName . "</a>" . "<br/>";
        echo "<tr><td>$user_workunitid</td>
            <td>" . $name . "_0.gz</td>
            <td>" . $name . "_1.gz</td>
            <td>"
        ;
        echo " </tr>"
        ;
    }

//row2("", "<input type=submit value='Delete Permanently Result Data Files!!'>");



//end_table();
//echo "</form>\n";
page_tail();

?>
