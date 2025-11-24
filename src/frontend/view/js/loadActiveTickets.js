async function loadActiveTickets() {
	let activeTickets = await (await fetch(absoluteUrl('src/backend/control/getActiveTickets.php'))).json();
	activeTickets.forEach(ticket => {
		let ticketDiv = document.createElement('div');
		ticketDiv.className = 'ticket  ' + ticket.status;
		ticketDiv.innerHTML = `
			<div class="clientLogoDiv">
				<img 
					src='${absoluteUrl("assets/img/icons/" + ticket.client + ".png")}' 
					onerror='this.src = absoluteUrl("assets/img/icons/generic.png")'
					class='clientLogo'
				/>
			</div>
			<div class="data ${ticket.client}">
				<p class='ticketTitle'><b>${ticket.client_name} - ${ticket.type}</b></p>
				<p class='ticketLastMessage'>${ticket.chat[ticket.chat.length - 1][2]}</p>
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

loadActiveTickets();
