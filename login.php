<?php
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";  // Nome de usuário do MySQL
$password = "Robvic09";  // Senha do MySQL
$dbname = "approb98_Approbare";  // Nome do banco de dados

try {
    // Conexão com o banco de dados
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html"); // Redireciona para a página de login
    exit();
}

// Busca as informações do usuário logado
$sql = "SELECT * FROM login WHERE id = :id"; // Mudei para 'login'
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $_SESSION['usuario_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuário não encontrado.");
}

// Atualização de dados (via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));
    $senha = htmlspecialchars(trim($_POST['senha'])); // Se for para atualizar a senha

    // Validação do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido.");
    }

    // Atualiza no banco
    $sql = "UPDATE login SET email = :email, senha = :senha WHERE id = :id"; // Mudei para 'login'
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha); // Se estiver atualizando a senha
    $stmt->bindParam(':id', $_SESSION['usuario_id']);

    if ($stmt->execute()) {
        header("Location: dashbord.html"); // Redireciona após atualização bem-sucedida
        exit();
    } else {
        echo "Erro ao atualizar os dados!";
    }
}

// Fecha a conexão
$conn = null;
?>
