<?php
session_start();
$titulo = 'Meus Endereços';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

try {
    require_once 'includes/conexao.php';
    $stmt = $pdo->prepare("SELECT * FROM enderecos WHERE usuario_id = ? ORDER BY id DESC");
    $stmt->execute([$_SESSION['usuario_id']]);
    $enderecos = $stmt->fetchAll();
} catch (Exception $e) {
    $enderecos = [];
}

$msg  = $_SESSION['endereco_msg'] ?? '';
$erro = $_SESSION['endereco_erro'] ?? '';
unset($_SESSION['endereco_msg'], $_SESSION['endereco_erro']);

include 'includes/cabecalho.php';
?>

<section class="form-section">
    <div class="container">
        <div class="section-header">
            <h2>Meus <span>Endereços</span></h2>
            <p>Gerencie seus endereços de entrega</p>
        </div>

        <?php if ($msg): ?>
            <div class="alert alert-success" style="max-width:620px;margin:0 auto 24px;"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <?php if ($erro): ?>
            <div class="alert alert-error" style="max-width:620px;margin:0 auto 24px;"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <div class="form-box" style="margin-bottom:32px;">
            <h3 style="font-size:1.05rem;font-weight:700;color:var(--navy);margin-bottom:16px;">Novo Endereço</h3>
            <form action="process/endereco.php" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="rua">Rua *</label>
                        <input type="text" id="rua" name="rua" required placeholder="Nome da rua">
                    </div>
                    <div class="form-group">
                        <label for="numero">Número *</label>
                        <input type="text" id="numero" name="numero" required placeholder="Nº">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="bairro">Bairro *</label>
                        <input type="text" id="bairro" name="bairro" required placeholder="Seu bairro">
                    </div>
                    <div class="form-group">
                        <label for="cidade">Cidade *</label>
                        <input type="text" id="cidade" name="cidade" required value="Campo Grande">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="cep">CEP *</label>
                        <input type="text" id="cep" name="cep" required data-val="cep" placeholder="79000-000">
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" id="complemento" name="complemento" placeholder="Apto, bloco...">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Salvar Endereço</button>
            </form>
        </div>

        <?php if (!empty($enderecos)): ?>
        <div style="max-width:620px;margin:0 auto;display:flex;flex-direction:column;gap:16px;">
            <?php foreach ($enderecos as $e): ?>
            <div style="background:var(--white);border:1px solid var(--gray-100);border-radius:var(--radius-md);padding:20px 24px;box-shadow:var(--shadow-sm);display:flex;justify-content:space-between;align-items:center;gap:16px;">
                <div>
                    <strong style="color:var(--navy);"><?= htmlspecialchars($e['rua']) ?>, <?= htmlspecialchars($e['numero']) ?></strong>
                    <span style="display:block;font-size:0.85rem;color:var(--text-light);margin-top:4px;">
                        <?= htmlspecialchars($e['bairro']) ?> - <?= htmlspecialchars($e['cidade']) ?>
                        <?php if ($e['complemento']): ?> | <?= htmlspecialchars($e['complemento']) ?><?php endif; ?>
                        <br>CEP: <?= htmlspecialchars($e['cep']) ?>
                    </span>
                </div>
                <a href="process/endereco.php?excluir=<?= $e['id'] ?>"
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Excluir este endereço?')">Excluir</a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p style="text-align:center;color:var(--text-light);font-size:0.9rem;">Nenhum endereço cadastrado ainda.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/rodape.php'; ?>
