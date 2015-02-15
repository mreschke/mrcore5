#!/bin/bash

# mRcore Install Script
# mReschke 2014-10-21

base="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $base

if [ -d "$base/vendor" ]; then
	echo "$base/vendor folder exists.  Means this install.sh script has probably already been run!"
	exit 0
fi

## FIXME
### REMEMBER to composer update on each of the built in mrcore workbenches


cat > .env.php << "EOF"
<?php
return [

'company' => 'mrcore5.dev',
'logo_text' => '<div>mrcore<i class="fa fa-sun-o"></i>wiki</div>',
'timezone' => 'America/Chicago',

'host' => 'mrcore5.dev',
'url' => 'http://mrcore5.dev',
'base_url' => '//mrcore5.dev',
'file_base_url' => 'mrcore5.dev/file',
'webdav_base_url' => 'webdav.mrcore5.dev',
'files' => '/var/www/mrcore5/files',

'use_cache' => false,
'cache_expires' => 1,
'use_encryption' => true,
'key' => 'SETME',
'cipher' => MCRYPT_RIJNDAEL_128,

'mysql_host' => 'mysql',
'mysql_database' => 'mrcore5',
'mysql_username' => 'root',
'mysql_password' => '',
'mysql_prefix' => '',
'redis_default_db' => 0,

'workbench_name' => 'Matthew Reschke',
'workbench_email' => 'mail@mreschke.com',

'debug' => true,

];
EOF

key=`tr -cd '[:alnum:]' < /dev/urandom | fold -w30 | head -n1`
sed -i "s/SETME/$key/g" .env.php

#sed -i "s/'Mrcore\\\\Services/#'Mrcore\\\\Services/g" app/config/app.php
#sed -i "s/'Mrcore\\\\Bootswatch/#'Mrcore\\\\Bootswatch/g" app/config/app.php
composer install
composer update -d workbench/mrcore/bootswatch-theme
composer update -d workbench/mrcore/workbench-framework
composer update -d workbench/theme/default-theme
./artisan migrate
./artisan db:seed
#sed -i "s/#'Mrcore\\\\Services/'Mrcore\\\\Services/g" app/config/app.php
#sed -i "s/#'Mrcore\\\\Bootswatch/'Mrcore\\\\Bootswatch/g" app/config/app.php


mkdir -p $base/files/index/{1..10}
ln -s ../../mrcore/workbench "$base/files/index/5/app"



#--------------------
#New Install Docs
#=================

#cd /var/www
#git clone https://github.com/mreschke/mrcore5
#cd mrcore5
#edit bootstrap/start.php with environment hostname if dev box
#Create .env.local.php with proper values
#composer install
#create database in mysql manually
#edit app/config/app.php and comment out my custom services including the bootswatch theme
#./artisan migrate
#./artisan db:seed
#uncomment app.php again
#done!

