<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>subscribe</title>
</head>
<body>
<ul id="demo">
    <li id="username"></li>
</ul>
</body>
<script type="text/javascript" src="//cdn.bootcss.com/jquery/3.1.1/jquery.js"></script>
<script type="text/javascript" src="//cdn.bootcss.com/socket.io/1.7.2/socket.io.js"></script>
<script type="text/javascript">

    var socket = io('127.0.0.1:3000');
    socket.on('test-channel:addNewMessage',function (data) {
        //alert(data.name);
        $("#username").text(data.name);
    });

    /*new Vue({
        el: '#demo',
        data: {
            users: []
        },
        ready:function () {
             socket.on('test-channel:addNewMessage',function (data) {
                 console.log(data);
                this.users.push(data.name);
             }.bind(this))
        }
    });*/
</script>
</html>
