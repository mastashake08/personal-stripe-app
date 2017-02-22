
var fs =  require('fs');

var options = {
    key:    fs.readFileSync('/etc/nginx/ssl/payments.jyroneparker.com/172756/server.key'),
    cert:   fs.readFileSync('/etc/nginx/ssl/payments.jyroneparker.com/172756/server.crt')
};
var app = require('https').createServer(options);
var io = require('socket.io')(app);

var Redis = require('ioredis');
var redis = new Redis();

app.listen(7001, function() {
    console.log('Server is running!');
});

function handler(req, res) {
    res.writeHead(200);
    res.end('Test');
}

io.on('connection', function(socket) {

});
redis.psubscribe('*', function(err, count) {
    //
});

redis.on('pmessage', function(subscribed, channel, message) {

    message = JSON.parse(message);
    console.log(message);
    io.emit(channel , message);


});
