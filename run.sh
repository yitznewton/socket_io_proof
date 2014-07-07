#!/bin/bash

cd /vagrant/
nodejs socketio_server.js 8080 &
nodejs socketio_server.js 8081 &
php application/scholard.php &

