<?php
// Configurações do banco de dados (ajuste com as credenciais da HostGator)
$servername = "localhost"; // O servidor será "localhost" na HostGator
$username = "admin";  
$password = "Robvic09";  
$dbname = "approb98_Approbare";  

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $receita = $_POST['receita'];

    // Prepara e executa a inserção
    $stmt = $conn->prepare("INSERT INTO novos_clientes (nome, email, receita) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $nome, $email, $receita); // ssd = string, string, decimal

    if ($stmt->execute()) {
        echo "Cliente cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o cliente: " . $stmt->error;
    }

    $stmt->close();
}

// Fecha a conexão
$conn->close();
?>
