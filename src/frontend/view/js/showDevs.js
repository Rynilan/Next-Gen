async function showDevs() {
	let devs = await (await fetch(absoluteUrl('assets/data/app/devs.json'))).json();
	devs.forEach(dev => {
		createDevDiv(dev);
	});
}

function createDevDiv(dev) {
	let devDiv = document.createElement('div');	
	devDiv.className = 'dev';
	devDiv.innerHTML = `
	<img src='${absoluteUrl('assets/img/devs/' + dev.name.split(' ')[0].toLowerCase() + '.png').replace(/\/$/, "")}'/>
	<div class='info'>
		<h4>${dev.name}</h4>
		<p class='description'>${dev.whoami}</p>
		<div class='social'>
			<a href='${dev.github}' target='_blank'><img src='https://skillicons.dev/icons?i=github'/></a>
			<a href='${dev.linkedin}' target='_blank'><img src='https://skillicons.dev/icons?i=linkedin'/></a>
			<a href='${dev.personal}' target='_blank'><img src='https://skillicons.dev/icons?i=html'/></a>
		</div>
	</div>
`;
	document.getElementById('us').appendChild(devDiv);
}

showDevs();
