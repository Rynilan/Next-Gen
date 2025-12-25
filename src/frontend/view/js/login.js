function putLogo() {
	document.getElementById('loginLogo').src = absoluteUrl('assets/img/logo.png');
}

async function login() {
	let mail = document.getElementById('login').value;
	let password = document.getElementById('password').value;
	let according = document.getElementById('check').checked;

	let result = await (await fetch(absoluteUrl(
		'src/backend/control/login.php?login=' + encodeURIComponent(mail) + '&password=' + encodeURIComponent(password) + '&according=' + encodeURIComponent(according)))).json();

	if (result.success) {
		window.location.href = result.redirect;
	} else {
		alert(result.error_message, 'Tente novamente');
		document.getElementById('check').checked = false;
	}
}

putLogo();
