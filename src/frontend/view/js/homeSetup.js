document.getElementById('homeImage').src = absoluteUrl('assets/img/home.png');
document.getElementById('divisionImage').src = absoluteUrl('assets/img/divider.png');
document.getElementById('costEfficiency').src = absoluteUrl('assets/img/team.png');
document.getElementById('costTime').src = absoluteUrl('assets/img/time.png');
document.getElementById('efficiency').src = absoluteUrl('assets/img/efficiency.png');

listenClick('loginButton', () => {redirect('login');});
listenClick('registerButton', () => {redirect('register');});
