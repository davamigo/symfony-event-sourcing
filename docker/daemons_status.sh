#!/bin/bash

service="docker_evsourcing_server";
user="david"
daemon1="app:event-storage-consumer-daemon"
daemon2="app:database-updater-daemon"

enabled=$( docker ps --format "{{.Names}}" | grep -i "$service" )
if [ "$enabled" == "" ]
then
    echo -e "\033[31mContainer \033[33m$service\033[31m not started!\033[0m\n";
    exit 1;
fi;

dir=$(dirname $0)
cd $dir

echo -e "\033[33mDaemons status checker...\033[0m"

if [ ! -z $(docker exec -t -u $user $service pgrep -f $daemon1) ]
then
    echo -e "$daemon1 \033[32mis running!\033[0m"
else
    echo -e "$daemon1 \033[31mis not running!\033[0m"
fi

if [ ! -z $(docker exec -t -u $user $service pgrep -f $daemon2) ]
then
    echo -e "$daemon2 \033[32mis running!\033[0m"
else
    echo -e "$daemon2 \033[31mis not running!\033[0m"
fi
