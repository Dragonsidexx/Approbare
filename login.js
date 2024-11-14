document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    // Alterna a visibilidade da senha e o ícone
    togglePassword.addEventListener('click', function () {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;

        // Alterna o ícone entre olho aberto e fechado
        this.classList.toggle('fa-eye-slash');
    });
});
