#!/usr/bin/env bash

cd laradock
docker-compose exec workspace php "$@"
cd ..