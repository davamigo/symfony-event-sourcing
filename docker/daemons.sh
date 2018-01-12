#!/bin/bash

service="docker_evsourcing_server";
user="david"
console="bin/console"

enabled=$( docker ps --format "{{.Names}}" | grep -i "$service" )
if [ "$enabled" == "" ]
then
    echo -e "\033[31mContainer \033[33m$service\033[31m not started!\033[0m\n";
    exit 1;
fi;

dir=$(dirname $0)
cd $dir

# nohup $console app:event-storage-consumer-daemon & 1> /dev/null 2> /dev/null
docker exec -d -u $user $service $console app:event-storage-consumer-daemon

# nohup $console app:app:database-updater-daemon & 1> /dev/null 2> /dev/null
docker exec -d -u $user $service $console app:database-updater-daemon
