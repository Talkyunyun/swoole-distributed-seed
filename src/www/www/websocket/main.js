var ws, room_id, uid;
var host = '127.0.0.1';
var port = 8081;
var data = new Object();
data.controller_name = 'WebSocket';
data.method_name = '';

if (!window.WebSocket) {
    alert('您的浏览器不支持实时聊天');
}
init();
$(function() {
    // 加入房间
    $('#join_btn').click(function() {
        room_id = $('#room').val();

        data.method_name = 'join';
        data.room_id = room_id;

        ws.send(JSON.stringify(data));
    });

    // 发送消息
    $('#send_btn').click(function() {
        data.method_name = 'message';
        data.msg = $('#send_val').val();

        ws.send(JSON.stringify(data));
    });


    // 消息监听
    ws.onmessage = function(e) {
        var data = JSON.parse(e.data);
        if (typeof data.action != 'undefined') {
            if (data.action == 'join') {
                $('#page_1').hide();
                $('#page_2').show();
            }
        }
        console.log('接收到消息:', data);
    }

    ws.onclose = function(e) {
        console.log('断开连接,尝试第1次连接');
    }
    ws.onerror = function(e) {
        console.log('无法链接服务器')
    }
});


// 初始化socket链接
function init() {
    uid = getUrlString('uid');
    ws = new WebSocket('ws://' + host + ':' + port);
    ws.onopen = function(e) {
        data.method_name = 'init';
        data.uid = uid;
        ws.send(JSON.stringify(data));
    }
}

// 获取Url参数
function getUrlString(name){
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)" );
    var r = window.location.search.substr( 1).match(reg);
    if(r!= null) return  unescape(r[2]); return null;
}
