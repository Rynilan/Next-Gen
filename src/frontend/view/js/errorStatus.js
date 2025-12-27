
function putErrorImage() {
	let img = document.getElementById('errorImage');
	const CODE_ERROR = getUrlParam('code_error');
	img.src = absoluteUrl('assets/img/error/' + CODE_ERROR + '.png');
}

function putErrorMessage() {
	let message = document.getElementById('errorMessage');
	const EXTRA = getUrlParam('extra');
	message.textContent = EXTRA;
}

putErrorImage();
putErrorMessage();
