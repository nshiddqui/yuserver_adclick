$(function() {
    loadElement();
});
$(document).ajaxComplete(function() {
    loadElement();
});

function loadElement() {
    $('input[type=checkbox]').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
    });
}