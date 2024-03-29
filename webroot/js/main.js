$(document).ready(function() {
    $(".button-collapse").sideNav();

	$('tr').on("click", function() {
    	window.location = $(this).data('href');
	});

    $('.add-gallery-modal-trigger').leanModal({dismissible: true});
    $('.add-image-modal-trigger').leanModal({dismissible: true});

    $('.tooltip-toggle').focus(function() {
        $('body').append('<span class="tooltip z-depth-4 animated fadeIn">' + $(this).attr('data-content') + '</span>');
        var offset = $(this).offset();
        $('body').find('span.tooltip').css({'top' : offset.top, 'left' : offset.left - 320})
    });
    $('.tooltip-toggle').focusout(function() {
        $('body').find('span.tooltip').remove();
    });

    $(window).resize(function() {
        $('body').find('span.tooltip').remove();
    });

    var e = "#email";
    var p = "#password";
    var pc = "#password_confirmed";
    var emailPattern = /[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}/;
    var pwPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,50}$/;

    $(e).keyup(function () {
        toggleClasses(e, emailPattern);
    });

    $(p).keyup(function () {
        toggleClasses(p, pwPattern);
    });

    $(pc).keyup(function () {
        confirmPassword($(this).val());
    });

    function toggleClasses(element, pattern) {
		console.log('dsad');
        $(element).removeClass("valid");
        $(element).removeClass("invalid");

        if (!pattern.test($(element).val()) || $(element).val() == "") {
            $(element).addClass("invalid");
        }
        else {
            $(element).addClass("valid");
        }
    }

    function confirmPassword() {
        $(pc).removeClass("valid");
        $(pc).removeClass("invalid");

        if ($(p).val() == $(pc).val() && $(pc).val() != "") {
            $(pc).addClass("valid");
        }
        else {
            $(pc).addClass("invalid");
        }
    }

    $('#image_add_tags_fields').keyup(function() {
        var tag_field = $('#image_add_tags_fields');
        if ($(tag_field).val().length > 0) {
            var tags = $(tag_field).val().split(" ");
            $(tag_field).siblings('input').remove();
            $(tag_field).siblings('div.chip').remove();
            $(tag_field).after('<input type="hidden" name="image_add_tags" id="image_add_tags" value="' + escapeHtml(tags) + '">');
            for (var i = 0; i < tags.length; i++) {
                if (tags[i] != "") {
                    $(tag_field).after('<div class="chip">' + escapeHtml(tags[i]) + '</div>')
                }
            }
        } else {
            $(tag_field).siblings('input').remove();
            $(tag_field).siblings('div.chip').remove();
        }
    });

    $('#image_add_reset').click(function() {
        $('#image_add_tags_fields').siblings('div.chip').remove();
    });

    $('#flash-closer').click(function() {
        $('#flash-closer').parent().parent().parent().remove();
    });


});

function escapeHtml(text) {
    if (text instanceof Array) {
        for (var i = 0; i < text.length; i++) {
            text[i] = escapeHtml(text[i]);
        }
        return text;
    }
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

