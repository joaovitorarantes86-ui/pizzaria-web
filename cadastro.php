<?php
session_start();
$titulo = 'Cadastro';

if (isset($_SESSION['usuario_tipo'])) {
    header('Location: pedidos.php');
    exit;
}

$erros = $_SESSION['cadastro_erros'] ?? [];
$dados = $_SESSION['cadastro_dados'] ?? [];
unset($_SESSION['cadastro_erros'], $_SESSION['cadastro_dados']);

include 'includes/cabecalho.php';
?>

<section class="login-section">
    <div class="container">
        <div class="login-box">
            <div class="form-box">
                <h2>Criar <span>conta</span></h2>
                <p class="sub">Cadastre-se para fazer pedidos mais rápido</p>

                <?php if (!empty($erros)): ?>
                    <div class="alert alert-error">
                        <?php foreach ($erros as $e): ?>
                            <div><?= $e ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="process/cadastro.php" method="POST" novalidate>
                    <div class="form-group">
                        <label for="nome">Nome completo *</label>
                        <input type="text" id="nome" name="nome" required
                               value="<?= htmlspecialchars($dados['nome'] ?? '') ?>"
                               placeholder="Seu nome">
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email" required data-val="email"
                               value="<?= htmlspecialchars($dados['email'] ?? '') ?>"
                               placeholder="seu@email.com">
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" id="telefone" name="telefone" data-val="tel"
                               value="<?= htmlspecialchars($dados['telefone'] ?? '') ?>"
                               placeholder="(67) 99999-9999">
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha *</label>
                        <input type="password" id="senha" name="senha" required data-val="senha"
                               placeholder="Mínimo 6 caracteres">
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="confirma">Confirmar senha *</label>
                        <input type="password" id="confirma" name="confirma" required
                               placeholder="Repita a senha">
                        <span class="form-error"></span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Cadastrar</button>
                </form>

                <p class="form-link">Já tem conta? <a href="login.php">Entrar</a></p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/rodape.php'; ?>
