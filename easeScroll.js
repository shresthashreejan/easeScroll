jQuery(document).ready(function ($) {
    var $easeButton = $('<div id="ease-scroll"><i class="fas fa-arrow-up"></i></div>').appendTo('body');

    $easeButton.css({
        'display': 'none',
        '--ease-scroll-bg-color': ease_scroll_vars.bg_color,
        '--ease-scroll-icon-color': ease_scroll_vars.icon_color
    });

    $easeButton.on('click', function () {
        $('html, body').animate({ scrollTop: 0 }, 800);
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $easeButton.fadeIn();
        } else {
            $easeButton.fadeOut();
        }
    });
});