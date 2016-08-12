//TODO
$.ajax({
	url: '/path/to/file',
	type: 'default GET (Other values: POST)',
	dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
	data: {param1: 'value1'}
})
.done(function() {
	console.log('success');
})
.fail(function() {
	alert('Não foi possível obter seus dados \n por favor tente entra novamente');
	setTimeout(function(){
		location.href = '/logout.php';
	}, 2000);
})
