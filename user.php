<?php
// Conexão com o banco de dados
$servername = "localhost"; // Altere se necessário
$username = "root"; // Altere se necessário
$password = ""; // Altere se necessário
$dbname = "approbare"; // Substitua pelo nome do seu banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Supondo que você tenha o ID do usuário armazenado na sessão
session_start();
$userId = $_SESSION['user_id']; // Ajuste para corresponder ao seu sistema de autenticação

// Inicializa a variável de erro
$error = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação do nome
    $nome = trim($_POST['nome']);
    if (empty($nome)) {
        $error = "O nome é obrigatório.";
    } elseif (strlen($nome) > 100) {
        $error = "O nome deve ter no máximo 100 caracteres.";
    }

    // Validação do email
    $email = trim($_POST['email']);
    if (empty($email)) {
        $error = "O email é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Formato de email inválido.";
    }

    // Validação da bio
    $bio = trim($_POST['bio']);
    if (empty($bio)) {
        $error = "A bio é obrigatória.";
    }

    // Se não houver erros, prosseguir para salvar no banco de dados
    if (empty($error)) {
        $sqlUpdate = "UPDATE usuarios SET nome = ?, email = ?, bio = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("sssi", $nome, $email, $bio, $userId);
        
        if ($stmtUpdate->execute()) {
            header("Location: user.php"); // redirecionar para a página do usuário após a atualização
            exit();
        } else {
            $error = "Erro ao atualizar informações.";
        }
        $stmtUpdate->close();
    }
}

// Consulta para pegar informações do usuário
$sql = "SELECT nome, email, foto, cargo, bio FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $user = [
        'nome' => 'Nome não encontrado',
        'email' => 'Email não encontrado',
        'foto' => null, // Não vamos definir uma imagem padrão aqui
        'cargo' => 'Cargo não disponível',
        'bio' => 'Bio não disponível'
    ];
}

// Fechar a conexão
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuário</title>
    <link rel="stylesheet" href="user.css">
    <link rel="icon" href="logoBran.jfif">
    <script>
        function validateForm() {
            const nome = document.getElementById('editNome').value.trim();
            const email = document.getElementById('editEmail').value.trim();
            const bio = document.getElementById('editBio').value.trim();
            let errorMessage = "";

            // Validação do nome
            if (nome === "") {
                errorMessage += "O nome é obrigatório.\n";
            } else if (nome.length > 100) {
                errorMessage += "O nome deve ter no máximo 100 caracteres.\n";
            }

            // Validação do email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === "") {
                errorMessage += "O email é obrigatório.\n";
            } else if (!emailRegex.test(email)) {
                errorMessage += "Formato de email inválido.\n";
            }

            // Validação da bio
            if (bio === "") {
                errorMessage += "A bio é obrigatória.\n";
            }

            // Se houver erros, exibe um alerta e impede o envio do formulário
            if (errorMessage) {
                alert(errorMessage);
                return false; // Impede o envio do formulário
            }
            return true; // Permite o envio do formulário
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <img src="<?php echo isset($user['foto']) && !empty($user['foto']) ? htmlspecialchars($user['foto']) : 'defaultProfile.jpg'; ?>" alt="Foto de perfil" class="profile-img">
            <h1 class="h1r"><?php echo htmlspecialchars($user['nome']); ?></h1>
            <p class="bio"><?php echo htmlspecialchars($user['bio']); ?></p> 
        </div>

        <div class="profile-details" id="profileDetails">
            <h2 class="info">Informações Pessoais:</h2>
            <ul>
                <li><strong>Nome:</strong> <span id="nome"><?php echo htmlspecialchars($user['nome']); ?></span></li>
                <li><strong>Email:</strong> <span id="email"><?php echo htmlspecialchars($user['email']); ?></span></li>
                <li><strong>Cargo:</strong> <span id="cargo"><?php echo htmlspecialchars($user['cargo']); ?></span></li> 
            </ul>
        </div>

        <?php if (!empty($error)): ?>
            <div id="errorMessage" style="color: red;"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="edit-profile" id="editProfile" style="display: none;">
            <h2>Editar Informações Pessoais</h2>
            <form id="editForm" method="POST" action="user.php" enctype="multipart/form-data" onsubmit="return validateForm();">
                <label for="editNome">Nome:</label>
                <input type="text" id="editNome" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>

                <label for="editEmail">Email:</label>
                <input type="email" id="editEmail" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="editBio">Bio:</label> 
                <textarea id="editBio" name="bio" required><?php echo htmlspecialchars($user['bio']); ?></textarea>

                <label for="foto">Foto de Perfil:</label>
                <input type="file" id="foto" name="foto">

                <button type="submit" class="btn">Salvar Alterações</button>
                <button type="button" class="btn cancel" onclick="document.getElementById('editProfile').style.display='none';">Cancelar</button>
            </form>
        </div>

        <div class="profile-actions">
            <button class="btn" id="editBtn" onclick="document.getElementById('editProfile').style.display='block';">Editar Perfil</button>
            <a href="user.html"><button class="btn logout">Sair</button></a>
        </div>
    </div>
</body>
</html>
