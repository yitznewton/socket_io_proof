# Socket.IO + RabbitMQ proof of concept

## Objective

This project shows how Socket.IO can be used as a browser-server message
transport layer, forwarding application instructions into a messaging
queue (RabbitMQ) from which a daemon-based application core can pop jobs
off and perform them.

In addition to allowing Socket.IO to scale without need for shared storage
or syncing within Socket.IO, it also completely decouples the application
logic from this browser-server message transport. This frees us from the
need to implement the transport and application layers on the same platform
or in the same language, as well as allowing for change down the road. We
can now write the application in PHP (as here), or Hack, or Go ..., and also
replace Socket.IO with the Ruby implementation of Faye, or the Python
implementation of Autobahn, without affecting the application core.

## Installation

```bash
$ vagrant up
$ vagrant ssh -c /vagrant/install.sh
```

## Running

```bash
$ vagrant ssh

# in vagrant shell:
$ /vagrant/run.sh
```

Now point separate browser sessions to

* http://33.33.34.101:8080
* http://33.33.34.101:8081
