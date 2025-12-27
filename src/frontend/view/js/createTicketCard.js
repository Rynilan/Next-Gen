function createTicket(ticket) {
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
	return ticketDiv;
}
window.createTicket = createTicket;
