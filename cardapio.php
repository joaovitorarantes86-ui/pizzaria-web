<?php
$titulo = 'Cardápio';

try {
    require_once 'includes/conexao.php';
    $pizzas = $pdo->query("SELECT * FROM cardapio WHERE ativo = 1 ORDER BY nome")->fetchAll();
} catch (Exception $e) {
    $pizzas = [];
}

if (empty($pizzas)):
    $pizzas = [
        ['imagem' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=800', 'nome' => 'Margherita', 'descricao' => 'Molho de tomate fresco, mussarela de búfala e manjericão.', 'preco' => 42.90, 'categoria' => 'salgada'],
        ['imagem' => 'https://images.unsplash.com/photo-1590947132387-155cc02f3212?w=800', 'nome' => 'Carne Seca', 'descricao' => 'Carne seca desfiada, catupiry, cebola caramelizada.', 'preco' => 54.90, 'categoria' => 'especial'],
        ['imagem' => 'https://images.unsplash.com/photo-1571407970349-bc81e7e96d47?w=800', 'nome' => 'Frango com Requeijão', 'descricao' => 'Frango temperado, requeijão cremoso, milho e orégano.', 'preco' => 48.90, 'categoria' => 'salgada'],
        ['imagem' => 'https://images.unsplash.com/photo-1511689660979-10d2b1aada49?w=800', 'nome' => 'Alho e Óleo', 'descricao' => 'Azeite extra virgem, alho dourado, parmesão e salsinha.', 'preco' => 38.90, 'categoria' => 'salgada'],
        ['imagem' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=800', 'nome' => 'Chocolate c/ Morango', 'descricao' => 'Creme de chocolate belga, morangos frescos e granulado.', 'preco' => 46.90, 'categoria' => 'doce'],
        ['imagem' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=800', 'nome' => 'Calabresa Especial', 'descricao' => 'Calabresa artesanal fatiada, cebola roxa, mussarela.', 'preco' => 44.90, 'categoria' => 'especial'],
    ];
endif;

$categorias = [
    'todas' => 'Todas',
    'salgada' => 'Salgadas',
    'especial' => 'Especiais',
    'doce' => 'Doces',
];

$badges = [
    'Margherita' => 'destaque',
    'Calabresa Especial' => 'destaque',
    'Chocolate c/ Morango' => 'nova',
];

include 'includes/cabecalho.php';
?>

<section class="cardapio-section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Sabores especiais</span>
            <h2>Nosso <span>Cardápio</span></h2>
            <p>Pizzas artesanais feitas com amor e ingredientes selecionados</p>
        </div>

        <div class="cardapio-toolbar">
            <div class="filter-group" id="filterGroup">
                <?php foreach ($categorias as $key => $label): ?>
                    <button class="filter-btn <?= $key === 'todas' ? 'ativo' : '' ?>" data-categoria="<?= $key ?>"><?= $label ?></button>
                <?php endforeach; ?>
            </div>
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Buscar pizza..." autocomplete="off">
            </div>
        </div>

        <div class="cardapio-promessa">
            <p>Massa fermentada por 48h &bull; Forno a lenha &bull; Ingredientes frescos</p>
        </div>

        <div class="menu-grid" id="menuGrid">
            <?php foreach ($pizzas as $pizza): ?>
             <div class="menu-card" data-animar data-categoria="<?= $pizza['categoria'] ?? 'salgada' ?>">
                <div class="menu-card-img">
                     <?php $img_src = htmlspecialchars($pizza['imagem'] ?? ''); ?>
                     <?php if (isset($badges[$pizza['nome']])): ?>
                        <span class="menu-badge <?= $badges[$pizza['nome']] ?>"><?= $badges[$pizza['nome']] === 'destaque' ? '★ Destaque' : 'Nova' ?></span>
                     <?php endif; ?>
                     <img src="<?= $img_src ?>" alt="<?= htmlspecialchars($pizza['nome']) ?>"
                          loading="lazy"
                          onerror="this.parentElement.innerHTML='<div style=height:200px;display:flex;align-items:center;justify-content:center;background:#f0e8dc;color:#9c9994;font-size:13px;>Sem imagem</div>'">
                </div>
                <div class="menu-card-body">
                    <h3><?= htmlspecialchars($pizza['nome']) ?></h3>
                    <p><?= htmlspecialchars($pizza['descricao']) ?></p>
                    <div class="menu-card-footer">
                        <span class="menu-price">R$ <?= number_format($pizza['preco'], 2, ',', '.') ?></span>
                        <a href="pedidos.php" class="btn-menu-order">Pedir</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var filterBtns = document.querySelectorAll('.filter-btn');
    var cards = document.querySelectorAll('.menu-card[data-categoria]');
    var searchInput = document.getElementById('searchInput');
    var grid = document.getElementById('menuGrid');
    var catAtiva = 'todas';

    function filtrar() {
        var termo = searchInput ? searchInput.value.trim().toLowerCase() : '';
        var count = 0;

        cards.forEach(function(card) {
            var cat = card.dataset.categoria || 'salgada';
            var nome = card.querySelector('h3').textContent.toLowerCase();
            var desc = card.querySelector('p').textContent.toLowerCase();
            var matchCat = catAtiva === 'todas' || cat === catAtiva;
            var matchBusca = !termo || nome.includes(termo) || desc.includes(termo);
            card.style.display = matchCat && matchBusca ? '' : 'none';
            if (matchCat && matchBusca) count++;
        });

        var empty = grid.querySelector('.cardapio-empty');
        if (count === 0) {
            if (!empty) {
                var el = document.createElement('div');
                el.className = 'cardapio-empty';
                el.innerHTML = '<p>Nenhuma pizza encontrada. Tente outro filtro ou busca.</p>';
                grid.appendChild(el);
            }
        } else {
            if (empty) empty.remove();
        }
    }

    filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            filterBtns.forEach(function(b) { b.classList.remove('ativo'); });
            this.classList.add('ativo');
            catAtiva = this.dataset.categoria;
            filtrar();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', filtrar);
    }
});
</script>

<?php include 'includes/rodape.php'; ?>
