#!/bin/bash

PROJECT_ROOT=../..
SCRIPT_LOG=/tmp/$0

NOMBRE_PROYECT=em
DIR_APPS=apps
NUMERO_VERSION=$1
NOMBRE_PLATAFORMA=$2
JOB_FILE_NAME=
VERSION_FILE_NAME=version.xml
DIR_ORIGINAL=`pwd`
cd $PROJECT_ROOT # go
DIR_ACTUAL=`pwd`
NOMBRE_PROYECTO=`basename $DIR_ACTUAL`
# em_job_1.3.xml
JOB_FILE_NAME="$NOMBRE_PROYECTO"_job_"$NUMERO_VERSION".xml
# emwrapper_1.3_i686-pc-linux-gnu
NOMBRE_WRAPPER="$NOMBRE_PROYECTO"wrapper_"$NUMERO_VERSION"_"$NOMBRE_PLATAFORMA"
# em_1.3_i686-pc-linux-gnu
NOMBRE_APP="$NOMBRE_PROYECTO"_"$NUMERO_VERSION"_"$NOMBRE_PLATAFORMA"
# /home/boincadm/em/apps/em/1.3/i686-pc-linux-gnu
DIR_VERSION=$DIR_ACTUAL/$DIR_APPS/$NOMBRE_PROYECTO/$NUMERO_VERSION/$NOMBRE_PLATAFORMA
$WRAPPER_BIN_LINUX_32=wrapper_25353_i686-pc-linux-gnu
$WRAPPER_BIN_LINUX_64=wrapper_25353_x86_64-pc-linux-gnu
$WRAPPER_BIN_MACOSX_32=wrapper_25353_windows_intelx86.exe
$WRAPPER_BIN_MACOSX_64=wrapper_25353_windows_x86_64.exe
$WRAPPER_BIN_WINDOWS_32=wrapper_25353_windows_intelx86.exe
$WRAPPER_BIN_WINDOWS_64=wrapper_25353_windows_x86_64.exe
$APP_BIN=emProgramName


DIR_DATA="$PROJECT_ROOT"/backupEm
if [[ "$NOMBRE_PLATAFORMA" == *linux* ]]
then
	WRAPPER_BIN_COMPLETE="$DIR_DATA"/"$WRAPPER_BIN_LINUX_32"
	APP_BIN_COMPLETE="$DIR_DATA"/"$APP_BIN_LINUX"
else
	if [[ "$NOMBRE_PLATAFORMA" == *windows* ]]
	then
		WRAPPER_BIN_COMPLETE="$DIR_DATA"/"$WRAPPER_BIN_WINDOWS_32"
		APP_BIN_COMPLETE="$DIR_DATA"/"$APP_BIN_WINDOWS"
	else
		if [[ "$NOMBRE_PLATAFORMA" == *macosx* ]]
		then
			WRAPPER_BIN_COMPLETE="$DIR_DATA"/"$WRAPPER_BIN_MACOSX_32"
			APP_BIN_COMPLETE="$DIR_DATA"/"$APP_BIN_MACOSX"
		else
			WRAPPER_BIN_COMPLETE="$DIR_DATA"/"$WRAPPER_BIN_LINUX_32"
			APP_BIN_COMPLETE="$DIR_DATA"/"$APP_BIN_LINUX"
		fi
	fi
fi




pwd >> $SCRIPT_LOG
echo "Desde el script " $0  >> $SCRIPT_LOG
echo " " >> $SCRIPT_LOG 2>&1

##########################################
## Creacion de estructura de directorios #
##########################################

mkdir -p $DIR_VERSION
##########################################
## Creacion de scripts de wrapper, ...   #
##########################################

cat > $DIR_VERSION/$JOB_FILE_NAME << DELIM 
<job_desc>
<task>
<application>em</application>
<command_line> -i ./in -o ./out</command_line>
</task>
</job_desc>
DELIM

cat > $DIR_VERSION/$VERSION_FILE_NAME << DELIM
<version>
<file>
<physical_name> $NOMBRE_WRAPPER  </physical_name>
<main_program/>
</file>
<file>
<physical_name> $NOMBRE_APP </physical_name>
<logical_name> $NOMBRE_PROYECTO </logical_name>
</file>
<file>
<physical_name> $JOB_FILE_NAME </physical_name>
<logical_name>job.xml</logical_name>
</file>
</version>
DELIM

 

##########################################
## Copia de wrapper.                     #
##########################################

cp $WRAPPER_BIN_COMPLETE  $DIR_VERSION

##########################################
## Copia de ejecutable.                  #
##########################################

cp $APP_BIN_COMPLETE  $DIR_VERSION




cd $DIR_ORIGINAL #back
