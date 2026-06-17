<?php
session_start();
$titulo = 'Login';

if (isset($_SESSION['usuario_tipo'])) {
    $redir = $_SESSION['usuario_tipo'] === 'admin' ? 'admin/index.php' : 'pedidos.php';
    header("Location: $redir");
    exit;
}

$erros = $_SESSION['login_erros'] ?? [];
$email = $_SESSION['login_email'] ?? '';
unset($_SESSION['login_erros'], $_SESSION['login_email']);

include 'includes/cabecalho.php';
?>

<section class="login-section">
    <div class="container">
        <div class="login-box">
            <div class="form-box">
                <h2>Entrar na <span>conta</span></h2>
                <p class="sub">Acesse para acompanhar seus pedidos</p>

                <?php if (!empty($erros)): ?>
                    <div class="alert alert-error">
                        <?php foreach ($erros as $e): ?>
                            <div><?= $e ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="process/login.php" method="POST" novalidate>
                    <div class="form-group">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email" required data-val="email"
                               value="<?= htmlspecialchars($email) ?>"
                               placeholder="seu@email.com">
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha *</label>
                        <input type="password" id="senha" name="senha" required data-val="senha"
                               placeholder="Mínimo 6 caracteres">
                        <span class="form-error"></span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Entrar</button>
                </form>

                <p class="form-link">Não tem conta? <a href="cadastro.php">Cadastre-se grátis</a></p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/rodape.php'; ?>
