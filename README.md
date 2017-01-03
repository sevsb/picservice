#picservice

共三个部分参与:
1. Web客户端，浏览器。
2. 应用服务器，业务服务器，app server。
3. 图片服务器，picservice。


布署：
    picservice为每个app server分配一个authorized_code，并将相同的code设置到各app中。



获取access_token:
    app server向picservice请求token：
    http://picservice/index.php?index/token&authorized_code=XXXXXX
    根据 请求者IP地址 + authorized_code（布署）判断是否合法。
    返回json:
    { "access_token": "xxxxxxxxxxx", "expired_time": 3600 }
    { "error": 1000, "desc": "token expired." }
    { "error": 1001, "desc": "invalid authorized code." }
    { "error": 1002, "desc": "unknown error." }


刷新token:


上传图片：
    JS上传文件前从app server拿到获取到的token以及回调URL，构造上传ajax向picservice发起上传请求:
    
    url: http://picservice/ajax.php,
    action: index.upload,
    data: {
        access_token: token,
        imgsrc: imgsrc,
        redirect_url: redirect_url
    }

    上传完成后，picservice将图片绑定到相应的app server，并回调redirect_url：
    http://app server/redirect_url&filename=YYYYYY

    app server在回调处完成后续剩余逻辑后，将结果返回至picservice:
    { "ret": "success" }
    { "ret": "fail", "reason": "xxxxx" }

    相同的结果由picservice通过ajax返回给客户端js。


访问图片：
    app server获取到token后，拼装图片URL地址发送给客户端：
    http://picservice/index.php?index/view&token=XXXXXX&pic=YYYYYY

    picservice收到客户端访问请求后，根据token判断当前请求来源于哪个app server，根据图片与app server的绑定情况决定是否有权限访问YYYYYY图片。





