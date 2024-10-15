
// Script para mostrar/esconder a senha
const passwordInput = document.getElementById('login-senha');
const eyeIcon = document.querySelector('.login__eye');
eyeIcon.addEventListener('click', () => {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    eyeIcon.classList.toggle('ri-eye-line');
    eyeIcon.classList.toggle('ri-eye-off-line');
    eyeIcon.classList.toggle('show-password');
});

// Verificar se todos os campos estão preenchidos para habilitar o botão
const inputs = document.querySelectorAll('.login__input');
const submitButton = document.getElementById('submit-button');

inputs.forEach(input => {
    input.addEventListener('input', () => {
        const allFilled = Array.from(inputs).every(input => input.value.trim() !== '');
        submitButton.disabled = !allFilled;
        submitButton.classList.toggle('enabled', allFilled);
    });
});
