<?php
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

// Executa cada instrução SQL
foreach ($tables as $sql) {
    if ($conn->query($sql) === TRUE) {
        // Tabela criada com sucesso
    } else {
        echo "Erro ao criar tabela: " . $conn->error . "<br>";
    }
}

// Fecha a conexão
$conn->close();
?>

