$(document).ready(function () {
    $('.modalForm__group').on('click', function (event) {
        $(this).addClass('focus');
        $(this).removeClass('novalid');
        $(this).find('.error-fld').hide();
    });
    $(document).mouseup(function (e){
        var div = $(".modalForm__group.focus");
        if (!div.is(e.target) && div.has(e.target).length === 0 && div.children('input').val()=="") {
            div.removeClass('focus');
        }
    });
})