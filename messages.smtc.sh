#!/bin/sh


echo "Dumping SmtC Messages table:"
/usr/bin/mysqldump Apps SmtC_Messages > SmtC_Messages.sql

ls -l SmtC_Messages.sql

echo "Dumping SmtC DB:"

/usr/bin/mysqldump SmtC > SmtC.sql

ls -l SmtC.sql
