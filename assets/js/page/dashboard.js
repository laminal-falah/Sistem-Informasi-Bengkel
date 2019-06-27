$(function() {
    $('#data-box').html("");
    $.ajax({
        url: http + 'api/v1/dashboard/',
        async: true,
        dataType: 'html',
        type: 'POST',
        success: function(res) {
            $('#data-box').append(JSON.parse(res));
        }
    });
});