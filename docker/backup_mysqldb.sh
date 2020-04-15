#!/bin/bash
set -e

source env.conf
NAMEPREFIX='1'
DBNAME=opencart
CONTAINER=opencart_mysql_$NAMEPREFIX
echo "backup.. " $DBNAME $CONTAINER
docker exec $CONTAINER /usr/bin/mysqldump -u root --password=root $DBNAME > backup.sql
