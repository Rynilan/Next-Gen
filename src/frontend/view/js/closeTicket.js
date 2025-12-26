async function decideShow() {
	let logged = await (await fetch(absoluteUrl('src/backend/control/getLogged.php'))).json();
	let close = document.getElementById('closeTicket')
	if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(logged.credential)) {
		close.style.display = 'none';
	} else {
		close.addEventListener('click', () => {closeTicket()});
	}
}

async function closeTicket() {
	if (!confirm('Tem certeza que deseja fechar este chamado?')) {
		return;
	}
	let ticketId = (new URLSearchParams(window.location.search)).get('extra');
	let result = await (await fetch(absoluteUrl(
		'src/backend/control/closeTicket.php?ticket_id=' + encodeURIComponent(ticketId) +
		'&finish=' + encodeURIComponent(prompt('Como se deu a finalização do chamado?'))
	))).json();
	if (result.success) {
		alert('Ticket fechado com sucesso.');
		window.location.href = absoluteUrl('src/frontend/view/loader.php?page_name=main')
	} else {
		alert(result.error);
	}
};

decideShow();
