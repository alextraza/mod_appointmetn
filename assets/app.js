jQuery(document).ready(function() {
    var $ = jQuery;
    var name = $('#feedback-name');
    var email = $('#feedback-email');
    var phone = $('#feedback-phone');
    var text = $('#feedback-text');

    $('#feedback').on('click', ' button', function(e) {
        //validate block
        if (!checkField(name)) {
            return false;
        }
        if (!checkField(phone)) {
            return false;
        }
        if (email.val() != '') {
            if (!validateEmail(email)) {
                return false;
            }
        }
        if (!checkField(text)) {
            return false;
        }

        // send ajax
        let action = window.location;
			if (confirm("Отправить сообщение?")) {
        $.ajax({
            type: 'POST',
            url: action,
            data: {
                option: 'com_ajax',
                module: 'appointment',
                format: 'json',
                method: 'post',
                name: name.val(),
                email: email.val(),
                phone: phone.val(),
                text: text.val()
            },
            success: function(data) {
							data = JSON.parse(data.data)
							if (data.status == 'success') {
								$('#feedback').html(data.message);
							} else {
								console.log(data.message.field);
								field = $('#feedback-' + data.message.field);
								field.addClass('invalid');
								field.next().text(data.message.text);
								field.next().show();
							}
            },
            error: function(error) {
                console.log(error);
            }
        });

			}
        return false;
    })

    $('#feedback input').on('blur', function() {
        if (! checkField($(this))) {
            return false;
        }
        $(this).next().hide();
    })

    $('#feedback textarea').on('blur', function() {
        if (! checkField($(this))) {
            return false;
        }
        $(this).next().hide();
    })

    $('#feedback-email').on('blur', function() {
        if ($(this).val() != '') {
            if (! validateEmail($(this))) {
                return false;
            }
        }
        $(this).next().hide();

    })

    /**
     * check, is field not empty
     */
    function checkField(field) {
        field.val(field.val().trim());
        if (!field.val()) {
            field.addClass('invalid');
            field.next().text('Поле обов\'вязкове для заповнення');
            field.next().show();
            return false;
        }
        return true;
    }

    /**
     * check, is email correct
     */
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!re.test(email.val())) {
            email.addClass('invalid');
            email.next().text("Помилковий формат email");
            email.next().show();
            return false;
        }
        email.removeClass('invalid');
        return true;
    }
});
