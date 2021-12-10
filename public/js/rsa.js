$(document).ready(function() {
    $('#re-password').keyup(function() {
        if ($(this).val() != $('#password').val()) {
            $('.check-password').html('Không chính xác');
            $('.check-password').css({ 'color': 'red', 'font-size': '13px' });
        } else {
            $('.check-password').html('Trùng khớp');
            $('.check-password').css({ 'color': 'green', 'font-size': '13px' });
        }
    })

})