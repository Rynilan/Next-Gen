function putErrorImage() {
	let img = document.getElementById('errorImage');
	const CODE_ERROR = (new URLSearchParams(window.location.search)).get('code_error');
	img.src = absoluteUrl('assets/img/error/' + CODE_ERROR + '.png');
}
putErrorImage()
