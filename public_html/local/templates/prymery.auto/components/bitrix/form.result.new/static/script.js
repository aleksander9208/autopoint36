$(document).ready(function () {
    $('.staticForm__group_textarea input[type=hidden]').val($('h1').text().trim());

    $('.staticForm__group').on('click', function (event) {
        $(this).removeClass('novalid');
        $(this).find('.error-fld').hide();
    });
})