/**
 * @desc:
 * @User:   xiao xiao (xiaojm@yueus.com)
 * @Date:   2017/3/2
 * @Time:   22:59
 * version: 1.0
 */

var http = require('http').Server();
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
redis.subscribe('test-channel');

redis.on('message', function (channel, message) {
    //console.log(message);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

http.listen(3000);
