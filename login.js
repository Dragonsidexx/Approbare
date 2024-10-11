const allowedUsers = {
    'approbare.arquitetura@gmail.com':
    //   ^  email  
    'approbare.arquitetura',
    //   ^  senha
 
};

const emailInput = document.getElementById('login-email');
const passwordInput = document.getElementById('login-pass');
const loginButton = document.querySelector('.login__button');
const togglePassword = document.getElementById('login-eye');

// Função para validar o email e senha
function validateForm() {
    const email = emailInput.value;
    const password = passwordInput.value;

    // Verifica se o email e senha correspondem aos permitidos
    if (allowedUsers[email] && allowedUsers[email] === password) {
        loginButton.disabled = false; // Habilita o botão
    } else {
        loginButton.disabled = true; // Desabilita o botão
    }
}

// Mostrar ou ocultar a senha ao clicar no ícone de olho
togglePassword.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // Alterna o ícone do olho
    this.classList.toggle('ri-eye-line');
    this.classList.toggle('ri-eye-off-line');
});

// Validação de email e senha ao digitar
emailInput.addEventListener('input', validateForm);
passwordInput.addEventListener('input', validateForm);

// Impede o comportamento padrão de envio do formulário e redireciona para index.html em caso de sucesso
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Evita o envio do formulário

    // Verifica novamente se as credenciais estão corretas antes de redirecionar
    const email = emailInput.value;
    const password = passwordInput.value;
    if (allowedUsers[email] && allowedUsers[email] === password) {
        window.location.href = 'sistem.html'; // Redireciona para o sistema
    } else {
        alert('Credenciais inválidas. Tente novamente.'); // Mensagem de erro
    }
});

