<?php
require_once("../inc/db.inc");
require_once("../inc/util.inc");
require_once("../inc/countries.inc");
require_once("../inc/utilidades.inc");


db_init();
$user = get_logged_in_user();


  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
$file=$_FILES["file"];
echo " size : " . $file['size'] . " error : " . $file['error'] . "<br>";
echo " name : " . $file['name']  . "<br>";
echo " type : " . $file['type']  . "<br>";
echo " tmp_name : " . $file['tmp_name']  . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

$dataDir="../../backupEm/";
$programName="emProgramName";
      move_uploaded_file($_FILES["file"]["tmp_name"],
      $dataDir . $programName);
      echo "Stored in: " . $dataDir . $programName . "<br>";
      $versiones=get_mysql_lastVersion("select max(version_num) from app_version,platform where platform.id=app_version.platformid");
      foreach($versiones as $version)
      {
	      $lastVersion=$version["max(version_num)"];
      }
echo "lastVersion : " . $lastVersion . "<br>";
$queryMyVersion="select max(version_num) from app_version,platform where app_version.platformid=platform.id and platform.name='". $_REQUEST["platform"] . "'";
      $myVersions=get_mysql_myVersion($queryMyVersion);
      foreach($myVersions as $myVersion)
      {
	      $myversion=$myVersion["max(version_num)"];
      }
echo "myversion : " . $myversion . "<br>";
echo "platform : " . $_REQUEST["platform"] . "<br>";
echo "query  : " . $queryMyVersion . "<br>";
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
echo "mayor : " . $mayor . " minor:" . $minor . " nextVersion : " . $nextVersion . "<br>";
      $salida=shell_exec('../../bin/creaNuevaVersion.sh '. $nextVersion . ' ' . $_REQUEST["platform"] );

    }

?> 
