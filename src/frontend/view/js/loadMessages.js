async function loadMessages() {
	let ticketId = (new URLSearchParams(window.location.search)).get('extra');
	let ticket = await (await fetch(absoluteUrl('src/backend/control/getTicket.php?ticket=' + ticketId))).json();
	document.getElementById('title').textContent += ' ' + ticket.client_name;
	ticket.chat.forEach(message => {
		createMessage(message, ticketId);
	});

}

function downloadFile(ticket, name) {
	const content = absoluteUrl('assets/data/tickets/' + ticket + '/ticket_base.json');
	const blob = new Blob([content], { type: "text/plain" });
	const url = URL.createObjectURL(blob);
	const a = document.createElement("a");
	a.style.display = 'none';
	a.href = url;
	a.download = name;
	document.body.appendChild(a);
	a.click();
	document.body.removeChild(a);
	URL.revokeObjectURL(url);
}


function createMessage(message, ticketId) {
	let messageDiv = document.createElement('div');
	messageDiv.className = (message[0] == 0)? 'human': 'ai';
	let messageText;
	if (!message[2].includes('<file name')) {
		messageText = `<p class='messageText'>${message[2]}</p>`;
	} else {
		let fileName = message[2].substring(11, message[2].indexOf('>'));
		messageText = `<div class='fileAttached' onclick="downloadFile('${ticketId}', '${fileName}')">
			<span class='material-symbols-outlined innerChat'>file_open</span>
			<p class='fileName'>${fileName}</p>
		</div>`;
	}
	messageDiv.innerHTML = `
		<span class='material-symbols-outlined'>${(message[0] == 0)? "account_circle": "robot_2"}</span>
		<div class='message'>` + messageText + `
			<p class='messageTime'>${message[1].substring(0, 16)}</p>
		</div>
	`;
	document.getElementById('chat').appendChild(messageDiv);
	document.getElementById('chat').scrollTo({
	  top: document.getElementById('chat').scrollHeight,
	  behavior: 'smooth'
	});
}
window.createMessage = createMessage;
loadMessages();
