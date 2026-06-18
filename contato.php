<?php
session_start();
$titulo = 'Contato';

$sucesso = $_SESSION['contato_sucesso'] ?? null;
$erros   = $_SESSION['contato_erros'] ?? [];
$dados   = $_SESSION['contato_dados'] ?? [];

unset($_SESSION['contato_sucesso'], $_SESSION['contato_erros'], $_SESSION['contato_dados']);

include 'includes/cabecalho.php';
?>

<section class="form-section">
    <div class="container">
        <div class="section-header">
            <h2>Fale <span>Conosco</span></h2>
            <p>Tem alguma dúvida, sugestão ou reclamação? Nossa equipe responde em até 24 horas.</p>
        </div>

        <div class="contato-wrap">

            <div class="contato-info" data-animar>
                <div class="contato-detail">
                    <span class="contato-icon">&#9906;</span>
                    <span>Rua das Pizzas, 123 - Campo Grande, MS</span>
                </div>
                <div class="contato-detail">
                    <span class="contato-icon">&#9742;</span>
                    <span>(67) 3333-4444</span>
                </div>
                <div class="contato-detail">
                    <span class="contato-icon">&#128241;</span>
                    <span>(67) 99999-8888 (WhatsApp)</span>
                </div>
                <div class="contato-detail">
                    <span class="contato-icon">&#9993;</span>
                    <span>contato@pizzariadasuzy.com.br</span>
                </div>
                <div class="contato-detail">
                    <span class="contato-icon">&#128338;</span>
                    <span>Seg–Dom: 18h às 23h30</span>
                </div>
            </div>

            <div class="form-box" style="margin:0;">

                <?php if ($sucesso): ?>
                    <div class="alert alert-success"><?= $sucesso ?></div>
                <?php endif; ?>

                <?php if (!empty($erros)): ?>
                    <div class="alert alert-error">
                        <?php foreach ($erros as $e): ?>
                            <div><?= $e ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="process/contato.php" method="POST" novalidate>

                    <div class="form-group">
                        <label for="nome">Nome *</label>
                        <input type="text" id="nome" name="nome" required
                               value="<?= htmlspecialchars($dados['nome'] ?? '') ?>"
                               placeholder="Seu nome completo">
                        <span class="form-error"></span>
                    </div>

                    <div class="form-row">
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
                    </div>

                    <div class="form-group">
                        <label for="assunto">Assunto *</label>
                        <select id="assunto" name="assunto" required>
                            <option value="">Selecione...</option>
                            <?php
                            $assuntos = ['Dúvida', 'Sugestão', 'Reclamação', 'Elogio', 'Outro'];
                            foreach ($assuntos as $a):
                                $sel = ($dados['assunto'] ?? '') === $a ? 'selected' : '';
                            ?>
                                <option value="<?= $a ?>" <?= $sel ?>><?= $a ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="form-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="mensagem">Mensagem *</label>
                        <textarea id="mensagem" name="mensagem" required
                                  placeholder="Escreva sua mensagem aqui..."><?= htmlspecialchars($dados['mensagem'] ?? '') ?></textarea>
                        <span class="form-error"></span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">Enviar Mensagem</button>
                </form>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/rodape.php'; ?>
