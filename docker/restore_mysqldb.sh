#!/bin/bash
set -e

source env.conf
NAMEPREFIX='1'
DBNAME=opencart
CONTAINER=opencart_mysql_$NAMEPREFIX
echo "restoring.. " $DBNAME $CONTAINER
cat backup.sql | docker exec -i $CONTAINER /usr/bin/mysql -u root --password=root $DBNAME
