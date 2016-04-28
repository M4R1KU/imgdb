$(document).ready(function() {
	$('tr').on("click", function() {
    	window.location = $(this).data('href');
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
        $(element).parent().removeClass("has-success");
        $(element).parent().removeClass("has-error");


        if (!pattern.test($(element).val()) || $(element).val() == "") {
            $(element).parent().addClass("has-error");
        }
        else {
            $(element).parent().addClass("has-success");
        }
    }

    function confirmPassword() {
        $(pc).parent().removeClass("has-success");
        $(pc).parent().removeClass("has-error");

        if ($(p).val() == $(pc).val() && $(pc).val() != "") {
            $(pc).parent().addClass("has-success");
        }
        else {
            $(pc).parent().addClass("has-error");
        }
    }

});
