<?php
require_once("../inc/db_ops.inc");
require_once("../inc/util_ops.inc");
require_once("../inc/countries.inc");
require_once("../inc/utilidades.inc");


db_init();

admin_page_head(tra("Creation New Application Version"));
start_table();


  if ($_FILES["file"]["error"] > 0)
{
	row1("ERROR uploading file ", '9');
	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	$file=$_FILES["file"];
	row2("Size", $file['size']);
	row2("Error", $file['error']);
	row2("Name", $file['name']);
	row2("Type", $file['type']);
	row2("Temporal Name", $file['tmp_name']);
}
  else
    {
	row1("SUCCESS uploading and creationg new app version", '9');
	row2("File Upload", $_FILES["file"]["name"]);
	row2("File Type", $_FILES["file"]["type"]);
	row2("File Size (Kb)", ($_FILES["file"]["size"] / 1024));
	//row2("Temp File ", $_FILES["file"]["tmp_name"] );

$dataDir="../../backupEm/";
$programName="emProgramName";
      move_uploaded_file($_FILES["file"]["tmp_name"],
      $dataDir . $programName);
      //row2("Stored in ", $dataDir . $programName );
      $versiones=get_mysql_lastVersion("select max(version_num) from app_version,platform where platform.id=app_version.platformid");
      foreach($versiones as $version)
      {
	      $lastVersion=$version["max(version_num)"];
      }
//row2("Last Version", $lastVersion);
$queryMyVersion="select max(version_num) from app_version,platform where app_version.platformid=platform.id and platform.name='". $_REQUEST["platform"] . "'";
      $myVersions=get_mysql_myVersion($queryMyVersion);
      foreach($myVersions as $myVersion)
      {
	      $myversion=$myVersion["max(version_num)"];
      }
//row2("My version Version", $myversion);
row2("Platform", $_REQUEST["platform"]);
//row2("Query", $queryMyVersion);
list ($mayor, $minor) = convierteNumeroVersion($lastVersion);
if($myversion < $lastVersion )
{ //Complete de current version with new platform.
}
else
{ //Create a new version number.
      $minor+=1;
      if($minor>99){
	      $minor=0;
	      $mayor+=1;
      }
}
      $nextVersion=$mayor.".".$minor;
//row2("Mayor", $mayor);
//row2("Minor", $minor);
row2("Version", $nextVersion);
      $salida=shell_exec('../../bin/creaNuevaVersion.sh '. $nextVersion . ' ' . $_REQUEST["platform"] );

    }
end_table();
admin_page_tail();
?> 
