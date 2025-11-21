async function goTo(page_name) {
	window.location.href = absoluteUrl('src/frontend/view/loader.php?page_name=' + encodeURIComponent(page_name));
}

document.getElementById('goToCreateTickets').addEventListener('click', () => {goTo('ticketCreation');})
