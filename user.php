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

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: HTML/dashbord.html");
    exit();
}

// Busca as informações do usuário logado
$sql = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $_SESSION['usuario_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuário não encontrado.");
}

// Atualização de dados (via POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $email = htmlspecialchars(trim($_POST['email']));
    $telefone = htmlspecialchars(trim($_POST['telefone']));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido.");
    }

    // Upload da foto (caso haja)
    $foto = $user['foto'];
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $foto = $uploadDir . basename($_FILES['foto']['name']);
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto)) {
            die("Erro ao fazer upload da foto.");
        }
    }

    // Atualiza no banco
    $sql = "UPDATE usuarios SET nome = :nome, email = :email, telefone = :telefone, foto = :foto WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':foto', $foto);
    $stmt->bindParam(':id', $_SESSION['usuario_id']);

    if ($stmt->execute()) {
        header("Location: /HTML/dashbord.html");
        exit();
    } else {
        echo "Erro ao atualizar os dados!";
    }
}

$conn = null;
?>
