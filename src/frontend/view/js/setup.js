// Some useful functions to all js.
const ROOT_URL = (
	await (
		await fetch('../../backend/control/getRootUrl.php')
	).json()
).root_url;

export function absoluteUrl(path) {
	return ROOT_URL + path;
}
window.absoluteUrl = absoluteUrl;

export async function controlFetch(fileAndArgs) {
	try {
		let response = await fetch(absoluteUrl('src/backend/control/' + fileAndArgs));
		if (response.ok) {
			return await response.json();
		} else {
			redirect('error', response.status);
			return null;
		}
	} catch (error) {
		alert('Alguma coisa deu errado ' + error);
		console.log(error);
		redirect('error', 500, error);
	}
}
window.controlFetch = controlFetch;

export async function redirect(page_name, code_error = null, extra = null) {
	window.location.href = absoluteUrl(
		'src/frontend/view/loader.php?page_name=' + page_name +
		'&code_error=' + code_error + '&extra=' + extra
	);
}
window.redirect = redirect;

export function listenClick(elementId, callback) {
	document.getElementById(elementId).addEventListener('click', () => callback());
}
window.listenClick = listenClick;

export function listenClickElement(element, callback) {
	element.addEventListener('click', () => callback());
}
window.listenClickElement = listenClickElement;

export function getUrlParam(paramName) {
	return (new URLSearchParams(window.location.search)).get(paramName);
}
window.getUrlParam = getUrlParam;

export function isAgent(credential) {
	return /^\d{2}\.?\d{3}\.?\d{3}\/?\d{4}-?\d{2}$/.test(credential);
}
window.isAgent = isAgent;

export function isUser(credential) {
	return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(credential);
}
window.isUser = isUser;

// Verificação do acesso.
async function verifyAcess() {
	let data = await controlFetch('getLogged.php');
	window.logged = data;
	let homeLink;

	if (!data.logged) {
		document.querySelectorAll('.logged').forEach((element) => {
			element.style.display = 'none';
		});
		homeLink = 'home';
	} else {
		homeLink = 'main';
	}
	document.getElementById('accountInfo').innerHTML = "<span class='material-symbols-outlined'>account_circle</span>" + data.name;
	document.querySelectorAll('.homeRedirect').forEach(home => listenClickElement(home, () => {redirect(homeLink);}));
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
	const PAGE_NAME = getUrlParam('page_name');
	const CODE_ERROR = getUrlParam('code_error');

	let data = await (await fetch(absoluteUrl('assets/data/app/pageAssets.json'))).json();
	let page_data = data[PAGE_NAME];
	if (['400', '401', '403', '404', '500'].includes(CODE_ERROR)) {
		page_data = page_data[CODE_ERROR];
	}
	data.default.css.forEach(stylesheet => page_data.css.push(stylesheet));
	data.default.js.forEach(script => page_data.js.push(script));
	document.getElementById('title').innerText = page_data.title;
	putCss(page_data.css.reverse());
	putJs(page_data.js.reverse());
}

async function putDefaultFunctions() {
	// Função do botão de conta (mostrar o menu).
	listenClick('menuButton', () => {
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
	// Função para sair.
	listenClick('exit', async () => {
		if (confirm('Tem certeza que deseja sair?')) {
			alert('Foi bom ter você conosco.');
			await controlFetch('exit.php');
			redirect('home');
		}
	});
	// Função para ir para o sobre.
	listenClick('about', () => {redirect('about');});
	// Função para gerir alunos.
	listenClick('allTickets', () => {redirect('listTickets');});
	// Função para gerir materiais.
	listenClick('accountInfo', () => {redirect('account_info');});
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
