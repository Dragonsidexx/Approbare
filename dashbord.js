document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebar');
    const userInfoDiv = document.querySelector('.user-info');

    // Função para alternar a visibilidade da sidebar
    const toggleSidebar = () => {
        sidebar.classList.toggle('active');
    };

    // Adiciona o evento de clique ao ícone de hambúrguer
    hamburger.addEventListener('click', toggleSidebar);

    // Função para exibir saudação personalizada do usuário
    const exibirSaudacaoUsuario = (nome) => {
        const userGreeting = document.createElement('span');
        userGreeting.textContent = `Bem-vindo, ${nome}!`;
        userGreeting.style.color = 'white';
        userGreeting.style.marginLeft = '10px';

        // Evita a adição repetida da saudação
        if (!userInfoDiv.querySelector('span')) {
            userInfoDiv.appendChild(userGreeting);
        }
    };

    // Recupera o nome e ID do usuário do localStorage
    const usuarioId = localStorage.getItem('usuario_id');
    const usuarioNome = localStorage.getItem('usuario_nome');

    // Verifica se há dados do usuário armazenados e exibe a saudação
    if (usuarioId && usuarioNome) {
        console.log(`Usuário logado: ${usuarioNome} (ID: ${usuarioId})`);
        exibirSaudacaoUsuario(usuarioNome);
    } else {
        console.log('Nenhum usuário logado.');
    }
});
