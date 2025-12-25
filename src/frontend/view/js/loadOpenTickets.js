async function setAcess() {
	let logged = await (await fetch(absoluteUrl('src/backend/control/getLogged.php'))).json();
	if (!logged.mail.includes('-at-nextgen-dot-admin')) {
		
	}
}

async function loadOpenTickets() {

	let response = await fetch(absoluteUrl('src/backend/control/getOpenTickets.php'));
	if (response.status != 200) {
		alert("Algum erro aconteceu.");
	}
	let activeTickets = await (response).json();
	let logged = await (await fetch(absoluteUrl('src/backend/control/getLogged.php'))).json();
	activeTickets.forEach(ticket => {
		let ticketDiv = document.createElement('div');
		ticketDiv.className = 'ticket  ' + ticket.status;
		ticketDiv.innerHTML = `
			<div class="imageLogoDiv">
				<img 
					src='${absoluteUrl("assets/img/" + (
						(logged.credential == ticket.user_mail)?
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

		ticketDiv.addEventListener('click', () => {
			window.location.href = absoluteUrl(
				'src/frontend/view/loader.php?page_name=chat&extra=' +
				encodeURIComponent(ticket.user + '/' + ticket.client + '/' + ticket.id)
			);
		})
		document.getElementById('tickets').appendChild(ticketDiv);
	});
}

loadOpenTickets();
