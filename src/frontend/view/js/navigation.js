function navigationToCreateTicket() {
	if (isUser(window.logged.credential)) {
		listenClick('goToCreateTickets', () => {redirect('ticketCreation');});
	} else {
		document.getElementById('goToCreateTickets').style.display = 'none';
	}
}

navigationToCreateTicket();
