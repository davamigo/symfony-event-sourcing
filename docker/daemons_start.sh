#!/bin/bash

service="docker_evsourcing_server";
user="david"
console="bin/console"
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

# nohup $console app:event-storage-consumer-daemon & 1> /dev/null 2> /dev/null
if [ -z $(docker exec -t -u $user $service pgrep -f $daemon1) ]
then
    echo -e "\033[33mStarting daemon:\033[0m $daemon1"
    docker exec -d -u $user $service $console $daemon1
fi

# nohup $console app:app:database-updater-daemon & 1> /dev/null 2> /dev/null
if [ -z $(docker exec -t -u $user $service pgrep -f $daemon2) ]
then
    echo -e "\033[33mStarting daemon:\033[0m $daemon2"
    docker exec -d -u $user $service $console $daemon2
fi
