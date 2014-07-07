# Socket.IO + RabbitMQ proof of concept

## Installation

```bash
$ vagrant ssh -c '/vagrant/install.sh'
```

## Running

```bash
$ vagrant up
$ vagrant ssh -c /vagrant/run.sh
```

In Vagrant session (`vagrant ssh`):

```bash
$ cd /vagrant/
$ nodejs socketio_server.js 8080 &
$ nodejs socketio_server.js 8081 &
$ php application/scholard.php &
```

Now point separate browser sessions to

* http://33.33.34.101:8080
* http://33.33.34.101:8081
