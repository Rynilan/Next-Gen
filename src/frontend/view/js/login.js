function putLogoAndLink() {
	document.getElementById('loginLogo').src = absoluteUrl('assets/img/logo.png');
	document.getElementById('registerLink').href = absoluteUrl('src/frontend/view/loader.php?page_name=register');
}

async function login() {
	let credential = document.getElementById('login').value;
	let password = document.getElementById('password').value;
	let according = document.getElementById('check').checked;

	let result = await controlFetch('login.php?login=' + encodeURIComponent(credential) + '&password=' + encodeURIComponent(password) + '&according=' + encodeURIComponent(according));

	if (result.success) {
		redirect(result.redirect);
	} else {
		alert(result.error_message, 'Tente novamente');
		document.getElementById('check').checked = false;
	}
}

putLogoAndLink();
