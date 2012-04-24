<?php
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
    //if (file_exists("upload/" . $_FILES["file"]["name"]))
    if (file_exists($dataDir . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      $dataDir . $programName);
      echo "Stored in: " . $dataDir . $programName;
$salida=shell_exec('../../bin/creaNuevaVersion.sh '. $version . ' ' . $plataforma );

      }
    }

?> 
