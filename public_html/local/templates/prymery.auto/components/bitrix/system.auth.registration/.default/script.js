function personalCheckbox(personalCheckbox) {
    if ($(personalCheckbox).length > 0) {
        $(personalCheckbox).each(function (index, element) {
            var form, submit;

            form = $(element).closest('form');
            submit = form.find('button, input[type=submit]');
            submit.prop('disabled', !$(element).prop("checked"))
        });
    }
};
personalCheckbox('#USER_PERSONAL');
$('#USER_PERSONAL').on('change', function () {
    personalCheckbox(this);
});