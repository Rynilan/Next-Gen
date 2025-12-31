async function putInfo() {
	if (isUser(window.logged.credential)) {
		document.getElementById('loggedImg').src = absoluteUrl('assets/img/user.png');
		document.getElementById('loggedIdentification').textContent = window.logged.name;
	} else {
		document.getElementById('loggedImg').src = absoluteUrl('assets/img/icons/' + window.logged.credential + '.png');
		document.getElementById('loggedIdentification').textContent = window.logged.credential + ' - ' + window.logged.name;
	}

	let ticketsResume = await controlFetch('getTicketsResume.php');
	document.getElementById('openTicketAmount').textContent += ticketsResume.openAmount;
	document.getElementById('closedTicketAmount').textContent += ticketsResume.closedAmount;
	document.getElementById('allTicketAmount').textContent += ticketsResume.totalAmount;
}

putInfo();
