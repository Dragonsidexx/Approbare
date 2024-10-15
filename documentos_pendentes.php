<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";  // Nome de usuário do MySQL
$password = "Robvic09";  // Senha do MySQL (deixe em branco se não houver senha)
$dbname = "approb98_Approbare";  // Nome do seu banco de dados

// Cria a conexão
$conn = new mysqli($host, $user, $pass, $db);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Criação da tabela documentos_pendentes
$sql = "CREATE TABLE IF NOT EXISTS documentos_pendentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    documentos_faltando TEXT NOT NULL,
    data_solicitacao DATETIME DEFAULT CURRENT_TIMESTAMP
)";

// Executa a instrução SQL para criar a tabela
if ($conn->query($sql) === TRUE) {
    // Tabela criada com sucesso
} else {
    echo "Erro ao criar tabela documentos_pendentes: " . $conn->error . "<br>";
}

// Consulta para obter documentos pendentes
$result = $conn->query("SELECT * FROM documentos_pendentes ORDER BY data_solicitacao DESC");

// Fecha a conexão
$conn->close();
?>