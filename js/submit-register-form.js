$(document).ready(function() {
	$('#email').blur(function(event) {
		event.preventDefault();
		var inp = $(this);

		var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		if (testEmail.test(inp.val())){

			inp.attr('disabled', 'disabled').addClass('disabled');
			$('#register').attr('disabled', 'disabled');

			$.ajax({
				url: '/classes/register.php',
				type: 'post',
				data: {action: 'checkEmail',
					email: inp.val()
				}
			})
			.done(function(d) {
				inp.removeAttr('disabled').removeClass('disabled');

				if (d == '1') {
					//pode usar
					$('#register').removeAttr('disabled');
					$('#email-used').addClass('invisible');
				}else {
					$('#email-used').removeClass('invisible');
				}
			})
			.fail(function() {
				alert('cheque sua conexão');
				inp.removeAttr('disabled').removeClass('disabled');
			})
		}
	});
	$('#form').submit(function(event) {
		var senha = $('#pass').val();
		var rpt = $('#repeat').val();
		console.log(senha);
		console.log(rpt);
		if (senha != rpt) {
			event.preventDefault();
			$('#pass-error').removeClass('invisible');
		}
	});
});
