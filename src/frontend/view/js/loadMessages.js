async function loadMessages() {
	let ticketId = (new URLSearchParams(window.location.search)).get('extra');
	let ticket = await (await fetch(absoluteUrl('src/backend/control/getTicket.php?ticket=' + ticketId))).json();
	document.getElementById('title').textContent += ' ' + ticket.counterpart_name;
	ticket.chat.forEach(message => {
		createMessage(message, ticketId, ticket.logged);
	});

}

async function downloadFile(ticket, name) {
	const content = absoluteUrl('assets/data/ticket_files/' + ticket + '/' + name);
	let blob = await (await fetch(content)).blob();
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


function createMessage(message, ticketId, logged) {
	let messageDiv = document.createElement('div');
	messageDiv.className = message.author + ((message.author == logged || (logged == 'support' && message.author == 'ai'))? ' messageFromLogged': '');
	let messageText;

	if (!message.message.includes('<file name')) {
		messageText = `<p class='messageText'>${message.message}</p>`;
	} else {
		let fileName = message.message.substring(11, message.message.indexOf('>')); // remove <file name=
		messageText = `<div class='fileAttached' onclick="downloadFile('${ticketId}', '${fileName}')">
			<span class='material-symbols-outlined innerChat'>file_open</span>
			<p class='fileName'>${fileName}</p>
		</div>`;
	}

	messageDiv.innerHTML = `
		<span class='material-symbols-outlined'>${(message.author == 'user')? "account_circle":((message.author == 'ai')? "robot_2": "support_agent")}</span>
		<div class='message'>` + messageText + `
			<p class='messageTime'>${message.transmitted}</p>
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
