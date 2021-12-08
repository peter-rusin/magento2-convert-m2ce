define(
    ['jquery'],
    function ($) {
        return function (config, element) {
            $(element).click(function(e) {
                if (confirm('Do you really want to leave website?')) {
                    window.location.href = $(this).attr('href')
                } else {
                    e.preventDefault()
                }
            });
        };
    }
);
