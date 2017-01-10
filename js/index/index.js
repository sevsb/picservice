
$(document).ready(function() {

    $('.submit_btn').click(function () {
        console.log('start');
        var host = $('.host').val();
        var namespace = $('.namespace').val();
        var prefix = $('.prefix').val();
        
        $.ajax({
            url: "ajax.php?action=" + 'picservice.add_host',
            type: 'post',
            data: {host: host, namespace: namespace, prefix: prefix},
            success: function (data) {
                data = eval("(" + data + ")");
                console.debug(data);
                //console.debug(data.ret);
                $.ajax({
                    url: host + 'ajax.php?action=picservice.update_code',
                    type: 'post',
                    data: {code: data.ret},
                    success: function (data) {
                        console.debug(data);
                        window.location.href = '?';
                    }
                });
            }
        });
    });
});

