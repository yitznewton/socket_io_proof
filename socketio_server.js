var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var amqp = require('amqplib');
var when = require('when');

app.get('/', function(req, rsp) {
    rsp.sendfile('index.html');
});

var queueName = 'scholar_notebook_work',
    jobsChannel,
    announceChannel;

amqp.connect('amqp://localhost').then(function(conn) {
  return when(conn.createChannel().then(function(ch) {
    ch.assertQueue(queueName, {durable: true});
    jobsChannel = ch;
    console.log('rabbit ready to post to jobs channel');
  }));
});

io.on('connection', function(socket) {
    console.log('a user connected');

    socket.on('notecard_update', function(message) {
        var messageString = JSON.stringify(message);
        console.log('notecard_update: ' + messageString);
        jobsChannel.sendToQueue(queueName, new Buffer(messageString), {deliveryMode:true});
        console.log('rabbit notified');
    });
});


http.listen(8080, function() {
    console.log('listening on 8080');
});
