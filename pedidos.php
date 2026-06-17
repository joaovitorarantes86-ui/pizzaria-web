<?php
session_start();
$titulo = 'Pedidos';

$sucesso = $_SESSION['pedido_sucesso'] ?? null;
$erros   = $_SESSION['pedido_erros'] ?? [];
$dados   = $_SESSION['pedido_dados'] ?? [];

unset($_SESSION['pedido_sucesso'], $_SESSION['pedido_erros'], $_SESSION['pedido_dados']);

try {
    require_once 'includes/conexao.php';
    $pizzas_db = $pdo->query("SELECT nome, preco FROM cardapio WHERE ativo = 1 ORDER BY nome")->fetchAll();
} catch (Exception $e) {
    $pizzas_db = [];
}

include 'includes/cabecalho.php';
?>

<section class="pedidos-section">
    <div class="container">
        <div class="section-header">
            <h2>Faça seu <span>Pedido</span></h2>
            <p>Preencha os dados abaixo e entraremos em contato para confirmar</p>
        </div>

        <div class="form-box">

            <?php if ($sucesso): ?>
                <div class="alert alert-success"><?= $sucesso ?></div>
            <?php endif; ?>

            <?php if (!empty($erros)): ?>
                <div class="alert alert-error">
                    <?php foreach ($erros as $e): ?>
                        <div><?= htmlspecialchars($e) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="process/pedido.php" method="POST" novalidate>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nome">Nome completo *</label>
                        <input type="text" id="nome" name="nome" required
                               value="<?= htmlspecialchars($dados['nome'] ?? '') ?>"
                               placeholder="Seu nome">
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="telefone">Telefone *</label>
                        <input type="text" id="telefone" name="telefone" required data-val="tel"
                               value="<?= htmlspecialchars($dados['telefone'] ?? '') ?>"
                               placeholder="(67) 99999-9999">
                        <span class="form-error"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="pizza">Sabor *</label>
                        <select id="pizza" name="pizza" required>
                            <option value="">Selecione...</option>
                            <?php if (!empty($pizzas_db)): ?>
                                <?php foreach ($pizzas_db as $p): ?>
                                    <?php $label = htmlspecialchars($p['nome']) . ' - R$ ' . number_format($p['preco'], 2, ',', '.'); ?>
                                    <option value="<?= $p['id'] ?>" <?= ($dados['pizza'] ?? '') == $p['id'] ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <?php
                                $sabores = [['id'=>1,'n'=>'Margherita','p'=>42.90],['id'=>2,'n'=>'Carne Seca','p'=>54.90],['id'=>3,'n'=>'Frango com Requeijão','p'=>48.90],['id'=>4,'n'=>'Alho e Óleo','p'=>38.90],['id'=>5,'n'=>'Chocolate c/ Morango','p'=>46.90],['id'=>6,'n'=>'Calabresa Especial','p'=>44.90]];
                                foreach ($sabores as $s):
                                    $label = $s['n'] . ' - R$ ' . number_format($s['p'], 2, ',', '.');
                                    $sel = ($dados['pizza'] ?? '') == $s['id'] ? 'selected' : '';
                                ?>
                                    <option value="<?= $s['id'] ?>" <?= $sel ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="tamanho">Tamanho *</label>
                        <select id="tamanho" name="tamanho" required>
                            <option value="">Selecione...</option>
                            <?php
                            $tamanhos = ['Pequena (4 fatias)', 'Média (6 fatias)', 'Grande (8 fatias)', 'Família (12 fatias)'];
                            foreach ($tamanhos as $t):
                                $sel = ($dados['tamanho'] ?? '') === $t ? 'selected' : '';
                            ?>
                                <option value="<?= $t ?>" <?= $sel ?>><?= $t ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="form-error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="endereco">Endereço de entrega *</label>
                    <input type="text" id="endereco" name="endereco" required
                           value="<?= htmlspecialchars($dados['endereco'] ?? '') ?>"
                           placeholder="Rua, número, bairro">
                    <span class="form-error"></span>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cep">CEP *</label>
                        <input type="text" id="cep" name="cep" required data-val="cep"
                               value="<?= htmlspecialchars($dados['cep'] ?? '') ?>"
                               placeholder="79000-000">
                        <span class="form-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="pagamento">Pagamento *</label>
                        <select id="pagamento" name="pagamento" required>
                            <option value="">Selecione...</option>
                            <?php
                            $pagamentos = ['Dinheiro', 'Pix', 'Cartão de Débito', 'Cartão de Crédito'];
                            foreach ($pagamentos as $p):
                                $sel = ($dados['pagamento'] ?? '') === $p ? 'selected' : '';
                            ?>
                                <option value="<?= $p ?>" <?= $sel ?>><?= $p ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="form-error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="obs">Observações</label>
                    <textarea id="obs" name="obs" placeholder="Ex: sem cebola, borda recheada..."><?= htmlspecialchars($dados['obs'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-full">Enviar Pedido</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/rodape.php'; ?>
