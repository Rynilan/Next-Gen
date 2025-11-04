function login() {
	const email = document.getElementById('email');
	const senha = document.getElementById('senha');
	const check = document.getElementById('check');
	if (email.checkValidity() && senha.checkValidity()) {
		if (check.checked) {
			window.location.href = "main.html";
		} else {
			alert("Você concorda com os termos?");
		}
	} else {
		alert("Email ou senha inválidos.");
		email.value = "";
		senha.value = "";
	}
}

function criarChamado() {
	window.location.href = "ticketCreation.html";
}

function criarChamadoVoltar() {
	const tipo = document.getElementById('tipo').value;
	const empresa = document.getElementById('empresa').value;
	const descricao = document.getElementById('descricao').value.trim();
	if (tipo != '-' && empresa != '-' && descricao != '') {
		window.location.href = "main.html";
	} else {
		alert("Algum campo foi mal preenchido.");
	}
}

function backMain() {
	window.location.href = "main.html";
}

function exit() {
	window.location.href = "login.html";
}

if (window.location.href.includes('login')) {
	document.getElementById('header').style.display = 'none';
}

if (document.getElementById('nextGenLogo') != null) {
	document.getElementById('nextGenLogo').addEventListener('click', () => {
		window.location.href = 'main.html';
	})
}

document.querySelectorAll('.chamado').forEach(
	element => {
		element.addEventListener('click', () => {window.location.href = 'chat.html'});
	}
);

if (document.getElementById('botao') == null) {
} else {
	document.getElementById('botao').addEventListener('click', () => {
		const chat = document.getElementById('chat');

		const divIn = document.createElement('div');
		const spanIn = document.createElement('span');
		const messageIn = document.createElement('p');
		divIn.className = 'humano';
		spanIn.className = 'material-symbols-outlined ' + 'interno';
		spanIn.textContent = 'account_circle';
		messageIn.textContent = document.getElementById('mensagem').value.trim();
		document.getElementById('mensagem').value = '';
		divIn.appendChild(spanIn);
		divIn.appendChild(messageIn);
		chat.appendChild(divIn);

		const divOut = document.createElement('div');
		const spanOut = document.createElement('span');
		const messageOut = document.createElement('p');
		divOut.className = 'ia';
		spanOut.className = 'material-symbols-outlined ' + 'interno';
		spanOut.textContent = 'robot_2';
		messageOut.textContent = 'Isso é uma resposta de IA funcional.';
		divOut.appendChild(spanOut);
		divOut.appendChild(messageOut);
		chat.appendChild(divOut);

		chat.scrollTo({
			top: chat.scrollHeight,
			behavior: 'smooth'
		});
	});
}

if (document.getElementById('voltar') != null) {
	document.getElementById('voltar').addEventListener('click', () => {
		window.location.href = 'main.html';
	});
}
