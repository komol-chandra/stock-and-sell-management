#!/bin/bash

# Array of Container IDs
container_ids=("849badcd387f" "0cdb11968d61" "40cf93a62228" "24e2222ee789")

# Stop containers using a loop
for container_id in "${container_ids[@]}"
do
    docker stop "$container_id"
done
