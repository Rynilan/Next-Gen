async function sendMessage() {
	let message = encodeURIComponent(document.getElementById('message').value.trim());

	let ticketId = (new URLSearchParams(window.location.search)).get('extra');
	let human = ticketId.includes('@nextgen.admin');
	let result = await (await fetch(absoluteUrl('src/backend/control/sendMessage.php?message=' + message + '&ticket_id=' + ticketId + '&human=' + ((human)? 1: 0)))).json();

	if (result.success) {
		createMessage(result.message, ticketId);
	} else {
		alert(result.error_message);
	}
}

document.getElementById('send').addEventListener('click', () => {sendMessage();});
