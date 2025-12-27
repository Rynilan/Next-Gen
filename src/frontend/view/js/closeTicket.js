async function decideShow() {
	let close = document.getElementById('closeTicket')
	if (isUser(window.logged.credential)) {
		close.style.display = 'none';
	} else {
		listenClickElement(close, () => {closeTicket()});
	}
}

async function closeTicket() {
	if (!confirm('Tem certeza que deseja fechar este chamado?')) {
		return;
	}
	let ticketId = getUrlParam('extra');
	let result = await controlFetch(
		'closeTicket.php?ticket_id=' + encodeURIComponent(ticketId) +
		'&finish=' + encodeURIComponent(prompt('Como se deu a finalização do chamado?'))
	);
	if (result.success) {
		alert('Ticket fechado com sucesso.');
		redirect('main');
	} else {
		alert(result.error);
	}
};

decideShow();
