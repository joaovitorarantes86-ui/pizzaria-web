<?php
session_start();

if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin') {
    header('Location: index.php');
    exit;
}

$erros = $_SESSION['login_erros'] ?? [];
$email = $_SESSION['login_email'] ?? '';
unset($_SESSION['login_erros'], $_SESSION['login_email']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/estilo.css">
    <link rel="stylesheet" href="../CSS/admin.css">
    <title>Admin - Login</title>
</head>
<body class="admin-login-body">

<div class="admin-login-box">
    <h2>Painel <span>Admin</span></h2>
    <p class="sub">Acesso restrito à equipe</p>

    <?php if (!empty($erros)): ?>
        <div class="alert alert-error" style="margin-bottom:20px;">
            <?php foreach ($erros as $e): ?>
                <div><?= $e ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="../process/login.php" method="POST" novalidate>
        <input type="hidden" name="origem" value="admin">
        <div class="form-group">
            <label for="email">E-mail *</label>
            <input type="email" id="email" name="email" required data-val="email"
                   value="<?= htmlspecialchars($email) ?>"
                   placeholder="inacio@email.com">
            <span class="form-error"></span>
        </div>
        <div class="form-group">
            <label for="senha">Senha *</label>
            <input type="password" id="senha" name="senha" required data-val="senha"
                   placeholder="Sua senha">
            <span class="form-error"></span>
        </div>
        <button type="submit" class="btn btn-primary btn-full">Entrar no Painel</button>
    </form>

    <p class="form-link"><a href="../index.php">&larr; Voltar ao site</a></p>
</div>

<script src="../JS/script.js"></script>
</body>
</html>
