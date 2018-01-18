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

echo -e "\033[33mDaemons status tool...\033[0m"

if [ "$1" == "" ]
then
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

    echo -e "\nUse:"
    echo -e "\t\033[36m$0 start\033[0m to start the daemons."
    echo -e "\t\033[36m$0 stop\033[0m to stop the daemons.\n"

elif [ "$1" == "start" ]
then
    if [ -z $(docker exec -t -u $user $service pgrep -f $daemon1) ]
    then
        # nohup $console app:event-storage-consumer-daemon & 1> /dev/null 2> /dev/null
        echo -e "\033[32mStarting daemon:\033[0m $daemon1"
        docker exec -d -u $user $service $console $daemon1
    else
        echo -e "$daemon1 \033[33malready started!\033[0m"
    fi

    if [ -z $(docker exec -t -u $user $service pgrep -f $daemon2) ]
    then
        # nohup $console app:app:database-updater-daemon & 1> /dev/null 2> /dev/null
        echo -e "\033[32mStarting daemon:\033[0m $daemon2"
        docker exec -d -u $user $service $console $daemon2
    else
        echo -e "$daemon2 \033[33malready started!\033[0m"
    fi

elif [ "$1" == "stop" ]
then
    if [ ! -z $(docker exec -t -u $user $service pgrep -f $daemon1) ]
    then
        echo -e "\033[31mStopping daemon:\033[0m $daemon1"
        docker exec -d -u $user $service kill -9 $(docker exec -t -u $user $service pkill -f $daemon1)
    else
        echo -e "$daemon1 \033[33malready stoped!\033[0m"
    fi

    if [ ! -z $(docker exec -t -u $user $service pgrep -f $daemon2) ]
    then
        echo -e "\033[31mStopping daemon:\033[0m $daemon2"
        docker exec -d -u $user $service kill -9 $(docker exec -t -u $user $service pkill -f $daemon2)
    else
        echo -e "$daemon1 \033[33malready stoped!\033[0m"
    fi
fi
