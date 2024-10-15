<?php
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";  // Nome de usuário do MySQL
$password = "Robvic09";  // Senha do MySQL (deixe em branco se não houver senha)
$dbname = "approb98_Approbare";  // Nome do seu banco de dados

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Busca o usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o usuário existe e se a senha está correta
    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id']; // Inicia a sessão
        header("Location:/HTML/dashbord.html"); // Redireciona para o sistema
        exit();
    } else {
        echo "<script>alert('Login ou senha inválidos!');</script>";
    }
}

$conn = null;
?>
