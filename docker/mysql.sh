#!/bin/bash

service="docker_evsourcing_database";

enabled=$( docker ps --format "{{.Names}}" | grep -i "$service" )
if [ "$enabled" == "" ]
then
    echo -e "\033[31mContainer \033[33m$service\033[31m not started!\033[0m\n";
    exit 1;
fi;

dir=$(dirname $0)
cd $dir

args=""
while [[ $# -ge 1 ]]; do
    args="$args $1"
    shift
done

docker exec -it $service mysql -uroot -proot $args
