async function loadTickets() {
	let tickets = await controlFetch('getAllTickets.php');	
	tickets.forEach(ticket => {
		let ticketDiv = createTicket(ticket);
		document.getElementById((ticket.status == 'open')? 'openTicketsDiv': 'closedTicketsDiv').appendChild(ticketDiv);
	});
}

loadTickets();
