async function loadOpenTickets() {
	let activeTickets = await controlFetch('getOpenTickets.php');
	if (activeTickets.length == 0) {
		let theresNoTickets = document.createElement('div');
		theresNoTickets.className = 'noTickets';
		theresNoTickets.innerHTML = `
			<p>
				Não há chamados abertos (ainda) ${isUser(window.logged.credential)? "Abra seu primeiro chamado": ""}
			</p>
		`;
		document.getElementById('tickets').appendChild(theresNoTickets);
	}
	activeTickets.forEach(ticket => {
			let ticketDiv = createTicket(ticket);
			document.getElementById('tickets').appendChild(ticketDiv);
	});
}


loadOpenTickets();
