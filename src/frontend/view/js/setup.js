const ROOT_URL = (
	await (
		await fetch('../../backend/control/getRootUrl.php')
	).json()
).root_url;

export function absoluteUrl(path) {
	return ROOT_URL + path;
}
window.absoluteUrl = absoluteUrl;

// Verificação do acesso.
async function verifyAcess() {
	let response = await fetch(absoluteUrl('src/backend/control/getLogged.php'));
	let data = await response.json();
	let homeLink;

	if (!data.logged) {
		document.querySelectorAll('.logged').forEach((element) => {
			element.style.display = 'none';
		});
		homeLink = 'login';
	} else {
		homeLink = 'main';
	}
	document.querySelectorAll('.homeRedirect').forEach(home => home.addEventListener('click', () => {
		window.location.href = absoluteUrl('src/frontend/view/loader.php?page_name=' + homeLink + '&code_error=');
	}));
}

// Adição do conteúdo personalizado às páginas.
async function putCss(sheets) {
	sheets.forEach((sheet) => {
		let link = document.createElement('link');
		link.rel = 'stylesheet';
		link.href = absoluteUrl('src/frontend/view/css/' + sheet + '.css');
		document.head.appendChild(link);
	});
}
function putJs(scripts) {
	scripts.forEach((script) => {
		let scriptTag = document.createElement('script');
		scriptTag.src = absoluteUrl('src/frontend/view/js/' + script + '.js');
		document.body.appendChild(scriptTag);
	})
}
async function putContent() {
	const PAGE_NAME = (new URLSearchParams(window.location.search)).get('page_name');
	const CODE_ERROR = (new URLSearchParams(window.location.search)).get('code_error');

	let data = await (await fetch(absoluteUrl('assets/data/app/pageAssets.json'))).json();
	let page_data = data[PAGE_NAME];
	if (CODE_ERROR) {
		console.log(data, PAGE_NAME, CODE_ERROR);
		page_data = page_data[CODE_ERROR];
	}
	data.default.css.forEach(stylesheet => page_data.css.push(stylesheet));
	data.default.js.forEach(script => page_data.js.push(script));
	document.getElementById('title').innerText = page_data.title;
	putCss(page_data.css);
	putJs(page_data.js);
}

async function putDefaultFunctions() {
	// Função do botão de conta (mostrar o menu).
	document.getElementById('menuButton').addEventListener('click', () => {
		const MENU = document.getElementById('menu');
		if (MENU.style.display === 'none') {
			MENU.style.display = 'block';
		} else {
			MENU.style.display = 'none';
		}
	});
	// Função para esconder o menu quando alguma interação ocorrer fora dele.
	document.addEventListener('click', (event) => {
		const MENU = document.getElementById('menu');
		if (!MENU.contains(event.target) && !document.getElementById('menuButton').contains(event.target)) {
			MENU.style.display = 'none';
		}
	});
	// Função para trocar de tema.
	/*document.getElementById('toggleTheme').addEventListener('click', () => {
		const THEME = document.getElementById('theme')
		if (THEME.textContent == 'light_mode') {
			localStorage.setItem('theme', 'light');
			THEME.textContent = 'dark_mode';
		} else {
			localStorage.setItem('theme', 'dark');
			THEME.textContent = 'light_mode';
		}
		document.body.classList.toggle('light-theme');
	});*/
	// Função para sair.
	document.getElementById('exit').addEventListener('click', () => {
		if (confirm('Tem certeza que deseja sair?')) {
			alert('Foi bom ter você conosco.');
			window.location.href = absoluteUrl('index.php');
		}
	});
	// Função para ir para o sobre.
	document.getElementById('about').addEventListener('click', () => {
		window.location.href = absoluteUrl('frontend/view/loader.php?page_name=about&code_error=');
	});
	// Função para gerir alunos.
	document.getElementById('allTickets').addEventListener('click', () => {
		window.location.href = absoluteUrl('frontend/view/loader.php?page_name=listTickets&code_error=');
	});
	// Função para gerir materiais.
	document.getElementById('accountInfo').addEventListener('click', () => {
		window.location.href = absoluteUrl('frontend/view/loader.php?page_name=accountInfo&code_error=');
	});
}

async function putData() {
	document.getElementById('nextGenLogo').src = absoluteUrl('assets/img/logo.png');
}

async function loadContent() {

	verifyAcess();
	putContent();
	putDefaultFunctions();
	putData();

}

loadContent();
