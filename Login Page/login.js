let registerBtn = document.getElementById('register');
let container = document.getElementById('container');
let loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', ()=>{
    container.classList.add("active");
})

loginBtn.addEventListener('click', ()=>{
    container.classList.remove("active");
})

// Sign-In Form
let signInForm = document.querySelector('.form-container.sign-in form');
let signInEmailInput = signInForm.querySelector('input[type="email"]');
let signInPasswordInput = signInForm.querySelector('input[type="password"]');
let signInButton = signInForm.querySelector('button');
let signInMessage = signInForm.querySelector('.error-message');

// Sign-Up Form
let signUpForm = document.querySelector('.form-container.sign-up form');
let signUpNameInput = signUpForm.querySelector('input[type="text"]');
let signUpEmailInput = signUpForm.querySelector('input[type="email"]');
let signUpPasswordInput = signUpForm.querySelector('input[type="password"]');
let signUpButton = signUpForm.querySelector('button');
let signUpMessage = signUpForm.querySelector('.error-message');
let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

// Sign-In Validation
signInButton.addEventListener('click', function (e) {
    e.preventDefault();

    let email = signInEmailInput.value.trim();
    let password = signInPasswordInput.value.trim();

    if (!email && !password) {
        signInMessage.textContent = 'Please enter your email and password';
        signInMessage.classList.remove('success-message');
        signInMessage.classList.add('error-message');
        signInMessage.style.display = 'flex';
    } else if (!email) {
        signInMessage.textContent = 'Please enter your email';
        signInMessage.classList.remove('success-message');
        signInMessage.classList.add('error-message');
        signInMessage.style.display = 'flex';
    } else if (!emailRegex.test(email)) {
        signInMessage.textContent = 'Please enter a valid email address';
        signInMessage.classList.remove('success-message');
        signInMessage.classList.add('error-message');
        signInMessage.style.display = 'flex';
    } else if (!password) {
        signInMessage.textContent = 'Please enter your password';
        signInMessage.classList.remove('success-message');
        signInMessage.classList.add('error-message');
        signInMessage.style.display = 'flex';
    } else {
        signInMessage.textContent = 'Sign-in successful!';
        signInMessage.classList.remove('error-message');
        signInMessage.classList.add('success-message');
        signInMessage.style.display = 'flex';
        signInEmailInput.value = '';
        signInPasswordInput.value = '';
        setTimeout(() => {
            signInMessage.style.display = 'none';
        }, 3000);
    }
});

// Sign-Up Validation
signUpButton.addEventListener('click', function (e) {
    e.preventDefault();

    let name = signUpNameInput.value.trim();
    let email = signUpEmailInput.value.trim();
    let password = signUpPasswordInput.value.trim();

    if (!name && !email && !password) {
        signUpMessage.textContent = 'Please enter your name, email, and password';
        signUpMessage.classList.remove('success-message');
        signUpMessage.classList.add('error-message');
        signUpMessage.style.display = 'flex';
    } else if (!name) {
        signUpMessage.textContent = 'Please enter your name';
        signUpMessage.classList.remove('success-message');
        signUpMessage.classList.add('error-message');
        signUpMessage.style.display = 'flex';
    } else if (!email) {
        signUpMessage.textContent = 'Please enter your email';
        signUpMessage.classList.remove('success-message');
        signUpMessage.classList.add('error-message');
        signUpMessage.style.display = 'flex';
    } else if (!emailRegex.test(email)) {
        signUpMessage.textContent = 'Please enter a valid email address';
        signUpMessage.classList.remove('success-message');
        signUpMessage.classList.add('error-message');
        signUpMessage.style.display = 'flex';
    } else if (!password) {
        signUpMessage.textContent = 'Please enter your password';
        signUpMessage.classList.remove('success-message');
        signUpMessage.classList.add('error-message');
        signUpMessage.style.display = 'flex';
    } else {
        signUpMessage.textContent = 'Sign-up successful!';
        signUpMessage.classList.remove('error-message');
        signUpMessage.classList.add('success-message');
        signUpMessage.style.display = 'flex';
        signUpNameInput.value = '';
        signUpEmailInput.value = '';
        signUpPasswordInput.value = '';
        setTimeout(() => {
            signUpMessage.style.display = 'none';
        }, 3000);
    }
});




