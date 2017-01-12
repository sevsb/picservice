
$(document).ready(function() {

    $('.submit_btn').click(function () {
        console.log('start');
        var host = $('.host').val();
        var namespace = $('.namespace').val();
        //var prefix = $('.prefix').val();
        
        __ajax('picservice.add_host',{host: host, namespace: namespace},function (data) {
            console.debug(data);
            //console.debug(data.ret);
             $.ajax({
                url: host + 'ajax.php?action=picservice.update_code',
                type: 'post',
                data: {code: data.info},
                success: function (data) {
                    console.debug(data);
                    window.location.href = '?';
                }
            });
        })
    });
});

