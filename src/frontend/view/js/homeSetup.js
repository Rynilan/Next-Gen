document.getElementById('enterpriseImage').src = absoluteUrl('assets/img/home.png');
document.getElementById('loginButton').addEventListener('click', () => {
	window.location.href = absoluteUrl('src/frontend/view/loader.php?page_name=login');
});
document.getElementById('registerButton').addEventListener('click', () => {
	window.location.href = absoluteUrl('src/frontend/view/loader.php?page_name=register');
});
