<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>跳转提示</title>
</head>
<body>
    <script src="{:url('/static/layui/layui.js')}"></script>
    <link rel="stylesheet" href="{:url('/static/layui/css/layui.css')}">
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
    <!--
    * $msg 待提示的消息
    * $url 待跳转的链接
    * $time 弹出维持时间（单位秒）
    * icon 这里主要有两个layer的表情，5和6，代表（哭和笑）
    -->
    <script type="text/javascript">
       layui.use('layer', function(){
            var layer = layui.layer;
            var msg = '<?php echo(strip_tags($msg));?>';
            var url = '<?php echo($url);?>';
            // 去除.html
            url = url.replace(/\.html/, "");
            var wait = '<?php echo($wait);?>';
        <?php
            switch ($code) {
                case 1:
                        ?>
                    layer.msg(msg,{icon:"6",time:wait*1000});
                <?php
                    break;
                case 0:
                        ?>
                    layer.msg(msg,{icon:"5",time:wait*1000});
                <?php
                    break;
            }
                ?>
            setTimeout(function(){
                location.href=url;
            },1000)
        });
    </script>
</body>
</html>