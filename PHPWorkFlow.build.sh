#!/bin/bash
# Generate Propel files, deal w/ Composer and other stuff
#
# this script is meanrt to be run in a development context

clear;
rm -f src/sqldb.map
rm -f src/PHPWorkFlow.sql
sudo rm -f htdocs/WorkFlowApp/templates_c/*
composer install
vendor/propel/propel/bin/propel sql:build
vendor/propel/propel/bin/propel model:build
vendor/propel/propel/bin/propel sql:insert
composer install
sudo chmod 777 /home/jschlies/repos/PHPWorkFlow/artifacts/
sudo chmod 777 /home/jschlies/repos/PHPWorkFlow/artifacts/UnitTest/
sudo rm -f /home/jschlies/repos/PHPWorkFlow/artifacts/UnitTest/*
sudo rm -f api/storage/logs/lumen.log
mysqldump  -u root -pW1sc0ns1n  PHPWorkFlow > PHPWorkFlow.mysqldump.sql
sudo service memcached restart

