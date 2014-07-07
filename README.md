# Socket.IO + RabbitMQ proof of concept

## Installation

```bash
$ sudo aptitude install \
  openssh-server git-core build-essential gcc tree \
  rabbitmq-server \
  php5-dev php5-cli php5-curl php5-sqlite sqlite3 \
  openssl libssl-dev

$ vagrant ssh -c 'sqlite3 /vagrant/application/scholar.sqlite3 < /vagrant/application/data/notecard.sql'
$ vagrant ssh -c 'curl -sS https://getcomposer.org/installer | php'
$ vagrant ssh -c 'cd /vagrant/application && ~/composer.phar install'
$ vagrant ssh -c 'cd /vagrant && npm install'
```

## Running

```bash
$ vagrant up
```

In Vagrant session (`vagrant ssh`):

```bash
$ nodejs socketio_server.js 8080 &
$ nodejs socketio_server.js 8081 &
$ php application/scholard.php &
```

Now point separate browser sessions to

* http://33.33.34.101:8080
* http://33.33.34.101:8081
