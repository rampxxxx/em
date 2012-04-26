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
      echo "Stored in: " . $dataDir . $programName;
      $versiones=get_mysql_lastVersion("select max(version_num) from app_version,platform where platform.id=app_version.platformid");
      foreach($versiones as $version)
      {
	      $lastVersion=$version["max(version_num)"];
      }
echo "lastVersion : " . $lastVersion . "<br>";
      $cien=100;
      $mayor=floor($lastVersion/$cien);
      $minor=$lastVersion%$cien;
      $minor+=1;
      $nextVersion=$mayor.".".$minor;
echo "mayor : " . $mayor . " minor:" . $minor . " nextVersion : " . $nextVersion . "<br>";
      $salida=shell_exec('../../bin/creaNuevaVersion.sh '. $nextVersion . ' ' . $_REQUEST["platform"] );

    }

?> 
