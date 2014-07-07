var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var amqp = require('amqplib');
var when = require('when');

app.get('/', function(req, rsp) {
    rsp.sendfile('index.html');
});

var queueName = 'scholar_notebook_work',
    announceQueueName = 'notecard_updates',
    jobsChannel,
    announceChannel,
    announceQueue;

amqp.connect('amqp://localhost').then(function(conn) {
    return conn.createChannel().then(function(ch) {
        jobsChannel = ch;
        return ch.assertQueue(queueName, {durable: true});
    }).then(function() {
        console.log('ready to post to rabbit jobs channel');
    }).then(function() {
        conn.createChannel().then(function(ch) {
            announceChannel = ch;
            ch.assertExchange(announceQueueName, 'fanout', {durable: false}).then(function() {
                return ch.assertQueue('', {exclusive: true});
            }).then(function(queueOk) {
                announceQueue = queueOk.queue;
                return ch.bindQueue(announceQueue, announceQueueName, '');
            }).then(function() {
                console.log('ready to listen for announcements from rabbit');
            });
        });
    });
});

io.on('connection', function(socket) {
    console.log('a user connected');

    socket.on('notecard_update', function(message) {
        var messageString = JSON.stringify(message);
        console.log('notecard_update: ' + messageString);
        console.log('sending update job to rabbit');
        jobsChannel.sendToQueue(queueName, new Buffer(messageString), {deliveryMode:true});
    });

    announceChannel.consume(announceQueue, function(message) {
        var update = JSON.parse(message.content);
        console.log('receiving announcement from rabbit: ' + message.content);
        console.log('sending update to browser clients');
        io.emit('notecard_updated', update);
    }, {noack: true});

    console.log('listening for announcements from rabbit');
});

var port = process.argv[2];

http.listen(port, function() {
    console.log('listening on port ' + port);
});
