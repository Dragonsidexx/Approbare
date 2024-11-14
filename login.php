<?php
session_start();
include('conexao.php'); // Certifique-se de que o caminho para conexao.php está correto

$erro = []; // Inicializa o array de erros

if (isset($_POST['email']) && strlen($_POST['email']) > 0) {
    $_SESSION['email'] = $mysqli->real_escape_string($_POST['email']); // Usa a conexão para escapar a string
    $_SESSION['senha'] = md5(md5($_POST['senha'])); // Hash duplo para a senha

    $sql_code = "SELECT email, senha FROM usuarios WHERE email = '$_SESSION[email]'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);
    $dado = $sql_query->fetch_assoc();
    $total = $sql_query->num_rows;

    if ($total == 0) {
        $erro[] = "Este email não existe."; 
    } else {
        if ($dado['senha'] == $_SESSION['senha']) {
            $_SESSION['usuario'] = $dado['codigo'];
        } else {
            $erro[] = "Senha incorreta.";  
        }
    }

    if (count($erro) == 0) {
        echo "<script>alert('Login efetuado com sucesso'); location.href='sucesso.php';</script>";
    } else {
        foreach ($erro as $e) {
            echo "<script>alert('" . htmlspecialchars($e) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="log.css">
    <link rel="shortcut icon" href="logo.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login</title>
</head>
<body>

<?php if (count($erro) > 0): ?>
    <div class="alert alert-danger">
        <?php foreach ($erro as $msg): ?>
            <p><?= htmlspecialchars($msg) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="login-box">
    <div class="login-key">
        <a href="reworkindex.html">
            <i class="fa fa-key" aria-hidden="true"></i>
        </a>
    </div>
    <div class="login-title">ADMIN PAINEL</div>
    
    <div class="login-form">
        <form action="" method="POST">
            <div class="form-group">
                <label class="form-control-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-control-label">Senha:</label>
                <div class="password-container">
                    <input type="password" name="senha" id="password" class="form-control" required>
                    <i class="fa fa-eye" id="togglePassword"></i>
                </div>
            </div>
            
            <button type="submit" class="btn btn-outline-primary">LOGIN</button>
        </form>
    </div>
</div>

<script src="login.js"></script> 
</body>
</html>
