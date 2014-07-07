#!/bin/bash

rm /vagrant/application/scholar.sqlite3
sqlite3 /vagrant/application/scholar.sqlite3 < /vagrant/application/data/notecard.sql
curl -sS https://getcomposer.org/installer | php
cd /vagrant/application && ~/composer.phar install
cd /vagrant && npm install

