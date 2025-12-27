document.getElementById('enterpriseImage').src = absoluteUrl('assets/img/home.png');
listenClick('loginButton', () => {redirect('login');});
listenClick('registerButton', () => {redirect('register');});
