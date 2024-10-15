<?php
$servername = "localhost";
$username = "root";  // Nome de usuário do MySQL
$password = "Robvic09";  // Senha do MySQL (deixe em branco se não houver senha)
$dbname = "approb98_Approbare";  // Nome do seu banco de dados

// Conectando ao banco de dados
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

    // Query para listar as solicitações
    $sql = "SELECT id, descricao_solicitacao, data_solicitacao FROM novas_solicitacoes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exibindo os dados
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['descricao_solicitacao']}</td>
                    <td>{$row['data_solicitacao']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>Nenhuma solicitação encontrada</td></tr>";
    }
    ?>

