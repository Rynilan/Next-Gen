async function putAgents() {
	let agents = await controlFetch('getAllAgents.php');
	const clientsSelect = document.getElementById('agent');
	agents.forEach(agent => {
		let option = document.createElement('option');
		option.value = agent.cnpj;
		option.textContent = agent.real_name;
		clientsSelect.appendChild(option)
	});
}

putAgents();
