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

	if(stristr($key, 'workunit_id') != FALSE) 
	{
		$workunit_id=$value;
	}
	else if(stristr($key, 'debug') != FALSE) 
	{
		$debug=$value;
	}
	$contador+=1;	
} 
if($debug==1)
{
	$result=mysql_query("select parameters from user_workunit where workunit_id = " . $workunit_id );
	while($row=mysql_fetch_array($result))
	{
		echo "<tr><td> " . nl2br($row['parameters']) . "</td>";
	}
}
else
{
	$result=mysql_query("select parametersE from user_workunit where workunit_id = " . $workunit_id );
	while($row=mysql_fetch_array($result))
	{
		echo "<tr><td> " . nl2br($row['parametersE']) . "</td>";
	}
}


end_table();
page_tail();


?>

</body>
</html>
