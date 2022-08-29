$(document).ready(function () {
    $('input').on('focus', function () {
        $(this).removeClass('novalid');
    })
})