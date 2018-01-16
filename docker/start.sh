#!/bin/bash

dockerfile="docker-compose.yml"
dir=$(dirname $0)
cd $dir

echo -e "Starting $dockerfile..."

docker-compose -f $dockerfile build
if [ $? -ne 0 ]; then
    exit 1
fi

mkdir -p ../var/docker/mysql
mkdir -p ../var/docker/mongo

docker-compose -f $dockerfile up -d --remove-orphans
if [ $? -ne 0 ]; then
    exit 1
fi
