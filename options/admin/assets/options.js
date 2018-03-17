(function ( $ ) {
    "use strict";

    var op = {};



    op.fn = {
        init: function () {
            op.$ = {};
            op.$.window = $(window);
            op.$.html = $('html');
            op.$.body = $(document.body);
            op.$.options = $('.options-panel');

            op.$.sections_list = op.$.options.find('.sections-list');
            op.$.submit_panel = op.$.options.find('.submit-panel');
            op.fn.stick_submit_panel();
            op.$.sections_list.on('click', 'a', op.fn.stick_submit_panel);
            op.$.window.scroll(op.fn.stick_submit_panel);
        },
        stick_submit_panel: function (e) {
            var opt_bottom = op.$.options.offset().top + op.$.options.outerHeight(),
                window_bottom = op.$.html.scrollTop() + op.$.window.height(),
                visible = (window_bottom > opt_bottom);
            console.log(opt_bottom, window_bottom, (window_bottom > opt_bottom));
            if (visible && op.$.submit_panel.hasClass('fixed')) {
                op.$.submit_panel
                    .css('left', '')
                    .css('right', '')
                    .removeClass('fixed');
            } else if (!visible && !op.$.submit_panel.hasClass('fixed')) {
                op.$.submit_panel
                    .css('left', op.$.submit_panel.offset().left)
                    .css('right', op.$.window.width() - op.$.submit_panel.offset().left - op.$.submit_panel.outerWidth())
                    .addClass('fixed');
            }
        }
    };

    $(document).ready(op.fn.init);

}(jQuery));