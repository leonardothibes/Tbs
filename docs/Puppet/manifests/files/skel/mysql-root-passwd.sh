#!/bin/bash

if [ "$1" == "" ]; then
    echo "Informe a nova senha do root"
    exit 1
fi

mysqladmin -u root password "$1" -p
sudo service mysql restart