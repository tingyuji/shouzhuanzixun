// JavaScript Document

$(function() {
    $("input[tip]").each(function() {
        var o = $(this),
        defaultvalue = o.attr('tip');
        if (!o.val()) {
            o.val(defaultvalue);
            o.css('color', '#aaa');
        }
        o.focus(function() {
            if (o.val() == defaultvalue) {
                o.val('');
                o.css('color', '#333');
            }
        }).blur(function() {
            if ($.trim(o.val()) === '') {
                o.val(defaultvalue);
                o.css('color', '#aaa');
            }
        })
    })
})