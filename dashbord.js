document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebar');

    hamburger.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });

    const usuarioId = localStorage.getItem('usuario_id');
    const usuarioNome = localStorage.getItem('usuario_nome');

    if (usuarioId && usuarioNome) {
        console.log(`Usuário logado: ${usuarioNome} (ID: ${usuarioId})`);
        const userGreeting = document.createElement('p');
        userGreeting.textContent = `Bem-vindo, ${usuarioNome}!`;
        document.body.insertBefore(userGreeting, sidebar);
    } else {
        console.log('Nenhum usuário logado.');
    }
});