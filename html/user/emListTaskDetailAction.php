<html>
<body>

<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");

$size = (int) count($_REQUEST);


db_init();
$user = get_logged_in_user();


page_head(tra("Parameters "));
start_table("align=\"center\"");
$contador=1;
foreach($_REQUEST as $key => $value)
{

	$result=mysql_query("select parameters from user_workunit where workunit_id = " . $value );
	while($row=mysql_fetch_array($result))
	{
		echo "<tr><td> " . nl2br($row['parameters']) . "</td>";
	}

	$contador+=1;	
} 


end_table();
page_tail();


?>

</body>
</html>
