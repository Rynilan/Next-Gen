async function putClients() {
	let clients = await (await fetch(absoluteUrl('src/backend/control/getClients.php'))).json();
	const clientsSelect = document.getElementById('client');
	clients.clients.forEach(client => {
		if (client.id == undefined) return;
		let option = document.createElement('option');
		option.value = client.id;
		option.textContent = client.name;
		clientsSelect.appendChild(option)
	});
}

putClients();
