<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Conecta ao banco de dados
$host = "localhost";
$dbname = "approb98_Approbare";
$user = "admin";
$password = "Robvic09";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Obtém o ID do usuário da sessão
$user_id = $_SESSION['user_id'];

// Busca informações adicionais do usuário no banco
$sql = "SELECT nome, email FROM usuarios WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Caso o usuário não seja encontrado, redireciona para o login
    session_destroy();
    header("Location: login.php");
    exit();
}

// Armazena informações adicionais do usuário
$username = htmlspecialchars($user['nome'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8');

?>
