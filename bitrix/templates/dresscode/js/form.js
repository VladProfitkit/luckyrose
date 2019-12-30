
jQuery(document).ready(function () {
    $('#distr_form').on('submit', function (event) {
        event.preventDefault();

        var t = $(this);
        var action = t.attr('action');
        var data = t.serialize();
        $.ajax({
            type: "POST",
            url: action,
            data: data,
            success: function (msg) {
                $('#distr_form').html('<div style="text-align: center;">Сообщение отправлено</div>');
            }
        });
    });
});