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
		let ticketDiv = document.createElement('div');
		ticketDiv.className = 'ticket  ' + ticket.status;
		ticketDiv.innerHTML = `
			<div class="imageLogoDiv">
				<img 
					src='${absoluteUrl("assets/img/" + (
						(window.logged.credential == ticket.user_mail)?
						"icons/" + ticket.agent_cnpj: "user"
					) + ".png")}' 
					onerror='this.src = absoluteUrl("assets/img/icons/generic.png")'
					class='imageLogo'
				/>
			</div>
			<div class="data ${ticket.agent_cnpj}">
				<p class='ticketTitle'><b>${ticket.counterpart_name} - ${ticket.type}</b></p>
				<p class='ticketLastMessage'>${ticket.reason}</p>
			</div>
		`;

		listenClickElement(ticketDiv, () => {redirect('chat', null, ticket.id);});
		document.getElementById('tickets').appendChild(ticketDiv);
	});
}

loadOpenTickets();
