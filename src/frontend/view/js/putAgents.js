async function putAgents() {
	let agents = await (await fetch(absoluteUrl('src/backend/control/getAllAgents.php'))).json();
	const clientsSelect = document.getElementById('agent');
	agents.forEach(agent => {
		let option = document.createElement('option');
		option.value = agent.cnpj;
		option.textContent = agent.real_name;
		clientsSelect.appendChild(option)
	});
}

putAgents();
