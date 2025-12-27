function putLink() {
	document.getElementById('loginLink').href = absoluteUrl('src/frontend/view/loader.php?page_name=login');
}

async function register(event) {
	let credential = document.getElementById('login').value;
	let password = document.getElementById('password').value;
	let according = document.getElementById('check').checked;
	let name = document.getElementById('name').value;
	let realName = '';

	if (isUser(credential)) {
	} else if (isAgent(credential)) {
	} else {
		alert('Email ou CNPJ inválido');
		return;
	}

	let result = await controlFetch(
		'register.php?credential=' + encodeURIComponent(credential) +
		'&pass=' + encodeURIComponent(password) +
		'&name=' + encodeURIComponent(name) + 
		'&real_name=' + encodeURIComponent(realName) +
		'&according=' + encodeURIComponent(according)
	);

	if (result.success) {
		alert('Cadastro concluído.');
		redirect('login');
	} else {
		alert(result.error_message + ', tente novamente');
		document.getElementById('check').checked = false;
	}
}

putLink();
