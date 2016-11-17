#!/bin/bash
docker-compose -f docker-compose-base.yml -f docker-compose-custom.yml -f docker-compose-prod.yml $@
