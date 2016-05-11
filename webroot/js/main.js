$(document).ready(function() {
    $(".button-collapse").sideNav();  
});



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

});

