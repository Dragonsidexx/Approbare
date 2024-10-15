const passwordInput = document.getElementById('login-pass');
const togglePassword = document.getElementById('login-eye');

// Mostrar ou ocultar a senha ao clicar no ícone de olho
togglePassword.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // Alterna o ícone do olho
    this.classList.toggle('ri-eye-line');
    this.classList.toggle('ri-eye-off-line');
});
