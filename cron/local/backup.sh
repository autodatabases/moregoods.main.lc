!/bin/shdate=`date "+%Y-%m-%d"`
date_del=`date "+%Y-%m-%d" --date='7 day ago'`

project="obriy"
path_from="/home/mstar/backup/$project/_backup"
path_site="/var/www/vhosts/moregoods.com.ua/httpdocs"

username=$(php $path_site/connect.php _for_cron_username)
password=$(php $path_site/connect.php _for_cron_password)
database=$(php $path_site/connect.php _for_cron_database)

/usr/bin/mysqldump $database -u $username -p$password --compatible=no_key_options --default-character-set=UTF8 --set-charset \
> $path_from/"$project"_temp.sql

gzip -c $path_from/"$project"_temp.sql > $path_from/"$project"_backup_$date.sql.zi_
rm $path_from/"$project"_temp.sql
rm $path_from/"$project"_backup_$date_del.sql.zi_

/usr/bin/lftp << EOF
open ftp_acc:ftp@pa55w0rd@ftp.logisticplus.com.ua
mput $path_from/*
bye
EOF
