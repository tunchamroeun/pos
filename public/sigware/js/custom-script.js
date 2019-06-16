$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    //notification
    $.ajax({
        method:'post',
        type:'json',
        date:{
            '_token':$('meta[name="_token"]').attr('content')
        },
        url: 'http://fashion.local/report/check-stock-notification',
        success:function (data) {
            $('#notification-count').text(data.count);
            $('#stock-notification').html(data.html);
        }
    });
});
