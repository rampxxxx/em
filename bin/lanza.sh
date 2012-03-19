#!/bin/bash

PROJECT_ROOT=../..


cd $PROJECT_ROOT # go

pwd >> /tmp/lanza.txt
echo "Desde el script lanza.sh" >> /tmp/lanza.txt
echo "bin/sample_work_generator_em -d 3 --app em --in_template_file em_in.xml --out_template_file em_out.xml --user_id $1 --alias $2 >> /tmp/lanza.txt 2>&1 " >> /tmp/lanza.txt
bin/sample_work_generator_em -d 3 --app em --in_template_file em_in.xml --out_template_file em_out.xml --user_id $1 --alias $2 >> /tmp/lanza.txt 2>&1

cd - #back
