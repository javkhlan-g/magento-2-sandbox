#!/usr/bin/env bash
mysqldump -h mysql -u root -pmagento --single-transaction --routines --triggers --events --verbose magento | sed -e 's/DEFINER[ ]*=[ ]*[^*]*\*/\*/' | gzip -c > /var/www/html/etc/mysql/init-db/local-db-save.sql.gz