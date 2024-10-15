// JavaScript Integrado
document.addEventListener("DOMContentLoaded", function () {
    const clientList = document.getElementById("client-list");
    const totalGerado = document.getElementById("total-gerado");
    const lucroStatus = document.getElementById("lucro-status");
    const searchInput = document.getElementById("search");

    // Carregar clientes do localStorage
    const clientes = JSON.parse(localStorage.getItem('clientes')) || [];

    // Função para atualizar a lista de clientes
    function updateClientList(filteredClientes = clientes) {
        clientList.innerHTML = "";
        let total = 0;

        filteredClientes.forEach((cliente, index) => {
            total += parseFloat(cliente.receitaGerada) || 0;
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${cliente.nome}</td>
                <td>${cliente.email}</td>
                <td>R$ ${parseFloat(cliente.receitaGerada).toFixed(2)}</td>
                <td><button class="delete-button" data-index="${index}">Excluir</button></td>
            `;
            clientList.appendChild(row);
        });

        totalGerado.innerText = `R$ ${total.toFixed(2)}`;
        lucroStatus.innerText = total >= 0 ? "Lucro" : "Prejuízo";
        updateChart(total);
    }

    // Função para atualizar o gráfico
    function updateChart(total) {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Gerado'],
                datasets: [{
                    label: 'Receita',
                    data: [total],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Excluir cliente
    clientList.addEventListener("click", function (event) {
        if (event.target.classList.contains("delete-button")) {
            const index = event.target.getAttribute("data-index");
            clientes.splice(index, 1);
            localStorage.setItem('clientes', JSON.stringify(clientes));
            updateClientList();
        }
    });

    // Função de pesquisa
    searchInput.addEventListener("input", function () {
        const searchTerm = searchInput.value.toLowerCase();
        const filteredClientes = clientes.filter(cliente =>
            cliente.nome.toLowerCase().includes(searchTerm) ||
            cliente.email.toLowerCase().includes(searchTerm)
        );
        updateClientList(filteredClientes);
    });

    // Inicializar a lista e o gráfico
    updateClientList();
});