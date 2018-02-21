#!/bin/sh
date=`date "+%Y-%m-%d"`
date_del=`date "+%Y-%m-%d" --date='28 day ago'`

project="irbis"
path_from="/home/mstar/backup/$project/_backup"
path_site="/var/www/irbis-vilnius.mstarproject.com"

username=$(php $path_site/connect.php _for_cron_username)
password=$(php $path_site/connect.php _for_cron_password)
database=$(php $path_site/connect.php _for_cron_database)

/usr/bin/mysqldump $database -u $username -p$password --compatible=no_key_options --default-character-set=UTF8 --set-charset \
cat_cross cat_cross_stop \
> $path_from/"$project"_weekly_temp.sql

if [ -n "$1" ]  # && "demo" == $1
then
    mv $path_from/"$project"_weekly_temp.sql $path_from/"$project"_weekly_demo_backup.sql
else
    gzip -c $path_from/"$project"_weekly_temp.sql > $path_from/"$project"_weekly_backup_$date.sql.zi_
    rm $path_from/"$project"_weekly_temp.sql
    rm $path_from/"$project"_weekly_backup_$date_del.sql.zi_
fi

# remote backup
RM_HOST="88.198.64.245"
RM_DIR="/var/opt/_backup/$project/"
EXCLUDE="--exclude=$project_weekly_demo_backup.sql --exclude=catalog"
/usr/bin/rsync ${EXCLUDE} -L -a -z --delete $path_from/ mstar@$RM_HOST:$RM_DIR
#/usr/bin/scp $path_from/"$project"_backup_$date.sql.zi_ mstar@$HOST:$DIR
# ln -s /var/opt/_backup/auto /home/mstar/backup/auto/_backup
# end remote backup

/usr/bin/lftp << EOF
open filer:fvbnw984rtuq03d2qw@46.166.162.51
mput $path_from/*
bye
EOF
