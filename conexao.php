<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "approbare";  

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $receita = $_POST['receita'];

    // Prepara e executa a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO novos_clientes (nome, email, receita) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $nome, $email, $receita);

    if ($stmt->execute()) {
        echo "<script>alert('Cliente cadastrado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar o cliente: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>

    <!-- CSS Interno -->
    <style>
        body {
            background-color: black;
            color: red;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login {
            width: 400px;
            padding: 30px;
            background-color: #1a1a1a;
            border-radius: 15px;
        }

        .login__title {
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }

        .login__box {
            margin-bottom: 15px;
            position: relative;
        }

        .login__input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-top: 5px;
        }

        .login__label {
            display: block;
            margin-bottom: 5px;
            color: white;
        }

        .login__button {
            width: 100%;
            padding: 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login__button:hover {
            background-color: white;
            color: blueviolet;
        }
    </style>
</head>
<body>
    <div class="login">
        <form id="cadastroForm" action="cadastro.php" method="POST">
            <h1 class="login__title">Cadastro</h1>

            <div class="login__box">
                <label for="nome" class="login__label">Nome do Cliente</label>
                <input type="text" name="nome" required class="login__input" placeholder="Digite o nome">
            </div>

            <div class="login__box">
                <label for="email" class="login__label">Email</label>
                <input type="email" name="email" required class="login__input" placeholder="Digite o email">
            </div>

            <div class="login__box">
                <label for="receita" class="login__label">Receita Gerada pelo Cliente</label>
                <input type="number" step="0.01" name="receita" required class="login__input" placeholder="Digite a receita">
            </div>

            <button type="submit" class="login__button">Cadastrar</button>
        </form>
    </div>
</body>
</html>
